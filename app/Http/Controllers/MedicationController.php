<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index()
    {
        $medications = Medication::all();
        return response()->json($medications);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'presentation' => 'required|string',
            'concentration' => 'required|string',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'expiration_date' => 'required|date',
            'batch_number' => 'nullable|string',
            'provider' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        $medication = Medication::create($validated);

        return response()->json($medication, 201);
    }

    public function update(Request $request, $id)
    {
        $medication = Medication::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string',
            'presentation' => 'sometimes|required|string',
            'concentration' => 'sometimes|required|string',
            'stock' => 'sometimes|required|integer|min:0',
            'min_stock' => 'sometimes|required|integer|min:0',
            'expiration_date' => 'sometimes|required|date',
            'batch_number' => 'nullable|string',
            'provider' => 'nullable|string',
            'status' => 'sometimes|required|string|in:active,inactive',
        ]);

        $medication->update($validated);

        return response()->json($medication);
    }

    public function destroy($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();

        return response()->json(null, 204);
    }
}
