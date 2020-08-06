@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Ship To</a></li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                PT
                            </th>
                            <td>
                                {{ $shipTo->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Address
                            </th>
                            <td>
                                {{ $shipTo->alamat }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection