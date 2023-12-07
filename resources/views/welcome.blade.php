@extends('layouts.nav')

@section('content')
    <div class="row">
        @include('components.menu')

        <div class="col-6">
            @include('components.successIdea')

            @auth
                <h4> Share yours ideas </h4>
                @include('components.submitIdea')
            @endauth


            @guest
                <h4>
                    <a href="/login">Connect</a> 
                     to share your Idea </h4>
            @endguest
            
            <hr>
            
            <div class="mt-3">
                @forelse ($ideas as $idea)
                    @include('components.IdeaCard')
                @empty
                    <p> No Idea for this case! </p>
                @endforelse

                {{ $ideas-> withQueryString()->links() }}
            </div>
        </div>

        @include('components.searchbar');
    </div>
@endsection