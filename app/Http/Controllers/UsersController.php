<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\TgUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search');

        $users = TgUser::when(!empty($search), function (Builder $builder) use ($search) {
            $builder->where(function (Builder $builder) use ($search) {
                $builder->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        })
            ->paginate();

        return view('users.list', [
            'users' => $users,
        ]);
    }

    public function view(int $id): View
    {
        $user = TgUser::whereId($id)
            ->first();

        if (is_null($user)) {
            throw new NotFoundHttpException();
        }

        $referrals = $user->referrals()
            ->paginate();

        return view('users.view', [
            'user' => $user,
            'referrals' => $referrals,
        ]);
    }

    public function ban(int $id): RedirectResponse
    {
        $user = TgUser::whereId($id)
            ->first();

        if (is_null($user)) {
            throw new NotFoundHttpException();
        }

        $user->banned_at = Carbon::now();
        $user->save();

        return redirect()->route('users.view', [
            'id' => $user->id,
        ]);
    }

    public function unban(int $id): RedirectResponse
    {
        $user = TgUser::whereId($id)
            ->first();

        if (is_null($user)) {
            throw new NotFoundHttpException();
        }

        $user->banned_at = null;
        $user->save();

        return redirect()->route('users.view', [
            'id' => $user->id,
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        $user = TgUser::whereId($id)
            ->first();

        if (is_null($user)) {
            throw new NotFoundHttpException();
        }

        $user->delete();

        return redirect()->route('users.list');
    }

    public function resetPhone(int $id): RedirectResponse
    {
        $user = TgUser::whereId($id)
            ->first();

        if (is_null($user)) {
            throw new NotFoundHttpException();
        }

        $user->phone = null;
        $user->save();

        return redirect()->route('users.view', [
            'id' => $id,
        ]);
    }

    public function resetYandexId(int $id): RedirectResponse
    {
        $user = TgUser::whereId($id)
            ->first();

        if (is_null($user)) {
            throw new NotFoundHttpException();
        }

        Car::whereTgUserId($id)
            ->delete();

        $user->driver_id = null;
        $user->save();

        return redirect()->route('users.view', [
            'id' => $id,
        ]);
    }

    public function changeHasDebt(
        int $id,
        int $hasDebt,
    )
    {
        $user = TgUser::whereId($id)
            ->first();

        if (is_null($user)) {
            throw new NotFoundHttpException();
        }

        $user->has_debt = $hasDebt;
        $user->save();

        return redirect()->route('users.view', [
            'id' => $id,
        ]);
    }
}
