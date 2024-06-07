<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        return response()->json($fournisseurs);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $fournisseur = new Fournisseur($request->all());
        $fournisseur->save();
        return response()->json($fournisseur, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $fournisseur = Fournisseur::find($id);
    if ($fournisseur) {
        return response()->json($fournisseur);
    } else {
        return response()->json(['message' => 'Fournisseur not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $fournisseur = Fournisseur::find($id);
        if ($fournisseur) {
            $fournisseur->fill($request->all());
            $fournisseur->save();
            return response()->json($fournisseur);
        } else {
            return response()->json(['message' => 'Fournisseur not found'], 404);
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
    $fournisseur = Fournisseur::find($id);
    if ($fournisseur) {
        $fournisseur->delete();
        return response()->json(['message' => 'Fournisseur deleted']);
    } else {
        return response()->json(['message' => 'Fournisseur not found'], 404);
    }
}
}