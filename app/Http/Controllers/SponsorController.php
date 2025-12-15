<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::latest()->paginate(10);
        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        return view('admin.sponsors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'sponsorship_level' => 'required|in:platinum,gold,silver,bronze',
            'sponsor_type' => 'required|in:event,chapter,network,brand',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sponsors/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('sponsors/banners', 'public');
        }

        Sponsor::create($data);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor added successfully.');
    }

    public function show(Sponsor $sponsor)
    {
        return view('admin.sponsors.show', compact('sponsor'));
    }

    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'sponsorship_level' => 'required|in:platinum,gold,silver,bronze',
            'sponsor_type' => 'required|in:event,chapter,network,brand',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            if ($sponsor->logo) Storage::disk('public')->delete($sponsor->logo);
            $data['logo'] = $request->file('logo')->store('sponsors/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($sponsor->banner) Storage::disk('public')->delete($sponsor->banner);
            $data['banner'] = $request->file('banner')->store('sponsors/banners', 'public');
        }

        $sponsor->update($data);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor updated successfully.');
    }

    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo) Storage::disk('public')->delete($sponsor->logo);
        if ($sponsor->banner) Storage::disk('public')->delete($sponsor->banner);
        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor deleted successfully.');
    }
}
