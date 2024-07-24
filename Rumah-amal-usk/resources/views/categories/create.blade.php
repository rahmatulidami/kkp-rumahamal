@extends('admin.layout')

@section('content')
<main id="main" class="main">
    <div class="container">
        <h1>Add Categories</h1>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div id="categories-container"  style="padding-bottom: 10px;">
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name[]" id="name" class="form-control" required>
                </div>
            </div>

            <button type="button" class="btn btn-secondary" id="add-category">Add Another Category</button>
            <button type="submit" class="btn btn-primary">Save Categories</button>
        </form>
    </div>

    <script>
        document.getElementById('add-category').addEventListener('click', function() {
            var container = document.getElementById('categories-container');
            var inputGroup = document.createElement('div');
            inputGroup.className = 'form-group';
            inputGroup.innerHTML = `
                <label for="name">Category Name</label>
                <input type="text" name="name[]" id="name" class="form-control" required>
            `;
            container.appendChild(inputGroup);
        });
    </script>
</main>
@endsection
