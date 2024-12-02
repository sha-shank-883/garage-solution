<!DOCTYPE html>
<html>
  <head>
    <title>Payment History</title>
    <style>
     body {
      color: green;
    }
    </style>
  </head>
  <body>
      <div style="width:100%;height:57px;">
        <table  width="100%" rules="cols" border="1">
          <tr>
            <td width="100%" align="center" >
              <div>
                <b>Sai Auto Care</b><br>
               <b> Badagad, Near Sai Mandir, 2375 / 7922 Puri Bypass Road,</b><br><B>Badagada Rd, Bhubaneswar, Odisha 751019</B>
              </div>
            </td>
              <div>
              </div>
            </td>
          </tr>      
        </table>
      </div>
      <div style="width:100%;height:60px;font-size: 21px;  text-align: center" >
        <br>
              <b></b><br><br>
      </div>
      <div>
        <table style="width:100%;height:57px;"   >
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>              
          </tr>
          <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="5" align="left">
              <table  width="100%">
                <tr>
                  <td width="50%">Customer Name :  {{$AdminSaleView['0']['customer_name'] }}
                 </td>
                  <td width="50%" align="left"></td>
                </tr>
                <tr>
                  <td width="50%">Address: {{$AdminSaleView['0']['customer_address'] }}</td>
                  <td width="50%" align="left">
                  </td>
                </tr>
                <tr>
                  <td width="30%">Customer No:{{$AdminSaleView['0']['customer_contact_number'] }}
                  </td>
                  <td width="70%" align="left"></td>
                </tr>
              </table>
            </td>          
            <td colspan="5" align="right">
              <table  width="100%">
                 <tr>
                  <td width="50%">Job ID :{{$AdminSaleView['0']['job_id'] }}</td>
                  <td width="50%" align="left">
                 
                  </td>
                </tr>
                 <tr>
                  <td width="30%">Email:{{$AdminSaleView['0']['customer_email'] }}</td>
                  <td width="70%" align="left"></td>
                </tr>  
              </table>
            </td>
            <td colspan="1">&nbsp;</td>        
          </tr>  
        </table>
        <table  border="1" rules="cols"  width="100%">
              <thead  style="text-align:center; border-style: solid;">
                <tr>
                  
                  <th style="white-space: nowrap">Job ID</th>
                  <th style="white-space: nowrap">Payment Date</th>
                  <th style="white-space: nowrap">Payment Amount</th>
                </tr>
              </thead>
              <tbody style="text-align:center;border-style: solid;">
                 @php $p=0; @endphp
                 @foreach($AdminSaleView as $key => $value)
                <tr style="border:1px solid black;">
                @php $p++; @endphp
                  <td>{{ $value['job_id'] }}</td>
                  <td>{{ $value['created_at'] }}</td>
                  <td>{{ $value['payment_amount'] }}</td>
                </tr>  

                @endforeach

              </tbody>
          <tfoot>
          
           
          </tfoot>
        </table>
      </div>
      <!--   <div style="text-align: right" width="100%">
      Signature:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
      </div> -->
  </body>
</html>