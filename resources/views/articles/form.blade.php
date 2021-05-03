@csrf
<div class="md-form">
  <label>タイトル</label>
  <input class="form-control" type="text" name="title" required value="{{ $article->title ?? old('title') }}">
</div>
<div class="form-group">
  <article-tags-input :initial-tags='@json($tagNames ?? [])' :autocomplete-items='@json($allTagNames ?? [])'>
  </article-tags-input>
</div>
<div class="form-group">
  <label></label>
  <textarea name="body" placeholder="本文" rows="10" class="form-control"
    required>{{ $article->body ?? old('body') }}</textarea>
</div>
