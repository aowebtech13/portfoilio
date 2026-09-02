<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::where('is_published', true)
            ->with(['media' => function ($query) {
                $query->orderBy('sort_order')->orderBy('id');
            }])
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'subtitle', 'slug', 'category', 'client', 'start_date', 'designer', 'hero_image']);

        return response()->json($projects);
    }

    public function show(string $slug): JsonResponse
    {
        $project = Project::where('slug', $slug)
            ->where('is_published', true)
            ->with(['media' => function ($query) {
                $query->orderBy('sort_order')->orderBy('id');
            }])
            ->firstOrFail();

        return response()->json($project);
    }
}
