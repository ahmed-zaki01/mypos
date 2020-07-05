@extends('layouts.dashboard.app')

@section('style')
<style>
    .loader {
        display: inline-block;
        width: 80px;
        height: 80px;
    }

    .loader:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 8px;
        border-radius: 50%;
        border: 6px solid #000;
        border-color: #000 transparent #000 transparent;
        animation: loader 1.2s linear infinite;
    }

    @keyframes loader {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endsection

@section('content')
<div class="card bg-light mt-5">

    <div class="card-header">
        <div class="row justify-content-between mb-2">
            <div class="col-sm-6">
                <h3 class="card-title mt-3">@lang('site.orders') Table - Total ({{$orders->total()}})</h3>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <form action="{{route('dashboard.orders.index')}}" method="GET">
                    <div class="mt-1">
                        <div class="col-md-8">
                            <div class="row">
                                <input type="text" name="search" class="form-control col-7 mr-3" placeholder="search" value="{{request()->search}}">
                                <button type="submit" class="btn btn-info col-4"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div> <!-- /.card-header -->

    <div class="card-body">
        <div class="row">
            {{-- all orders table --}}
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('site.orders')</h3>
                    </div>
                    <div class="card-body">
                        @if ($orders->count())
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('site.client_name')</th>
                                    <th>@lang('site.total_price')</th>
                                    <th>@lang('site.created_at')</th>
                                    {{-- <th>@lang('site.status')</th> --}}
                                    <th>@lang('site.actions')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)

                                <tr>
                                    <td class="table-col">{{ $index + 1 }}</td>
                                    <td class="table-col">{{ $order->client->name }}</td>
                                    <td class="table-col">{{ number_format($order->total_price, 2) }}</td>
                                    <td class="table-col">{{ $order->created_at->toFormattedDateString() }}</td>
                                    {{-- <td class="table-col">{{ $order->status }}</td> --}}
                                    <td class="row justify-content-center align-items-center">

                                        @if (auth()->user()->hasPermission('read_orders'))
                                        <a href="#" class="btn btn-sm btn-info mr-2 view-products-btn" data-url="{{route('dashboard.orders.show', $order->id)}}" data-method="get"><i class="fa fa-eye"></i></a>
                                        @else
                                        <a href="#" class="btn btn-sm btn-info disabled mr-2"><i class="fa fa-eye"></i></a>
                                        @endif

                                        @if (auth()->user()->hasPermission('update_orders'))
                                        <a href="{{route('dashboard.clients.orders.edit', ['client' => $order->client_id, 'order' => $order->id])}}" class="btn btn-sm btn-info mr-2"><i class="fa fa-edit"></i></a>
                                        @else
                                        <a href="#" class="btn btn-sm btn-info disabled mr-2"><i class="fa fa-edit"></i></a>
                                        @endif

                                        @if (auth()->user()->hasPermission('delete_orders'))
                                        <form action="{{route('dashboard.orders.destroy', $order->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></button>
                                        </form>
                                        @else
                                        <a href="#" class="btn btn-sm btn-danger disabled"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h4 class="py-2 text-center">@lang('site.no_data_found')</h4>
                        @endif
                    </div>
                </div>
            </div>



            <!-- order details div -->
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">@lang('site.products.products')</h3>
                    </div>
                    <div id="order-products-list" class="card-body">
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.order details div -->
            </div>
        </div>

    </div>
</div>
@endsection
