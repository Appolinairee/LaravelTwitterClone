@extends('layouts.nav')

@section('content')
<div class="row">
    @include('components.menu')

    <div class="col-6">    
        @include('components.profilCard')

        <div class="mt-3">
            @forelse ($ideas as $idea)
                @include('components.IdeaCard')
            @empty
                <p> No Idea for this case! </p>
            @endforelse

            {{ $ideas->withQueryString()->links() }}
        </div>
    </div>

    @include('components.searchbar')
</div>
@endsection