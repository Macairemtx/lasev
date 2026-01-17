<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Récupérer tous les paramètres de l'application pour Flutter
     */
    public function index()
    {
        $settings = AppSetting::getAllForApi();
        
        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    /**
     * Récupérer un paramètre spécifique
     */
    public function show($key)
    {
        $setting = AppSetting::where('key', $key)->first();
        
        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Paramètre non trouvé'
            ], 404);
        }

        // Pour les fichiers, retourner l'URL complète
        $value = $setting->value;
        if (in_array($setting->type, ['image', 'video']) && $value) {
            $value = asset('storage/' . $value);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'key' => $setting->key,
                'value' => $value,
                'type' => $setting->type,
                'label' => $setting->label,
            ]
        ]);
    }

    /**
     * Récupérer les paramètres par groupe
     */
    public function getByGroup($group)
    {
        $settings = AppSetting::getByGroup($group);
        
        $formatted = [];
        foreach ($settings as $setting) {
            $value = $setting->value;
            if (in_array($setting->type, ['image', 'video']) && $value) {
                $value = asset('storage/' . $value);
            }
            
            $formatted[$setting->key] = [
                'value' => $value,
                'type' => $setting->type,
                'label' => $setting->label,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $formatted
        ]);
    }
}

