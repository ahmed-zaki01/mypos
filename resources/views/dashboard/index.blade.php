@extends('layouts.dashboard.app')

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
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- content of index page -->
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $cats }}</h3>

                    <p>@lang('site.cats')</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-list-outline"></i>
                </div>
                <a href="{{ route('dashboard.cats.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $products }}</h3>

                    <p>@lang('site.products.products')</p>
                </div>
                <div class="icon">
                    <i class="ion ion-laptop"></i>
                </div>
                <a href="{{ route('dashboard.products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $clients }}</h3>

                    <p>@lang('site.clients.clients')</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-people"></i>
                </div>
                <a href="{{ route('dashboard.clients.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $users }}</h3>

                    <p>@lang('site.users')</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-people"></i>
                </div>
                <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>POS Morris Chart</h3>
                </div>
                <div class="card-body">
                    <div class="chart" id="line-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</div>
@endsection


@push('scripts')
<script>
    /* Morris.js Charts */
    // Sales chart
    new Morris.Line({
        element : 'line-chart',
        resize : true,
        data : [
        @foreach($sales_data as $data)
            { ym: "{{$data->year}}-{{$data->month}}", sum: "{{$data->sum}}" },
        @endForeach
        ],
        xkey : 'ym',
        ykeys : ['sum'],
        labels : ['Total'],
        lineColors : ['#efefef'],
        lineWidth : 4,
        hideHover : 'auto',
        gridTextColor : '#000',
        gridStrokeWidth : 0.4,
        pointSize : 4,
        pointStrokeColors: ['#efefef'],
        gridLineColor : '#efefef',
        gridTextFamily : 'Open Sans',
        gridTextSize : 10
    })
</script>
@endpush
