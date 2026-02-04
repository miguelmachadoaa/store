<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DollarValue;
use Illuminate\Http\Request;

class DollarValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dollarValues = DollarValue::orderBy('date', 'desc')->paginate(10);
        return view('admin.dollar-values.index', compact('dollarValues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dollar-values.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:dollar_values,date',
            'value' => 'required|numeric|min:0',
        ]);

        DollarValue::create($validated);

        return redirect()->route('admin.dollar-values.index')
            ->with('success', 'Valor del dólar creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DollarValue $dollarValue)
    {
        return view('admin.dollar-values.edit', compact('dollarValue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DollarValue $dollarValue)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:dollar_values,date,' . $dollarValue->id,
            'value' => 'required|numeric|min:0',
        ]);

        $dollarValue->update($validated);

        return redirect()->route('admin.dollar-values.index')
            ->with('success', 'Valor del dólar actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DollarValue $dollarValue)
    {
        $dollarValue->delete();

        return redirect()->route('admin.dollar-values.index')
            ->with('success', 'Valor del dólar eliminado exitosamente.');
    }
}
