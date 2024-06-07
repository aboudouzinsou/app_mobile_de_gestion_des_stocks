<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExerciceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exercices = Exercice::all();
        return response()->json($exercices);
    }

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    try {
        $exercice = new Exercice($request->all());
        $exercice->save();
        return response()->json($exercice, 201);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
}

/**
 * Display the specified resource.
 */
public function show($id)
{
    $exercice = Exercice::find($id);
    if ($exercice) {
        return response()->json($exercice);
    } else {
        return response()->json(['message' => 'Exercice not found'], 404);
    }
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    try {
        $exercice = Exercice::find($id);
        if ($exercice) {
            $exercice->fill($request->all());
            $exercice->save();
            return response()->json($exercice);
        } else {
            return response()->json(['message' => 'Exercice not found'], 404);
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
    $exercice = Exercice::find($id);
    if ($exercice) {
        $exercice->delete();
        return response()->json(['message' => 'Exercice deleted']);
    } else {
        return response()->json(['message' => 'Exercice not found'], 404);
    }
}
}