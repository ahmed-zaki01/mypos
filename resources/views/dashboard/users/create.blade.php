@extends('layouts.dashboard.app')

@section('content')
<div class="card card-primary mt-5">
    @include('partials._errors')


    <div class="card-header">
        <h3 class="card-title mt-2"><i class="fa fa-user mr-1"></i> New User</h3>
        <a href="{{url()->previous()}}" class="btn btn-default text-dark float-right"><i class="fas fa-arrow-left mr-2"></i> Back</a>
    </div> <!-- /.card-header -->
    <!-- form start -->
    <form action="{{route('dashboard.users.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" value="{{old('first_name')}}" class="form-control" id="first_name" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" value="{{old('last_name')}}" class="form-control" id="last_name" required>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email" required>
            </div>

            <div class="form-group">
                <label for="img">Image</label>
                <input type="file" name="img" class="form-control img-input" id="img" required>
            </div>

            <div class="form-group">
                <img src="{{asset('uploads/users/default.png')}}" style="height: 100px;" class="img-thumbnail img-preview" alt="user profile image">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
            </div>

            <div class="form-group">
                <label for="permissions">Permissions</label>

                <div class="nav-tabs-custom" id="permissions">
                    @php
                    $models = ['users', 'cats', 'products'];
                    $maps = array(
                    'read' => 'view',
                    'create' => 'add',
                    'update' => 'edit',
                    'delete' => 'delete',
                    );
                    @endphp

                    <ul class="nav nav-tabs">
                        @foreach ($models as $index => $model)
                        <li class="nav-item mr-3 "><a href="#{{$model}}" class="nav-link {{$index == 0 ? 'active':''}}" data-toggle="tab">{{$model}}</a></li>
                        @endforeach
                    </ul>
                    <div class="tab-content pt-2">
                        @foreach ($models as $index => $model)

                        <div class="tab-pane {{$index == 0 ? 'active':''}}" id="{{$model}}">
                            @foreach ($maps as $key => $map)
                            <label class="mr-3"><input type="checkbox" name="permissions[]" value="{{$key . '_' . $model}}" class="mr-1">{{$map}}</label>
                            @endforeach

                        </div>
                        <!-- /.tab-pane -->
                        @endforeach
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>


        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
