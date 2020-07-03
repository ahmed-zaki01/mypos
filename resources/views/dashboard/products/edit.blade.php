@extends('layouts.dashboard.app')


@section('script')
<script src="{{asset('dashboard_files/plugins')}}/ckeditor/ckeditor.js">

</script>
<script src="{{asset('dashboard_files/plugins')}}/ckeditor/styles.js"></script>
<script>
    $(document).ready(function () {
        CKEDITOR.config.language = "{{ app()->getLocale() }}";
    });
</script>
@endsection


@section('content')
<div class="card card-primary mt-5">
    @include('partials._errors')


    <div class="card-header">
        <h3 class="card-title mt-2"><i class="fa fa-list mr-1"></i> Edit @lang('site.products.product') {{$product->translate(app()->getLocale())->name}}</h3>
        <a href="{{url()->previous()}}" class="btn btn-default text-dark float-right"><i class="fas fa-arrow-left mr-2"></i> Back</a>
    </div> <!-- /.card-header -->
    <!-- form start -->
    <form action="{{route('dashboard.products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">


            <div class="form-group">
                <label for="cat">@lang('site.cats')</label>
                <select name="cat_id" id="cat" class="form-control">
                    <option value="" selected disabled>@lang('site.all_cats')</option>
                    @foreach ($cats as $cat)
                    <option value="{{$cat->id}}" {{$product->cat_id == $cat->id ? 'selected' : ''}}>{{$cat->name}}</option>
                    @endforeach
                </select>
            </div>

            @foreach (config('translatable.locales') as $locale)

            <div class="form-group">
                <label for="name">@lang('site.'.$locale.'.name')</label>
                <input type="text" name="{{$locale}}[name]" value="{{$product->translate($locale)->name}}" class="form-control" id="name">
            </div>

            <div class="form-group">
                <label for="desc">@lang('site.'.$locale.'.desc')</label>
                <textarea name="{{$locale}}[desc]" id="desc" class="form-control ckeditor">{{$product->translate($locale)->desc}}</textarea>

            </div>

            @endforeach

            <div class="form-group">
                <label for="img">@lang('site.img')</label>
                <input type="file" name="img" class="form-control img-input" id="img">
            </div>

            <div class="form-group">
                <img src="{{$product->img_path}}" style="height: 100px;" class="img-thumbnail img-preview" alt="product image">
            </div>

            <div class="form-group">
                <label for="purchase_price">@lang('site.products.purchase_price')</label>
                <input type="number" name="purchase_price" value="{{$product->purchase_price}}" step="0.01" class="form-control" id="purchase_price">
            </div>

            <div class="form-group">
                <label for="sell_price">@lang('site.products.sell_price')</label>
                <input type="number" name="sell_price" value="{{$product->sell_price}}" step="0.01" class="form-control" id="sell_price">
            </div>

            <div class="form-group">
                <label for="stock">@lang('site.products.stock')</label>
                <input type="number" name="stock" value="{{$product->stock}}" class="form-control" id="stock">
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection
