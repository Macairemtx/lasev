<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MeditationController;
use App\Http\Controllers\Api\GratitudeJournalController;
use App\Http\Controllers\Api\AffirmationController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\RetreatPlanController;
use App\Http\Controllers\Api\FoodComfortFormController;

// Route d'enregistrement temporaire (onboarding mobile)
Route::post('/auth/register-temporary', [AuthController::class, 'registerTemporary']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth route for login
Route::post('login', [AuthController::class, 'login']);

// CRUD Blogs (admin only, all media types)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('blogs', BlogController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('affirmations', AffirmationController::class);
    Route::apiResource('meditations', MeditationController::class);
});

// Journaux de gratitude (auth user only)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('gratitude-journals', [GratitudeJournalController::class, 'index']);
    Route::post('gratitude-journals', [GratitudeJournalController::class, 'store']);
    Route::get('gratitude-journals/{id}', [GratitudeJournalController::class, 'show']);
    Route::put('gratitude-journals/{id}', [GratitudeJournalController::class, 'update']);
    Route::delete('gratitude-journals/{id}', [GratitudeJournalController::class, 'destroy']);
});

// Events, affirmations, meditations accessibles en lecture à tous
Route::get('events', [EventController::class, 'index']);
Route::get('events/{id}', [EventController::class, 'show']);
Route::get('affirmations', [AffirmationController::class, 'index']);
Route::get('affirmations/{id}', [AffirmationController::class, 'show']);
Route::get('meditations', [MeditationController::class, 'index']);
Route::get('meditations/{id}', [MeditationController::class, 'show']);

// CRUD Retreat Plans
Route::apiResource('retreat-plans', RetreatPlanController::class);

// Phrase du jour
Route::get('daily-quote', [\App\Http\Controllers\Api\DailyQuoteController::class, 'getCurrentQuote'])->name('daily-quote.current');

// Soumettre ou mettre à jour la fiche food comfort
Route::post('food-comfort-form', [FoodComfortFormController::class, 'storeOrUpdate']);

// Route pour paiement et création/connexion utilisateur
Route::post('retreat-plans/{plan}/pay', [\App\Http\Controllers\Api\PaymentController::class, 'payAndRegisterOrLogin']);

// Paramètres de l'application (publics - pour Flutter)
Route::get('settings', [\App\Http\Controllers\Api\SettingsController::class, 'index']);
Route::get('settings/{key}', [\App\Http\Controllers\Api\SettingsController::class, 'show']);
Route::get('settings/group/{group}', [\App\Http\Controllers\Api\SettingsController::class, 'getByGroup']);

// Objectifs disponibles (pour l'onboarding)
Route::get('objectives', [\App\Http\Controllers\Api\ObjectiveController::class, 'index']);
