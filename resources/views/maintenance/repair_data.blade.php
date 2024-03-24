@extends('layouts.header')

@section('main')
    @push('title')
        <title>{{ trans('messages.repair_data_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper" data-select2-id="select2-data-29-hx21" style="min-height: 343px;">
        <div class="content" data-select2-id="select2-data-28-127e">
        <div class="page-header">
        <div class="add-item d-flex">
        <div class="page-title">
        <h4>Quotation List</h4>
        <h6>Manage Your Quotation</h6>
        </div>
        </div>
        <ul class="table-top-head">
        <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Pdf" data-bs-original-title="Pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
        </li>
        <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Excel" data-bs-original-title="Excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
        </li>
        <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Print" data-bs-original-title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer feather-rotate-ccw"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></a>
        </li>
        <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg></a>
        </li>
        <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Collapse" data-bs-original-title="Collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></a>
        </li>
        </ul>
        <div class="page-btn">
        <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>Add New Quotation</a>
        </div>
        </div>

        <div class="card table-list-card">
        <div class="card-body">
        <div class="table-top" data-select2-id="select2-data-27-vwnz">
        <div class="search-set">
        <div class="search-input">
        <a href="" class="btn btn-searchset"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></a>
        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label> <input type="search" class="form-control form-control-sm" placeholder="Search" aria-controls="DataTables_Table_0"></label></div><div id="DataTables_Table_1_filter" class="dataTables_filter"><label> <input type="search" class="form-control form-control-sm" placeholder="Search" aria-controls="DataTables_Table_1"></label></div><div id="DataTables_Table_2_filter" class="dataTables_filter"><label> <input type="search" class="form-control form-control-sm" placeholder="Search" aria-controls="DataTables_Table_2"></label></div></div>
        </div>
        <div class="search-path">
        <div class="d-flex align-items-center">
        <a class="btn btn-filter" id="filter_search">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter filter-icon"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
        <span><img src="assets/img/icons/closes.svg" alt="img"></span>
        </a>
        </div>
        </div>
        <div class="form-sort" data-select2-id="select2-data-26-sf9j">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders info-img"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
        <select class="select select2-hidden-accessible" data-select2-id="select2-data-1-rqmf" tabindex="-1" aria-hidden="true">
        <option data-select2-id="select2-data-3-wesa">Sort by Date</option>
        <option data-select2-id="select2-data-33-axy8">25 9 23</option>
        <option data-select2-id="select2-data-34-nd7e">12 9 23</option>
        </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="select2-data-2-n0gb" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-c8fl-container" aria-controls="select2-c8fl-container"><span class="select2-selection__rendered" id="select2-c8fl-container" role="textbox" aria-readonly="true" title="Sort by Date">Sort by Date</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
        </div>
        </div>

        <div class="card" id="filter_inputs" style="display: none;">
        <div class="card-body pb-0">
        <div class="row">
        <div class="col-lg-2 col-sm-6 col-12">
        <div class="input-blocks">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box info-img"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        <select class="select select2-hidden-accessible" data-select2-id="select2-data-4-0f1d" tabindex="-1" aria-hidden="true">
        <option data-select2-id="select2-data-6-jzgk">Choose product</option>
        <option>Bold V3.2</option>
        <option>Apple Series 5 Watch</option>
        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-5-g9vf" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-nme7-container" aria-controls="select2-nme7-container"><span class="select2-selection__rendered" id="select2-nme7-container" role="textbox" aria-readonly="true" title="Choose product">Choose product</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
        </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
        <div class="input-blocks">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-stop-circle info-img"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="9" width="6" height="6"></rect></svg>
        <select class="select select2-hidden-accessible" data-select2-id="select2-data-7-lcmg" tabindex="-1" aria-hidden="true">
        <option data-select2-id="select2-data-9-6sl4">Choose Status</option>
        <option>Sent</option>
        <option>Ordered</option>
        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-8-bhtc" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-584l-container" aria-controls="select2-584l-container"><span class="select2-selection__rendered" id="select2-584l-container" role="textbox" aria-readonly="true" title="Choose Status">Choose Status</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
        </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
        <div class="input-blocks">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user info-img"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        <select class="select select2-hidden-accessible" data-select2-id="select2-data-10-0fz4" tabindex="-1" aria-hidden="true">
        <option data-select2-id="select2-data-12-7ab3">Choose Custmer</option>
        <option>walk-in-customer</option>
        <option>John Smith</option>
        </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-11-bj8f" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-nefe-container" aria-controls="select2-nefe-container"><span class="select2-selection__rendered" id="select2-nefe-container" role="textbox" aria-readonly="true" title="Choose Custmer">Choose Custmer</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
        </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-12">
        <div class="input-blocks">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text info-img"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        <div class="input-groupicon">
        <input type="text" class="form-control" placeholder="Enter Reference">
        </div>
        </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12">
        <div class="input-blocks">
        <a class="btn btn-filters ms-auto"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg> Search </a>
        </div>
        </div>
        </div>
        </div>
        </div>

        <div class="table-responsive">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer table-responsive"><table class="table datanew dataTable no-footer" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
        <thead>
        <tr><th class="no-sort sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="




        : activate to sort column descending" style="width: 78.0156px;">
        <label class="checkboxs">
        <input type="checkbox" id="select-all">
        <span class="checkmarks"></span>
        </label>
        </th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Product Name: activate to sort column ascending" style="width: 320.5px;">Product Name</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Reference: activate to sort column ascending" style="width: 130.75px;">Reference</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Custmer Name: activate to sort column ascending" style="width: 184.516px;">Custmer Name</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 127.297px;">Status</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Grand Total ($): activate to sort column ascending" style="width: 187.016px;">Grand Total ($)</th><th class="no-sort sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 190.906px;">Action</th></tr>
        </thead>
        <tbody>












        <tr class="odd">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/stock-img-01.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Lenovo 3rd Generation</a>
        </td>
        <td>PT001</td>
        <td>walk-in-customer</td>
        <td><span class="badges status-badge">Sent</span></td>
        <td>$550</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me-2 p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr><tr class="even">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/stock-img-06.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Bold V3.2</a>
        </td>
        <td>PT002</td>
        <td>walk-in-customer</td>
        <td><span class="badges status-badge">Sent</span></td>
        <td>$430</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me-2 p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr><tr class="odd">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/stock-img-02.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Nike Jordan</a>
        </td>
        <td>PT003</td>
        <td>walk-in-customer</td>
        <td><span class="badges order-badge">Ordered</span></td>
        <td>$260</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me-2 p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr><tr class="even">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/stock-img-03.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Apple Series 5 Watch</a>
        </td>
        <td>PT004</td>
        <td>John Smith</td>
        <td><span class="badges unstatus-badge">Pending</span></td>
        <td>$470</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me-2 p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr><tr class="odd">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/stock-img-04.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Amazon Echo Dot</a>
        </td>
        <td>PT005</td>
        <td>Harley Stanley</td>
        <td><span class="badges unstatus-badge">Pending</span></td>
        <td>$380</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me-2 p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr><tr class="even">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/stock-img-05.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Lobar Handy</a>
        </td>
        <td>PT006</td>
        <td>Egbert Caldwell</td>
        <td><span class="badges status-badge">Sent</span></td>
        <td>$190</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me-2 p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr><tr class="odd">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/expire-product-01.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Red Premium Handy</a>
        </td>
        <td>PT007</td>
        <td>walk-in-customer</td>
        <td><span class="badges unstatus-badge">Pending</span></td>
        <td>$540</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me-2 p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr><tr class="even">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/expire-product-02.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Iphone 14 Pro</a>
        </td>
        <td>PT008</td>
        <td>Benjamin</td>
        <td><span class="badges order-badge">Ordered</span></td>
        <td>$610</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me-2 p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr><tr class="odd">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/expire-product-03.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Black Slim 200</a>
        </td>
        <td>PT009</td>
        <td>walk-in-customer</td>
        <td><span class="badges unstatus-badge">Pending</span></td>
        <td>$220</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me- p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr><tr class="even">
        <td class="sorting_1">
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
        </td>
        <td class="productimgname">
        <div class="view-product me-2">
        <a href="javascript:void(0);">
        <img src="assets/img/products/expire-product-04.png" alt="product">
        </a>
        </div>
        <a href="javascript:void(0);">Woodcraft Sandal</a>
        </td>
        <td>PT010</td>
        <td>Nydia Fitzgerald</td>
        <td><span class="badges status-badge">Sent</span></td>
        <td>$460</td>
        <td class="action-table-data">
        <div class="edit-delete-action data-row">
        <a class="me-2 p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye action-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </a>
        <a class="me-2 p-2 mb-0" data-bs-toggle="modal" data-bs-target="#edit-units">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </a>
        <a class="me-2 confirm-text p-2 mb-0" href="javascript:void(0);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </a>
        </div>
        </td>
        </tr></tbody>
        </table><div class="dataTables_length" id="DataTables_Table_0_length"><label><select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select form-select-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select></label></div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous"><a aria-controls="DataTables_Table_0" aria-disabled="true" role="link" data-dt-idx="previous" tabindex="-1" class="page-link"><i class="fa fa-angle-left"></i> </a></li><li class="paginate_button page-item active"><a href="#" aria-controls="DataTables_Table_0" role="link" aria-current="page" data-dt-idx="0" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0" role="link" data-dt-idx="1" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item next" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" role="link" data-dt-idx="next" tabindex="0" class="page-link"> <i class=" fa fa-angle-right"></i></a></li></ul></div><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">1 - 10 of 12 items</div></div>
        </div>
        </div>
        </div>

        </div>
        </div>
        <div class="modal fade" id="edit-units">
            <div class="modal-dialog edit-sales-modal">
            <div class="modal-content">
            <div class="page-wrapper p-0 m-0">
            <div class="content p-0">
            <div class="page-header p-4 mb-0">
            <div class="add-item new-sale-items d-flex">
            <div class="page-title">
            <h4>Edit Quotation</h4>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            </div>
            <div class="card">
            <div class="card-body">
            <form action="quotationList.html">
            <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
            <div class="input-blocks">
            <label>Customer Name</label>
            <div class="row">
            <div class="col-lg-10 col-sm-10 col-10">
            <select class="select">
            <option>Thomas</option>
            <option>Rose</option>
            </select>
            </div>
            <div class="col-lg-2 col-sm-2 col-2 ps-0">
            <div class="add-icon">
            <span class="choose-add"><i data-feather="plus-circle" class="plus"></i></span>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
            <div class="input-blocks">
            <label>Date</label>
            <div class="input-groupicon calender-input">
            <i data-feather="calendar" class="info-img"></i>
            <input type="text" class="datetimepicker" placeholder="19 jan 2023">
            </div>
            </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
            <div class="input-blocks">
            <label>Reference Number</label>
            <input type="text" placeholder="010203">
            </div>
            </div>
            <div class="col-lg-12 col-sm-6 col-12">
            <div class="input-blocks">
            <label>Product Name</label>
            <div class="input-groupicon select-code">
            <input type="text" placeholder="Please type product code and select">
            <div class="addonset">
            <img src="assets/img/icons/scanners.svg" alt="img">
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="table-responsive no-pagination">
            <table class="table  datanew">
            <thead>
            <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Purchase Price($)</th>
            <th>Discount($)</th>
            <th>Tax(%)</th>
            <th>Tax Amount($)</th>
            <th>Unit Cost($)</th>
            <th>Total Cost(%)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>
            <div class="productimgname">
            <a href="javascript:void(0);" class="product-img stock-img">
            <img src="assets/img/products/stock-img-02.png" alt="product">
            </a>
            <a href="javascript:void(0);">Nike Jordan</a>
            </div>
            </td>
            <td>
            <div class="product-quantity">
            <span class="quantity-btn">+<i data-feather="plus-circle" class="plus-circle"></i></span>
            <input type="text" class="quntity-input" value="2">
            <span class="quantity-btn"><i data-feather="minus-circle" class="feather-search"></i></span>
            </div>
            </td>
            <td>2000</td>
            <td>500</td>
            <td>
            0.00
            </td>
            <td>0.00</td>
            <td>0.00</td>
            <td>1500</td>
            </tr>
            <tr>
            <td>
            <div class="productimgname">
            <a href="javascript:void(0);" class="product-img stock-img">
            <img src="assets/img/products/stock-img-03.png" alt="product">
            </a>
            <a href="javascript:void(0);">Apple Series 5 Watch</a>
            </div>
            </td>
            <td>
            <div class="product-quantity">
            <span class="quantity-btn">+<i data-feather="plus-circle" class="plus-circle"></i></span>
            <input type="text" class="quntity-input" value="2">
            <span class="quantity-btn"><i data-feather="minus-circle" class="feather-search"></i></span>
            </div>
            </td>
            <td>3000</td>
            <td>400</td>
            <td>
            0.00
            </td>
            <td>0.00</td>
            <td>0.00</td>
            <td>1700</td>
            </tr>
            <tr>
            <td>
            <div class="productimgname">
            <a href="javascript:void(0);" class="product-img stock-img">
            <img src="assets/img/products/stock-img-05.png" alt="product">
            </a>
            <a href="javascript:void(0);">Lobar Handy</a>
            </div>
            </td>
            <td>
            <div class="product-quantity">
            <span class="quantity-btn">+<i data-feather="plus-circle" class="plus-circle"></i></span>
            <input type="text" class="quntity-input" value="2">
            <span class="quantity-btn"><i data-feather="minus-circle" class="feather-search"></i></span>
            </div>
            </td>
            <td>2500</td>
            <td>500</td>
            <td>
            0.00
            </td>
            <td>0.00</td>
            <td>0.00</td>
            <td>2000</td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="row">
            <div class="col-lg-6 ms-auto">
            <div class="total-order w-100 max-widthauto m-auto mb-4">
            <ul>
            <li>
            <h4>Order Tax</h4>
            <h5>$ 0.00</h5>
            </li>
            <li>
            <h4>Discount</h4>
            <h5>$ 0.00</h5>
            </li>
            <li>
            <h4>Shipping</h4>
            <h5>$ 0.00</h5>
            </li>
            <li>
            <h4>Grand Total</h4>
            <h5>$5200.00</h5>
            </li>
            </ul>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
            <div class="input-blocks mb-3">
            <label>Order Tax</label>
            <div class="input-groupicon select-code">
            <input type="text" placeholder="0">
            </div>
            </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
            <div class="input-blocks mb-3">
            <label>Discount</label>
            <div class="input-groupicon select-code">
            <input type="text" placeholder="0">
            </div>
            </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
            <div class="input-blocks mb-3">
            <label>Shipping</label>
            <div class="input-groupicon select-code">
            <input type="text" placeholder="0">
            </div>
            </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
            <div class="input-blocks mb-3">
            <label>Status</label>
            <select class="select">
            <option>Sent</option>
            <option>Completed</option>
            <option>Inprogress</option>
            </select>
            </div>
            </div>
            <div class="col-lg-12">
            <div class="input-blocks summer-description-box">
            <label>Description</label>
            <div id="summernote5"></div>
            </div>
            </div>
            <div class="col-lg-12 text-end">
            <button type="button" class="btn btn-cancel add-cancel me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-submit add-sale">Submit</button>
            </div>
            </div>
            </form>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>

            <div class="customizer-links" id="setdata">
            <ul class="sticky-sidebar">
            <li class="sidebar-icons">
            <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Theme">
            <i data-feather="settings" class="feather-five"></i>
            </a>
            </li>
            </ul>
            </div>

    @include('layouts.footer')
@endsection
