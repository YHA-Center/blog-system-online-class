@extends('layouts.frontend')

@section('content')

{{-- Page Content  --}}

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <a href="{{ route('user.home') }}">Back</a>
            {{-- Post Content  --}}
            <article>
                {{-- Post Header  --}}
                <header class="mb-4">
                    {{-- Post Title  --}}
                    <h1 class="fw-bolder mb-1">{{ $post->title }}</h1>
                    {{-- Post Meta Content  --}}
                    <div class="text-muted fst-italic mb-2">Posted on {{ $post->created_at->diffForHumans() }} by <b>{{ $post->User->name }}</b></div>
                    {{-- Post Categories  --}}
                    <a href="" class="badge bg-secondary text-decoration-none link-light">
                        {{ $post->Category->name }}
                    </a>
                </header>
                {{-- Preview Image  --}}
                <figure class="mb-4">
                    <img src="{{ asset($post->cover) }}" alt="" class="img-fluid rounded">
                </figure>
                {{-- Post Content  --}}
                <section class="mb-5">
                    <p class="fs-5 mb-4">
                        <?= $post->description ?>
                    </p>
                </section>
            </article>

            {{-- Comment Section  --}}
            <section class="mb-5">
                <div class="card bg-light">
                    <div class="card-body">
                        {{-- Comment Form  --}}
                        <form action="{{ route('comment.store', $post->id) }}" class="mb-4" method="POST">
                            @csrf
                            <textarea name="content" class="form-control"
                            id="" rows="3" style="resize: none" placeholder="type something..."></textarea>
                            @error ('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-sm btn-primary mt-2 ">Post</button>
                        </form>

                        {{-- Single Comment  --}}
                        @foreach ($comments as $c)
                        <div class="d-flex mt-3">
                            <div class="flex-shrink-0">
                                <img src="https://dummyimage.com/50x50/ced4da/6c757d.jpg"
                            alt="" class="rounded-circle">
                            </div>
                            <div class="ms-3">
                                <div class="fw-bold d-block d-flex align-items-center justify-content-between">
                                    {{ $c->User->name }}
                                </div>
                                <small class=""> {{ $c->created_at->diffForHumans() }} </small> <br>

                                {{ $c->content }} <br>
                                {{-- delete button  --}}
                                @auth
                                @if (Auth::user()->id == $c->user_id)
                                    <a href="{{ route('comment.destroy', $c->id) }}" class="text-sm ">
                                        Delete
                                    </a>
                                @endif
                            @endauth
                            </div>
                        </div>
                        @endforeach

                        {{ $comments->links() }}
                    </div>

                </div>
            </section>

        </div>
        {{-- Side Widget  --}}
        <div class="col-lg-4">
            {{-- Side widget  --}}
            <div class="card mb-4">
                <div class="card-header">Latest Post</div>
                <div class="card-body">
                    @foreach ($latest_post as $post)
                        <div class="d-flex justify-content-between">
                            <a href="" class="text-primary text-decoration-none text-bold">
                                {{ $post->title }}
                            </a>
                            <small class="text-muted">
                                {{ $post->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <p>
                            <?= Str::words($post->description, 20, '...') ?>
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
