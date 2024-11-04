@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.balance_sheet_report_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.balance_sheet_report_lang', [], session('locale')) }}</h6>
                    </div>
                </div>

                <ul class="table-top-head">
                    <li>
                        <a data-bs-toggle="tooltip" id="csvButton" data-bs-placement="top" title="Excel"><img
                                src="{{ asset('img/icons/excel.svg') }}" alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" id="printButton" data-bs-placement="top" title="Print"><i
                                data-feather="printer" class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                                class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
            </div>

            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-1">
                            <button class="btn btn-success" onclick="get_order_detail_report('0')">
                                {{ trans('messages.weekly_report', [], session('locale')) }}
                            </button>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-info" onclick="get_order_detail_report('2')">
                                {{ trans('messages.monthly_report', [], session('locale')) }}
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-warning" onclick="get_order_detail_report('3')">
                                {{ trans('messages.annual_report', [], session('locale')) }}
                            </button>
                        </div>
                    </div><br><br>

                    <form class="form_data" action="{{ route('balance_sheet_report') }}" method="POST">
                        <div class="row">

                            @csrf
                            <div class="col-lg-3 mt-1">
                                <label
                                    for="date-field">{{ trans('messages.date_from_lang', [], session('locale')) }}</label>
                                <input class="datetimepicker form-control bg-light border-0 " value="{{ $sdata }}"
                                    id="date_from" data-time="true" name="date_from">
                                @error('date_from')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3 mt-1">
                                <label for="date-field">{{ trans('messages.to_date_lang', [], session('locale')) }}</label>
                                <input class="datetimepicker form-control bg-light border-0 " value="{{ $edata }}"
                                    id="to_date" data-time="true" name="to_date">
                                @error('to_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3 mt-1">
                                <label>{{ trans('messages.choose_sales_category_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 payment_method" name="payment_method">
    
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
    
                                    @foreach ($accounts as $account)
                                    @php
                                    $selected = "";
                                    if($account_id == $account->id)
                                    {
                                        $selected = "selected='true'";
                                    }
                                @endphp
    
    
                                        <option {{  $selected }}  value="{{ $account->id }}" > {{ $account->account_name }}</option>
                                    @endforeach
                                    @php
    
                                        if($account_id == "point")
                                        {
                                            $selected = "selected='true'";
                                        }
                                    @endphp
                                    <option {{  $selected }}  value="point">{{ trans('messages.points_lang', [], session('locale')) }}</option>
    
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="form btn btn-info mt-4" id="date_data">
                                    <i class="ri-printer-line align-bottom me-1"></i> Submit
                                </button>
                            </div>

                        </div>
                    </form><br><br>

                    {{-- <div class="row">
                        <div class="col-lg-2">

                            <a href="" class="btn btn-success">{{ trans('messages.total_income', [], session('locale')) }}: {{ $total_income }} </a>

                        </div>
                        <div class="col-lg-2">

                            <a href="" class="btn btn-success">{{ trans('messages.total_discount', [], session('locale')) }}: {{ $overall_discount }}</a>

                        </div>
                        <div class="col-lg-2">

                            <a href="" class="btn btn-success"> {{ trans('messages.total_visa', [], session('locale')) }}: {{ $total_visa }}</a>

                        </div>
                        <div class="col-lg-2">

                            <a href="" class="btn btn-warning"> {{ trans('messages.total_bank', [], session('locale')) }}: {{ $total_bank }}</a>

                        </div>
                        <div class="col-lg-2">

                            <a href="" class="btn btn-warning"> {{ trans('messages.total_cash', [], session('locale')) }}: {{ $total_cash }}</a>

                        </div>

                    </div><br><br> --}}
                    <div class=" table-responsive">
                        <table id="bank_statement" class="display nowrap">
                            <thead>
                                <tr> 
                                    <th> {{ trans('messages.add_date_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.created_by_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.source_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.income_type_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.notes_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.credit_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.debit_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.balance_lang', [], session('locale')) }}</th>
                                 </tr>
                            </thead>
                            <tbody>
                                <tr>
                              
                                    <td>{{ trans('messages.initial_balance_lang', [], session('locale')) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td> 
                                    <td class="bank-balance">0</td>
                                    
                                    
                                </tr>
                                @php $sno=0; @endphp
                                {{-- pos payment --}}
                                @foreach ($pos_payment as $pp)
                                    @php
                                         
                                        $source='';
                                        $bank_in=0;
                                        $bank_out=0;
                                        if(!empty($pp->order_no2))
                                        {
                                            $source=trans('messages.out_lang', [], session('locale'));
                                            $bank_in=0;
                                            $bank_out=abs($pp->paid_amount);
                                            $type=trans('messages.type_restore_sale_lang', [], session('locale'));
                                        }
                                        else 
                                        {
                                            $source=trans('messages.in_lang', [], session('locale'));
                                            $bank_in=$pp->paid_amount;
                                            $bank_out=0;
                                            $type=trans('messages.type_sale_lang', [], session('locale'));

                                        } 
                                        $sno++;
                                        echo '<tr>
                                                 
                                                <td>'.$pp->created_at.'</td>
                                                <td>'.$pp->added_by.'</td>
                                                <td>'.$type.'</td>
                                                <td>'.$source.'</td>
                                                <td>'.$pp->notes.'</td>
                                                <td class="bank-in">'.$bank_in.'</td>
                                                <td class="bank-out">'.$bank_out.'</td>
                                                <td class="bank-balance"></td>
                                            
                                            </tr>';
                                    @endphp
                                @endforeach
                                {{-- expense --}}
                                @foreach ($expense_payment as $ep)
                                    @php
                                         
                                         
                                        $source=trans('messages.out_lang', [], session('locale'));
                                        $bank_in=0;
                                        $bank_out=abs($ep->amount);
                                        
                                        $sno++;
                                        echo '<tr>
                                                 
                                                <td>'.$ep->created_at.'</td>
                                                <td>'.$ep->added_by.'</td>
                                                <td>'.trans('messages.type_expense_lang', [], session('locale')).'</td>
                                                <td>'.$source.'</td>
                                                <td>'.$ep->notes.'</td>
                                                <td class="bank-in">'.$bank_in.'</td>
                                                <td class="bank-out">'.$bank_out.'</td>
                                                <td class="bank-balance"></td>
                                            
                                            </tr>';
                                    @endphp
                                @endforeach
                                {{-- pos payment expense --}}  
                                @foreach ($pos_payment_expense as $ppe)
                                    @php
                                         
                                        $source='';
                                        $bank_in=0;
                                        $bank_out=0;
                                        if(!empty($ppe->order_no2))
                                        {
                                            $source=trans('messages.in_lang', [], session('locale'));
                                            $bank_in=abs($ppe->account_tax_fee);
                                            $bank_out=0;
                                            $type=trans('messages.type_restore_sale_payment_expense_lang', [], session('locale'));
                                        }
                                        else 
                                        {
                                            $source=trans('messages.out_lang', [], session('locale'));
                                            $bank_in=0;
                                            $bank_out=$ppe->account_tax_fee;
                                            $type=trans('messages.type_sale_payment_expense_lang', [], session('locale'));

                                        } 
                                        
                                        $sno++;
                                        echo '<tr>
                                                 
                                                <td>'.$ppe->created_at.'</td>
                                                <td>'.$ppe->added_by.'</td>
                                                <td>'.$type.'</td>
                                                <td>'.$source.'</td>
                                                <td></td>
                                                <td class="bank-in">'.$bank_in.'</td>
                                                <td class="bank-out">'.$bank_out.'</td>
                                                <td class="bank-balance"></td>
                                            
                                            </tr>';
                                    @endphp
                                @endforeach
                                {{-- maintenance payment --}}  
                                @foreach ($maintenance_payment as $mp)
                                    @php
                                         
                                         
                                        $source=trans('messages.in_lang', [], session('locale'));
                                        $bank_out=0;
                                        $bank_in=abs($mp->paid_amount);
                                        
                                        $sno++;
                                        echo '<tr>
                                                 
                                                <td>'.$mp->created_at.'</td>
                                                <td>'.$mp->added_by.'</td>
                                                <td>'.trans('messages.type_maintenance_payment_lang', [], session('locale')).'</td>
                                                <td>'.$source.'</td>
                                                <td></td>
                                                <td class="bank-in">'.$bank_in.'</td>
                                                <td class="bank-out">'.$bank_out.'</td>
                                                <td class="bank-balance"></td>
                                            
                                            </tr>';
                                    @endphp
                                @endforeach
                                {{-- maintenance payment expense --}}  
                                @foreach ($maintenance_payment_expense as $mpe)
                                    @php
                                         
                                         
                                         $source=trans('messages.out_lang', [], session('locale'));
                                        $bank_in=0;
                                        $bank_out=abs($mpe->account_tax_fee);
                                        
                                        $sno++;
                                        echo '<tr>
                                                 
                                                <td>'.$mpe->created_at.'</td>
                                                <td>'.$mpe->added_by.'</td>
                                                <td>'.trans('messages.type_maintenance_payment_expense_lang', [], session('locale')).'</td>
                                                <td>'.$source.'</td>
                                                <td></td>
                                                <td class="bank-in">'.$bank_in.'</td>
                                                <td class="bank-out">'.$bank_out.'</td>
                                                <td class="bank-balance"></td>
                                            
                                            </tr>';
                                    @endphp
                                @endforeach
                                {{-- maintenance payment expense --}}  
                                @foreach ($purchase_payment as $spp)
                                    @php
                                         
                                         
                                         $source=trans('messages.out_lang', [], session('locale'));
                                        $bank_in=0;
                                        $bank_out=abs($spp->paid_amount);
                                        
                                        $sno++;
                                        echo '<tr>
                                                 
                                                <td>'.$spp->created_at.'</td>
                                                <td>'.$spp->added_by.'</td>
                                                <td>'.trans('messages.type_purchase_payment_lang', [], session('locale')).'</td>
                                                <td>'.$source.'</td>
                                                <td></td>
                                                <td class="bank-in">'.$bank_in.'</td>
                                                <td class="bank-out">'.$bank_out.'</td>
                                                <td class="bank-balance"></td>
                                            
                                            </tr>';
                                    @endphp
                                @endforeach
                                 {{-- transform_payment_from --}}  
                                @foreach ($transform_payment_from as $tpf)
                                 @php
                                      
                                      
                                     $source=trans('messages.out_lang', [], session('locale'));
                                     $bank_in=0;
                                     $bank_out=abs($tpf->amount);
                                     
                                     $sno++;
                                     echo '<tr>
                                              
                                             <td>'.$tpf->created_at.'</td>
                                             <td>'.$tpf->added_by.'</td>
                                             <td>'.trans('messages.type_transfer_payment_from_lang', [], session('locale')).'</td>
                                             <td>'.$source.'</td>
                                             <td></td>
                                             <td class="bank-in">'.$bank_in.'</td>
                                             <td class="bank-out">'.$bank_out.'</td>
                                             <td class="bank-balance"></td>
                                         
                                         </tr>';
                                 @endphp
                                @endforeach
                                 {{-- transform_payment_to --}}  
                                 @foreach ($transform_payment_to as $tpt)
                                 @php
                                      
                                      
                                     $source=trans('messages.in_lang', [], session('locale'));
                                     $bank_in=abs($tpt->amount);
                                     $bank_out=0;
                                     
                                     $sno++;
                                     echo '<tr>
                                              
                                             <td>'.$tpt->created_at.'</td>
                                             <td>'.$tpt->added_by.'</td>
                                             <td>'.trans('messages.type_transfer_payment_to_lang', [], session('locale')).'</td>
                                             <td>'.$source.'</td>
                                             <td></td>
                                             <td class="bank-in">'.$bank_in.'</td>
                                             <td class="bank-out">'.$bank_out.'</td>
                                             <td class="bank-balance"></td>
                                         
                                         </tr>';
                                 @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    





    @include('layouts.report_footer')
@endsection
