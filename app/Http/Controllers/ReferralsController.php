<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReferralsController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search');

        $referrals = Referral::with([
            'from',
            'income',
        ])
            ->when(!empty($search), function (Builder $builder) use ($search) {
                $builder->where(function (Builder $builder) use ($search) {
                    $builder->whereRelation('income', 'first_name', 'like', '%' . $search . '%')
                        ->orWhereRelation('income', 'last_name', 'like', '%' . $search . '%')
                        ->orWhereRelation('income', 'username', 'like', '%' . $search . '%')
                        ->orWhereRelation('from', 'first_name', 'like', '%' . $search . '%')
                        ->orWhereRelation('from', 'last_name', 'like', '%' . $search . '%')
                        ->orWhereRelation('from', 'username', 'like', '%' . $search . '%');
                });
            })
            ->paginate();

        return view('referrals.list', [
            'referrals' => $referrals,
        ]);
    }

    public function view(int $id): View
    {
        $referral = Referral::whereId($id)
            ->first();

        if (is_null($referral)) {
            throw new NotFoundHttpException();
        }

        return view('referrals.view', [
            'referral' => $referral,
        ]);
    }
}
