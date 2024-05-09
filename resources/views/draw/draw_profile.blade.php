@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.draw_profile_lang', [], session('locale')) }}</title>
@endpush
 
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">

                        <h4> {{ trans('messages.draw_profile_lang', [], session('locale')) }}</h4>
                     </div> 
                </div>

                <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                       
                            <input type="hidden" class="form-control" id="draw_id" value="<?php echo $draw->id ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>{{ trans('messages.draw_name_lang', [], session('locale')) }} : {{ $draw->draw_name }}</h5>
                                    <h5>{{ trans('messages.draw_starts_lang', [], session('locale')) }} : {{ $draw->draw_starts }}</h5>
                                    <h5>{{ trans('messages.draw_ends_lang', [], session('locale')) }} : {{ $draw->draw_ends }}</h5>
                                    {{-- <h5>{{ trans('messages.customer_type_lang', [], session('locale')) }} : @php echo $draw_customer @endphp</h5> --}}
                                </div>
                                <div class="col-md-4">
                                    <h5>{{ trans('messages.draw_date_lang', [], session('locale')) }} : {{ $draw->draw_date }}</h5>
                                    <h5>{{ trans('messages.amount_lang', [], session('locale')) }} : {{ $draw->amount }}</h5>
                                    <h5>{{ trans('messages.draw_detail_lang', [], session('locale')) }} : {{ $draw->draw_detail }}</h5>
                                </div> 
                            </div><br>
                            @if(!empty($lucky_customer))
                            <div class="row">
                                
                                <div class="livebox-container">
                                    <ul id="livebox-slideshow">
                                        @foreach ($lucky_customer as $index => $customer)
                                            <li class="in" data-id="{{ $customer['customer_id'] }}" data-index="{{ $index }}">
                                                <h1 class="text-primary">{{ $customer['customer_name'] }}</h1>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="container text-center">
                                <button id='start' class="btn btn-primary btn-lg py-4 px-2 rounded-circle">Start :-)</button>
                                <button id='stop' class="btn btn-danger btn-lg py-4 px-2 rounded-circle" style="display: none;">Stop
                                    ;-)</button>
                            </div>
                            <hr>
                            @endif
                            
                            @if(!empty($all_winners))
                               <div class="row">
                                   @php echo $all_winners; @endphp
                               </div>
                            
                            @endif
                    </div>
                </div>
                <!-- /product list -->
            </div>
        </div>
    </div>

    
    <div class="modal" tabindex="-1" role="dialog" id="winnerModal" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="winnerModalTitle" class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="return hideWinnerModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column flex-1 align-content-center justify-content-center">
                        <h6 class="text-center">{{ trans('messages.winner_lang', [], session('locale')) }}</h6>
                        <div id="winnerModalContent" class="text-center"></div>
                        <i class="fas fa-trophy fa-4x text-center" style="color:gold"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
		<!-- /Main Wrapper -->
    @include('layouts.footer')
    @endsection

