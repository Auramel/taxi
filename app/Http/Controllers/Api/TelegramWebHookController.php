<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TgHashRoute;
use App\Models\TgUser;
use App\Services\Telegram\HashRoute;
use App\Services\Telegram\ScreenResult;
use App\Services\Telegram\Screens\CommandNotFoundScreen;
use Auramel\TelegramBotApi\BotApi;
use Auramel\TelegramBotApi\Types\Update;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class TelegramWebHookController extends Controller
{
    private BotApi $botApi;
    private TgUser $tgUser;
    private Update $payload;

    public function webhook(Request $request): JsonResponse
    {
        try {
            $telegramToken = env('TELEGRAM_TOKEN');
            $this->botApi = new BotApi($telegramToken);
            $this->payload = Update::fromResponse($request->all());
            $this->tgUser = $this->checkTgUser();

            if (!is_null($this->tgUser->banned_at)) {
                throw new AccessDeniedHttpException();
            }

            $this->route();
        } catch (Throwable $exception) {
            Log::error($exception);
        }

        return response()->json([]);
    }

    private function checkTgUser(): TgUser
    {
        $message = $this->payload->getMessage();
        $callbackQuery = $this->payload->getCallbackQuery();

        $from = !is_null($message)
            ? $message->getFrom()
            : $callbackQuery->getFrom();

        $tgUser = TgUser::whereTid($from->getId())
            ->first();

        if (is_null($tgUser)) {
            $tgUser = new TgUser();
        }

        $tgUser->tid = $from->getId();
        $tgUser->username = $from->getUsername();
        $tgUser->first_name = $from->getFirstName();
        $tgUser->last_name = $from->getLastName();
        $tgUser->save();

        return $tgUser;
    }

    private function route()
    {
        $message = $this->payload->getMessage();
        $callbackQuery = $this->payload->getCallbackQuery();

        $screen = null;
        $method = null;
        $data = [];

        if (!is_null($message)) {
            $command = $message->getText();

            $routes = config('tg_routes');
            $route = $routes[$command] ?? null;

            if (!is_null($route)) {
                $screen = $route['screen'];
                $method = $route['method'] ?? null;
            }
        } elseif (!is_null($callbackQuery)) {
            $callbackQueryData = $callbackQuery->getData();

            $tgHashRoute = TgHashRoute::whereHash($callbackQueryData)
                ->first();

            if (!is_null($tgHashRoute)) {
                $hashRoute = HashRoute::fromArray(
                    json_decode($tgHashRoute->data, JSON_OBJECT_AS_ARRAY),
                );

                $screen = $hashRoute->getScreen();
                $method = $hashRoute->getMethod();
                $data = $hashRoute->getData();

                $this->botApi->answerCallbackQuery($callbackQuery->getId());
            }
        }

        $key = 'screen-state-cache-user-' . $this->tgUser->id;

        if (is_null($screen)) {
            if (Cache::has($key)) {
                $screenResult = ScreenResult::fromArray(Cache::get($key));
                $screen = $screenResult->getName();
                $method = $screenResult->getMethod();
                $data = $screenResult->getData();
            } else {
                $screen = CommandNotFoundScreen::class;
            }
        }

        $result = $this->runScreen(
            screen: $screen,
            method: $method,
            data: $data,
        );

        if (!$result->isEmpty()) {
            Cache::put($key, $result->toArray());
        } else {
            Cache::delete($key);
        }
    }

    private function runScreen(
        string $screen,
        ?string $method = null,
        array $data = [],
    ): ScreenResult
    {
        $screen = new $screen(
            botApi: $this->botApi,
            tgUser: $this->tgUser,
            payload: $this->payload,
            data: $data,
        );

        return is_null($method)
            ? $screen->index()
            : $screen->$method();
    }
}
