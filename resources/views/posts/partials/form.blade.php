<div>
    <input type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}">
    @error('title')
    <div>Please fill title</div>
    @enderror
</div>
<div>
    <textarea name="content">{{ old('content',  optional($post ?? null)->content) }}</textarea>
</div>

@if($errors->any())
    <div>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
