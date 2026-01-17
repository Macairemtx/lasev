<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, image, video, boolean, json
            $table->string('group')->default('general'); // general, appearance, content, media
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insérer les paramètres par défaut
        $settings = [
            // Media - Vidéo de démarrage
            ['key' => 'app_startup_video', 'value' => null, 'type' => 'video', 'group' => 'media', 'label' => 'Vidéo de démarrage', 'description' => 'Vidéo qui s\'affiche au démarrage de l\'application'],
            ['key' => 'app_background_image', 'value' => null, 'type' => 'image', 'group' => 'appearance', 'label' => 'Image de fond', 'description' => 'Image de fond principale de l\'application'],
            ['key' => 'app_logo', 'value' => null, 'type' => 'image', 'group' => 'appearance', 'label' => 'Logo de l\'application', 'description' => 'Logo affiché dans l\'application'],
            ['key' => 'app_splash_image', 'value' => null, 'type' => 'image', 'group' => 'appearance', 'label' => 'Image Splash Screen', 'description' => 'Image affichée au démarrage'],
            
            // Couleurs et thème
            ['key' => 'app_primary_color', 'value' => '#265533', 'type' => 'text', 'group' => 'appearance', 'label' => 'Couleur principale', 'description' => 'Couleur principale de l\'application (hex)'],
            ['key' => 'app_secondary_color', 'value' => '#4CAF50', 'type' => 'text', 'group' => 'appearance', 'label' => 'Couleur secondaire', 'description' => 'Couleur secondaire (hex)'],
            
            // Contenu
            ['key' => 'app_name', 'value' => 'LASEV Meditation', 'type' => 'text', 'group' => 'general', 'label' => 'Nom de l\'application', 'description' => 'Nom affiché dans l\'application'],
            ['key' => 'app_description', 'value' => 'Application de méditation et bien-être', 'type' => 'text', 'group' => 'general', 'label' => 'Description', 'description' => 'Description de l\'application'],
            ['key' => 'app_welcome_message', 'value' => 'Bienvenue dans votre espace de méditation', 'type' => 'text', 'group' => 'content', 'label' => 'Message de bienvenue', 'description' => 'Message affiché lors du premier lancement'],
            
            // Paramètres généraux
            ['key' => 'app_version', 'value' => '1.0.0', 'type' => 'text', 'group' => 'general', 'label' => 'Version de l\'application', 'description' => 'Version actuelle'],
            ['key' => 'app_maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'general', 'label' => 'Mode maintenance', 'description' => 'Activer/désactiver le mode maintenance'],
            ['key' => 'app_notification_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'general', 'label' => 'Notifications activées', 'description' => 'Activer les notifications push'],
            
            // Social et contact
            ['key' => 'app_contact_email', 'value' => 'contact@lasev.com', 'type' => 'text', 'group' => 'general', 'label' => 'Email de contact', 'description' => 'Email pour les contacts'],
            ['key' => 'app_contact_phone', 'value' => null, 'type' => 'text', 'group' => 'general', 'label' => 'Téléphone de contact', 'description' => 'Numéro de téléphone'],
            ['key' => 'app_website_url', 'value' => null, 'type' => 'text', 'group' => 'general', 'label' => 'URL du site web', 'description' => 'Lien vers le site web'],
            
            // Médias additionnels
            ['key' => 'app_background_video_1', 'value' => null, 'type' => 'video', 'group' => 'media', 'label' => 'Vidéo de fond 1', 'description' => 'Première vidéo de fond optionnelle'],
            ['key' => 'app_background_video_2', 'value' => null, 'type' => 'video', 'group' => 'media', 'label' => 'Vidéo de fond 2', 'description' => 'Deuxième vidéo de fond optionnelle'],
            ['key' => 'app_background_video_3', 'value' => null, 'type' => 'video', 'group' => 'media', 'label' => 'Vidéo de fond 3', 'description' => 'Troisième vidéo de fond optionnelle'],
            ['key' => 'app_background_video_4', 'value' => null, 'type' => 'video', 'group' => 'media', 'label' => 'Vidéo de fond 4', 'description' => 'Quatrième vidéo de fond optionnelle'],
        ];

        foreach ($settings as $setting) {
            DB::table('app_settings')->insert([
                ...$setting,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};

