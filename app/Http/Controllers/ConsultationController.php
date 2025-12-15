<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConsultationController extends Controller
{
    /**
     * Display a listing of consultations.
     */
    public function index()
    {
        $consultations = Consultation::latest()->paginate(10);
        return view('admin.consultations.index', compact('consultations'));
    }

    /**
     * Show the form for creating a new consultation.
     */
    public function create()
    {
        return view('admin.consultations.create');
    }

    /**
     * Store a newly created consultation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'consultation_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'mode' => 'required|in:online,offline,hybrid',
            'meeting_link' => 'nullable|string|max:500',
            'venue' => 'nullable|string|max:255',
            'consultant_name' => 'nullable|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled,rescheduled',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        Consultation::create($data);

        return redirect()->route('admin.consultations.index')->with('success', 'Consultation created successfully.');
    }

    /**
     * Show the form for editing the specified consultation.
     */
    public function edit(Consultation $consultation)
    {
        return view('admin.consultations.edit', compact('consultation'));
    }

    /**
     * Update the specified consultation.
     */
    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'consultation_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'mode' => 'required|in:online,offline,hybrid',
            'meeting_link' => 'nullable|string|max:500',
            'venue' => 'nullable|string|max:255',
            'consultant_name' => 'nullable|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled,rescheduled',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $consultation->update($data);

        return redirect()->route('admin.consultations.index')->with('success', 'Consultation updated successfully.');
    }

    /**
     * Remove the specified consultation.
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return redirect()->route('admin.consultations.index')->with('success', 'Consultation deleted successfully.');
    }
}
