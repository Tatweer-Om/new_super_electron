<!DOCTYPE html>
<?php
$locale = session('locale');
if ($locale == 'ar') {
    $dir = "dir='rtl'";
} else {
    $dir = "dir='ltr'";
}
?>
<html lang="en" <?php echo $dir; ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Barcode</title>
 
</head>

<body>
    
    <div style="text-align: center; backgound: #000000; margin-top: 0 px; margin-bottom: 0 px; height:10px;font-weight: bold;font-size:10px;">Super Electronics</div>
       <div style="text-align:center; backgound:#000000" >
        <svg class="barcode"
         jsbarcode-margin="0"
         jsbarcode-margintop="5"
         jsbarcode-marginright="15"
         jsbarcode-marginleft="1"
         jsbarcode-height="25"
         jsbarcode-width="1"
         jsbarcode-fontsize="12"
         jsbarcode-textalign="Center"
         jsbarcode-value="<?php echo $barcode; ?>"/>
      </div>
    <div style="margin-right:5px; border: #000 solid 0px; height:14px;font-size:10px;overflow:hidden; text-align: center; backgound: #000000; margin-top: 0 px; margin-bottom: 0px;font-weight: bold" ><?php echo $title ?></div>
        {{-- <div style="text-align: center; backgound: #000000;font-size:10px; margin-top: 0 px; margin-bottom: 0 px;height:15px;font-weight: bold">OMR <?php echo number_format((float)$price,3) ?></div> --}}
    
    
    </body>
    
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
     <!-- Barcode JS -->
    <script src="{{ asset('js/JsBarcode.all.min.js') }}"></script>
    <script type="text/javascript">
        
        window.print();
        {{-- window.onafterprint = window.close; --}}
        // window.close();
        JsBarcode(".barcode").init();
    </script>
</html>
