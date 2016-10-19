@extends('admin.base')

@section('content')
    <section class="dd-page-header">
        <h1>Admin Users</h1>
    </section>
    <div class="row">
        <div class="col-md-6">
            @foreach($users as $user)
                <div class="user-profile-card">
                    <header class="user-profile-card-header">
                        <h4>{{ $user->name }}</h4>
                        <span>{{ $user->isA('super_admin') ? 'Super user' : 'Limited User' }}</span>
                    </header>
                    <div class="user-profile-card-body">
                        <p>{{ $user->email }}</p>
                    </div>
                    <footer class="user-profile-card-footer clearfix">
                        <div class="user-actions pull-right">
                            <a href="/admin/users/{{ $user->id }}/edit">
                                <div class="btn dd-btn btn-light">
                                    Edit
                                </div>
                            </a>
                            @include('admin.partials.deletebutton', ['objectName' => $user->name, 'deleteFormAction' => '/admin/users/'.$user->id])
                        </div>
                    </footer>
                </div>
            @endforeach
        </div>
        <div class="col-md-6">
            <h3>Add a new admin user</h3>
            @include('admin.forms.register')
        </div>
    </div>
    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection