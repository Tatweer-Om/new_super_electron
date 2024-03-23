@extends('layouts.header')

@section('main')
    @push('title')
        <title>{{ trans('messages.technicians_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="welcome d-lg-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center welcome-text">
                    <h3 class="d-flex align-items-center"><img src="assets/img/icons/hi.svg" alt="img">&nbsp;Hi John
                        Smilga,</h3>&nbsp;<h6>here's what's happening with your store today.</h6>
                </div>
                <div class="d-flex align-items-center">
                    <div class="position-relative daterange-wraper me-2">
                        <div class="input-groupicon calender-input">
                            <input type="text" class="form-control  date-range bookingrange" placeholder="Select"
                                value="13 Aug 1992">
                        </div>
                        <i data-feather="calendar" class="feather-14"></i>
                    </div>
                    <button type="button" data-toggle="tooltip" class="btn btn-white-outline d-none d-md-inline-block"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                            class="feather-16"></i></button>
                    <a href="#" class="d-none d-lg-inline-block" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Collapse" id="collapse-header"><i data-feather="chevron-up" class="feather-16"></i></a>
                </div>
            </div>
            <div class="row sales-cards">
                <div class="col-xl-6 col-sm-12 col-12">
                    <div class="card d-flex align-items-center justify-content-between default-cover mb-4">
                        <div>
                            <h6>Weekly Earning</h6>
                            <h3>$<span class="counters" data-count="95000.45">95000.45</span></h3>
                            <p class="sales-range"><span class="text-success"><i data-feather="chevron-up"
                                        class="feather-16"></i>48%&nbsp;</span>increase compare to last week</p>
                        </div>
                        <img src="assets/img/icons/weekly-earning.svg" alt="img">
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card color-info bg-primary mb-4">
                        <img src="assets/img/icons/total-sales.svg" alt="img">
                        <h3 class="counters" data-count="10000.00">10,000+</h3>
                        <p>No of Total Sales</p>
                        <i data-feather="rotate-ccw" class="feather-16" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Refresh"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card color-info bg-secondary mb-4">
                        <img src="assets/img/icons/purchased-earnings.svg" alt="img">
                        <h3 class="counters" data-count="800.00">800+</h3>
                        <p>No of Total Sales</p>
                        <i data-feather="rotate-ccw" class="feather-16" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Refresh"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-4 d-flex">
                    <div class="card flex-fill default-cover w-100 mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Best Seller</h4>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="view-all d-flex align-items-center">
                                    View All<span class="ps-2 d-flex align-items-center"><i data-feather="arrow-right"
                                            class="feather-16"></i></span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless best-seller">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/stock-img-01.png" alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Lenovo 3rd Generation</a>
                                                        <p class="dull-text">$4420</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="head-text">Sales</p>
                                                6547
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/stock-img-06.png" alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Bold V3.2</a>
                                                        <p class="dull-text">$1474</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="head-text">Sales</p>
                                                3474
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/stock-img-02.png" alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Nike Jordan</a>
                                                        <p class="dull-text">$8784</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="head-text">Sales</p>
                                                1478
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/stock-img-03.png" alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Apple Series 5 Watch</a>
                                                        <p class="dull-text">$3240</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="head-text">Sales</p>
                                                987
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/stock-img-04.png" alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Amazon Echo Dot</a>
                                                        <p class="dull-text">$597</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="head-text">Sales</p>
                                                784
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xl-8 d-flex">
                    <div class="card flex-fill default-cover w-100 mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Recent Transactions</h4>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="view-all d-flex align-items-center">
                                    View All<span class="ps-2 d-flex align-items-center"><i data-feather="arrow-right"
                                            class="feather-16"></i></span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless recent-transactions">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Details</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/stock-img-05.png" alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Lobar Handy</a>
                                                        <span class="dull-text d-flex align-items-center"><i
                                                                data-feather="clock" class="feather-14"></i>15 Mins</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="d-block head-text">Paypal</span>
                                                <span class="text-blue">#416645453773</span>
                                            </td>
                                            <td><span class="badge background-less border-success">Success</span></td>
                                            <td>$1,099.00</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/expire-product-01.png"
                                                            alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Red Premium Handy</a>
                                                        <span class="dull-text d-flex align-items-center"><i
                                                                data-feather="clock" class="feather-14"></i>10 Mins</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="d-block head-text">Apple Pay</span>
                                                <span class="text-blue">#147784454554</span>
                                            </td>
                                            <td><span class="badge background-less border-danger">Canceled</span></td>
                                            <td>$600.55</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/expire-product-02.png"
                                                            alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Iphone 14 Pro</a>
                                                        <span class="dull-text d-flex align-items-center"><i
                                                                data-feather="clock" class="feather-14"></i>10 Mins</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="d-block head-text">Stripe</span>
                                                <span class="text-blue">#147784454554</span>
                                            </td>
                                            <td><span class="badge background-less border-primary">Pending</span></td>
                                            <td>$1,099.00</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/expire-product-03.png"
                                                            alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Black Slim 200</a>
                                                        <span class="dull-text d-flex align-items-center"><i
                                                                data-feather="clock" class="feather-14"></i>10 Mins</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="d-block head-text">PayU</span>
                                                <span class="text-blue">#147784454554</span>
                                            </td>
                                            <td><span class="badge background-less border-success">Success</span></td>
                                            <td>$1,569.00</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>
                                                <div class="product-info">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="assets/img/products/expire-product-04.png"
                                                            alt="product">
                                                    </a>
                                                    <div class="info">
                                                        <a href="product-list.html">Woodcraft Sandal</a>
                                                        <span class="dull-text d-flex align-items-center"><i
                                                                data-feather="clock" class="feather-14"></i>15 Mins</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="d-block head-text">Paytm</span>
                                                <span class="text-blue">#147784454554</span>
                                            </td>
                                            <td><span class="badge background-less border-success">Success</span></td>
                                            <td>$1,478.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @include('layouts.footer')
        @endsection
