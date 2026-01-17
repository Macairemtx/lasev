<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetreatPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RetreatPlanController extends Controller
{
    /**
     * Afficher la liste des plans de retraite
     */
    public function index()
    {
        $plans = RetreatPlan::latest()->paginate(15);
        return view('admin.retreat-plans.index', compact('plans'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.retreat-plans.create');
    }

    /**
     * Enregistrer un nouveau plan de retraite
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_days' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'tags' => 'nullable|string',
            'services' => 'nullable|string',
            'status' => 'required|in:available,on_request,coming_soon',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Gérer l'upload de l'image
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('retreat-plans', 'public');
            $data['cover_image'] = $path;
        }

        // Convertir les champs JSON
        if ($request->filled('features')) {
            $features = array_filter(array_map('trim', explode(',', $request->features)));
            $data['features'] = json_encode($features);
        }

        if ($request->filled('tags')) {
            $tags = array_filter(array_map('trim', explode(',', $request->tags)));
            $data['tags'] = json_encode($tags);
        }

        if ($request->filled('services')) {
            $services = array_filter(array_map('trim', explode(',', $request->services)));
            $data['services'] = json_encode($services);
        }

        RetreatPlan::create($data);

        return redirect()->route('admin.retreat-plans.index')
            ->with('success', 'Plan de retraite créé avec succès.');
    }

    /**
     * Afficher un plan de retraite
     */
    public function show($id)
    {
        $plan = RetreatPlan::findOrFail($id);
        return view('admin.retreat-plans.show', compact('plan'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $plan = RetreatPlan::findOrFail($id);
        return view('admin.retreat-plans.edit', compact('plan'));
    }

    /**
     * Mettre à jour un plan de retraite
     */
    public function update(Request $request, $id)
    {
        $plan = RetreatPlan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_days' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'tags' => 'nullable|string',
            'services' => 'nullable|string',
            'status' => 'required|in:available,on_request,coming_soon',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Gérer l'upload de l'image
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image
            if ($plan->cover_image) {
                Storage::disk('public')->delete($plan->cover_image);
            }
            $path = $request->file('cover_image')->store('retreat-plans', 'public');
            $data['cover_image'] = $path;
        } else {
            unset($data['cover_image']);
        }

        // Convertir les champs JSON
        if ($request->filled('features')) {
            $features = array_filter(array_map('trim', explode(',', $request->features)));
            $data['features'] = json_encode($features);
        } else {
            $data['features'] = null;
        }

        if ($request->filled('tags')) {
            $tags = array_filter(array_map('trim', explode(',', $request->tags)));
            $data['tags'] = json_encode($tags);
        } else {
            $data['tags'] = null;
        }

        if ($request->filled('services')) {
            $services = array_filter(array_map('trim', explode(',', $request->services)));
            $data['services'] = json_encode($services);
        } else {
            $data['services'] = null;
        }

        $plan->update($data);

        return redirect()->route('admin.retreat-plans.index')
            ->with('success', 'Plan de retraite mis à jour avec succès.');
    }

    /**
     * Supprimer un plan de retraite
     */
    public function destroy($id)
    {
        $plan = RetreatPlan::findOrFail($id);
        
        // Supprimer l'image
        if ($plan->cover_image) {
            Storage::disk('public')->delete($plan->cover_image);
        }
        
        $plan->delete();

        return redirect()->route('admin.retreat-plans.index')
            ->with('success', 'Plan de retraite supprimé avec succès.');
    }
}

