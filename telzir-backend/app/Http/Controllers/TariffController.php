<?php

namespace App\Http\Controllers;

use App\Http\Requests\TariffRequest;
use App\Models\Tariffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TariffController extends Controller
{
    public function getTariffs()
    {
        return Tariffs::all();
    }

    public function removeTariff(Request $request)
    {
        try {
            DB::beginTransaction();
                $tariff = Tariffs::find($request['id']);

                if ($tariff) {
                    $tariff->delete();
                }
            DB::commit();
        } catch (\Throwable $th) {
            return response()->json(['error', $th->getMessage()], 401);
        }
    }

    public function store(TariffRequest $request)
    {
        try {
            DB::beginTransaction();
                $input = $request->validated();

                $verify = Tariffs::where('ddd_init', $input['ddd_init'])
                    ->where('ddd_end', $input['ddd_end'])
                    ->first();

                if($verify) {
                    return response()->json(["error" => "Já existe uma taxa cadastrada para esses ddd's"], 401);
                }

                Tariffs::create([
                    'ddd_init' => $input['ddd_init'],
                    'ddd_end' => $input['ddd_end'],
                    'tariff' => $input['tariff']
                ]);
            DB::commit();

        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }
}
