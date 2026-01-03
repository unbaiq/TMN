<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InsightController extends Controller
{
    /**
     * Display a listing of insights.
     */
    public function index()
    {
        $insights = Insight::latest()->paginate(10);
        return view('admin.insights.index', compact('insights'));
    }

    /**
     * Show the form for creating a new insight.
     */
    public function create()
    {
        return view('admin.insights.create');
    }

    /**
     * Store a newly created insight.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'nullable|string|max:255',
            'author_name' => 'nullable|string|max:255',
            'publish_date' => 'nullable|date',
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('insights', 'public');
        }

        Insight::create($data);

        return redirect()->route('admin.insights.index')->with('success', 'Insight created successfully.');
    }

    /**
     * Display the specified insight.
     */
  
public function show(string $slug)
{
    $insight = Insight::where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    return view('user.detail-insight', compact('insight'));
}


    /**
     * Show the form for editing the specified insight.
     */
    public function edit(Insight $insight)
    {
        return view('admin.insights.edit', compact('insight'));
    }

    /**
     * Update the specified insight.
     */
    public function update(Request $request, Insight $insight)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'nullable|string|max:255',
            'author_name' => 'nullable|string|max:255',
            'publish_date' => 'nullable|date',
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($insight->image) {
                Storage::disk('public')->delete($insight->image);
            }
            $data['image'] = $request->file('image')->store('insights', 'public');
        }

        $insight->update($data);

        return redirect()->route('admin.insights.index')->with('success', 'Insight updated successfully.');
    }

    /**
     * Remove the specified insight.
     */
    public function destroy(Insight $insight)
    {
        if ($insight->image) {
            Storage::disk('public')->delete($insight->image);
        }

        $insight->delete();

        return redirect()->route('admin.insights.index')->with('success', 'Insight deleted successfully.');
    }
}
