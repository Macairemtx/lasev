<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    // Lister tous les événements avec leurs images
    public function index()
    {
        $events = Event::with('media')->get();
        return response()->json($events);
    }

    // Afficher un événement
    public function show($id)
    {
        $event = Event::with('media')->findOrFail($id);
        return response()->json($event);
    }

    // Créer un événement avec une galerie d'images
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'status' => 'nullable|in:upcoming,ongoing,completed,cancelled',
            'images' => 'required|array|min:1',
            'images.*.title' => 'required|string|max:255',
            'images.*.slug' => 'nullable|string|max:255|unique:media,slug',
            'images.*.file_path' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $event = Event::create($request->only(['title', 'description', 'event_date', 'location', 'price', 'status']));
        foreach ($request->images as $img) {
            $media = new Media([
                'title' => $img['title'],
                'slug' => $img['slug'] ?? null,
                'media_type' => 'image',
                'file_path' => $img['file_path'],
            ]);
            $event->media()->save($media);
        }
        $event->load('media');
        return response()->json(['success' => true, 'data' => $event], 201);
    }

    // Mettre à jour un événement (sans gestion fine de la galerie ici)
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'sometimes|required|date',
            'location' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'status' => 'nullable|in:upcoming,ongoing,completed,cancelled',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $event->update($request->only(['title', 'description', 'event_date', 'location', 'price', 'status']));
        $event->load('media');
        return response()->json(['success' => true, 'data' => $event]);
    }

    // Supprimer un événement et ses images
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        foreach ($event->media as $media) {
            $media->delete();
        }
        $event->delete();
        return response()->json(['success' => true, 'message' => 'Événement supprimé']);
    }
}
