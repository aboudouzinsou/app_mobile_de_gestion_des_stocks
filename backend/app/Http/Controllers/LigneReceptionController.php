<?php

namespace App\Http\Controllers;

use App\Models\LigneReception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LigneReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ligneReceptions = LigneReception::all();
        return response()->json($ligneReceptions);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $ligneReception = new LigneReception($request->all());
        $ligneReception->save();
        return response()->json($ligneReception, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $ligneReception = LigneReception::find($id);
    if ($ligneReception) {
        return response()->json($ligneReception);
    } else {
        return response()->json(['message' => 'LigneReception not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $ligneReception = LigneReception::find($id);
        if ($ligneReception) {
            $ligneReception->fill($request->all());
            $ligneReception->save();
            return response()->json($ligneReception);
        } else {
            return response()->json(['message' => 'LigneReception not found'], 404);
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
    $ligneReception = LigneReception::find($id);
    if ($ligneReception) {
        $ligneReception->delete();
        return response()->json(['message' => 'LigneReception deleted']);
    } else {
        return response()->json(['message' => 'LigneReception not found'], 404);
    }
}
}