<div class="modal fade dd-modal" id="create-post-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ceate a new blog post</h4>
            </div>
            <div class="modal-body">
                @include('errors')
                {!! Form::open(['url' => '/admin/blog/posts', 'class' => 'form-horizontal dd-form modal-form']) !!}
                <div class="form-group">
                    <label for="title">Title: </label>
                    {!! Form::text('title', null, ['class' => "form-control", 'placeholder' => 'a good title for your post', 'required']) !!}
                </div>
                <div class="form-group">
                    <label for="description">Description: </label>
                    <p class="sharing-info">This text you add here will be the message that accompanies the link to this post shared on social sites such as <span class="facebook-name">facebook</span>, if you choose to enable sharing. You do get to edit this before you publish.</p>
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'you can edit this later']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dd-btn btn-light dd-modal-cancel-btn" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn dd-btn dd-modal-confirm-btn">Create</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->