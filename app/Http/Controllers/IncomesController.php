<?php

namespace App\Http\Controllers;

use App\Models\Incomes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user()->incomes;
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
            'income_date' => 'required|date',
        ];
        $data = $request->validate($rules);

        // Assign the income to the actual user
        $user = $request->user();
        $data['user_id'] = $user->id;

        $income = Incomes::create($data);

        return $income;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Incomes  $incomes
     * @return \Illuminate\Http\Response
     */
    public function show(Incomes $incomes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Incomes  $incomes
     * @return \Illuminate\Http\Response
     */
    public function edit(Incomes $incomes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incomes  $incomes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incomes $incomes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incomes  $incomes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incomes $incomes)
    {
        //
    }
}
