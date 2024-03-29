<div>
    <form action="{{ route('idea.comment.store', $idea->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="fs-6 form-control" rows="1"></textarea>
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-sm"> Post Comment </button>
        </div>
    </form>
    <hr>

    @php
        $comments = $idea->comments->sortByDesc('created_at');
    @endphp

    @foreach ($comments as $comment)
        <div class="d-flex align-items-start">
            <img style="width:35px" class="me-2 avatar-sm rounded-circle"
                src="{{ $comment->user->getImage() }}"
                alt="{{ $comment->user->name }}">

            <div class="w-100">
                <div class="d-flex justify-content-between">
                    <h6 class=""> {{ $comment->user->name }}
                    </h6>
                    <small class="fs-6 fw-light text-muted"> {{$idea->created_at->diffForHumans()   }}</small>
                </div>
                
                <p class="fs-6 mt-3 fw-light">
                    {{ $comment->content }}
                </p>
            </div>
        </div>
    @endforeach
</div>