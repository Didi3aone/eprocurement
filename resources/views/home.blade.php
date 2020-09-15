@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
    <div class="col-md-7 col-4 align-self-center">
        <div class="d-flex m-t-10 justify-content-end">
            {{-- <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                <div class="chart-text m-r-10">
                    <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                    <h4 class="m-t-0 text-info">$58,356</h4></div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                <div class="chart-text m-r-10">
                    <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                    <h4 class="m-t-0 text-primary">$48,356</h4></div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div> --}}
            {{-- <div class="">
                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
            </div> --}}
        </div>
    </div>
</div>
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <a href="{{ route('admin.purchase-request.index') }}">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-info"><i class="mdi mdi-cart-outline"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">{{ $prTotal }}</h3>
                        <h5 class="text-muted m-b-0">Total PR</h5></div>
                </div>
            </div>
            </a>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <a href="{{ route('admin.purchase-order.index') }}">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-car"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{ $poTotal }}</h3>
                        <h5 class="text-muted m-b-0">Total PO</h5></div>
                </div>
            </div>
            </a>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            @if(\Auth::user()->roles[0]->id == 1 || \Auth::user()->roles[0]->id == 3)
                <a href="{{ route('admin.master-acp.index') }}">
            @else
                <a href="{{ route('admin.acp-approval') }}">
            @endif
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-primary"><i class="fa fa-money"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{ $acpTotal }}</h3>
                        <h5 class="text-muted m-b-0">Acp</h5></div>
                </div>
            </div>
            </a>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        {{-- <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-danger"><i class="fa fa-truck"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">0</h3>
                        <h5 class="text-muted m-b-0">PO Proses</h5></div>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- Column -->
</div>
@endsection
@section('scripts')
@parent

@endsection