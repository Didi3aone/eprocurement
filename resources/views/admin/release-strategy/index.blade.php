@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Purchase Request</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">PR</a></li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </div>
</div>
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive m-t-40">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Release Group</td>
                                        <td>
                                            <input type="text" class="form-control" name="rs_group"> Release Group for PO
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Release Strategy</td>
                                        <td>
                                            <input type="text" class="form-control" name="rs_strategy"> Release PO 0 - 500jt
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Release Indicator</td>
                                        <td>
                                            <input type="text" class="form-control" name="rs_indicator"> Released, Changeable
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Processor</th>
                                        <th>Status</th>
                                        <th>
                                            <button type="button" id="add_release_strategy_item" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Item</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="release_strategy_items">
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="rs_code[]" value="01">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="rs_description[]" value="PURCHASING HEAD">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="rs_processor[]" value="PURCHASING MANAGER">
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-control" name="rs_status[]" checked>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>