<div class="row">
    <form action="{{ route('idea.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea class="form-control" id="idea" rows="3" placeholder="Your Idea" name="content" required></textarea>

            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
            
        </div>
        
        <div class="">
            <button type="submit" class="btn btn-dark"> Share </button>
        </div>
    </form>
</div>