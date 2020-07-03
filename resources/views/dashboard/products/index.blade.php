@extends('layouts.dashboard.app')

@section('style')
<style>
    .table-col {
        vertical-align: middle !important;
    }
</style>

@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.dashboard')</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- products table -->
<div class="card">
    <div class="card-header">
        <div class="row justify-content-between mb-2">
            <div class="col-sm-3">
                <h3 class="card-title mt-3">@lang('site.products.products') Table - Total ({{ $products->total() }})</h3>
            </div>
            <!-- /.col -->
            <div class="col-sm-8">
                <form action="{{ route('dashboard.products.index') }}" method="GET" class="w-100">
                    <div class="row justify-content-between mt-1">
                        <div class="col-md-10">
                            <div class="row">
                                <input type="text" name="search" class="form-control col-4 mr-3" placeholder="search" value="{{ request()->search }}">

                                <select name="cat_id" class="form-control col-3 mr-3" id="">
                                    <option value="" selected>@lang('site.all_cats')</option>
                                    @foreach ($cats as $cat)
                                    <option value="{{ $cat->id }}" {{ request()->cat_id == $cat->id ? 'selected':'' }}>{{$cat->name}}</option>
                                    @endforeach
                                </select>


                                <button type="submit" class="btn btn-info col-2"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>

                        @if (auth()->user()->hasPermission('create_products'))
                        <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary col-md-2"><i class="fa fa-plus"></i> Add</a>
                        @else
                        <a href="#" class="btn btn-primary col-md-2 disabled"><i class="fa fa-plus"></i> Add</a>
                        @endif

                    </div>

                </form>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @if ($products->count())
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    {{-- <th>@lang('site.cat')</th> --}}
                    <th>@lang('site.name')</th>
                    <th>@lang('site.img')</th>
                    <th>@lang('site.products.sell_price')</th>
                    <th>@lang('site.products.purchase_price')</th>
                    <th>@lang('site.products.profit_percent') %</th>
                    <th>@lang('site.products.stock')</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)

                <tr>
                    <td class="table-col">{{ $index + 1 }}</td>
                    {{-- <td class="table-col">{{ $product->cat->name }}</td> --}}
                    <td class="table-col">{{ $product->name }}</td>
                    <td class="table-col"><img src="{{ $product->img_path }}" style="height: 75px;" class="img-thumbnail" alt="product image"></td>
                    <td class="table-col">{{ $product->purchase_price }}</td>
                    <td class="table-col">{{ $product->sell_price }}</td>
                    <td class="table-col">{{ $product->profit_percent }} %</td>
                    <td class="table-col">{{ $product->stock }}</td>
                    <td class="row justify-content-center align-items-center" style="height: 100px;">
                        @if (auth()->user()->hasPermission('update_products'))
                        <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-sm btn-info mr-2"><i class="fa fa-edit"></i> Edit</a>
                        @else
                        <a href="#" class="btn btn-sm btn-info disabled mr-2"><i class="fa fa-edit"></i> Edit</a>
                        @endif

                        @if (auth()->user()->hasPermission('delete_products'))
                        <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                        @else
                        <a href="#" class="btn btn-sm btn-danger disabled"><i class="fa fa-trash"></i> Delete</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <h2 class="py-5 text-center">@lang('site.no_data_found')</h2>
        @endif
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        {{  $products->appends(request()->query())->links()  }}
    </div>
</div>
@endsection
