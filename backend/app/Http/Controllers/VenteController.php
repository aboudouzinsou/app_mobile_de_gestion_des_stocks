<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventes = Vente::all();
        return response()->json($ventes);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $vente = new Vente($request->all());
        $vente->save();
        return response()->json($vente, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $vente = Vente::find($id);
    if ($vente) {
        return response()->json($vente);
    } else {
        return response()->json(['message' => 'Vente not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $vente = Vente::find($id);
        if ($vente) {
            $vente->fill($request->all());
            $vente->save();
            return response()->json($vente);
        } else {
            return response()->json(['message' => 'Vente not found'], 404);
        }
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Remove the specified resource from storage.
 */
public function destroy($id)
{
    $vente = Vente::find($id);
    if ($vente) {
        $vente->delete();
        return response()->json(['message' => 'Vente deleted']);
    } else {
        return response()->json(['message' => 'Vente not found'], 404);
    }
}
}