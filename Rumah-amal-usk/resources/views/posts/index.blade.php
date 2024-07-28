@extends('posts.layout')

@section('content')
<main id="main" class="main">
    <div class="container mt-4">
        <h1 class="mb-4">Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Add New Post</a>

        <!-- Tabel Daftar Post -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Thumbnail</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Categories</th>
                        <th>Tags</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" width="100" class="img-thumbnail">
                            </td>
                            <td>{{ $post->created_at->format('d M Y') }}</td>
                            <td>{{ $post->updated_at->format('d M Y') }}</td>
                            <td>
                                @foreach($post->categories as $category)
                                    <span class="badge bg-primary me-1">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($post->tags as $tag)
                                    <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm" target="_blank">Preview</a>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function previewPost(url) {
            window.open(url, '_blank', 'width=800,height=600');
        }
    </script>
</main>
@endsection
