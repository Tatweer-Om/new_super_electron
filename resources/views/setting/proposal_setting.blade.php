@extends('layouts.setting_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.proposal_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content settings-content">
            <div class="page-header settings-pg-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4> {{ trans('messages.proposal_&_qout_lang', [], session('locale')) }}</h4>
                        <h6> {{ trans('messages.proposal_&_terms_lang', [], session('locale')) }}</h6>
                    </div>
                </div>
                <ul class="table-top-head">
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
            <div class="row">
                <div class="col-xl-12">
                    <div class="settings-wrapper d-flex">
                        <div class="sidebars settings-sidebar theiaStickySidebar" id="sidebar2">
                            <div class="sidebar-inner slimscroll">
                                <div id="sidebar-menu5" class="sidebar-menu">
                                    <ul>
                                        <li class="submenu-open">
                                            <ul>
                                                <li class=" submenu">
                                                    <a href="javascript:void(0);" ><i
                                                            data-feather="settings"></i><span> {{ trans('messages.gnrl_setting_lang', [], session('locale')) }}</span><span
                                                            class="menu-arrow"></span></a>

                                                        <ul>
                                                        <li><a href="{{ url('setting') }}" class="active">{{ trans('messages.cmpny_profile_lang', [], session('locale')) }}</a></li>
                                                        <li><a href="{{ url('pos_qout_setting') }}" >{{ trans('messages.pos_invo_lang', [], session('locale')) }}</a></li>
                                                    </ul>
                                                </li>
                                                <li class="submenu">
                                                    <a href="javascript:void(0);" class="active subdrop"><i
                                                            data-feather="airplay"></i><span>{{ trans('messages.proposal_&_qout_lang', [], session('locale')) }}</span><span
                                                            class="menu-arrow"></span></a>
                                                    <ul>
                                                        <li><a href="{{ url('proposal_setting') }}" class="active"> {{ trans('messages.terms_refs_lang', [], session('locale')) }}</a></li>
                                                        <li><a href="{{ url('qout_setting') }}"> {{ trans('messages.qout_detail_lang', [], session('locale')) }}</a></li>

                                                    </ul>
                                                </li>
                                                <li class="submenu">
                                                    <a href="javascript:void(0);"><i data-feather="archive"></i><span>
                                                        {{ trans('messages.maint_agree_lang', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
                                                    <ul>
                                                        <li><a href="{{ url('inspection_setting') }}">{{ trans('messages.inspection_setting_lang', [], session('locale')) }}</a></li>
                                                        <li><a href="{{ url('maint_setting') }}"> {{ trans('messages.repair_agreement_lang', [], session('locale')) }} </a></li>

                                                    </ul>
                                                </li>
                                                <li class="submenu">
                                                    <a href="javascript:void(0);"><i data-feather="server"></i><span> {{ trans('messages.stck_setting_lang', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
                                                    <ul>
                                                        <li><a href="{{ url('tax_setting') }}">{{ trans('messages.tax_matter_lang', [], session('locale')) }}</a>

                                                        </li>
                                                        <li><a href="{{ url('points') }}" >{{ trans('messages.point_sstm_lang', [], session('locale')) }}</a></li>
                                                    </ul>
                                                </li>


                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="settings-page-wrap">
                            <form action="" id="proposal" method="Post">
                                @csrf
                                <div class="setting-title">
                                    <h4> {{ trans('messages.prorosal_term_lang', [], session('locale')) }}</h4>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> {{ trans('messages.terms_condition_lang', [], session('locale')) }}</label>

                                            <textarea id="bulletTextarea" class="form-control"  style="resize: both; overflow: auto;" name="proposal">{{ $proposal->proposal_detail ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="text-end settings-bottom-btn">
                                    <button type="button" class="btn btn-cancel me-2"> {{ trans('messages.cancel_lang', [], session('locale')) }}</button>
                                    <button type="submit" class="btn btn-submit"> {{ trans('messages.save_change_lang', [], session('locale')) }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @include('layouts.footer')
@endsection
