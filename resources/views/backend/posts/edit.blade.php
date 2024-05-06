@extends('layouts.backend')
@section('title', 'Edit Post')
@section('content')

<script>
    $(document).ready(function() {
        console.log('jquery is running')
        $('#summernote').summernote({
            height: 200,
        });
    });
</script>

<div class="container-fluid">
    {{-- page heading  --}}
    <h1 class="h3 mb-2 text-gray-800">Post</h1>

    {{-- success session  --}}
    @if (session('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif
    {{-- DataTable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Post</h6>
        </div>
        <div class="card-body">
            {{-- Image  --}}
            <img src="{{ asset($post->cover) }}" alt="" class="card-img">
            <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Title  --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control
                    @error('title') is-invalid @enderror" value="{{ $post->title }}">
                    @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Category  --}}
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-control @error('category')
                        is-invalid
                    @enderror">
                        <option value="0" disabled>Choose Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if($category->id == $post->Category->id)
                                selected
                            @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Description  --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="summernote" >{{ $post->description }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- cover image  --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control @error('image')
                        is-invalid
                    @enderror">
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Action buttons  --}}
                <div class="mb-3">
                    {{-- cancel button  --}}
                    <a href="{{ route('post.list') }}"
                    class="btn btn-secondary btn-sm btn-icon-split mb-3">
                        <span class="icon text-white-50">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                        <span class="text">Cancel</span>
                    </a>
                    {{-- create button  --}}
                    <button type="submit" class="btn btn-primary btn-sm btn-icon-split mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
