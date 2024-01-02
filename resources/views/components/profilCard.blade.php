<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img style="width: 80px; height: 70px;" class="me-3 avatar-sm rounded-circle"
                    src="{{ $user->getImage() }}" alt="Mario Avatar">

                    @if ($editing ?? false)
                        <form action="{{ route('users.update', $user) }}" method="post">
                            @csrf
                            @method('put')

                            <input type="text" value="{{ $user->name }}" name="name">
                            <input type="submit" value="Change">    
                        </form>
                    @else
                        <div>
                            <h3 class="card-title mb-0"><a href="{{ route('users.show', $user->id) }}"> {{ $user->name }}
                                </a></h3>   
                            <span class="fs-6 text-muted">{{ $user->email }}</span>
                        </div>
                    @endif
                
                @auth
                    @if (Auth::id() === $user->id)
                        @if ($editing ?? false)
                            <a href="{{ route('users.show', $user->id) }}">View</a>
                        @else
                            <a href="{{ route('users.edit', $user->id) }}">Edit</a>
                        @endif
                    @endif
                @endauth

            </div>
        </div>

        <div class="px-2 mt-4">
            @if ($editing ?? false)
                <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="file" name="image" id="profil" accept="image/*" />
                    <input type="submit" value="validate">
                </form>
            @endif

            <h5 class="fs-5"> Bio : </h5>

            @if ($editing ?? false)
                <form action="{{ route('users.update', $user) }}" method="post">
                    @csrf
                    @method('put')
                    <textarea type="text" name="bio">{{ $user->bio }}</textarea>
                    <input type="submit" value="Change">
                </form>
            @else
                <p class="fs-6 fw-light">
                    {{ $user->bio }}
                </p>
            @endif
            
            <div class="d-flex justify-content-start">
                <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-user me-1">
                    </span> 0 Followers </a>
                <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-brain me-1">
                    </span> {{ $user->ideas->count() }} </a>
                <a href="#" class="fw-light nav-link fs-6"> <span class="fas fa-comment me-1">
                    </span> {{ $user->comments->count() }} </a>
            </div>
            {{
                auth()->user()->isFollowing($user)
            }}
            @auth
            @if (Auth::id() !== $user->id)
                <div class="mt-3">
                    <form action="{{ route('users.follow', $user) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            @if (auth()->user()->isFollowing($user))
                               Je suis
                            @else
                                Tu es
                            @endif
                        </button>
                    </form>
                </div>
            @endif
            @endauth
        </div>
    </div>
</div>
<hr>