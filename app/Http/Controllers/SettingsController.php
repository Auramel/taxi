<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::get();

        return view('settings.view', [
            'settings' => $settings,
        ]);
    }

    public function index_(Request $request): RedirectResponse
    {
        $params = $request->all();
        unset($params['_token']);

        foreach ($params as $key => $value) {
            $setting = Setting::whereName($key)
                ->first();

            if (is_null($setting)) {
                $setting = new Setting();
                $setting->name = $key;
            }

            $setting->value = $value;
            $setting->save();
        }

        return redirect()->route('settings.view');
    }
}
