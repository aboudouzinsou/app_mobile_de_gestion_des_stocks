<?php

namespace App\Http\Controllers;

use App\Models\Inventaire;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InventaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventaires = Inventaire::all();
        return response()->json($inventaires);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $inventaire = new Inventaire($request->all());
        $inventaire->save();
        return response()->json($inventaire, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $inventaire = Inventaire::find($id);
    if ($inventaire) {
        return response()->json($inventaire);
    } else {
        return response()->json(['message' => 'Inventaire not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $inventaire = Inventaire::find($id);
        if ($inventaire) {
            $inventaire->fill($request->all());
            $inventaire->save();
            return response()->json($inventaire);
        } else {
            return response()->json(['message' => 'Inventaire not found'], 404);
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
    $inventaire = Inventaire::find($id);
    if ($inventaire) {
        $inventaire->delete();
        return response()->json(['message' => 'Inventaire deleted']);
    } else {
        return response()->json(['message' => 'Inventaire not found'], 404);
    }
}
}