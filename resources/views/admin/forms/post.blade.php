{!! Form::model($post, ['url' => $formAction, 'class' => 'dd-form blog-edit-form form-horizontal', 'id' => 'blog-editor-form']) !!}
@include('errors')
<div class="form-group">
    <label for="title">Title: </label>
    {!! Form::text('title', null, ['class' => "form-control"]) !!}
</div>
<div class="form-group">
    <label for="description">Description: </label>
    <p class="sharing-info">This text you add here will be the message that accompanies the link to this post shared on social sites such as <span class="facebook-name">facebook</span>, if you choose to enable sharing.</p>
    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'post-description']) !!}
</div>
<div class="form-group">
    <label for="content">Content: </label>
    {!! Form::textarea('body', null, ['class' => 'form-control', 'id' => 'post-body']) !!}
</div>
<div class="form-group">
    <button type="submit" id="blog-editor-form-submit" class="btn dd-btn">Save</button>
</div>
{!! Form::close() !!}
<div class="hidden-image-upload">
    <input type="file" id="post-file-input">
</div>