@extends('posts.layout')

@section('content')
<main id="main" class="main">
<div class="container">
    <h1>Posts</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">Add New Post</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Thumbnail</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Categories</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td><img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" width="100" class="shadow mb-5 bg-body-tertiary rounded"></td>
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->updated_at }}</td>
                    <td>{{ implode(', ', $post->categories->pluck('name')->toArray()) }}</td>
                    <td>
                        <div class="btn-group d-flex justify-content-between pe-3">
                            <button type="button" class="btn btn-info" onclick="previewPost('{{ route('posts.show', $post->id) }}')">Preview</button>
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning rounded">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function previewPost(url) {
        window.open(url, '_blank', 'width=800,height=600');
    }
</script>
</main>
@endsection
