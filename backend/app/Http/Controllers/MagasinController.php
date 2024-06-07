<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MagasinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $magasins = Magasin::all();
        return response()->json($magasins);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $magasin = new Magasin($request->all());
        $magasin->save();
        return response()->json($magasin, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $magasin = Magasin::find($id);
    if ($magasin) {
        return response()->json($magasin);
    } else {
        return response()->json(['message' => 'Magasin not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $magasin = Magasin::find($id);
        if ($magasin) {
            $magasin->fill($request->all());
            $magasin->save();
            return response()->json($magasin);
        } else {
            return response()->json(['message' => 'Magasin not found'], 404);
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
    $magasin = Magasin::find($id);
    if ($magasin) {
        $magasin->delete();
        return response()->json(['message' => 'Magasin deleted']);
    } else {
        return response()->json(['message' => 'Magasin not found'], 404);
    }
}
}