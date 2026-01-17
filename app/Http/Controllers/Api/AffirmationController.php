<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Affirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AffirmationController extends Controller
{
    // Lister toutes les affirmations
    public function index(Request $request)
    {
        $query = Affirmation::query();
        if ($request->has('category_id')) {
            $query->where('category_id', intval($request->category_id));
        }
        $affirmations = $query->get();
        return response()->json($affirmations);
    }

    // Afficher une affirmation
    public function show($id)
    {
        $affirmation = Affirmation::findOrFail($id);
        return response()->json($affirmation);
    }

    // Créer une affirmation
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $affirmation = Affirmation::create($request->only(['category_id', 'title', 'body']));
        return response()->json(['success' => true, 'data' => $affirmation], 201);
    }

    // Mettre à jour une affirmation
    public function update(Request $request, $id)
    {
        $affirmation = Affirmation::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $affirmation->update($request->only(['category_id', 'title', 'body']));
        return response()->json(['success' => true, 'data' => $affirmation]);
    }

    // Supprimer une affirmation
    public function destroy($id)
    {
        $affirmation = Affirmation::findOrFail($id);
        $affirmation->delete();
        return response()->json(['success' => true, 'message' => 'Affirmation supprimée']);
    }

    /**
     * Afficher les affirmations par catégorie
     */
    public function byCategory($category_id)
    {
        $affirmations = Affirmation::where('category_id', intval($category_id))->get();
        return response()->json($affirmations);
    }
}
