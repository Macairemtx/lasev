<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodComfortForm;
use Illuminate\Http\Request;

class FoodComfortFormController extends Controller
{
    /**
     * Afficher la liste des formulaires de confort alimentaire
     */
    public function index()
    {
        $forms = FoodComfortForm::with(['user', 'retreatPlan'])
            ->latest()
            ->paginate(15);
            
        return view('admin.food-comfort-forms.index', compact('forms'));
    }

    /**
     * Afficher les détails d'un formulaire
     */
    public function show($id)
    {
        $form = FoodComfortForm::with(['user', 'retreatPlan'])->findOrFail($id);
        return view('admin.food-comfort-forms.show', compact('form'));
    }

    /**
     * Supprimer un formulaire
     */
    public function destroy($id)
    {
        $form = FoodComfortForm::findOrFail($id);
        $form->delete();

        return redirect()->route('admin.food-comfort-forms.index')
            ->with('success', 'Formulaire supprimé avec succès.');
    }
}

