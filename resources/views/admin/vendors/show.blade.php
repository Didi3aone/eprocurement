@extends('layouts.admin')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Master</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Vendor</a></li>
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
                                {{ trans('cruds.vendors.fields.id') }}
                            </th>
                            <td>
                                {{ $vendors->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.vendors.fields.name') }}
                            </th>
                            <td>
                                {{ $vendors->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-bordered mb-3 customtab">
                    <li class="nav-item">
                        <a href="#general-data" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">General Data</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#company-data" data-toggle="tab" aria-expanded="true"
                            class="nav-link">
                            <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">Company Data</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#bank-details" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">Bank Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#tax-number" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">Tax Number</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#addtional-address" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">Additional Address</span>
                        </a>
                    </li> --}}
                </ul>

                <div class="tab-content">
                    <div class="tab-pane" id="general-data">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vendors.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $vendors->code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.vendors.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $vendors->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        BP GROUP
                                    </th>
                                    <td>
                                        {{ $vendors->getBpGroup['name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Title
                                    </th>
                                    <td>
                                        {{ $vendors->getTitle['name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Street
                                    </th>
                                    <td>
                                        {{ $vendors->street }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Different City
                                    </th>
                                    <td>
                                        {{ $vendors->different_city }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Postal Code
                                    </th>
                                    <td>
                                        {{ $vendors->postal_code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        City
                                    </th>
                                    <td>
                                        {{ $vendors->city }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Country
                                    </th>
                                    <td>
                                        {{ $vendors->country }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Street 2
                                    </th>
                                    <td>
                                        {{ $vendors->street_2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Street 3
                                    </th>
                                    <td>
                                        {{ $vendors->street_3 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Street 4
                                    </th>
                                    <td>
                                        {{ $vendors->street_4 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Street 5
                                    </th>
                                    <td>
                                        {{ $vendors->street_5 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Default telp
                                    </th>
                                    <td>
                                        {{ $vendors->office_telephone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Additional Telp 1
                                    </th>
                                    <td>
                                        {{ $vendors->telephone_2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Additional Telp 2
                                    </th>
                                    <td>
                                        {{ $vendors->telephone_3 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Additional Telp 3
                                    </th>
                                    <td>
                                        {{ $vendors->telephone_3 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Default Fax
                                    </th>
                                    <td>
                                        {{ $vendors->office_fax }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Additional Default Fax 2
                                    </th>
                                    <td>
                                        {{ $vendors->fax_2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Default Email
                                    </th>
                                    <td>
                                        {{ $vendors->email }}
                                    </td>
                                </tr>
                                 <tr>
                                    <th>
                                        Additional Email 2
                                    </th>
                                    <td>
                                        {{ $vendors->email_2 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane show active" id="company-data">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Vendor
                                    </th>
                                    <th>
                                       Company Code
                                    </th>
                                    <th>
                                        Reconciliation Account In ledger
                                    </th>
                                    <th>
                                        Planing Group
                                    </th>
                                    <th>
                                        Payment Terms
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendors->getCompanyData as $key => $value)
                                <tr>
                                    <td>{{ $vendors->name }}</td>
                                    <td>{{ $value->company_code }}</td>
                                    <td>{{ $value->account_gl }}</td>
                                    <td>{{ $value->planning_group }}</td>
                                    <td>{{ $value->payment_terms }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="bank-details">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        Vendor
                                    </th>
                                    <td>
                                       {{ $vendors->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Bank Country Keys
                                    </th>
                                    <td>
                                       {{ $vendors->getBankDetails['bank_country_key'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Bank Keys
                                    </th>
                                    <td>
                                       {{ $vendors->getBankDetails['bank_keys'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Account No
                                    </th>
                                    <td>
                                       {{ $vendors->getBankDetails['account_no'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Bank 
                                    </th>
                                    <td>
                                       {{ $vendors->getBankDetails['bank_details'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Account Holder Name 
                                    </th>
                                    <td>
                                       {{ $vendors->getBankDetails['account_holder_name'] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tax-number">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        Vendor
                                    </th>
                                    <td>
                                       {{ $vendors->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Tax Number Category
                                    </th>
                                    <td>
                                       {{ $vendors->getTaxNumber['tax_numbers_category'] }}
                                    </td>
                                </tr>
                                 <tr>
                                    <th>
                                        Tax Number
                                    </th>
                                    <td>
                                       {{ $vendors->getTaxNumber['tax_numbers'] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="tab-pane" id="additional-address">
                        <p>Food truck quinoa dolor sit amet, consectetuer adipiscing elit. Aenean
                            commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et
                            magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
                            ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa
                            quis enim.</p>
                        <p class="mb-0">Donec pede justo, fringilla vel, aliquet nec, vulputate eget,
                            arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam
                            dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus
                            elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula,
                            porttitor eu, consequat vitae, eleifend ac, enim.</p>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection