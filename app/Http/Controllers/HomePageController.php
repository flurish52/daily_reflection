<?php

namespace App\Http\Controllers;

use App\Models\HomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia::render('Admin/EditHome', [
            'sections' => HomePage::orderBy('order', 'DESC')->get(),
        ]);
    }

    public function getSections()
    {
           return $sections = HomePage::orderBy('order', 'DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:200048',
            'background_value' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:200048',
            'background_type' => 'required|in:color,image,none',
            'text_color' => 'nullable|string|max:255',
            'layout_type' => 'required|in:text_left_image_right,image_left_text_right,image_top,image_bottom,centered,full_width',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $validated['user_id'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/sections', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        }

        // Handle background image upload
        if ($request->hasFile('background_value')) {
            $bgPath = $request->file('background_value')->store('uploads/backgrounds', 'public');
            $validated['background_value'] = '/storage/' . $bgPath;
        }

        $homePage = HomePage::create($validated);

        return response()->json([
            'message' => 'Section created successfully',
            'data' => $homePage
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(HomePage $homePage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomePage $homePage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomePage $section)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' =>  $request->hasFile('image')
                ? 'nullable|file|mimes:jpg,jpeg,png,webp|max:200048'
                : 'nullable|string',
            'background_value' =>  $request->hasFile('background_value')
                ? 'nullable|file|mimes:jpg,jpeg,png,webp|max:200048'
                : 'nullable|string',
            'background_type' => 'required|in:color,image,none',
            'text_color' => 'nullable|string|max:255',
            'layout_type' => 'required|in:text_left_image_right,image_left_text_right,image_top,image_bottom,centered,full_width',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('uploads/sections', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        } elseif (is_string($request->image)) {
            $validated['image'] = $request->image;
        }
        if ($request->hasFile('background_value')) {
            $bgPath = $request->file('background_value')
                ->store('uploads/backgrounds', 'public');
            $validated['background_value'] = '/storage/' . $bgPath;
        } elseif (is_string($request->background_value)) {
            $validated['background_value'] = $request->background_value;
        }

        $validated['user_id'] = auth()->id();

        $section->update($validated);

        return response()->json([
            'message' => 'Section updated successfully',
            'data' => $section
        ]);
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomePage $section)
    {
        $section->delete();

        return response()->json([
            'message' => 'Section deleted successfully'
        ]);
    }

}
