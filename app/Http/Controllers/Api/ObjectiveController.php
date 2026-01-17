<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Objective;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    /**
     * Récupérer tous les objectifs disponibles
     */
    public function index()
    {
        $objectives = Objective::all();
        return response()->json($objectives);
    }
}

