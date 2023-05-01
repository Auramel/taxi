<?php

namespace App\Http\Controllers;

use App\Models\Taxopark;
use App\Models\TgUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaxoparksController extends Controller
{
    public function index(): View
    {
        $taxoparks = Taxopark::paginate();

        return view('taxoparks.list', [
            'taxoparks' => $taxoparks,
        ]);
    }

    public function create(): View
    {
        return view('taxoparks.create');
    }

    public function create_(Request $request): RedirectResponse
    {
        $taxopark = new Taxopark();
        $taxopark->name = $request->get('name');
        $taxopark->park_id = $request->get('park_id');
        $taxopark->client_id = $request->get('client_id');
        $taxopark->api_key = $request->get('api_key');
        $taxopark->save();

        return  redirect()->route('taxoparks.list');
    }

    public function view(int $id): View
    {
        $taxopark = Taxopark::whereId($id)
            ->first();

        if (is_null($taxopark)) {
            throw new NotFoundHttpException();
        }

        return view('taxoparks.view', [
            'taxopark' => $taxopark,
        ]);
    }

    public function view_(
        int $id,
        Request $request,
    ): RedirectResponse
    {
        $taxopark = Taxopark::whereId($id)
            ->first();

        if (is_null($taxopark)) {
            throw new NotFoundHttpException();
        }

        return redirect()->route('taxoparks.list');
    }

    public function delete(int $id): RedirectResponse
    {
        $taxopark = Taxopark::whereId($id)
            ->first();

        if (is_null($taxopark)) {
            throw new NotFoundHttpException();
        }

        $taxopark->delete();

        TgUser::whereTaxoparkId($taxopark->id)
            ->update([
                'taxopark_id' => null,
            ]);

        return redirect()->route('taxoparks.list');
    }
}
