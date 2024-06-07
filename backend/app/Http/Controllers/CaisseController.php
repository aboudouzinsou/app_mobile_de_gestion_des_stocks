<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CaisseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $caisses = Caisse::all();
        return response()->json($caisses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255',
            'libelle' => 'required|string|max:255',
            'personnel_id' => 'required|integer|exists:personnels,id', // Assuming 'personnels' is the table name
        ]);

        try {
            $caisse = Caisse::create($data);
            return response()->json($caisse, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Caisse $caisse)
    {
        return response()->json($caisse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Caisse $caisse)
    {
        $data = $request->validate([
            'code' => 'sometimes|required|string|max:255',
            'libelle' => 'sometimes|required|string|max:255',
            'personnel_id' => 'sometimes|required|integer|exists:personnels,id',
        ]);

        try {
            $caisse->update($data);
            return response()->json($caisse);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caisse  $caisse
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Caisse $caisse)
    {
        $caisse->delete();
        return response()->json(null, 204);
    }
}