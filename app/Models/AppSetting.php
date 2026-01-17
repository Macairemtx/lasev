<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    /**
     * Récupérer une valeur de paramètre par sa clé
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Définir une valeur de paramètre
     */
    public static function setValue($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Récupérer tous les paramètres par groupe
     */
    public static function getByGroup($group)
    {
        return self::where('group', $group)->get();
    }

    /**
     * Récupérer tous les paramètres formatés pour l'API
     */
    public static function getAllForApi()
    {
        $settings = self::all();
        $formatted = [];
        
        foreach ($settings as $setting) {
            $formatted[$setting->key] = [
                'value' => $setting->value,
                'type' => $setting->type,
                'label' => $setting->label,
            ];
        }
        
        return $formatted;
    }
}

