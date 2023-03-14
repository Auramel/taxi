<?php

namespace App\Http\Controllers\WebApp\Car;

use App\Api\Car\RegisterCarApi;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\TgUser;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class RegisterCarController extends Controller
{
    public function view(): View
    {
        return view('webapp.car.register');
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
                'park_profile' => [
                    'callsign' => 'car' . Carbon::now()->toDateTimeString(),
                    'status' => 'working',
                ],
                'vehicle_licenses' => [
                    'licence_plate_number' => $requestParameters['licence_plate_number'],
                    'registration_certificate' => $requestParameters['registration_certificate'],
                ],
                'vehicle_specifications' => [
                    'brand' => $requestParameters['brand'],
                    'color' => $requestParameters['color'],
                    'model' => $requestParameters['model'],
                    'transmission' => $requestParameters['transmission'],
                    'vin' => $requestParameters['vin'],
                    'year' => (int) $requestParameters['year'],
                ],
            ];

            $errors = [];
            $registerCarApi = new RegisterCarApi();
            $carId = $registerCarApi->run($bodyParameters);

            $car = Car::whereCarId($carId)
                ->whereTgUserId($tgUser->id)
                ->first();

            if (is_null($car)) {
                $car = new Car();
                $car->car_id = $carId;
                $car->tg_user_id = $tgUser->id;
                $car->save();
            }
        } catch (Throwable $exception) {
            $errors[] = $exception->getMessage();
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        return redirect()->route('webapp.success');
    }
}
