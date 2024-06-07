<?php

namespace App\Http\Controllers;

use App\Models\LigneVente;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LigneVenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ligneVentes = LigneVente::all();
        return response()->json($ligneVentes);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $ligneVente = new LigneVente($request->all());
        $ligneVente->save();
        return response()->json($ligneVente, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $ligneVente = LigneVente::find($id);
    if ($ligneVente) {
        return response()->json($ligneVente);
    } else {
        return response()->json(['message' => 'LigneVente not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $ligneVente = LigneVente::find($id);
        if ($ligneVente) {
            $ligneVente->fill($request->all());
            $ligneVente->save();
            return response()->json($ligneVente);
        } else {
            return response()->json(['message' => 'LigneVente not found'], 404);
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
    $ligneVente = LigneVente::find($id);
    if ($ligneVente) {
        $ligneVente->delete();
        return response()->json(['message' => 'LigneVente deleted']);
    } else {
        return response()->json(['message' => 'LigneVente not found'], 404);
    }
}
}