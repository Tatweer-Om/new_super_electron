@extends('layouts.setting_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.setting_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content settings-content">
            <div class="page-header settings-pg-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.setting_lang', [], session('locale')) }}</h4>
                        <h6> {{ trans('messages.setting_portal_lang', [], session('locale')) }}</h6>
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
                                                    <a href="javascript:void(0);" class="active subdrop"><i
                                                            data-feather="settings"></i><span> {{ trans('messages.gnrl_setting_lang', [], session('locale')) }}</span><span
                                                            class="menu-arrow"></span></a>

                                                        <ul>
                                                        <li><a href="{{ url('setting') }}" class="active">{{ trans('messages.cmpny_profile_lang', [], session('locale')) }}</a></li>
                                                        <li><a href="{{ url('pos_qout_setting') }}" >{{ trans('messages.pos_invo_lang', [], session('locale')) }}</a></li>
                                                    </ul>
                                                </li>
                                                <li class="submenu">
                                                    <a href="javascript:void(0);"><i
                                                            data-feather="airplay"></i><span>{{ trans('messages.proposal_&_qout_lang', [], session('locale')) }}</span><span
                                                            class="menu-arrow"></span></a>
                                                    <ul>
                                                        <li><a href="{{ url('proposal_setting') }}"> {{ trans('messages.terms_refs_lang', [], session('locale')) }}</a></li>
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
                            <form action="" id="company_data" class="company_data" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="setting-title">
                                    <h4> {{ trans('messages.cmpny_profile_lang', [], session('locale')) }}</h4>
                                </div>
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="card-title-head">
                                            <h6><span><i data-feather="home" class="feather-chevron-up"></i></span> {{ trans('messages.sstm_info_lang', [], session('locale')) }}</h6>
                                        </div>
                                        <div class="profile-pic-upload">
                                            <div class="profile-pic">
                                                @php
                                                    $image = asset('images/dummy_image/no_image.png');
                                                    if (!empty($setting_data->main_logo)) {
                                                        $image = asset('images/setting_images/' . $setting_data->main_logo);
                                                    }
                                                @endphp
                                                <img src="{{ $image }}" class="img_tags" id="main_img_tag" width="300px" height="100px">

                                            </div>

                                            <div class="new-employee-field">
                                                <div class="mb-0">
                                                    <div class="image-upload mb-0">
                                                        <input type="file" name="main_logo" onchange="return fileValidation('main_logo','main_img_tag')" id="main_logo">
                                                        <div class="image-uploads">
                                                            <h4>{{ trans('messages.chang_logo_lang', [], session('locale')) }}</h4>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="card-title-head">
                                            <h6><span><i data-feather="clipboard" class="feather-chevron-up"></i></span> {{ trans('messages.ino_logo_lang', [], session('locale')) }}</h6>
                                        </div>
                                        <div class="profile-pic-upload">
                                            <div class="profile-pic">
                                                @php
                                                $image = asset('images/dummy_image/no_image.png');
                                                if (!empty($setting_data->invo_logo)) {
                                                    $image = asset('images/setting_images/' . $setting_data->invo_logo);
                                                }
                                            @endphp
                                            <img src="{{ $image }}" class="img_tags" id="invo_img_tag" width="300px" height="100px">
                                            </div>
                                            <div class="new-employee-field">
                                                <div class="mb-0">
                                                    <div class="image-upload mb-0">
                                                        <input type="file" onchange="return fileValidation('invo_logo','invo_img_tag')" id="invo_logo" name="invo_logo">
                                                        <div class="image-uploads">
                                                            <h4> {{ trans('messages.chang_logo_lang', [], session('locale')) }}</h4>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label"> {{ trans('messages.system_nm_lang', [], session('locale')) }}</label>
                                            <input type="text" value="{{ $setting_data ? $setting_data->system_name : '' }}" class="form-control system_name" name="system_name" id="system_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label"> {{ trans('messages.phone_lang', [], session('locale')) }}</label>
                                            <input type="text" value="{{ $setting_data ? $setting_data->company_phone : ''}}" class="form-control" name="company_phone" id="company_phone">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">{{ trans('messages.email_lang', [], session('locale')) }}</label>
                                            <input type="email" value="{{ $setting_data->company_email ?? '' }}" class="form-control" name="company_email" id="company_email">
                                        </div>
                                    </div>

                                </div>
                                <div class="card-title-head">
                                    <h6><span><i data-feather="map-pin"  class="feather-chevron-up"></i></span>
                                        {{ trans('messages.our_adrs_lang', [], session('locale')) }}</h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> {{ trans('messages.address_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control" value="{{ $setting_data->company_address ?? ''}}" name="company_address" id="company_address">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">{{ trans('messages.cntry_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control" value="{{ $setting_data->country ?? ''}}" name="country" id="country">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"> {{ trans('messages.state_pro_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control" value="{{ $setting_data->state ?? ''}}" name="state" id="state">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"> {{ trans('messages.cty_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control" value="{{ $setting_data->city ?? ''}}" name="city" id="city">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"> {{ trans('messages.post_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control" value="{{ $setting_data->postal_code ?? ''}}" name="postal_code" id="postal_code">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"> {{ trans('messages.zip_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control" value="{{ $setting_data->zip_code ?? ''}}" name="zip_code" id="zip_code">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label"> {{ trans('messages.cr_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control" value="{{ $setting_data->cr_no ?? ''}}" name="cr_no" id="cr_no">
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
