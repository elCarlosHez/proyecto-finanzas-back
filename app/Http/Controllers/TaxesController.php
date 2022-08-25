<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Isr;

class TaxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $deductions = $user->deduction()->first();
        $anual_incomeBeforeTaxes = $user->salary * 12;
        $anual_income = $user->salary * 12;
        
        // Reducimos del ingreso anual las deducciones 
        $personalDeductionSum = $deductions->donation + $deductions->education + $deductions->medical;
        $personalDeduction = min($anual_income * 0.15, $personalDeductionSum);
        $anual_income = $anual_income - min($deductions->retirement, $anual_income * 0.1) - $personalDeduction;

        $taxes = $this->calculoDeImpuestos($anual_income);
        $taxesBeforeDeductions = $this->calculoDeImpuestos($anual_incomeBeforeTaxes);
        $taxes['balance'] = $taxesBeforeDeductions['impuesto_determinado'] - $taxes['impuesto_determinado'];
        $taxes['deducciones'] = $deductions;

        return json_encode($taxes);
    }

    private function calculoDeImpuestos($anual_income)
    {
        $Isr_data = Isr::where('lower_limit', '<=', $anual_income)
            ->orderBy('lower_limit', 'desc')
            ->limit(1)
            ->first();
        $excedente = $anual_income - $Isr_data->lower_limit;
        $impuesto_marginal = $excedente * $Isr_data->percentage;
        $impuesto_determiando = $Isr_data->fixed_fee + $impuesto_marginal;
        $libre = $anual_income - $impuesto_determiando;

        return [
            "ingreso_bruto" => $anual_income,
            "impuesto_determinado" => $impuesto_determiando,
            "ingreso_neto" => $libre,
            "tasa" => $Isr_data->percentage,
        ];
    }

    public function getDeductions(Request $request)
    {
        $user = $request->user();
        $deductions = $user->deduction()->first();

        return $deductions;
    }

    public function updateDeductions(Request $request)
    {
        $rules = [
            'medical' => 'numeric',
            'retirement' => 'numeric',
            'donation' => 'numeric',
            'education' => 'numeric',
        ];

        $data = $request->validate($rules);

        $user = $request->user();
        $deductions = $user->deduction()->first();
        $deductions->update($data);
        return $deductions;
    }
}
