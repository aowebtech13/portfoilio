@extends('admin.layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="admin-header">
        <h1>Edit Project</h1>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Back to Projects</a>
    </div>

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" id="projectForm">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Project Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required placeholder="Enter project title">
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $project->subtitle) }}" placeholder="e.g. Brand identity and web development">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <input type="text" id="category" name="category" value="{{ old('category', $project->category) }}" placeholder="e.g. Development">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client">Client</label>
                                <input type="text" id="client" name="client" value="{{ old('client', $project->client) }}" placeholder="e.g. Envato">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="text" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date) }}" placeholder="e.g. 7 August 2021">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="designer">Designer</label>
                                <input type="text" id="designer" name="designer" value="{{ old('designer', $project->designer) }}" placeholder="e.g. Ui-ThemeZ">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="overview">Project Overview</label>
                        <textarea id="overview" name="overview" placeholder="Enter project overview...">{{ old('overview', $project->overview) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="background_content">Background Content</label>
                        <textarea id="background_content" name="background_content" placeholder="Enter background section content...">{{ old('background_content', $project->background_content) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="hero_image">Hero Image URL (Cloudinary)</label>
                        <input type="url" id="hero_image" name="hero_image" value="{{ old('hero_image', $project->hero_image) }}" placeholder="https://res.cloudinary.com/...">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="is_published">Status</label>
                        <select id="is_published" name="is_published">
                            <option value="0" {{ old('is_published', $project->is_published) == 0 ? 'selected' : '' }}>Draft</option>
                            <option value="1" {{ old('is_published', $project->is_published) == 1 ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.1); margin: 30px 0;">

            <h3 style="margin-bottom: 20px; font-weight: 500;">Media (Images & Videos)</h3>
            <p style="color: rgba(255,255,255,0.6); font-size: 14px; margin-bottom: 20px;">Manage Cloudinary URLs for images and videos.</p>

            <div id="mediaContainer">
                @php
                    $existingMedia = $project->media->sortBy('sort_order');
                    $mediaIndex = 0;
                @endphp
                @foreach($existingMedia as $media)
                    <div class="media-item" data-index="{{ $mediaIndex }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label>Type</label>
                                    <select name="media[{{ $mediaIndex }}][type]">
                                        <option value="image" {{ $media->type == 'image' ? 'selected' : '' }}>Image</option>
                                        <option value="video" {{ $media->type == 'video' ? 'selected' : '' }}>Video</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label>URL (Cloudinary)</label>
                                    <input type="url" name="media[{{ $mediaIndex }}][url]" value="{{ $media->url }}" placeholder="https://res.cloudinary.com/...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label>Section</label>
                                    <select name="media[{{ $mediaIndex }}][section]">
                                        <option value="portfolio" {{ $media->section == 'portfolio' ? 'selected' : '' }}>Portfolio</option>
                                        <option value="hero" {{ $media->section == 'hero' ? 'selected' : '' }}>Hero</option>
                                        <option value="background" {{ $media->section == 'background' ? 'selected' : '' }}>Background</option>
                                        <option value="testimonial" {{ $media->section == 'testimonial' ? 'selected' : '' }}>Testimonial</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label>Sort Order</label>
                                    <input type="number" name="media[{{ $mediaIndex }}][sort_order]" value="{{ $media->sort_order }}" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label>Caption (optional)</label>
                                    <input type="text" name="media[{{ $mediaIndex }}][caption]" value="{{ $media->caption }}" placeholder="Image caption...">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.media-item').remove()" style="margin-top: 10px;">Remove</button>
                    </div>
                    @php $mediaIndex++; @endphp
                @endforeach
            </div>

            <button type="button" class="btn btn-secondary" onclick="addMediaItem()" style="margin-top: 15px;">+ Add Another Media</button>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                <button type="submit" class="btn btn-primary">Update Project</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary" style="margin-left: 10px;">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        let mediaCount = {{ $existingMedia->count() }};
        function addMediaItem() {
            const container = document.getElementById('mediaContainer');
            const index = mediaCount++;
            const div = document.createElement('div');
            div.className = 'media-item';
            div.setAttribute('data-index', index);
            div.innerHTML = `
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Type</label>
                            <select name="media[${index}][type]">
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>URL (Cloudinary)</label>
                            <input type="url" name="media[${index}][url]" placeholder="https://res.cloudinary.com/...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Section</label>
                            <select name="media[${index}][section]">
                                <option value="portfolio">Portfolio</option>
                                <option value="hero">Hero</option>
                                <option value="background">Background</option>
                                <option value="testimonial">Testimonial</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Sort Order</label>
                            <input type="number" name="media[${index}][sort_order]" value="${index}" min="0">
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-12">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Caption (optional)</label>
                            <input type="text" name="media[${index}][caption]" placeholder="Image caption...">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.media-item').remove()" style="margin-top: 10px;">Remove</button>
            `;
            container.appendChild(div);
        }
    </script>
@endsection
