<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::all();
        return response()->json($commandes);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $commande = new Commande($request->all());
        $commande->save();
        return response()->json($commande, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $commande = Commande::find($id);
    if ($commande) {
        return response()->json($commande);
    } else {
        return response()->json(['message' => 'Commande not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $commande = Commande::find($id);
        if ($commande) {
            $commande->fill($request->all());
            $commande->save();
            return response()->json($commande);
        } else {
            return response()->json(['message' => 'Commande not found'], 404);
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
    $commande = Commande::find($id);
    if ($commande) {
        $commande->delete();
        return response()->json(['message' => 'Commande deleted']);
    } else {
        return response()->json(['message' => 'Commande not found'], 404);
    }
}
}