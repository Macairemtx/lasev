<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meditation;
use App\Models\Affirmation;
use App\Models\Event;
use App\Models\Blog;
use App\Models\User;
use App\Models\GratitudeJournal;
use App\Models\RetreatPlan;
use App\Models\FoodComfortForm;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord admin
     */
    public function index()
    {
        $stats = [
            'meditations' => Meditation::count(),
            'affirmations' => Affirmation::count(),
            'events' => Event::count(),
            'blogs' => Blog::count(),
            'users' => User::count(),
            'gratitude_journals' => GratitudeJournal::count(),
            'retreat_plans' => RetreatPlan::count(),
            'retreat_plans_available' => RetreatPlan::where('status', 'available')->count(),
            'food_comfort_forms' => FoodComfortForm::count(),
        ];

        // Dernières méditations
        $recentMeditations = Meditation::with('media')->latest()->take(5)->get();
        
        // Derniers utilisateurs
        $recentUsers = User::latest()->take(5)->get();

        // Plans de retraite disponibles (publiés)
        $availableRetreatPlans = RetreatPlan::where('status', 'available')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMeditations', 'recentUsers', 'availableRetreatPlans'));
    }
}

