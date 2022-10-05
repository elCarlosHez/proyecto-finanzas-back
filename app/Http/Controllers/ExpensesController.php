<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = Expenses::where('user_id', $request->user()->id)
            ->orderBy('expense_date', 'desc')
            ->get()
            ->groupBy(function (Expenses $item) {
                return Carbon::parse($item->expense_date)->locale('es_ES')->format('F Y');
            });

        return json_encode($result);
    }

    public function getResume(Request $request)
    {
        $expensesOfTheMonth = $request->user()->expenses()->whereMonth('expense_date', Carbon::now()->month)->sum('amount');
        $resume = $request->user()->salary - $expensesOfTheMonth;
        return $resume;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'type' => ['required', Rule::in(['unique', 'recurrent'])],
            'periodicity' => ['required', Rule::in(['diario', 'semanal', 'quincenal', 'mensual', 'semestral', 'anual'])],
            'expense_date' => 'required',
        ];
        $data = $request->validate($rules);
        $data['expense_date'] = Carbon::parse($data['expense_date']);

        // Assign the income to the actual user
        $user = $request->user();
        $data['user_id'] = $user->id;

        $expenses = Expenses::create($data);

        return $expenses;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenses $expenses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenses $expenses)
    {
        //
    }
}
