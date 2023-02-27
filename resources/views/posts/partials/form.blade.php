<div class="form-group">
    <label for="title">Title</label>
    <input id="title" class="form-control" type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}">
    @error('title')
    <div>Please fill title</div>
    @enderror
</div>
<div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" id="content" name="content">{{ old('content',  optional($post ?? null)->content) }}</textarea>
</div>


<div class="form-group">
    <label for="content">Thumbnail</label>
    <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
</div>

@errors
@enderrors
