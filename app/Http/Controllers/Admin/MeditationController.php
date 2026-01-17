<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meditation;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeditationController extends Controller
{
    /**
     * Liste des méditations
     */
    public function index()
    {
        $meditations = Meditation::with('media')->latest()->paginate(15);
        return view('admin.meditations.index', compact('meditations'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('admin.meditations.create');
    }

    /**
     * Créer une méditation
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:meditations,slug',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
            'media_title' => 'required|string|max:255',
            'media_slug' => 'nullable|string|max:255|unique:media,slug',
            'media_file' => 'required|file|mimes:mp3,mp4,m4a,mov,avi,wav|max:102400', // 100MB max
            'media_type' => 'required|in:audio,video',
            'media_duration' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Gérer l'upload du fichier
        $file = $request->file('media_file');
        $mediaType = $request->media_type; // 'audio' ou 'video'
        
        // Créer le répertoire de stockage s'il n'existe pas
        $directory = $mediaType === 'video' ? 'storage/videos/meditations' : 'storage/audios/meditations';
        if (!file_exists(public_path($directory))) {
            mkdir(public_path($directory), 0755, true);
        }
        
        // Générer un nom de fichier unique
        $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $filePath = $directory . '/' . $fileName;
        
        // Déplacer le fichier
        $file->move(public_path($directory), $fileName);

        $meditation = Meditation::create($request->only(['title', 'slug', 'description', 'duration']));

        $media = new Media([
            'title' => $request->media_title,
            'slug' => $request->media_slug,
            'media_type' => $mediaType,
            'file_path' => $filePath,
            'duration' => $request->media_duration,
        ]);
        $meditation->media()->save($media);

        return redirect()->route('admin.meditations.index')
            ->with('success', 'Méditation créée avec succès');
    }

    /**
     * Afficher une méditation
     */
    public function show(Meditation $meditation)
    {
        $meditation->load('media');
        return view('admin.meditations.show', compact('meditation'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Meditation $meditation)
    {
        $meditation->load('media');
        return view('admin.meditations.edit', compact('meditation'));
    }

    /**
     * Mettre à jour une méditation
     */
    public function update(Request $request, Meditation $meditation)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:meditations,slug,' . $meditation->id,
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
            'media_title' => 'sometimes|required|string|max:255',
            'media_slug' => 'nullable|string|max:255|unique:media,slug,' . ($meditation->media->id ?? 'NULL'),
            'media_file' => 'sometimes|file|mimes:mp3,mp4,m4a,mov,avi,wav|max:102400', // 100MB max
            'media_type' => 'sometimes|required|in:audio,video',
            'media_duration' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $meditation->update($request->only(['title', 'slug', 'description', 'duration']));

        if ($meditation->media) {
            $updateData = [
                'title' => $request->media_title ?? $meditation->media->title,
                'slug' => $request->media_slug ?? $meditation->media->slug,
                'duration' => $request->media_duration ?? $meditation->media->duration,
            ];
            
            // Si un nouveau fichier est uploadé
            if ($request->hasFile('media_file')) {
                $file = $request->file('media_file');
                $mediaType = $request->media_type ?? $meditation->media->media_type;
                
                // Supprimer l'ancien fichier
                if ($meditation->media->file_path && file_exists(public_path($meditation->media->file_path))) {
                    unlink(public_path($meditation->media->file_path));
                }
                
                // Créer le répertoire de stockage s'il n'existe pas
                $directory = $mediaType === 'video' ? 'storage/videos/meditations' : 'storage/audios/meditations';
                if (!file_exists(public_path($directory))) {
                    mkdir(public_path($directory), 0755, true);
                }
                
                // Générer un nom de fichier unique
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $filePath = $directory . '/' . $fileName;
                
                // Déplacer le fichier
                $file->move(public_path($directory), $fileName);
                
                $updateData['file_path'] = $filePath;
                $updateData['media_type'] = $mediaType;
            }
            
            $meditation->media->update($updateData);
        }

        return redirect()->route('admin.meditations.index')
            ->with('success', 'Méditation mise à jour avec succès');
    }

    /**
     * Supprimer une méditation
     */
    public function destroy(Meditation $meditation)
    {
        if ($meditation->media) {
            $meditation->media->delete();
        }
        $meditation->delete();

        return redirect()->route('admin.meditations.index')
            ->with('success', 'Méditation supprimée avec succès');
    }
}

