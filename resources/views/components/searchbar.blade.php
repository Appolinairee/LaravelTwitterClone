<div class="col-3">
    <div class="card">
        <div class="card-header pb-0 border-0">
            <h5 class="">Search</h5>
        </div>

        <div class="card-body">
            <form action="{{ route("welcome") }}" method="GET">
                <input name="search" placeholder="..." class="form-control w-100" type="text" id="search" value="{{ request('search', '') }}" >
                <button type="submit" class="btn btn-dark mt-2">Search</button>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header pb-0 border-0">
            <h5 class="">Who to follow</h5>
        </div>
        <div class="card-body">
            @auth
                @foreach (auth()->user()->userToFollow() as $follow)
                    <div class="hstack gap-2 mb-3">
                        <a href="{{ route('users.show', $follow->id)}}">
                            <div class="avatar">
                                <a href="#!"><img style="width: 50px;" class="avatar-img rounded-circle" src={{ $follow->getImage() }} alt=""></a>
                            </div>
                            <div class="overflow-hidden">
                                <a class="h6 mb-0" href="#!">{{ $follow->name }}</a>
                                <p class="mb-0 small text-truncate">{{ $follow->email }}</p>
                            </div>
                        </a>

                        <a class="btn btn-primary-soft rounded-circle icon-md ms-auto">
                            @if (auth()->user()->isFollowing($follow))
                                <form action="{{ route('users.follow', $follow) }}" method="post">
                                    @csrf
                                    <button type="submit"><i class="fa-solid fa-minus"> </i></button>
                                </form>
                            @else
                                <form action="{{ route('users.follow', $follow) }}" method="post">
                                    @csrf
                                    <button type="submit"><i class="fa-solid fa-plus"> </i></button>
                                </form>
                            @endif
                        </a>
                    </div>
                @endforeach
            @endauth
            
            <div class="d-grid mt-3">
                <a class="btn btn-sm btn-primary-soft" href="#!">Show More</a>
            </div>
        </div>
    </div>
</div>