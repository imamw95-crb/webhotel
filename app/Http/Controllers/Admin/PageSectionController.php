<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;

class PageSectionController extends Controller
{
    public function index()
    {
        $sections = PageSection::ordered()->get();

        return view('admin.sections.index', compact('sections'));
    }

    public function edit(PageSection $section)
    {
        return view('admin.sections.form', compact('section'));
    }

    public function update(Request $request, PageSection $section)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'content' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);
        $section->update($validated);
        PageSection::clearCache();

        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully.');
    }
}
