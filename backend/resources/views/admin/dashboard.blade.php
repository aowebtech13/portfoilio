@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-header">
        <h1>Dashboard</h1>
        <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>

    <div class="stats-row">
        <div class="admin-card stat-card">
            <h3>Total Projects</h3>
            <p style="font-size: 36px; font-weight: 500; margin: 0;">{{ \App\Models\Project::count() }}</p>
        </div>
        <div class="admin-card stat-card">
            <h3>Published</h3>
            <p style="font-size: 36px; font-weight: 500; margin: 0;">{{ \App\Models\Project::where('is_published', true)->count() }}</p>
        </div>
        <div class="admin-card stat-card">
            <h3>Drafts</h3>
            <p style="font-size: 36px; font-weight: 500; margin: 0;">{{ \App\Models\Project::where('is_published', false)->count() }}</p>
        </div>
    </div>

    <div class="admin-card">
        <h3>Quick Actions</h3>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Create New Project</a>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary" style="margin-left: 10px;">View All Projects</a>
    </div>
@endsection
