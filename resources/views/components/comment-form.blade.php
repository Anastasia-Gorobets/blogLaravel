<div class="mb-2 mt-2">
    @auth
        <form method="POST" action="{{$route}}">
            @csrf
            <div class="form-group">
                <label for="content">Comment</label>
                <textarea class="form-control" id="content" name="content">{{ old('content') }}</textarea>
            </div>
            @errors
            @enderrors
            <div>
                <input  class="btn btn-primary btn-block" type="submit" value="Add comment">
            </div>
        </form>
    @else
        <a href="{{route('login')}}">Sign in to post comments!</a>
    @endauth
</div>
</hr>
