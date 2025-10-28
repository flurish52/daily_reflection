<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
      return  inertia::render('Admin/Events', [
          'events' => Event::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function homeIndex()
    {
        $events = Event::with('post.category')
            ->orderBy('happening_date', 'desc')
            ->paginate(5);

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'post_id' => 'nullable|exists:articles,id',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'happening_date' => 'required|date',
            'status' => 'required|string|in:upcoming,completed,cancelled',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $validated['image'] = $path;
        }

        $event = Event::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Saved',
        ], 200);

    }


    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'post_id' => 'nullable|exists:articles,id',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'happening_date' => 'required|date',
            'status' => 'required|string|in:upcoming,past,cancelled',
            'image' => 'nullable',
        ]);

        // Handle image upload or keep existing
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($event->image && file_exists(public_path('storage/' . $event->image))) {
                unlink(public_path('storage/' . $event->image));
            }

            $path = $request->file('image')->store('events', 'public');
            $validated['image'] = $path;
        } elseif (is_string($request->image)) {
            // Keep existing URL or path string
            $validated['image'] = $request->image;
        }

        $event->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Saved',
        ], 200);

    }



    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found',
            ], 404);
        }

        // Delete image if it exists
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully',
        ], 200);
    }

}
