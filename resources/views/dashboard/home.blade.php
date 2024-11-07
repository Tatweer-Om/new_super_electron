
@extends('layouts.header')

@section('main')
@push('title')
<title> {{ trans('messages.home_page', [], session('locale')) }}</title>
@endpush

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
			<div class="page-wrapper">
				<div class="content">
					<div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dash-widget">
                                <div class="dash-widgetimg">
                                    <span><i class="fas fa-box" style="font-size: 24px;"></i></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5 style="font-size:0.8rem;"><span class="counters" data-count="{{ $total_Purchase_invoices ?? ''}}"></span></h5>
                                    <p style="font-size:0.7rem;">{{ trans('messages.total_purchases', [], session('locale')) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dash-widget dash1">
                                <div class="dash-widgetimg">
                                    <span><i class="fas fa-cogs" style="font-size: 24px;"></i></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5 style="font-size:0.8rem;"><span class="counters" data-count="{{ $total_products ?? ''}}"></span></h5>
                                    <p style="font-size:0.7rem;">{{ trans('messages.total_products', [], session('locale')) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dash-widget dash2">
                                <div class="dash-widgetimg">
                                    <span><i class="fas fa-tags" style="font-size: 24px;"></i></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5 style="font-size:0.8rem;"><span class="counters" data-count="{{ $total_brands }}"></span></h5>
                                    <p style="font-size:0.7rem;">{{ trans('messages.total_brands', [], session('locale')) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><i class="fas fa-th" style="font-size: 24px;"></i></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5 style="font-size:0.8rem;"><span class="counters" data-count="{{ $total_cat ?? '' }}"></span></h5>
                                    <p style="font-size:0.7rem;">{{ trans('messages.total_category', [], session('locale')) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <div class="dash-count">
                                <div class="dash-counts">
                                    <h4>{{ $total_customers ?? '' }}</h4>
                                    <h5>{{ trans('messages.customers', [], session('locale')) }}</h5>
                                </div>
                                <div class="dash-imgs">
                                    <i data-feather="user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <div class="dash-count das1">
                                <div class="dash-counts">
                                    <h4>{{ $total_supplier ?? '' }}</h4>
                                    <h5>{{ trans('messages.suppliers', [], session('locale')) }}</h5>
                                </div>
                                <div class="dash-imgs">
                                    <i data-feather="user-check"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <div class="dash-count das2">
                                <div class="dash-counts">
                                    <h4>{{ $total_Purchase_invoices ?? '' }}</h4>
                                    <h5>{{ trans('messages.purchase_invoices', [], session('locale')) }}</h5>
                                </div>
                                <div class="dash-imgs">
                                    <i data-feather="file-text"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <div class="dash-count das3">
                                <div class="dash-counts">
                                    <h4>{{ $total_sales_invoices ?? '' }}</h4>
                                    <p>{{ trans('messages.sales_invoices', [], session('locale')) }}</p>
                                </div>
                                <div class="dash-imgs">
                                    <i data-feather="file"></i>
                                </div>
                            </div>
                        </div>
                    </div>

					<!-- Button trigger modal -->

					<div class="row">
						<div class="col-lg-7 col-sm-12 col-12 d-flex">
							<div class="card flex-fill">
                                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">{{ trans('messages.income_expense', [], session('locale')) }}</h5>
                                    {{-- <pre>
                                        {{ print_r($finalMonthlyData) }}
                                    </pre> --}}
                                    <div class="graph-sets">
                                        <ul>
                                            <li>
                                                <span>{{ trans('messages.income', [], session('locale')) }}</span>
                                            </li>
                                            <li>
                                                <span>{{ trans('messages.expense', [], session('locale')) }}</span>
                                            </li>
                                        </ul>

                                        <div class="dropdown">
                                            <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                               {{ $year }} <i class="fas fa-calendar"></i>
                                            </button>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @foreach ($finalMonthlyData as $month => $data)
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            @php
                                                                $monthName = \Carbon\Carbon::createFromFormat('m', $month)->format('F');
                                                            @endphp
                                                            {{ $monthName }} - Income: {{ $data['final_profit'] }} - Expense: {{ $data['total_expense'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="sales_charts"></div>
                                </div>
                            </div>



						</div>
						<div class="col-lg-5 col-sm-12 col-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">{{ trans('messages.recently_added_products', [], session('locale')) }}</h4>

								</div>
								<div class="card-body">
									<div class="table-responsive dataview">
										<table class="table datatable ">
											<thead>

												<tr>
                                                    <th>{{ trans('messages.sno', [], session('locale')) }}</th>
                                                    <th>{{ trans('messages.products', [], session('locale')) }}</th>
                                                    <th>{{ trans('messages.sales_price', [], session('locale')) }}</th>

												</tr>
											</thead>
											<tbody>
                                                @foreach($recent_products as $index => $product)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td class="productimgname">
                                                        <a href="#" class="product-img">
                                                            <img src="{{ file_exists(public_path('imges/product_images/' . $product->stock_image)) ? asset('imges/product_images/' . $product->stock_image) : asset('images/dummy_image/no_image.png') }}" alt="product">
                                                        </a>

                                                        <p>{{ $product->product_name }}</p>
                                                    </td>
                                                    <td>{{ $product->sale_price }}</td>
                                                </tr>
                                            @endforeach


											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card mb-0">
						<div class="card-body">
							<h4 class="card-title">Recent Orders</h4>
							<div class="table-responsive dataview">
								<table class="table datatable ">
									<thead>
                                        <tr>
                                            <th>{{ trans('messages.sno') }}</th>
                                            <th>{{ trans('messages.order_no') }}</th>
                                            <th>{{ trans('messages.customer_name') }}</th>
                                            <th>{{ trans('messages.total_amount') }}</th>
                                            <th>{{ trans('messages.created_at') }}</th>
                                            <th>{{ trans('messages.created_by') }}</th>
                                        </tr>

									</thead>
									<tbody>

                                        @foreach ($orders as $index => $order)

                                        @php
                                            $customer_name= DB::table('customers')->where('id', $order->customer_id)->value('customer_name');
                                            $user_name= DB::table('users')->where('id', $order->user_id)->value('authuser_name');
                                        @endphp
                                        <tr>
											<td>{{ $index + 1 }}</td>
											<td><a href="javascript:void(0);">{{ $order->order_no ?? '' }}</a></td>
											<td >

												{{ $customer_name ?? '' }}
											</td>
											<td>{{ $order->total_amount }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y (h:i a)') }}</td>
											<td>{{ $user_name ?? '' }}</td>
										</tr>
                                        @endforeach


									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- /Main Wrapper -->
        <script id="incomeData" type="application/json">
            {{ json_encode(array_values(array_column($finalMonthlyData, 'final_profit'))) }}
        </script>
        <script id="expenseData" type="application/json">
            {{ json_encode(array_values(array_column($finalMonthlyData, 'total_expense'))) }}
        </script>

        @include('layouts.footer')
        @endsection
