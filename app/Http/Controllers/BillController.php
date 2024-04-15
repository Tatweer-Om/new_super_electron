<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillController extends Controller
{

    public function printBill($bill){




     $table =null;
     $this->db->where('order_no',$bill);
     $query= $this->db->get('tbl_pos_order_detail');

     $discount = 0;
     $this->db->where('order_no',$bill);
     $q = $this->db->get('tbl_pos_order');
     if($q->num_rows()==1)
     {
       $r = $q->row();
       // $discount = $r->discount_amount;
       $balance = $r->cash_back;
       $paid = $r->paid_amount;
       $payment_method = $r->payment_method;
       $time = $r->time;
       $cus_id = $r->customer_id;
       $notes = $r->notes;
       $total_tax = $r->total_tax;


     }
     if($query->num_rows()>0){
       $sno=0;
       $grand_total =0;
       $discount =0;
       foreach($query->result() as $rows)
       {
         $name='';
         $sno++;
   $grand_total +=($rows->item_price*$rows->item_quantity);
   $discount +=($rows->item_discount_price);

   $where = "barcode = $rows->item_barcode OR pkg_title = $rows->item_barcode";
   $this->db->where($where);
   $stock_data = $this->db->get('tbl_stock')->row_array();
   $this->db->where('barcode',$rows->item_barcode);
   $service_data = $this->db->get('tbl_service')->row_array();
   $this->db->where('offer_barcode',$rows->item_barcode);
   $offer_data = $this->db->get('tbl_special_offer')->row_array();
   if(!empty($stock_data))
   {
     if($stock_data['barcode']==$rows->item_barcode)
     {
       $name=$stock_data['title'].' (S)';
     }
     else
     {
       $name=$stock_data['title'].' (P)';
     }

   }
   else if(!empty($service_data))
   {
      $name=$service_data['name'];
   }
   else if(!empty($offer_data))
   {
      $name=$offer_data['offer_name'];
   }
   else
   {
     $name=$rows->item_barcode;
   }

    $table .=

             '<tr>
                 <td class="text-center"">'.number_format(($rows->item_total),3).'</td>
                 <td class="text-center">'.number_format($rows->item_quantity,0).'</td>
                 <td class="text-center">'.$rows->item_price.'</td>
                 <td class="text-center">'.$name.'</td>

             </tr> '

             ;
       }
       $method=null;
       if($payment_method==1)
       {
         $method='Visa card';
       }
       else  if($payment_method==2)
       {
         $method='Bank Transfer';
       }
       else  if($payment_method==3)
       {
         $method='Cash';
       }
       else  if($payment_method==4)
       {
         $method='Pay Later';
       }

       $table .='
             <tr>
             <td >Payment Method</td>
             <td colspan="2" style="text-align:center">'.$method.'</td>
             <td  style="font-weight: bold;"> <p style="margin-top:5px;">دفع بواسطة</td>
              </tr>
             <tr>
             <td >Sub Total</td>
             <td colspan="2" style="text-align:center">'.number_format($grand_total,3).'</td>
             <td  style="font-weight: bold;"> <p style="margin-top:5px;"> التكلفة ر.ع</td>
              </tr>
              <tr>
             <td >Tax (5%)</td>
             <td colspan="2" style="text-align:center">'.number_format($total_tax,3).'</td>
             <td  style="font-weight: bold;"> <p style="margin-top:5px;">(5%)ضريبة</td>
              </tr>
             <tr>
               <td >Discount</td>
               <td colspan="2" style="text-align:center">'.number_format($discount,3).'</td>
               <td  style=" margin-left:2px;font-weight: bold;flout:right;"> <p style="margin-top:5px;"> الخصم  ر.ع</td>
               </tr>
             <tr>
             <td >Bill Amount</td>
             <td colspan="2" style="text-align:center">'.number_format(($grand_total-$discount+$total_tax),3).'</td>
             <td  style="font-weight: bold;flout:right;" > <p style="margin-top:5px;">  الإجمالي ر.ع</td>
             </tr>
              <tr>
             <td >Paid</td>
             <td colspan="2" style="text-align:center">'.number_format($paid,3). '</td>
   <td   style="font-weight: bold;font-size:10px;flout:right;" > <p style="margin-top:3px;">المدفوع</td>
             </tr>
             <tr>
             <td >Balance</td>
             <td colspan="2" style="text-align:center">'.number_format($balance,3). '</td>
   <td   style="font-weight: bold;font-size:10px;flout:right;" > <p style="margin-top:3px;">المتبقي </td>
             </tr>
             '
             ;



       $data['table']=$table;
       $data['time']=$time;
       $data['bill']=$bill;
       $data['cus_id']=$cus_id;
       $data['notes']=$notes;
       $data['bill_number'] = str_replace('BILL-','',$bill);
       $this->load->view('admins/pages/bills',$data);
     }
     else{
       echo 'NONE';
     }




   }
}
