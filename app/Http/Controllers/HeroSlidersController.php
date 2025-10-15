<?php

namespace App\Http\Controllers;

use App\Models\HeroSliders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HeroSlidersController extends Controller
{
    public function index()
    {
        return inertia::render('Admin/HeroSlider', [
        'slides' => HeroSliders::orderBy('order', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_text' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'text' => 'nullable|string',
            'background_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('background_image')) {
            $path = $request->file('background_image')->store('uploads/hero_sliders', 'public');
            $validated['background_image'] = '/storage/' . $path;
        }

        HeroSliders::create($validated);

        return response()->json([
            'message' => 'Hero slider added successfully',
        ], 201);
}


    public function destroy($slide)
    {
        $slide = HeroSliders::findOrFail($slide);

        if ($slide->background_image) {
            $imagePath = str_replace('/storage/', 'public/', $slide->background_image);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        $slide->delete();

        return response()->json([
            'message' => 'Hero slider deleted successfully'
        ]);
    }

}
