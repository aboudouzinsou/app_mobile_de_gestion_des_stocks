<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::all();
        return response()->json($produits);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $produit = new Produit($request->all());
        $produit->save();
        return response()->json($produit, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $produit = Produit::find($id);
    if ($produit) {
        return response()->json($produit);
    } else {
        return response()->json(['message' => 'Produit not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $produit = Produit::find($id);
        if ($produit) {
            $produit->fill($request->all());
            $produit->save();
            return response()->json($produit);
        } else {
            return response()->json(['message' => 'Produit not found'], 404);
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
    $produit = Produit::find($id);
    if ($produit) {
        $produit->delete();
        return response()->json(['message' => 'Produit deleted']);
    } else {
        return response()->json(['message' => 'Produit not found'], 404);
    }
}
}