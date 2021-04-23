<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calculator\LiteCalculatorRequest;
use App\Services\User\CalculateInfoAboutRoomsService;
use App\Services\User\CalculateLiteService;
use App\Services\User\ProfessionalCalculatorDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function professional(
        Request $request,
        CalculateLiteService $service,
        ProfessionalCalculatorDataService $dataService
    )
    {
        $dataPattern = $dataService->run($request);
        $res = $service->run($dataPattern)
            ->sortBy('price')
            ->values();
        return response()->json($res);
    }


    /**
     * Простой калькулятор ремонта
     * @param LiteCalculatorRequest $request
     * @param CalculateLiteService $service
     * @return JsonResponse
     */

    public function calculate(
        LiteCalculatorRequest $request,
        CalculateLiteService $service
    )
    {
        $calculateService = new CalculateInfoAboutRoomsService
        ($request->get('type'), $request->get('typeRem'), $request->get('rooms'), $request->get('aere'));
        // aere = area (but there was a typo in request params)
        $calcPattern = $calculateService->run();
        $res = $service->run($calcPattern)
            ->sortBy('price')
            ->values();
        return response()->json($res->toArray());
    }

}
