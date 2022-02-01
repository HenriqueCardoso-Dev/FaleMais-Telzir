<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalcRequest;
use App\Models\Tariffs;
use Illuminate\Http\Request;

class CallValueCalculator extends Controller
{
    //
    public function calculator (CalcRequest $request)
    {
        $data = $request->validated();

        $tariff = Tariffs::where('ddd_init', $data['ddd_init'])
            ->where('ddd_end', $data['ddd_end'])
            ->select('tariff')
            ->first()['tariff'] ?? 0;

        if($tariff == 0) {
            return response()->json(["error" => "Não existe tarifa cadastrada para esses ddd's, verifique a tabela" ], 401);
        }

        /*if($data['time'] <= $data['plan']) {
            return response()->json(['message', 'A ligação será coberta pelo plano e não será cobrada!']);
        }*/

        if($data['plan'] > 0 && $data['time'] > $data['plan']) {
            $lastTime = $data['time'] - $data['plan'];
            $newTariff = $tariff + (($tariff / 100) * 10);
        } elseif($data['plan'] > 0 && $data['time'] < $data['plan']) {
            $lastTime = $data['time'];
            $newTariff = 0;
        }

        if($data['plan'] == 0){
            $lastTime = $data['time'];
            $newTariff = $tariff;
            $plane = "nenhum";
        } else {
            $plane = "FaleMais ".$data['plan'];
        }


        $noPlane = $data['time'] * $tariff;

        $finalPrice = $lastTime * $newTariff;




        return response()->json([
            'ddd_init' => $data['ddd_init'],
            'ddd_end' => $data['ddd_end'],
            'time' => $data['time'],
            'plane' => $plane,
            'noPlane' => $noPlane,
            'finalPrice' => $finalPrice
        ]);

    }
}
