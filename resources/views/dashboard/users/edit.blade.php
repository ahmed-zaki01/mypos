@extends('layouts.dashboard.app')

@section('script')
<script>
    $(".img-input").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
            $('.img-preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]); // convert to base64 string
        }
    });
</script>
@endsection

@section('content')
<div class="card card-primary mt-5">
    @include('partials._errors')


    <div class="card-header">
        <h3 class="card-title mt-2"><i class="fa fa-user mr-1"></i> Edit <span class="text-light font-weight-bold">{{$user->first_name . ' ' . $user->last_name}}</span></h3>
        <a href="{{url()->previous()}}" class="btn btn-default text-dark float-right"><i class="fas fa-arrow-left mr-2"></i> Back</a>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{route('dashboard.users.update', $user->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="card-body">

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" id="first_name" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" value="{{$user->last_name}}" class="form-control" id="last_name" required>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" value="{{$user->email}}" class="form-control" id="email" required>
            </div>

            <div class="form-group">
                <label for="img">Image</label>
                <input type="file" name="img" class="form-control img-input" id="img">
            </div>

            <div class="form-group">
                <img src="{{$user->img_path}}" style="height: 100px;" class="img-thumbnail img-preview" alt="user profile image">
            </div>

            <div class="form-group">
                <label for="permissions">Permissions</label>

                <div class="nav-tabs-custom" id="permissions">
                    @php
                    $models = ['users', 'cats', 'products'];
                    $maps = array('read' => 'view', 'create' => 'add', 'update' => 'edit', 'delete' => 'delete');
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
                            <label class="mr-3"><input type="checkbox" name="permissions[]" value="{{$key . '_' . $model}}" class="mr-1" {{$user->hasPermission($key.'_'.$model) ? 'checked':''}}>{{$map}}</label>
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
