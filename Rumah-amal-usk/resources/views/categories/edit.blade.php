@extends('categories.layout')

@section('content')
<main id="main" class="main">
    <div class="container">
        <h1>{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h1>

        <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update' : 'Add' }}</button>
        </form>
    </div>
</main>
@endsection
