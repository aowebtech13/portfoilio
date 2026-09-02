<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'client' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'string', 'max:255'],
            'designer' => ['nullable', 'string', 'max:255'],
            'overview' => ['nullable', 'string'],
            'background_content' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'url', 'max:2048'],
            'is_published' => ['boolean'],
            'media' => ['nullable', 'array'],
            'media.*.type' => ['required_with:media', 'in:image,video'],
            'media.*.url' => ['required_with:media', 'url', 'max:2048'],
            'media.*.caption' => ['nullable', 'string', 'max:255'],
            'media.*.section' => ['required_with:media', 'in:hero,portfolio,background,testimonial'],
            'media.*.sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published', false);

        $project = Project::create($validated);

        if (!empty($validated['media'])) {
            foreach ($validated['media'] as $index => $mediaItem) {
                $project->media()->create([
                    'type' => $mediaItem['type'],
                    'url' => $mediaItem['url'],
                    'caption' => $mediaItem['caption'] ?? null,
                    'section' => $mediaItem['section'] ?? 'portfolio',
                    'sort_order' => $mediaItem['sort_order'] ?? $index,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $project->load('media');
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'client' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'string', 'max:255'],
            'designer' => ['nullable', 'string', 'max:255'],
            'overview' => ['nullable', 'string'],
            'background_content' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'url', 'max:2048'],
            'is_published' => ['boolean'],
            'media' => ['nullable', 'array'],
            'media.*.type' => ['required_with:media', 'in:image,video'],
            'media.*.url' => ['required_with:media', 'url', 'max:2048'],
            'media.*.caption' => ['nullable', 'string', 'max:255'],
            'media.*.section' => ['required_with:media', 'in:hero,portfolio,background,testimonial'],
            'media.*.sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published', false);

        $project->update($validated);

        if (!empty($validated['media'])) {
            $project->media()->delete();
            foreach ($validated['media'] as $index => $mediaItem) {
                $project->media()->create([
                    'type' => $mediaItem['type'],
                    'url' => $mediaItem['url'],
                    'caption' => $mediaItem['caption'] ?? null,
                    'section' => $mediaItem['section'] ?? 'portfolio',
                    'sort_order' => $mediaItem['sort_order'] ?? $index,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
