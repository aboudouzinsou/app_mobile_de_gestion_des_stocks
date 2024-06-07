<?php

namespace App\Http\Controllers;

use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LigneCommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ligneCommandes = LigneCommande::all();
        return response()->json($ligneCommandes);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $ligneCommande = new LigneCommande($request->all());
        $ligneCommande->save();
        return response()->json($ligneCommande, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $ligneCommande = LigneCommande::find($id);
    if ($ligneCommande) {
        return response()->json($ligneCommande);
    } else {
        return response()->json(['message' => 'LigneCommande not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $ligneCommande = LigneCommande::find($id);
        if ($ligneCommande) {
            $ligneCommande->fill($request->all());
            $ligneCommande->save();
            return response()->json($ligneCommande);
        } else {
            return response()->json(['message' => 'LigneCommande not found'], 404);
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
    $ligneCommande = LigneCommande::find($id);
    if ($ligneCommande) {
        $ligneCommande->delete();
        return response()->json(['message' => 'LigneCommande deleted']);
    } else {
        return response()->json(['message' => 'LigneCommande not found'], 404);
    }
}
}