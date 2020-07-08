@extends('layouts.dashboard.app')

@section('content')
<div class="card bg-light mt-5">

    <div class="card-header">
        <h3 class="card-title mt-2"><i class="fa fa-list mr-1"></i> New Order</h3>
        <a href="{{url()->previous()}}" class="btn btn-default text-dark float-right"><i class="fas fa-arrow-left mr-2"></i> Back</a>
    </div> <!-- /.card-header -->

    <div class="card-body">
        <div class="row">

            {{-- cats with its products --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('site.cats')</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($cats as $cat)
                        <div class="card card-primary collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">{{$cat->name}}</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: none;">
                                @if ($cat->products->count())
                                <table class="table table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>@lang('site.name')</th>
                                            <th>@lang('site.products.price')</th>
                                            <th>@lang('site.products.add_product')</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cat->products as $index => $product)

                                        <tr>
                                            <td class="table-col">{{ $index + 1 }}</td>
                                            <td class="table-col">{{ $product->name }}</td>
                                            <td class="table-col">{{ number_format($product->sell_price, 2) }}</td>
                                            <td class="table-col">
                                                <a href="#" class="btn btn-sm btn-success add-product-btn" id="product-{{$product->id}}" data-id="{{$product->id}}" data-name="{{$product->name}}" data-price="{{$product->sell_price}}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <h4 class="py-2 text-center">@lang('site.no_data_found')</h4>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- order details div -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('site.items')</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('dashboard.clients.orders.store', $client->id)}}" method="post">
                            @csrf
                            @method('POST')

                            <table class="table table-hover text-center mb-3">
                                <thead>
                                    <tr>
                                        <th>@lang('site.products.product')</th>
                                        <th>@lang('site.quantity')</th>
                                        <th>@lang('site.products.price')</th>
                                        <th>@lang('site.delete')</th>
                                    </tr>
                                </thead>
                                <tbody class="order-list"></tbody>
                            </table>
                            <h4 class="">@lang('site.total_price'): <span class="total-price">0</span></h4>
                            <button type="submit" id="add-order-btn" class="btn btn-block btn-primary disabled text-uppercase" style="font-size: 1.2rem;">@lang('site.products.add_product')</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- /.order details div -->

            {{-- client orders --}}
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('site.orders') of {{$client->name}} - Total ({{ $orders->total() }})</h3>
                    </div>
                    <div class="card-body">
                        @if ($orders->count())
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.total_price')</th>
                                    <th>@lang('site.created_at')</th>
                                    {{-- <th>@lang('site.status')</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)

                                <tr>
                                    <td class="table-col">{{ $index + 1 }}</td>
                                    <td class="table-col">{{ number_format($order->total_price, 2) }}</td>
                                    <td class="table-col">{{ $order->created_at->format('m.d.Y H:i:s') }}</td>
                                    {{-- <td class="table-col">{{ $order->status }}</td> --}}
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
        </div>
    </div>
    <!-- /.card-body -->

</div>
@endsection
