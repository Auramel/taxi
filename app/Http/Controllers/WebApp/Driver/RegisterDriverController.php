<?php

namespace App\Http\Controllers\WebApp\Driver;

use App\Api\Driver\RegisterDriverApi;
use App\Http\Controllers\Controller;
use App\Models\TgUser;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class RegisterDriverController extends Controller
{
    public function view(): View
    {
        return view('webapp.driver.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $tid = $request->get('user');
        $tgUser = TgUser::whereTid($tid)
            ->first();

        if (is_null($tgUser)) {
            throw new NotFoundHttpException();
        }

        try {
            $requestParameters = $request->all();
            $bodyParameters = [
                'account' => [
                    'balance_limit' => '0',
                    'block_orders_on_balance_below_limit' => false,
                    'work_rule_id' => 'e26a3cf21acfe01198d50030487e046b',
                ],
                'order_provider' => [
                    'partner' => true,
                    'platform' => true,
                ],
                'person' => [
                    'contact_info' => [
                        'address' => $requestParameters['address'],
                        'email' => $requestParameters['email'],
                        'phone' => $requestParameters['phone'],
                    ],
                    'driver_license' => [
                        'country' => $requestParameters['country'],
                        'expiry_date' => $requestParameters['expiry_date'],
                        'issue_date' => $requestParameters['issue_date'],
                        'number' => $requestParameters['number'],
                    ],
                    'driver_license_experience' => [
                        'total_since_date' => $requestParameters['total_since_date'],
                    ],
                    'full_name' => [
                        'first_name' => $requestParameters['first_name'],
                        'last_name' => $requestParameters['last_name'],
                        'middle_name' => $requestParameters['middle_name'],
                    ],
                ],
                'profile' => [
                    'hire_date' => Carbon::now()->toDateString(),
                ],
            ];

            $errors = [];
            $registerDriverApi = new RegisterDriverApi();
            $driverId = $registerDriverApi->run($bodyParameters);

            $tgUser->driver_id = $driverId;
            $tgUser->save();
        } catch (Throwable $exception) {
            $errors[] = $exception->getMessage();
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        return redirect()->route('webapp.success');
    }
}
