<?php

namespace App\Http\Controllers;

use App\Models\AdminChapter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    public function index()
    {
        return view('chapters.index');
    }

    public function list()
    {
        return AdminChapter::with('members:id,name,email')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'          => 'nullable|exists:chapters,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'city'        => 'nullable|string|max:255',
            'pincode'     => 'nullable|string|max:20',
            'is_active'   => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $chapter = AdminChapter::updateOrCreate(
            ['id' => $validated['id'] ?? null],
            $validated
        );

        if (!$chapter->chapter_code) {
            $chapter->update([
                'chapter_code' => 'CHP-' . str_pad($chapter->id, 3, '0', STR_PAD_LEFT)
            ]);
        }

        return response()->json($chapter);
    }

    public function destroy(AdminChapter $chapter)
    {
        $chapter->delete();
        return response()->json(['success' => true]);
    }

    public function toggle(AdminChapter $chapter)
    {
        $chapter->update(['is_active' => !$chapter->is_active]);
        return response()->json(['is_active' => $chapter->is_active]);
    }

    public function assignMembers(Request $request, AdminChapter $chapter)
    {
        $validated = $request->validate([
            'members'   => 'array',
            'members.*' => 'exists:users,id',
        ]);

        $chapter->members()->sync($validated['members'] ?? []);

        return response()->json(['success' => true]);
    }

    public function members(AdminChapter $chapter)
    {
        return $chapter->members()
            ->select('users.id','users.name','users.email')
            ->get();
    }

    public function allMembers()
    {
        return User::where('role','member')
            ->select('id','name','email')
            ->get();
    }
}
