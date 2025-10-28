<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Articles;
use App\Http\Requests\StoreArticlesRequest;
use App\Http\Requests\UpdateArticlesRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($category)
    {
        // Find the category by slug
        $cat = Category::where('slug', $category)->firstOrFail();

        // Fetch all articles under this category
        $posts = Articles::with('category', 'author')
            ->where('category_id', $cat->id)
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->orderBy('created_at', 'desc')
            ->paginate();
        return inertia('Posts/Index', [
            'posts' => $posts,
            'categories' => Category::orderby('name', 'ASC')->get(),
        ]);
    }

    public function getByArchive($archive)
    {
        // Find the category by slug
        $cat = Archive::where('slug', $archive)->firstOrFail();

        // Fetch all articles under this category
        $posts = Articles::with('category', 'author')
            ->where('archive_id', $cat->id)
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->orderBy('created_at', 'desc')
            ->paginate();
        return inertia('Posts/Index', [
            'posts' => $posts,
            'categories' => Category::orderby('name', 'ASC')->get(),
        ]);
    }

    public function fetchAll()
    {
        $posts = Articles::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate();
        return inertia('Posts/Index', [
            'posts' => $posts,
            'categories' => Category::orderby('name', 'ASC')->get(),
        ]);
    }



    public function adminPostsIndex()
    {
        $posts = Articles::with('category', 'author')
            ->orderBy('created_at', 'desc')
            ->get();

        return inertia('Admin/Posts/Index', [
            'posts' => $posts
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia::render('Admin/Posts/Create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticlesRequest $request)
    {
        $data = $request->validated();

        $now = Carbon::now();

        // Create or get the archive for this month
        $archive = Archive::firstOrCreate(
            [
                'slug' => $now->format('F-Y'), // e.g. October-2025
            ],
            [
                'name' => $now->format('F Y'), // e.g. October 2025
            ]
        );

            $data['archive_id'] = $archive->id;

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('articles', 'public');
            $data['featured_image'] = $path;
        }

        // Handle tags if sent as JSON string
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = json_decode($data['tags'], true);
        }

        // Generate slug if not provided
//        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = \Str::slug($data['title']);
//        }

        // Save to database
        $article = Articles::create($data);

        // Build the update URL dynamically
        $updateUrl = route('admin.post.edit', ['article' => $article->id]);

        return response()->json([
            'message' => 'Article created successfully',
            'data' => $article,
            'update_url' => $updateUrl
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($category,  $slug)
    {
        $categoryQ  = Category::where('slug', $category)->firstOrFail();

        $articleToView = Articles::with('category', 'author')
            ->where('category_id', $categoryQ->id)
            ->where('slug', $slug)->firstOrFail();

        return inertia::render('Posts/Show', [
            'article' => $articleToView,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Articles $article)
    {
        return inertia::render('Admin/Posts/Create', [
            'article' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticlesRequest $request, Articles $article)
    {
        $data = $request->validated();

        // Handle featured image (can be file or string URL)
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($article->featured_image && \Storage::disk('public')->exists($article->featured_image)) {
                \Storage::disk('public')->delete($article->featured_image);
            }

            // Store new image
            $path = $request->file('featured_image')->store('articles', 'public');
            $data['featured_image'] = $path;
        } elseif (isset($data['featured_image']) && is_string($data['featured_image'])) {
            // Use existing string URL directly
            $data['featured_image'] = $data['featured_image'];
        }

        // Handle tags
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = json_decode($data['tags'], true);
        }

        // Auto-generate slug if empty
//        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = \Str::slug($data['title']);
//        }

        // Update record
        $article->update($data);

        return response()->json([
            'message' => 'Article updated successfully',
            'data' => $article
        ], 200);
    }


    public function toggleStatus(Request $request, Articles $article)
    {
        $request->validate([
            'status' => 'required|in:published,draft',
        ]);

        $article->update([
            'status' => $request->status,
            'published_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Status updated']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Articles $articles)
    {
        //
    }
}
