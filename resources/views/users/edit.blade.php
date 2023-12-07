@extends('layouts.nav')

@section('content')
    <div class="row">
        @include('components.menu')

        <div class="col-6">
            @include('components.profilCard')
        </div>

        <hr>

        @include('components.searchbar')
    </div>
@endsection
