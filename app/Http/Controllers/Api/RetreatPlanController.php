<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RetreatPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RetreatPlanController extends Controller
{
    // Lister tous les plans de retraite
    public function index()
    {
        $plans = RetreatPlan::all();
        return response()->json($plans);
    }

    // Afficher un plan de retraite
    public function show($id)
    {
        $plan = RetreatPlan::findOrFail($id);
        return response()->json($plan);
    }

    // Créer un plan de retraite
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_days' => 'required|integer',
            'cover_image' => 'nullable|string',
            'features' => 'nullable|array',
            'tags' => 'nullable|array',
            'services' => 'nullable|array',
            'status' => 'nullable|in:available,on_request,coming_soon',
            'price' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $plan = RetreatPlan::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration_days' => $request->duration_days,
            'cover_image' => $request->cover_image,
            'features' => $request->features ? json_encode($request->features) : null,
            'tags' => $request->tags ? json_encode($request->tags) : null,
            'services' => $request->services ? json_encode($request->services) : null,
            'status' => $request->status ?? 'available',
            'price' => $request->price,
        ]);
        return response()->json(['success' => true, 'data' => $plan], 201);
    }

    // Mettre à jour un plan de retraite
    public function update(Request $request, $id)
    {
        $plan = RetreatPlan::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'duration_days' => 'sometimes|required|integer',
            'cover_image' => 'nullable|string',
            'features' => 'nullable|array',
            'tags' => 'nullable|array',
            'services' => 'nullable|array',
            'status' => 'nullable|in:available,on_request,coming_soon',
            'price' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $plan->update([
            'title' => $request->title ?? $plan->title,
            'description' => $request->description ?? $plan->description,
            'duration_days' => $request->duration_days ?? $plan->duration_days,
            'cover_image' => $request->cover_image ?? $plan->cover_image,
            'features' => $request->features ? json_encode($request->features) : $plan->features,
            'tags' => $request->tags ? json_encode($request->tags) : $plan->tags,
            'services' => $request->services ? json_encode($request->services) : $plan->services,
            'status' => $request->status ?? $plan->status,
            'price' => $request->price ?? $plan->price,
        ]);
        return response()->json(['success' => true, 'data' => $plan]);
    }

    // Supprimer un plan de retraite
    public function destroy($id)
    {
        $plan = RetreatPlan::findOrFail($id);
        $plan->delete();
        return response()->json(['success' => true, 'message' => 'Plan supprimé']);
    }
}
