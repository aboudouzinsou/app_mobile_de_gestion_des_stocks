<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::all();
        return response()->json($categories);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $categorie = new Categorie($request->all());
        $categorie->save();
        return response()->json($categorie, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $categorie = Categorie::find($id);
    if ($categorie) {
        return response()->json($categorie);
    } else {
        return response()->json(['message' => 'Categorie not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $categorie = Categorie::find($id);
        if ($categorie) {
            $categorie->fill($request->all());
            $categorie->save();
            return response()->json($categorie);
        } else {
            return response()->json(['message' => 'Categorie not found'], 404);
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
    $categorie = Categorie::find($id);
    if ($categorie) {
        $categorie->delete();
        return response()->json(['message' => 'Categorie deleted']);
    } else {
        return response()->json(['message' => 'Categorie not found'], 404);
    }
}
}