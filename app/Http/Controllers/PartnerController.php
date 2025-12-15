<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->paginate(10);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'partner_type' => 'required|in:strategic,sponsor,vendor,associate,technology',
            'level' => 'required|in:platinum,gold,silver,bronze',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('partners/banners', 'public');
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner added successfully.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'partner_type' => 'required|in:strategic,sponsor,vendor,associate,technology',
            'level' => 'required|in:platinum,gold,silver,bronze',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            if ($partner->logo) Storage::disk('public')->delete($partner->logo);
            $data['logo'] = $request->file('logo')->store('partners/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($partner->banner) Storage::disk('public')->delete($partner->banner);
            $data['banner'] = $request->file('banner')->store('partners/banners', 'public');
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner updated successfully.');
    }

    public function show(Partner $partner)
    {
        return view('admin.partners.show', compact('partner'));
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) Storage::disk('public')->delete($partner->logo);
        if ($partner->banner) Storage::disk('public')->delete($partner->banner);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner deleted successfully.');
    }
}
