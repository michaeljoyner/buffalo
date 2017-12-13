@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Buffalo Tools Social</h1>
    </section>
    <section class="social-accounts">
        <div class="facebook-auth-status">
            <h2>Share News Posts with <span class="facebook-name">Facebook</span></h2>
            <p class="lead">This allows you to auto-share any new news post on <span class="facebook-name">facebook</span>. The post will be shared only on its
                first publication, and will be shared to the account that you have given access to.</p>
            <social-user icon-src="/images/assets/facebook_white.png"
                         platform="facebook"
                         fetch-url="/admin/social/facebook/user"
                         unique="1"
            ></social-user>
        </div>
        <div class="twitter-auth-status">
            <h2>Share on Twitter</h2>
            <p class="lead">Authorise with Twitter to automatically tweet your new news posts</p>
            <social-user icon-src="/images/assets/twitter_white.svg"
                         platform="twitter"
                         fetch-url="/admin/social/twitter/user"
                         unique="2"
            ></social-user>
        </div>
        <div class="google-plus-auth-status">
            <h2>Share on Google Plus</h2>
            <p class="lead">Authorise with Google Plus to automatically share your new news posts. Posts will only be shared for Google Apps users.</p>
            <social-user icon-src="/images/assets/google_plus_white.png"
                         platform="googleplus"
                         fetch-url="/admin/social/googleplus/user"
                         unique="3"
            ></social-user>
        </div>
    </section>

@endsection