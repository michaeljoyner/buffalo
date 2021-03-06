<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/only.png') }}" alt="logo"/>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >Products <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/products/search">Search</a></li>
                        <li><a href="/admin/categories">Categories</a></li>
                        <li><a href="/admin/suppliers">Factories</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >Customers <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/orders">Inquiries</a></li>
                        <li><a href="/admin/customers">Customers</a></li>
                        <li><a href="/admin/quotes">Quotes</a></li>
                    </ul>
                </li>


                @if(Auth::user()->isA('super_admin'))
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >Site Content <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/slides">Banner Slides</a></li>
                        <li><a href="/admin/blog/posts">Insights</a></li>
                        <li><a href="/admin/social">Social</a></li>
                    </ul>
                </li>
                @endif
                <form class="navbar-form navbar-left" role="search" method="GET" action="/admin/products/search" autocomplete="off">
                    <div class="form-group">
                        <input type="text" name="q" class="form-control" placeholder="Search">
                    </div>
                </form>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(Auth::user()->isA('super_admin'))
                <li><a href="/admin/users">Users</a></li>
                @endif
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >{{ Auth::user()->email }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/users/password/reset">Reset Password</a></li>
                        <li><a href="/admin/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>