<?php
$locale = session('locale');
if ($locale == 'ar') {
    $dir = "dir='rtl'";
} else {
    $dir = "dir='ltr'";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $repairing->repairing_type == 2 ? 'Inspection Agreement' : 'Repairing Agreement' }}</title>

        <link rel="icon" type="image/png" sizes="16x16" href="">

        <style>
            @font-face {
                font-family: tahoma;
                /*src: url(../../assets/dist/fonts/Tajawal-Light.ttf);*/
            }

            body {
                font-family: tahoma;
            }

            #barcode {
                font-size: 20px;
                height: 80px;
                margin-left: -20px;
            }

            .outer_div {
                justify-content: center;
                height: 115px;
                width: 200px;
                text-align: center;
            }

            #brnd_name {
                margin: 10px;
                background: black;
                color: white;
                font-family: monospace;

            }
        </style>
        <style>
            @page {
                size: A3
            }
        </style>
        <!-- Custom styles for this document -->
        <style>
            body {
                /*          font-family: Tahoma;
*/
                font-size: 14px;
            }

            th {
                border-bottom: 1px solid black;
            }

            td {
                border-bottom: 1px solid black;
                font-size: 12px
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }
        </style>
        <style>
            @page {
                size: 80mm 100mm
            }

            /* output size */
            body.receipt .sheet {
                width: 80mm;
                height: auto;
                padding: 5mm;
            }

            /* sheet size */

            @media print {
                body.receipt {
                    width: 80mm
                }
            }

            /* fix for Chrome */
        </style>

</head>

<body class="receipt">
    <section class="sheet">

        <p align="center"><img src="{{ asset('images/setting_images/' . $shop->invo_logo) }}"
                style="width:150px;height:50px; margin-right: 11px"></p>
        <h3 align="center">{{ $repairing->repairing_type == 2 ? 'Inspection Agreement' : 'Repairing Agreement' }}</h3>
        <p align="center"> رقم المرجع. {{ $repairing->reference_no ?? 'N/A' }} </p>

        <p align="center"> {{ $shop->system_name }}</p>
        <p align="center"> {{ $invo->contact }} هاتف </p>
        <p align="center">{{ $invo->address }} العنوان </p>
        <p align="center"> {{ $invo->instagram }} </p>


        <table>
            <tr>

                <th colspan="4" style="font-size: 13px;text-align: center;">الرقم المدني </th>
                <th colspan="4" style="font-size: 13px;text-align: center;">الهاتف</th>
                <th colspan="4" style="font-size: 13px;text-align: center;">الزبون</th>

            </tr>
            <tr>

                <th colspan="4" style="font-size: 10px;text-align: center;"> Customer ID</th>
                <th colspan="4" style="font-size: 10px;text-align: center;">Contact</th>
                <th colspan="4" style="font-size: 10px;text-align: center;">Customer</th>

            </tr>

            <tr>

                <td colspan="4" class="text-center">{{ $customer->customer_number ?? 'N/A' }} </td>
                <td colspan="4" class="text-center">{{ $customer->customer_phone ?? 'N/A' }} </td>
                <td colspan="4" class="text-center">{{ $customer->customer_name ?? 'N/A' }}<br>

                </td>
            </tr>

            <tr>
                <td colspan="3">Product</td>
                <td colspan="4" style="text-align:center">{{ $product->product_name ?? 'N/A' }}</td>
                <td colspan="4" style="font-weight: bold;">
                    <p style="margin-top:5px;     text-align: right;"> المنتج
                </td>
            </tr>
            <tr>
                <td colspan="3">Product Price</td>
                <td colspan="4" style="text-align:center">{{ $warranty->purchase_price ?? 'N/A' }} </td>
                <td colspan="4" style="font-weight: bold;     text-align: right;">
                    <p style="margin-top:5px; "> سعر الشراء ر.ع
                </td>
            </tr>
            <tr>
                <td colspan="3">Barcode/Imei</td>
                <td colspan="4" style="text-align:center ">
                    {{ $warranty->item_imei ? $warranty->item_imei : $warranty->item_barcode ?? 'N/A' }}</td>
                <td colspan="4" style="font-weight: bold;     text-align: right;">
                    <p style="margin-top:5px;">رمز المنتج /<br /> رقم التسلسل
                </td>
            </tr>
            <tr>
                <td colspan="3">Warranty</td>
                <td colspan="4" style="text-align:center">{{ $warranty->warranty_type == 1 ? 'shop' : 'agent' }}<br>
                    {{ $warranty->warranty_days ?? 'N/A' }} يوم <br>
                    صالح لغاية: {{ $warranty->created_at->addDays($warranty->warranty_days)->format('Y-m-d') }}</td>
                <td colspan="6" style="  margin-left:2px;font-weight: bold;     text-align: right;">
                    <p style="margin-top:5px;"> مدة الضمان
                </td>
            </tr>
            <tr>
                <td colspan="3">Recieving Date</td>
                <td colspan="4" style="text-align:center">
                    {{ $repairing->receive_date }}

                </td>

                <td colspan="4" style="font-weight: bold;     text-align: right;">
                    <p style="margin-top:5px;">تاريخ الاستلام
                </td>
            </tr>

    <tr>
        <td colspan="3">Status</td>
        <td colspan="4" class="text-center">
            @switch($repairing->status)
                @case(1)
                    Item Received
                    @break
                @case(2)
                    Sent To Agent
                    @break
                @case(3)
                    Received From Agent
                    @break
                @case(4)
                    Item Repaired (Ready)
                    @break
                @case(5)
                    Item Delivered
                    @break
                @case(6)
                    inspection and repairing
                    @break
                @default
                    none
            @endswitch
        </td>
        <td colspan="4" style="font-weight: bold;     text-align: right;">
            <p style="margin-top:5px;"> الحالة
        </td>
    </tr>


@if ($warranty->warranty_type == 1)
    <tr>
        <td colspan="3">Maintenance Type</td>
        <td colspan="4" class="text-center">
            @switch($repairing->repairing_type)
                @case(1)
                    Inspection and Repairing
                    @break
                @case(2)
                    Product Replacement Approved
                    @break
            @endswitch
        </td>
        <td colspan="4" style="font-weight: bold;     text-align: right;">
            <p style="margin-top:5px;"> الحالة
        </td>
    </tr>
@endif


        </table>

        <h5 style="font-weight: bold;     text-align: right;">"الشروط والأحكام" </h5>
        <ul>
            <li>{{ $condition->inspection_detail }}</li>
        </ul>

        <center>
            <div id="barcode"></div>
        </center>
    </section>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery-barcode.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {

            $("#barcode").barcode("{{ $repairing->reference_no }}", "code128");

            // Print the window
            window.print();

            // Close the window after 2 seconds
            setTimeout(function() {
                window.close();
            }, 2000);
        });
    </script>


</body>

</html>
