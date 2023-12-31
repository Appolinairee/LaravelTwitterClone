@extends('layouts.nav')

@section('content')
<div class="row">
    @include('components.menu')

    <div class="col-6">    
        @if($editing ?? false)
            <h4>Update your Idea </h4>
            
            <div class="row">
                <form action="{{ route('idea.update', $idea->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <textarea class="form-control" id="idea" rows="3" placeholder="Your Idea" name="content" required>{{ $idea->content }}</textarea>
            
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-dark"> Share </button>
                    </div>
                </form>
            </div>
            <hr>
        @endif

        <div class="mt-3">
            @include('components.IdeaCard')
        </div>
    </div>

    @include('components.searchbar')
</div>
@endsection