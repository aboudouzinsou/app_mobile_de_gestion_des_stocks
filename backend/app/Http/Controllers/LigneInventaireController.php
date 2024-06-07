<?php

namespace App\Http\Controllers;

use App\Models\LigneInventaire;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LigneInventaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ligneInventaires = LigneInventaire::all();
        return response()->json($ligneInventaires);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $ligneInventaire = new LigneInventaire($request->all());
        $ligneInventaire->save();
        return response()->json($ligneInventaire, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $ligneInventaire = LigneInventaire::find($id);
    if ($ligneInventaire) {
        return response()->json($ligneInventaire);
    } else {
        return response()->json(['message' => 'LigneInventaire not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $ligneInventaire = LigneInventaire::find($id);
        if ($ligneInventaire) {
            $ligneInventaire->fill($request->all());
            $ligneInventaire->save();
            return response()->json($ligneInventaire);
        } else {
            return response()->json(['message' => 'LigneInventaire not found'], 404);
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
    $ligneInventaire = LigneInventaire::find($id);
    if ($ligneInventaire) {
        $ligneInventaire->delete();
        return response()->json(['message' => 'LigneInventaire deleted']);
    } else {
        return response()->json(['message' => 'LigneInventaire not found'], 404);
    }
}
}