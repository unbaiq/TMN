<?php

namespace App\Http\Controllers;

use App\Models\ConsultationRequest;
use Illuminate\Http\Request;

class ConsultationRequestController extends Controller
{
    /* ================= PUBLIC ================= */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:20',
            'city'       => 'nullable|string|max:100',
            'zip_code'   => 'nullable|string|max:20',
        ]);

        ConsultationRequest::create($validated);

        return back()->with('success', 'Consultation request submitted successfully.');
    }

    /* ================= ADMIN ================= */

    public function index()
    {
        $requests = ConsultationRequest::latest()->paginate(10);

        return view('admin.consultation-request.index', compact('requests'));
    }

    public function show(ConsultationRequest $consultationRequest)
    {
        return view('admin.consultation-request.show', compact('consultationRequest'));
    }

    public function edit(ConsultationRequest $consultationRequest)
    {
        return view('admin.consultation-request.edit', compact('consultationRequest'));
    }

    public function destroy(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->delete();

        return redirect()
            ->route('admin.consultation-request.index')
            ->with('success', 'Consultation request deleted.');
    }
     

    /**
     * Update status
     */
    public function update(Request $request, ConsultationRequest $consultationRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,closed',
        ]);

        $consultationRequest->update($validated);

        return redirect()
            ->route('admin.consultation-requests.index')
            ->with('success', 'Consultation request status updated successfully.');
    }
}
