<div id="loading" style="display: none; flex-direction: column; align-items: center;">
    <div class="loader"></div>
</div>
@if ($products->count())
<table class="table table-hover text-center">
    <thead>
        <tr>
            <th>@lang('site.products.product')</th>
            <th>@lang('site.quantity')</th>
            <th>@lang('site.products.price')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $index => $product)
        <tr>
            <td class="table-col">{{ $product->name }}</td>
            <td class="table-col">{{ $product->pivot->quantity }}</td>
            <td class="table-col">{{ number_format($product->pivot->quantity * $product->sell_price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<h3 class="py-3"><span>@lang('site.total_price'): </span>{{ number_format($order->total_price, 2) }}</h3>
<button class="btn btn-info btn-block"><i class="fas fa-print"></i> @lang('site.print')</button>
@else
<h2 class="py-5 text-center">@lang('site.no_data_found')</h2>
@endif
</div>
</div>
