@extends('posts.layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <h1>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h1>

    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($post))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ isset($post) ? $post->title : '' }}" required>
        </div>

        <div class="form-group">
            <label for="thumbnail">Thumbnail</label>
            <div class="d-flex justify-content-center">
                @if (isset($post) && $post->thumbnail)
                    <img id="thumbnail-preview" src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail Preview" style="max-width: 200px; margin-bottom:10px; border-radius:15px;">
                @else
                    <img id="thumbnail-preview" src="#" alt="Thumbnail Preview" style="display: none; max-width: 200px;">
                @endif
            </div>
            <input type="file" name="thumbnail" id="thumbnail" class="form-control">
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control ckeditor">{{ isset($post) ? $post->content : '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="categories">Categories</label>
            <div class="select-btn">
                <span class="btn-text">Select Categories</span>
                <span class="arrow-dwn">
                    <i class="fa-solid fa-chevron-down"></i>
                </span>
            </div>

            <ul class="list-items">
                @foreach($categories as $category)
                    <li class="item {{ isset($post) && $post->categories->contains($category->id) ? 'checked' : '' }}">
                        <span class="checkbox">
                            <i class="fa-solid fa-check check-icon"></i>
                        </span>
                        <span class="item-text">{{ $category->name }}</span>
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ isset($post) && $post->categories->contains($category->id) ? 'checked' : '' }} style="display: none;">
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <div class="tags-input">
                <ul id="tags">
                    @if (isset($post))
                        @foreach($post->tags as $tag)
                            <li>{{ $tag->name }}<button class="delete-button">X</button></li>
                        @endforeach
                    @endif
                </ul>
                <input type="text" id="input-tag" placeholder="Enter tag name" />
            </div>
            <input type="hidden" name="tags" id="tags-hidden" value="{{ isset($post) ? $post->tags->pluck('name')->implode(',') : '' }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Update Post' : 'Save Post' }}</button>
    </form>
</div>

<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.1/"
        }
    }
</script>
<script type="module" src="{{ URL::asset('assets/ckeditor/main.js') }}"></script>
<script>
document.getElementById('thumbnail').addEventListener('change', function() {
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('thumbnail-preview').style.display = 'block';
        document.getElementById('thumbnail-preview').src = e.target.result;
    }
    reader.readAsDataURL(this.files[0]);
});

const selectBtn = document.querySelector(".select-btn"),
      items = document.querySelectorAll(".item");

selectBtn.addEventListener("click", () => {
    selectBtn.classList.toggle("open");
});

items.forEach(item => {
    item.addEventListener("click", () => {
        item.classList.toggle("checked");

        let checkbox = item.querySelector("input[type='checkbox']");
        checkbox.checked = !checkbox.checked;

        let checked = document.querySelectorAll(".checked"),
            btnText = document.querySelector(".btn-text");

        if (checked && checked.length > 0) {
            btnText.innerText = `${checked.length} Selected`;
        } else {
            btnText.innerText = "Select Categories";
        }
    });
});

const tags = document.getElementById('tags');
const input = document.getElementById('input-tag');
const hiddenInput = document.getElementById('tags-hidden');

input.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const tagContent = input.value.trim();

        if (tagContent !== '') {
            const tag = document.createElement('li');
            tag.innerText = tagContent;
            tag.innerHTML += '<button class="delete-button">X</button>';
            tags.appendChild(tag);
            input.value = '';
            updateHiddenInput();
        }
    }
});

tags.addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-button')) {
        event.target.parentNode.remove();
        updateHiddenInput();
    }
});

function updateHiddenInput() {
    const tagsArray = Array.from(tags.children).map(tag => tag.innerText.replace('X', '').trim());
    hiddenInput.value = tagsArray.join(',');
    console.log('Tags:', hiddenInput.value); // Debugging output
}
</script>

<style>
/* Custom Styles */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

.container {
    max-width: 800px;
    margin: 20px auto;
}

.form-group {
    margin-bottom: 20px;
}

.select-btn {
    display: flex;
    height: 50px;
    align-items: center;
    justify-content: space-between;
    padding: 0 16px;
    border-radius: 8px;
    cursor: pointer;
    background-color: #fff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}

.select-btn .btn-text {
    font-size: 17px;
    font-weight: 400;
    color: #333;
}

.select-btn .arrow-dwn {
    display: flex;
    height: 21px;
    width: 21px;
    color: #fff;
    font-size: 14px;
    border-radius: 50%;
    background: #6e93f7;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
}

.select-btn.open .arrow-dwn {
    transform: rotate(-180deg);
}

.list-items {
    margin-top: 15px;
    border-radius: 8px;
    padding: 16px;
    background-color: #fff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    display: none;
}

.select-btn.open ~ .list-items {
    display: block;
}

.list-items .item {
    display: flex;
    align-items: center;
    list-style: none;
    height: 50px;
    cursor: pointer;
    transition: 0.3s;
    padding: 0 15px;
    border-radius: 8px;
}

.list-items .item:hover {
    background-color: #e7edfe;
}

.item .item-text {
    font-size: 16px;
    font-weight: 400;
    color: #333;
}

.item .checkbox {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 16px;
    width: 16px;
    border-radius: 4px;
    margin-right: 12px;
    border: 1.5px solid #c0c0c0;
    transition: all 0.3s ease-in-out;
}

.item.checked .checkbox {
    background-color: #4070f4;
    border-color: #4070f4;
}

.checkbox .check-icon {
    color: #fff;
    font-size: 11px;
    transform: scale(0);
    transition: all 0.2s ease-in-out;
}

.item.checked .check-icon {
    transform: scale(1);
}

.tags-input {
    display: inline-block;
    position: relative;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    box-shadow: 2px 2px 5px #00000033;
    width: 100%;
}

.tags-input ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tags-input li {
    display: inline-block;
    background-color: #f2f2f2;
    color: #333;
    border-radius: 20px;
    padding: 5px 10px;
    margin-right: 5px;
    margin-bottom: 5px;
}

.tags-input input[type="text"] {
    border: none;
    outline: none;
    padding: 5px;
    font-size: 14px;
}

.tags-input input[type="text"]:focus {
    outline: none;
}

.tags-input .delete-button {
    background-color: transparent;
    border: none;
    color: #999;
    cursor: pointer;
    margin-left: 5px;
}
</style>
@endsection
