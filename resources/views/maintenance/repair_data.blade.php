@extends('layouts.maintenance_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.repair_data_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>{{ trans('messages.maintenance_list_lang', [], session('locale')) }}</h4>
                 </div> 
            </div>
           <!-- /product list this is my first commit -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label>{{ trans('messages.status_lang', [], session('locale')) }}</label>
                                <select class="status form-control" id="status" name="status">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option> 
                                    <option value="1">{{ trans('messages.receive_status_lang', [], session('locale')) }}</option> 
                                    <option value="6">{{ trans('messages.inspection_status_lang', [], session('locale')) }}</option> 
                                    <option value="2">{{ trans('messages.send_agent_status_lang', [], session('locale')) }}</option>
                                    <option value="3">{{ trans('messages.receive_agent_status_lang', [], session('locale')) }}</option>
                                    <option value="4">{{ trans('messages.ready_status_lang', [], session('locale')) }}</option>
                                    <option value="5">{{ trans('messages.deleivered_status_lang', [], session('locale')) }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="all_maintenance" class="table  ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('messages.reference_no_lang',[],session('locale')) }}</th>
                                    <th>{{ trans('messages.receiving_date_lang',[],session('locale'))}}</th>
                                    <th>{{ trans('messages.deliver_date_lang',[],session('locale'))}}</th>
                                    <th>{{ trans('messages.repair_type_lang',[],session('locale'))}}</th>
                                    <th>{{ trans('messages.status_lang',[],session('locale'))}}</th>
                                    <th>{{ trans('messages.created_at_lang',[],session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>
</div>

    @include('layouts.footer')
@endsection
