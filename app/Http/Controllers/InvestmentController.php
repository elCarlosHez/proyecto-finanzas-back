<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        try {
            $investment = Investment::where('risk', $data['risk'])
                ->where('time', $data['time'])
                ->orderBy('yield_rate', 'asc')
                ->firstOrFail();
        } catch (\Throwable $th) {
            $investment = Investment::where('time', '<=', $data['time'])
                ->where('risk', '<=', $data['risk'])
                ->orderBy('yield_rate', 'asc')
                ->first();
        }
        
        $yieldRateByPeriod = $investment->yield_rate;
        $calculo = ($data['money'] + $data['saving'] * 12) * (1 + $yieldRateByPeriod) ** 1;
        return json_encode([
            "investment" => $investment,
            "earnings" => $calculo,
        ]);
    }
}
