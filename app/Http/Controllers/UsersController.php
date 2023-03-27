<?php

namespace App\Http\Controllers;

use App\Models\TgUser;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    public function index(): View
    {
        $users = TgUser::paginate();

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
}
