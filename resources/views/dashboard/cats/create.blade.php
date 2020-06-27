@extends('layouts.dashboard.app')

@section('content')
<div class="card card-primary mt-5">
    @include('partials._errors')


    <div class="card-header">
        <h3 class="card-title mt-2"><i class="fa fa-list mr-1"></i> New Category</h3>
        <a href="{{url()->previous()}}" class="btn btn-default text-dark float-right"><i class="fas fa-arrow-left mr-2"></i> Back</a>
    </div> <!-- /.card-header -->
    <!-- form start -->
    <form action="{{route('dashboard.cats.store')}}" method="POST">
        @csrf
        <div class="card-body">

            @foreach (config('translatable.locales') as $locale)

            <div class="form-group">
                <label for="name">@lang('site.'.$locale.'.name')</label>
                <input type="text" name="{{$locale}}[name]" value="{{old($locale. '.name')}}" class="form-control" id="name">
            </div>

            @endforeach

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
