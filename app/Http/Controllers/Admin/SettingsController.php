<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Afficher la page CMS avec tous les paramètres groupés
     */
    public function index()
    {
        $groups = [
            'general' => AppSetting::getByGroup('general'),
            'appearance' => AppSetting::getByGroup('appearance'),
            'media' => AppSetting::getByGroup('media'),
            'content' => AppSetting::getByGroup('content'),
        ];

        return view('admin.settings.index', compact('groups'));
    }

    /**
     * Mettre à jour un paramètre
     */
    public function update(Request $request, $key)
    {
        $setting = AppSetting::where('key', $key)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'value' => 'nullable',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,mov|max:20480', // 20MB max
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $value = $request->input('value');

        // Gérer l'upload de fichiers pour les types image et video
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Supprimer l'ancien fichier si existe
            if ($setting->value) {
                Storage::disk('public')->delete($setting->value);
            }

            // Déterminer le dossier selon le type
            $folder = $setting->type === 'video' ? 'videos' : 'images';
            $path = $file->store($folder, 'public');
            
            $value = $path;
        }

        $setting->update(['value' => $value]);

        return back()->with('success', "Paramètre '{$setting->label}' mis à jour avec succès");
    }

    /**
     * Mettre à jour plusieurs paramètres en une fois
     */
    public function bulkUpdate(Request $request)
    {
        $settings = $request->input('settings', []);

        foreach ($settings as $key => $value) {
            $setting = AppSetting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            }
        }

        return back()->with('success', 'Paramètres mis à jour avec succès');
    }

    /**
     * Supprimer un fichier média
     */
    public function deleteFile($key)
    {
        $setting = AppSetting::where('key', $key)->firstOrFail();

        if ($setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
            $setting->update(['value' => null]);
            return back()->with('success', 'Fichier supprimé avec succès');
        }

        return back()->with('error', 'Fichier introuvable');
    }

    /**
     * Réinitialiser un paramètre à sa valeur par défaut
     */
    public function reset($key)
    {
        $setting = AppSetting::where('key', $key)->firstOrFail();
        
        // Supprimer le fichier si c'est un média
        if (in_array($setting->type, ['image', 'video']) && $setting->value) {
            Storage::disk('public')->delete($setting->value);
        }

        $defaults = [
            'app_primary_color' => '#265533',
            'app_secondary_color' => '#4CAF50',
            'app_name' => 'LASEV Meditation',
            'app_description' => 'Application de méditation et bien-être',
            'app_welcome_message' => 'Bienvenue dans votre espace de méditation',
            'app_version' => '1.0.0',
            'app_maintenance_mode' => '0',
            'app_notification_enabled' => '1',
            'app_contact_email' => 'contact@lasev.com',
        ];

        $value = $defaults[$key] ?? null;
        $setting->update(['value' => $value]);

        return back()->with('success', "Paramètre '{$setting->label}' réinitialisé");
    }
}

