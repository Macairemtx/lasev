<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affirmation;
use App\Models\AffirmationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AffirmationController extends Controller
{
    public function index()
    {
        $affirmations = Affirmation::with('category')->latest()->paginate(15);
        return view('admin.affirmations.index', compact('affirmations'));
    }

    public function create()
    {
        $categories = AffirmationCategory::where('is_active', true)->orderBy('order')->get();
        return view('admin.affirmations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:affirmation_categories,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Affirmation::create($request->all());

        return redirect()->route('admin.affirmations.index')
            ->with('success', 'Affirmation créée avec succès.');
    }

    public function show($id)
    {
        $affirmation = Affirmation::with('category')->findOrFail($id);
        return view('admin.affirmations.show', compact('affirmation'));
    }

    public function edit($id)
    {
        $affirmation = Affirmation::findOrFail($id);
        $categories = AffirmationCategory::where('is_active', true)->orderBy('order')->get();
        return view('admin.affirmations.edit', compact('affirmation', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $affirmation = Affirmation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:affirmation_categories,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $affirmation->update($request->all());

        return redirect()->route('admin.affirmations.index')
            ->with('success', 'Affirmation mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $affirmation = Affirmation::findOrFail($id);
        $affirmation->delete();

        return redirect()->route('admin.affirmations.index')
            ->with('success', 'Affirmation supprimée avec succès.');
    }
}

