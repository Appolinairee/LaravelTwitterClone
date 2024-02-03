<div class="col-3">
    <div class="card overflow-hidden">
        <div class="card-body pt-3">
            <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
                <li class="nav-item">
                    <a class="{{ Route::is('welcome')? 'text-white bg-primary rounded' : '' }} nav-link text-dark" href="{{ Route('welcome') }}">
                        <span>Home</span></a>
                </li>

                <li class="nav-item text-dark">
                    <a class="{{ Route::is('feed')? 'text-white bg-primary rounded' : '' }} nav-link" href="{{ Route('feed') }}">
                        <span>Feed</span>
                    </a>
                </li>

                <li class="{{ Route::is('terms')? 'text-white bg-primary rounded' : '' }} nav-item">
                    <a class="nav-link" href="{{ Route('terms') }}">
                        <span>Terms</span>
                    </a>
                </li>
            </ul>
        </div>

        @auth
            <div class="card-footer text-center py-2">
                <a class="btn btn-link btn-sm" href="{{ Route('users.show', auth()->user()->id) }}">View Profile </a>
            </div>
        @endauth
    </div>
</div>