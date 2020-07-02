@extends('layouts.dashboard.app')


@section('content')
<div class="card card-primary mt-5">
    @include('partials._errors')


    <div class="card-header">
        <h3 class="card-title mt-2"><i class="fa fa-list mr-1"></i> Edit <span class="text-light font-weight-bold">{{$client->name}}</span></h3>
        <a href="{{url()->previous()}}" class="btn btn-default text-dark float-right"><i class="fas fa-arrow-left mr-2"></i> Back</a>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{route('dashboard.clients.update', $client->id)}}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label for="name">@lang('site.name')</label>
                <input type="text" name="name" value="{{$client->name}}" class="form-control" id="name" required>
            </div>

            <div>

                @for ($i = 0; $i < 2; $i++) <div class="form-group">
                    <label for="phone">
                        @if ($i == 0)
                        @lang('site.primary_phone')
                        @else
                        @lang('site.secondary_phone')
                        @endif
                    </label>
                    <input type="text" name="phone[]" value="{{$client->phone[$i]}}" class="form-control" id="phone" {{ $i == 0 ? 'required':'' }}>
            </div>
            @endfor


            <div class="form-group">
                <label for="address">@lang('site.clients.address')</label>
                <input type="text" name="address" value="{{$client->address}}" class="form-control" id="address" required>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
