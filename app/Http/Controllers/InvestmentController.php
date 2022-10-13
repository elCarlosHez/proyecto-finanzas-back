<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;

class InvestmentController extends Controller
{
    public function getAnInvestment(Request $request)
    {
        $rules = [
            'name' => 'string:required',
            'time' =>  ['required', Rule::in(['1', '2', '3'])],
            'risk' => ['required', Rule::in(['1', '2', '3'])],
            'money' => 'numeric',
            'saving' => 'numeric',
        ];

        $data = $request->validate($rules);

        $investment = null;

        // Enviamos una petición a la IA para obtener la mejor inversión
        $backend_url = env('PYTHON_URL');
        $time = $data['time'];
        $risk = $data['risk'];
        $response = Http::get("{$backend_url}/get-prediction", [
            "time" => $time,
            "risk" => $risk
        ]);
        $reponseData = $response->json();

        // Realizamos la proyección con la inversión obtenida
        $investment= Investment::find($reponseData['result']);
        
        $yieldRateByPeriod = $investment->yield_rate;
        $calculo = ($data['money'] + $data['saving'] * 12) * (1 + $yieldRateByPeriod) ** 1;
        return json_encode([
            "investment" => $investment,
            "earnings" => $calculo,
        ]);
    }
}
