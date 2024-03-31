@extends('layouts.header')

@section('main')
    @push('title')
        <title>{{ trans('message.tax_setting_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content settings-content">
            <div class="page-header settings-pg-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Tax Matters</h4>
                        <h6>Add tax for all products</h6>
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
                                                    <a href="javascript:void(0);"><i
                                                            data-feather="settings"></i><span>General Settings</span><span
                                                            class="menu-arrow"></span></a>

                                                    <ul>
                                                        <li><a href="{{ url('setting') }}">Company Profile</a></li>
                                                        <li><a href="{{ url('pos_qout_setting') }}">POS Invoice</a></li>
                                                    </ul>
                                                </li>
                                                <li class="submenu">
                                                    <a href="javascript:void(0);"><i
                                                            data-feather="airplay"></i><span>Proposal and
                                                            Quotation</span><span class="menu-arrow"></span></a>
                                                    <ul>
                                                        <li><a href="{{ url('proposal_setting') }}">Terms of Refernce</a>
                                                        </li>
                                                        <li><a href="{{ url('qout_setting') }}">Quotation Detail</a></li>

                                                    </ul>
                                                </li>
                                                <li class="submenu">
                                                    <a href="javascript:void(0);"><i
                                                            data-feather="archive"></i><span>Maintenance Agreement
                                                        </span><span class="menu-arrow"></span></a>
                                                    <ul>
                                                        <li><a href="{{ url('inspection_setting') }}">Inspection
                                                                Agreement</a></li>
                                                        <li><a href="{{ url('maint_setting') }}">Repairing Agreement </a>
                                                        </li>

                                                    </ul>
                                                </li>
                                                <li class="submenu">
                                                    <a href="javascript:void(0);" class="active subdrop"><i
                                                            data-feather="server"></i><span>Stock
                                                            Settings</span><span class="menu-arrow"></span></a>
                                                    <ul>
                                                        <li><a href="{{ url('tax_setting') }}" class="active">Tax
                                                                Matters</a></li>
                                                    </ul>
                                                    <ul>
                                                        <li><a href="{{ url('points') }}" >Points
                                                                System</a></li>
                                                    </ul>
                                                </li>

                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="settings-page-wrap">
                            <div class="setting-title">
                                <h4>Tax Settings</h4>
                            </div>
                        <form action="" id="taxsetting" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6 d-flex">
                                    <div class="connected-app-card d-flex w-100">
                                        <ul class="w-100">
                                            <li class="flex-column align-items-start">
                                                <div class="d-flex align-items-center justify-content-between w-100">
                                                    <div class="security-type d-flex align-items-center">
                                                        <div class="tax-title">
                                                            <h5>Tax For All</h5>
                                                        </div>
                                                    </div>
                                                    <div class="status-toggle modal-status d-flex justify-content-between align-items-center ms-2">
                                                        <input type="checkbox" {{ $tax->tax_type == 'percentage' ? 'checked' : '' }} id="taxToggle" class="check" onchange="toggleTaxInput()" name="check">

                                                        <label for="taxToggle" class="checktoggle"> </label>
                                                    </div>
                                                </div>
                                                <p>This Tax will be applied to all products</p>
                                            </li>
                                            <li>
                                                <div class="col-lg-8 col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" id="taxInputLabel">Percentage Tax</label>
                                                        <input type="text" class="form-control" value="{{ $tax->tax ?? '' }}" id="taxInput" placeholder="Enter tax percentage" name="tax">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-end settings-bottom-btn">
                                    <button type="button" class="btn btn-cancel me-2">Cancel</button>
                                    <button type="submit" class="btn btn-submit">Save Changes</button>
                                </div>

                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('layouts.footer')
@endsection
