<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsultationController extends Controller
{
    /**
     * Display feed items (CMS blocks).
     */
    public function index()
    {
        $consultations = Consultation::orderBy('display_order')
            ->latest()
            ->paginate(10);

        return view('admin.consultations.index', compact('consultations'));
    }

    /**
     * Show form to create a new feed item.
     */
    public function create()
    {
        return view('admin.consultations.create');
    }

    /**
     * Store a new feed item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'nullable|string|max:255|unique:consultations,key',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',

            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:500',

            'display_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_public' => 'nullable|boolean',
        ]);

        // Auto-generate key if not provided
        if (empty($validated['key'])) {
            $validated['key'] = Str::slug($validated['title']);
        }

        // Boolean safety
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active']   = $request->boolean('is_active', true);
        $validated['is_public']   = $request->boolean('is_public', true);

        // Audit
        $validated['created_by'] = auth()->id();

        Consultation::create($validated);

        return redirect()
            ->route('admin.consultations.index')
            ->with('success', 'Feed section created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(Consultation $consultation)
    {
        return view('admin.consultations.edit', compact('consultation'));
    }

    /**
     * Update feed item.
     */
    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:consultations,key,' . $consultation->id,
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',

            'cta_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:500',

            'display_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_public' => 'nullable|boolean',
        ]);

        // Boolean safety
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active']   = $request->boolean('is_active', true);
        $validated['is_public']   = $request->boolean('is_public', true);

        // Audit
        $validated['updated_by'] = auth()->id();

        $consultation->update($validated);

        return redirect()
            ->route('admin.consultations.index')
            ->with('success', 'Feed section updated successfully.');
    }

    /**
     * Delete feed item.
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()
            ->route('admin.consultations.index')
            ->with('success', 'Feed section deleted successfully.');
    }
}
