@extends('layouts.header')
@section('main')
    @push('title')
        <title>{{ trans('messages.suppliers_lang', [], session('locale')) }}</title>
    @endpush


    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>{{ trans('messages.profile', [], session('locale')) }}</h4>
                    <h6>{{ trans('messages.supplier_profile', [], session('locale')) }}</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="profile-set">
                        <div>
                        </div>
                        <div class="profile-top">
                            <div>
                                @if ($supplier->supplier_image)
                                    <div class="profile-contentimg">
                                        <img src="{{ asset('images/supplier_images/' . $supplier->supplier_image) }}"
                                            alt="img" id="blah">
                                    </div>
                                @else
                                    <div class="profile-contentimg">
                                        <img src="{{ asset('images/dummy_image/no_image.png') }}" alt="img"
                                            id="blah">
                                    </div><br>
                                @endif
                                        <div class="profile-contentname">
                                            <h2>{{ $supplier->supplier_name}}</h2>
                                            @if (!empty($supplier->supplier_email))
                                                <h4>{{ trans('messages.email_lang', [], session('locale')) }}: {{ $supplier->supplier_email }}</h4>
                                            @endif
                                            @if (!empty($supplier->supplier_phone))
                                                <h4>{{ trans('messages.phone_lang', [], session('locale')) }}: {{ $supplier->supplier_phone }}</h4>
                                            @endif
                                        </div>


                            </div>

                        </div><br><br>
                        <div class="row">

                            <div class="row">
                                <div >
                                    <h3>{{ trans('messages.order_detail_lang', [], session('locale')) }}</h3>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table" id="order_detail">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('messages.invoice_no_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.invoice_date', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.invoice_price', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.shipping_charges', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.tax_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.total_price', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.status_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.action_lang', [], session('locale')) }}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($purchasesall as $purchase)
                                                        <tr>
                                                            <td>{{ $purchase['invoice_no'] }}</td>
                                                            <td>{{ $purchase['purchase_date'] }}</td>
                                                            <td>{{ $purchase['invoice_price'] }}</td>
                                                            <td>{{ $purchase['shipping_cost'] }}</td>
                                                            <td>{{ $purchase['total_tax'] }}</td>

                                                            <td>{{ $purchase['total_price'] }}</td>
                                                            <td>
                                                                @if($purchase['status'] == 1)
                                                                    New
                                                                @elseif($purchase['status'] == 2)
                                                                    Completed
                                                                @else
                                                                    Unknown
                                                                @endif
                                                            </td>
                                                           <td>
    <a class="me-3" href="{{ url('purchase_view/' . $purchase['id']) }}">
        <i class="fas fa-eye"></i>
    </a>
</td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <a href="javascript:void(0);" class="btn btn-submit ">{{ trans('messages.submit_lang', [], session('locale')) }}</a>
                                <a href="javascript:void(0);" class="btn btn-cancel">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




{{-- model  --}}

    @include('layouts.footer')
@endsection