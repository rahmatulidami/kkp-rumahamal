<!-- resources/views/posts/edit.blade.php -->

@extends('layouts.layout')

@section('title', 'Edit Post')

@section('content')

<main class="main">

    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Edit Post</h1>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Page Title -->

    <div class="container">
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" class="form-control">
                @if ($post->thumbnail)
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail" class="img-thumbnail mt-2" style="width: 150px;">
                @endif
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea id="content" name="content" class="form-control" rows="10">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="categories" class="form-label">Categories</label>
                <select id="categories" name="categories[]" class="form-select" multiple required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <input type="text" id="tags" name="tags" class="form-control" value="{{ old('tags', $post->tags->pluck('name')->implode(',')) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>

</main>

@endsection
