
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>BILL</title>

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
    .outer_div{
        justify-content:center;
        height: 115px;
    width: 200px;
    text-align:center;
    }
    #brnd_name{
        margin:10px;
        background: black;
        color: white;
        font-family: monospace;

    }
</style>
  <style>@page { size: A3 }</style>
  <!-- Custom styles for this document -->
  <style>
        body {
/*          font-family: Tahoma;
*/          font-size: 14px;
        }

        th{border-bottom:1px solid black;}
        td{border-bottom:1px solid black;font-size:12px}
        table{width:100%;border-collapse:collapse;}
        .text-center{text-align:center;}
        .text-right{text-align:right;}
      </style>
  <style>
     @page { size: 80mm 100mm } /* output size */
     body.receipt .sheet { width: 80mm; height:auto;padding: 5mm; } /* sheet size */

     @media print { body.receipt { width: 80mm } } /* fix for Chrome */
   </style>

</head>

<body class="receipt">
  <section class="sheet">

     <p align="center"><img src="{{ asset('images/setting_images/' . $shop->invo_logo) }}" style="width:150px;height:50px; margin-right: 11px"></p>

     <p align="center"> Bill No.  الفاتورة {{ $item->reference_no }}</p>
         <p align="center">  {{ $shop->system_name }}</p>
         <p align="center">  {{ $invo->contact }} هاتف  </p>
         <p align="center">{{ $invo->address }} العنوان    </p>
         <p align="center">  {{ $invo->instagram }} </p>
                   <!-- <p align="center"> CR : cr_number  </p> -->

      <table>
        <tr>

             <th style="font-size: 13px;text-align: center;">الإجمالي|</th>
             <th style="font-size: 13px;text-align: center;">الخصم</th>
                 <th style="font-size: 13px;text-align: center;">الكمية|</th>
                 <th style="font-size: 13px;text-align: center;">السعر|</th>
              <th style="font-size: 13px;text-align: center;">المنتج</th>

<!--              <th style="font-size: 13px;text-align: center;">#</th>
 -->


        </tr>
        <tr>


             <th style="font-size: 13px;text-align: center;">Paid Amount</th>
             <th style="font-size: 13px;text-align: center;">Discount</th>
                            <th style="font-size: 13px;text-align: center;">Total Amount</th>

                 <th style="font-size: 13px;text-align: center;">Repairing Details</th>

              <th style="font-size: 13px;text-align: center;">Item</th>
<!--              <th style="font-size: 13px;text-align: center;">#</th>
 -->


        </tr>

        <tr>
            <td class="text-center">{{ number_format($item->grand_total, 3) }} </td>

                <td class="text-center">{{number_format( $item->total_discount ?? 0, 3) }} </td>


            <td class="text-center">{{ number_format($item->grand_total + $item->total_discount , 3) }} </td>

            @php


                if($item->status==1){
                $status= 'Recieved';
                }
                elseif ($item->status==4) {
                    $status= 'Ready'; }
                    else{
                        $status= 'Delievered';
                    }

                 if($item->repairing_type==1){

                    $repairing_type = 'Repair';


                 }
                 else{
                    $repairing_type = 'Inspection';
                 }


      @endphp
            <td class="text-center">{{ $repairing_type}} <br> {{ $status }}</td>
            <td class="text-center">{{ $item->product_name }}<br>
                {{ $item->product_model }}
            </td>
        </tr>



            <tr>
              <td >Payment Method</td>

              <td colspan="3" style="text-align:center"> {{$payment_method  }}</td>
              <td  style="font-weight: bold;"> <p style="margin-top:5px;">دفع بواسطة</td>
             </tr>
            <tr>
              <td >Sub Total</td>
              <td colspan="3" style="text-align:center">{{ number_format($item->grand_total + $item->total_discount , 3) }}</td>
              <td  style="font-weight: bold;"> <p style="margin-top:5px;"> التكلفة ر.ع</td>
             </tr>
             {{-- <tr>
              <td >Tax</td>
              <td colspan="3" style="text-align:center"></td>
              <td  style="font-weight: bold;"> <p style="margin-top:5px;">ضريبة</td>
             </tr> --}}
            <tr>
              <td >Discount</td>
              <td colspan="3" style="text-align:center">{{number_format( $item->total_discount ?? 0, 3) }}</td>
              <td  style=" margin-left:2px;font-weight: bold;flout:right;"> <p style="margin-top:5px;"> الخصم  ر.ع</td>
              </tr>
            <tr>
              <td >Bill Amount</td>
              <td colspan="3" style="text-align:center">{{ number_format($item->grand_total, 3) }}

              </td>

              <td  style="font-weight: bold;flout:right;" > <p style="margin-top:5px;">  الإجمالي ر.ع</td>
            </tr>
             <tr>
              <td >Paid</td>
              <td colspan="3" style="text-align:center">{{ number_format($paid_amount, 3) }}</td>
              <td   style="font-weight: bold;font-size:10px;flout:right;" > <p style="margin-top:3px;">المدفوع</td>
            </tr>
            {{-- <tr>
              <td >Balance</td>
              <td colspan="3" style="text-align:center"></td>
              <td   style="font-weight: bold;font-size:10px;flout:right;" > <p style="margin-top:3px;">المتبقي </td>
            </tr> --}}


     </table>


     <p align="center" style="font-size:12px;margin-right:0px !important;">الوقت والتاريخ: </p>
     <p align="center" style="font-size:12px;margin-right:0px !important;">بواسطة :  </p>


       <p style="margin-top: -13px;margin-left: 80px; font-size:12px; " Name :name </p>

       <p style="margin-top: -13px;margin-left: 80px; font-size:12px; " Contact : contact  </p>

       <p style="margin-top: -13px;margin-left: 80px; font-size:12px; " Address : notes </p>

       <p style="margin-top: -13px;margin-left: 80px; font-size:15px; " Notes : notes </p>
     <br>
        <p class="text-center" style="margin-top: -13px; font-size:15px; " footer  </p>
     <center><div id="barcode"></div></center>
  </section>
  <script src="{{  asset('js/jquery-3.6.0.min.js')}}"></script>
   <script src="{{  asset('js/jquery-barcode.js')}}"></script>


   <script type="text/javascript">
    $(document).ready(function(){
        // Barcode generation
        $("#barcode").barcode("{{ $item->reference_no }}", "code128");

        // Print and close window
        window.print();

        // Set timeout to close the window
        setTimeout(function() {
            window.close();
        }, 2000);
    });
    </script>

</body>

</html>
