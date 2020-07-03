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
                    <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Clients</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- clients table -->
<div class="card">
    <div class="card-header">
        <div class="row justify-content-between mb-2">
            <div class="col-sm-6">
                <h3 class="card-title mt-3">@lang('site.clients.clients') Table - Total ({{$clients->total()}})</h3>
            </div>
            <!-- /.col -->
            <div class="col-sm-6 d-flex text-right">
                <form action="{{route('dashboard.clients.index')}}" method="GET" class="w-100">
                    <div class="row justify-content-between mt-1">
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="search" class="form-control col-7 mr-3" placeholder="search" value="{{request()->search}}">
                                <button type="submit" class="btn btn-info col-4"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>

                        @if (auth()->user()->hasPermission('create_clients'))
                        <a href="{{route('dashboard.clients.create')}}" class="btn btn-primary col-md-2"><i class="fa fa-plus"></i> Add</a>
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
        @if ($clients->count())
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>@lang('site.name')</th>
                    <th>@lang('site.primary_phone')</th>
                    <th>@lang('site.secondary_phone')</th>
                    <th>@lang('site.clients.address')</th>
                    <th>@lang('site.clients.add_order')</th>
                    <th>@lang('site.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $index => $client)

                <tr>
                    <td class="table-col">{{ $index + 1 }}</td>
                    <td class="table-col">{{ $client->name }}</td>
                    <td class="table-col">{{ $client->phone[0] }}</td>

                    <td class="table-col">
                        @if ($client->phone[1]){{ $client->phone[1] }}@else <span class="text-gray">Doesn't have</span> @endif
                    </td>

                    <td class="table-col">{{ $client->address }}</td>

                    <td class="table-col">
                        @if (auth()->user()->hasPermission('create_orders'))
                        <a class="btn btn-sm btn-primary" href="{{route('dashboard.clients.orders.create', $client->id)}}">Add Order</a>
                        @else
                        <a class="btn btn-sm btn-primary disabled" href="#">Add Order</a>
                        @endif
                    </td>
                    <td class="row justify-content-center align-items-center">
                        @if (auth()->user()->hasPermission('update_clients'))
                        <a href="{{route('dashboard.clients.edit', $client->id)}}" class="btn btn-sm btn-info mr-2"><i class="fa fa-edit"></i> Edit</a>
                        @else
                        <a href="#" class="btn btn-sm btn-info disabled mr-2"><i class="fa fa-edit"></i> Edit</a>
                        @endif

                        @if (auth()->user()->hasPermission('delete_clients'))
                        <form action="{{route('dashboard.clients.destroy', $client->id)}}" method="POST">
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
        {{ $clients->appends(request()->query())->links() }}
    </div>
</div>
@endsection
