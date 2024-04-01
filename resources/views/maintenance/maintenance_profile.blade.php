@extends('layouts.maintenance_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.maintenance_profile_lang', [], session('locale')) }}</title>
    @endpush
    
    <div class="page-wrapper">
        <input type="hidden" class="reference_no" value="{{ $repair_detail->reference_no }}"> 
        <div class="content">
        <div class="welcome d-lg-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center welcome-text">
                <h3 class="d-flex align-items-center"> {{ $customer_data->customer_name }} ({{ $customer_data->customer_phone }})
                {{-- <h6><span class='badges bg-lightgreen badges_table'>{{ trans('messages.purchase_date_lang', [], session('locale')) }} : {{ get_date_only($order_data->created_at)}}</span> --}}
                    {{-- <span class='badges bg-lightgreen badges_table'>{{ trans('messages.receiving_date_lang', [], session('locale')) }} : {{ get_date_only($repair_detail->receive_date) }}</span> --}}
                    <span class='badges bg-lightgreen badges_table'>{{ trans('messages.deliver_date_lang', [], session('locale')) }} : {{ get_date_only($repair_detail->deliver_date)}}</span></h3> 

                {{-- </h6> --}}
            </div>
            <div class="d-flex align-items-center">
                <div class="position-relative daterange-wraper me-2">
                    <div class="input-groupicon calender-input">
                        <select class="repairing_type form-control" id="repairing_type" name="repairing_type">
                            <option {{ $repair_detail->repairing_type == 1 ? 'selected' : '' }} value="1">{{ trans('messages.inspection_and_repair_lang', [], session('locale')) }}</option> 
                            <option {{ $repair_detail->repairing_type == 2 ? 'selected' : '' }} value="2">{{ trans('messages.replace_lang', [], session('locale')) }}</option>
                             
                        </select>
                     </div> 
                </div>
             </div>
            <div class="d-flex align-items-center">
                <div class="position-relative daterange-wraper me-2">
                    <div class="input-groupicon calender-input">
                        <select class="change_status form-control" id="change_status" name="status">
                            <option {{ $repair_detail->status == 1 ? 'selected' : '' }} value="1">{{ trans('messages.receive_status_lang', [], session('locale')) }}</option> 
                            <option {{ $repair_detail->status == 6 ? 'selected' : '' }} value="6">{{ trans('messages.inspection_status_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 2 ? 'selected' : '' }} value="2">{{ trans('messages.send_agent_status_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 3 ? 'selected' : '' }} value="3">{{ trans('messages.receive_agent_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 4 ? 'selected' : '' }} value="4">{{ trans('messages.ready_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 5 ? 'selected' : '' }} value="5">{{ trans('messages.deleivered_lang', [], session('locale')) }}</option>
                        </select>
                     </div> 
                </div>
             </div>
        </div>
        <div class="welcome d-lg-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="position-relative daterange-wraper me-2">
                    <div class="input-groupicon calender-input">
                        <label>{{ trans('messages.technicians_lang', [], session('locale')) }}</label>
                        <select class="searchable_select select2 technician_id" name="technician_id" multiple>
                            @foreach ($view_technicians as $tech)
                                @php
                                    $selected = in_array($tech->id, $all_technicians) ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $tech->id }}" {{ $selected }}>{{ $tech->technician_name }}</option>
                            @endforeach
                        </select>
                        
                     </div> 
                </div>
             </div>
        </div>
        <div class="row sales-cards">
            <div class="col-xl-3 col-sm-12 col-12">
                <div class="card d-flex align-items-center justify-content-between default-cover mb-4">
                    <div>
                        <h6>
                            @php if ($repair_detail->repairing_type == 1) {
                                echo "<span class='badges bg-lightgreen badges_table'>" . trans('messages.inspection_and_repair_lang', [], session('locale')) . "</span>";
                            } else if ($repair_detail->type == 2) {
                                echo "<span class='badges bg-lightgreen badges_table'>" . trans('messages.replace_lang', [], session('locale')) . "</span>";
                            }
                            @endphp
                            <br>
                            {{ $title }} 
                        </h6>
                        @php
                            if ($imei != "") {
                        @endphp
                            <h3><span>{{ $imei }}</span></h3>
                        @php
                            }
                        @endphp

                        <h6 class="sales-range"><span class="text-success">{{ trans('messages.purchase_price_lang', [], session('locale')) }} {{ $pro_data->total_purchase }}</span></h6>
                    </div>
                 </div>
            </div>
            <div class="col-xl-3 col-sm-12 col-12">
                <div style="height:156.52px!important;overflow-y: auto;padding:10px!important " class="card d-flex align-items-center justify-content-between default-cover mb-4">
                    <div>
                        <h6 style="white-space: preline">{{ trans('messages.notes_lang', [], session('locale')) }} : <br>{{ $repair_detail->notes }}</h6>
                    </div>
                 </div>
            </div>
            @php if($warranty_type==1){ @endphp
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card color-info bg-primary mb-4">
                        <i class="fas fa-wifi fa-3x"></i>
                        <h3 class="counters" data-count="{{$pro_sum }}" id="total_product">{{$pro_sum }}</h3>
                        <p>{{ trans('messages.total_product_lang', [], session('locale')) }}</p>
                        <i data-feather="rotate-ccw" class="feather-16" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card color-info bg-secondary mb-4">
                        <i class="fas fa-tools fa-3x"></i>
                        <h3 class="counters" data-count="{{$serv_sum }}" id="total_service">{{$serv_sum }}</h3>
                        <p>{{ trans('messages.total_service_lang', [], session('locale')) }}</p>
                        <i data-feather="rotate-ccw" class="feather-16" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"></i>
                    </div>
                </div>
            @php } @endphp
        </div>


        {{-- add pro and service for reparing --}}
        @php if($warranty_type==1){ @endphp
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-6 d-flex">
                <div class="card flex-fill default-cover w-100 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ trans('messages.services_lang', [], session('locale')) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-10">
                                <select class="searchable_select select2 service_id">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                        @foreach ($view_service as $srv) {
                                            <option value="{{$srv->id}}">{{$srv->service_name}}</option>';
                                        }
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                <div class="add-icon">
                                    <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                    data-bs-target="#add_service_modal">
                                        <i class="plus_i_class fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive no-pagination">
                            <table class="table no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.service_name_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.cost_lang', [], session('locale')) }}</th> 
                                        <th>{{ trans('messages.action_lang', [], session('locale')) }}</th> 
                                    </tr>
                                </thead>
                                <tbody id="service_tbody">
                                 
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
    
         
    
    
            <div class="col-sm-12 col-md-12 col-xl-6 d-flex">
                <div class="card flex-fill default-cover w-100 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ trans('messages.products_lang', [], session('locale')) }}</h4>
                         
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-10">
                                <select class="searchable_select select2 product_id">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                    @foreach ($view_product as $pro)
                                        @php
                                            $title = !empty($pro->product_name) ? $pro->product_name : $pro->product_name_ar;
                                        @endphp
                                        <option value="{{ $pro->id }}">{{ $title }}</option>
                                    @endforeach
                                
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive no-pagination">
                            <table class="table no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.product_name_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.cost_lang', [], session('locale')) }}</th> 
                                        <th>{{ trans('messages.action_lang', [], session('locale')) }}</th> 
                                    </tr>
                                </thead>
                                <tbody id="product_tbody">
                                 
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php } @endphp
        {{--  --}}

        @php
        if (!$repairing_history_record=="") {
        @endphp
    
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-12 d-flex">
            <div class="card flex-fill default-cover w-100 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ trans('messages.repairing_history_lang', [], session('locale')) }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless recent-transactions">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('messages.receiving_date_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.deliver_date_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.cost_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php echo $repairing_history_record; @endphp
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @php
        }
    @endphp
       
    
    
        
         
        </div>
        </div>
        <div class="customizer-links">
        <ul class="sticky-sidebar">
        <li class="sidebar-icons">
        <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Theme">
        <i data-feather="settings" class="feather-five"></i>
        </a>
        </li>
        </ul>
        </div>
        </div>
        
{{-- service add modal --}}
<div class="modal fade" id="add_service_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('add_service') }}" class="add_service" method="POST" enctype="multipart/form-data">
                 @csrf

                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="new_service_id" name="service_id">
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.service_name_lang', [], session('locale')) }}</label>
                                    <input type="text" class="form-control service_name" name="service_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.service_cost_lang', [], session('locale')) }}</label>
                                    <input type="text" class="form-control service_cost cost" name="service_cost">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.service_detail_lang', [], session('locale')) }}</label>
                                    <textarea  class="form-control service_detail" rows="3" name="service_detail"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2 submit_form">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                            <a class="btn btn-cancel" data-bs-dismiss="modal">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                        </div>



                    </div>
                </form>
      </div>
    </div>
</div>
{{--  --}}
 
@include('layouts.footer')
@endsection
