<?php

namespace App\Http\Controllers;

use App\Models\MemberCsr;
use App\Models\Chapter;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberCsrController extends Controller
{
    /**
     * Display a listing of CSR records.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = MemberCsr::with(['member', 'chapter'])
            ->when($user->role === 'member', fn($q) => $q->where('member_id', $user->id))
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('csr_title', 'like', "%$search%")
                        ->orWhere('csr_description', 'like', "%$search%")
                        ->orWhereHas('member', fn($u) => $u->where('name', 'like', "%$search%"));
                });
            })
            ->when($request->csr_type, fn($q) => $q->where('csr_type', $request->csr_type))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest();

        $csrs = $query->paginate(10);

        return view('member.csrs.index', compact('csrs'));
    }

    /**
     * Show form for creating a new CSR.
     */
    public function create()
    {
        $user = Auth::user();
        $chapters = Chapter::orderBy('name')->get();
        $events = Event::latest()->get();

        return view('member.csrs.create', compact('chapters', 'events'));
    }

    /**
     * Store a newly created CSR.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'csr_title' => 'required|string|max:255',
            'csr_description' => 'nullable|string',
            'csr_type' => 'required|string',
            'csr_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'amount_spent' => 'nullable|numeric',
            'volunteer_hours' => 'nullable|integer|min:0',
            'beneficiary_name' => 'nullable|string|max:255',
            'beneficiaries_count' => 'nullable|integer|min:0',
            'proof_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('proof_document')) {
            $validated['proof_document'] = $request->file('proof_document')->store('csr_proofs', 'public');
        }

        $validated['member_id'] = $user->id;
        $validated['chapter_id'] = $user->chapter_id;
        $validated['created_by'] = $user->id;
        $validated['status'] = 'pending';

        MemberCsr::create($validated);

       return redirect()->route($this->csrIndexRoute())
    ->with('success', 'CSR record added successfully!');

    }

    /**
     * Display CSR details.
     */
    public function show(MemberCsr $csr)
    {
        $csr->load(['member', 'chapter', 'event']);
        return view('member.csrs.show', compact('csr'));
    }

    /**
     * Edit CSR record.
     */
    public function edit(MemberCsr $csr)
    {
        $this->authorizeAccess($csr);

        $chapters = Chapter::orderBy('name')->get();
        $events = Event::latest()->get();

        return view('member.csrs.edit', compact('csr', 'chapters', 'events'));
    }

    /**
     * Update CSR record.
     */
    public function update(Request $request, MemberCsr $csr)
    {
        $this->authorizeAccess($csr);

        $validated = $request->validate([
            'csr_title' => 'required|string|max:255',
            'csr_description' => 'nullable|string',
            'csr_type' => 'required|string',
            'csr_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'amount_spent' => 'nullable|numeric',
            'volunteer_hours' => 'nullable|integer|min:0',
            'beneficiary_name' => 'nullable|string|max:255',
            'beneficiaries_count' => 'nullable|integer|min:0',
            'status' => 'nullable|string|in:pending,approved,rejected',
            'proof_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('proof_document')) {
            if ($csr->proof_document) Storage::disk('public')->delete($csr->proof_document);
            $validated['proof_document'] = $request->file('proof_document')->store('csr_proofs', 'public');
        }

        $csr->update($validated);

        return redirect()->route($this->csrIndexRoute())
    ->with('success', 'CSR record updated successfully!');

    }

    /**
     * Delete CSR record.
     */
    public function destroy(MemberCsr $csr)
    {
        $this->authorizeAccess($csr);

        if ($csr->proof_document) Storage::disk('public')->delete($csr->proof_document);
        $csr->delete();

        return redirect()->route($this->csrIndexRoute())
    ->with('success', 'CSR record deleted successfully!');

    }

    /**
     * Access control
     */
    protected function authorizeAccess(MemberCsr $csr)
    {
        $user = Auth::user();
        if ($user->role === 'member' && $csr->member_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }
    }
    protected function csrIndexRoute(): string
{
    $user = Auth::user();

    return $user->role === 'admin'
        ? 'admin.csrs.index'
        : 'member.csrs.index';
}

}
