{{-- /*
 *  File Name              :
 *  Type                   :   
 *  Description            :   
 *  Author                 : Ashtosh Kumar Choubey
 *  Contact                : 9658476170
 *  Email                  : contact@worldgyan.com
 *  Date                   : 12/12/2018  
 *  Modified By            :       
 *  Date of Modification   :     
 *  Purpose of Modification: 
 * 
 */ --}}
@extends('samples') 
@section('content')
<section class="content" style="margin-left: 20px;margin-right: 20px;">
   {{ isset($id)?Form::open(['url' => 'AutoCare/purchase/update','files' => 'true' ,'enctype' => 'multipart/form-data', 'autocomplete' => 'OFF']) : Form::open(['url' => 'AutoCare/purchase/add','files' => 'true' ,'enctype' => 'multipart/form-data', 'autocomplete' => 'OFF']) }} 
   {{ csrf_field() }}
   {{ Form::hidden('id', isset($id) ? $id :'', []) }} 
  <div class="card">
    <div class="card-header">
      <h4 class="box-title text-primary ">Please Fill Up Purchase Details</h4><a href=""></a>
    </div>
    <div class="card-body">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12 col-sm-12">
        <!-- general form elements -->
          <div class="box box-primary">

            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              @if ($errors->any())
              <ul class="alert alert-danger" style="list-style:none">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
              </ul>
              @endif
              @if(session()->has('message.level'))
              <div class="alert alert-{{ session('message.level') }} alert-dismissible" onload="javascript: Notify('You`ve got mail.', 'top-right', '5000', 'info', 'fa-envelope', true); return false;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-check"></i> {{ ucfirst(session('message.level')) }}!</h4>
              {!! session('message.content') !!}
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
          <label class="form-col-form-label" for="supplier_name">Supplier Name</label>
          {{Form::select('supplier_name',$supplier ,isset($supplier_name)?$supplier_name: '', ['class' => 'form-control form-control ','id'=>'supplier_name','required', 'placeholder' => '  Supplier Name'] )}}
            <div class="invalid-feedback">
            {{ $errors->has('supplier_name') ? $errors->first('name', ':message') : '' }}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-grou">
          <label class="form-col-form-label" for="bill_num">Bill Number</label>
          {{Form::number('bill_num',isset($bill_num)?$bill_num: '', ['class' => 'form-control form-control ', 'placeholder' => 'Bill Number'] )}}
          <div class="invalid-feedback">
          {{ $errors->has('bill_num') ? $errors->first('bill_num', ':message') : '' }}
          </div>
          </div>
        </div> 
         <div class="col-md-4">
          <div class="form-grou">
          <label class="form-col-form-label" for="bill_date">Bill Date</label>
          {{Form::date('bill_date',isset($bill_date)?$bill_date: '', ['class' => 'form-control form-control ', 'placeholder' => 'Bill Date'] )}}
          <div class="invalid-feedback">
          {{ $errors->has('bill_date') ? $errors->first('bill_date', ':message') : '' }}
          </div>
          </div>
        </div> 
       
      </div> 
      <hr/>
      <div class="row">   
        <div class="col-sm-12">  
          <div class="card">
            <div class="card-header">
            <h5 >
            Please fill up the Purchase details
            </h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="addmoretable" class="table table-bordered">
                  <thead>
                    <tr>
                     <th style="white-space: nowrap" >Spare Name</th>
                     <th style="white-space: nowrap" >Brand Name</th>
                     <th style="white-space: nowrap" >Model Name</th>
                     <th style="white-space: nowrap" >Part Number</th>
                     <th style="white-space: nowrap" >Discription &emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;</th>
                     <th style="white-space: nowrap" >HSN&emsp;</th>
                     <th style="white-space: nowrap" >Unit Price</th>
                     <th style="white-space: nowrap" >Unit Price Exit</th>
                     <th style="white-space: nowrap" >Qty &emsp;&emsp;</th>
                     <th style="white-space: nowrap" >GST &emsp;&emsp;</th>
                     <!-- <th style="white-space: nowrap" >Discount</th> -->
                     <th style="white-space: nowrap" >TAmount</th>
                       @php
                        if(!isset($id))
                        {
                          echo "<th>";
                          echo 'Action';
                          echo "</th>";
                        }
                      
                      @endphp                     
                    </tr>
                  </thead>
                  <tbody id="tBody">
                    <tr id="addRow">
                      <td  class="product_name">{{Form::select('product_id[]',$product, isset($product_id)?$product_id: '', ['class' => 'form-control ','required'=>'true','placeholder'=>'Select' ,'id' => 'product_id'])}}
                      </td>
                      <td  class="company_name">{{Form::select('company_name[]', $brand_select,isset($company_name)?$company_name: '', ['class' => 'form-control ', 'id' => 'Brand Name'])}}
                      </td>
                       <td class="model_number">{{Form::select('model_number[]',$model_select, isset($model_number)?$model_number: '', ['class' => 'form-control ', 'id' => 'model_number'])}}
                      </td>
                      <td class="part_number">{{Form::text('part_number[]', isset($part_number)?$part_number: '', ['class' => 'form-control ', 'id' => 'part_number'])}}
                      </td>
                       <td class="discription">{{Form::textarea('discription[]', isset($discription)?$discription: '', ['class' => 'form-control ', 'id' => 'discription',"style"=>"height: 40px;"])}}
                      </td>                      
                      <td class="hsn">{{Form::text('hsn[]', isset($hsn)?$hsn: '', ['class' => 'form-control ', 'id' => 'hsn'])}}
                      </td>
                      <td class="unit_price">{{Form::text('unit_price[]', isset($unit_price)?$unit_price: '', ['class' => 'form-control ','min-width'=>'30px' ,'id' => 'unit_price'])}}
                      </td>
                       <td class="unit_price_exit">{{Form::text('unit_price_exit[]', isset($unit_price_exit)?$unit_price_exit: '', ['class' => 'form-control ', 'id' => 'unit_price_exit'])}}
                      </td>
                      <td class="quantity">{{Form::text('quantity[]', isset($quantity)?$quantity: '', ['class' => 'form-control qtn', 'id' => 'quantity',isset($id)?'readonly':''])}}
                      </td>
                      <td class="gst">{{Form::text('gst[]', isset($gst)?$gst: '', ['class' => 'form-control ', 'id' => 'gst'])}}
                      </td>
                      <!-- <td class="discount">{{Form::text('discount[]', isset($product_id)?$product_id: '', ['class' => 'form-control ', 'id' => 'discount'])}}
                      </td> -->
                      <td class="total_amount">{{Form::text('total_amount[]', isset($total_amount)?$total_amount: '', ['class' => 'form-control ', 'id' => 'total_amount','readonly'])}}
                      </td>
                      
                        @php
                        if(!isset($id))
                        {
                          echo "<td>";
                          echo '<a href="javascript:void(0)"  class="addMore btn btn-primary btn-sm"><i class="fa fa-plus "></i></a>';
                          echo "</td>";
                        }
                      
                      @endphp
                     
                    </tr>
                  </tbody>
                  <tfoot class="small font-italic text-info text-capitalize">
                    <tr>
                      <td colspan="12">Supplier Name and Product Name Is compalsary <br>
                   
                      After insering the quantity Total Price will be automatically calculated if you click outsite the text field<br/>For Example if unit price is 10,quanity = 2 and gst = 10 % then total price will be (unitprice + gst)*quanity means (10+1)*2=22<br>
                     <span class="text-danger"> you can change default value but make sure calculation is right otherwise it may affect your application.</span>
                      </td>
                    </tr>
                    
                  </tfoot>
                </table>
               </div> 
            </div>
            <div class="card-footer">
              <div class="text-center">
                <input type="submit"  class="btn btn-primary" value="{{ isset($id)?'update':'Add' }}">
              </div>               
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
</div>

  <!--/.col (left) -->
  
{{Form::close()}}
      <!-- /.row -->
</section>

<script type = "text/javascript" language = "javascript">
//  alert("hii");
    $(document).ready(function() {
      
      var i=0;
      $('.addMore').on("click",function(){
        i=parseInt(i)+1;
         $("#tBody").append('<tr id="AddRow'+i+'">\
                    <td class="product_name">{{Form::select("product_id[]", $product,"" ,["class" => "form-control ","placeholder"=>"Select" ,"required"=>"true", "id" => "product_id"])}}\
                    </td>\
                    <td class="company_name">{{Form::select("company_name[]", $brand_select,"", ["class" => "form-control ", "id" => "company_name"])}}\
                    </td>\
                    <td class="model_number">{{Form::select("model_number[]",$model_select,"" ,["class" => "form-control ", "id" => "model_number",])}}\
                    </td>\
                    <td class="part_number">{{Form::text("part_number[]", "", ["class" => "form-control ", "id" => "part_number"])}}\
                    </td>\
                    <td class="discription">{{Form::textarea("discription[]", "", ["class" => "form-control ", "id" => "discription","style"=>"height: 40px;"])}}\
                    </td>\
                    <td class="hsn">{{Form::text("hsn[]", "", ["class" => "form-control ", "id" => "hsn",])}}\
                    </td>\
                    <td class="unit_price">{{Form::text("unit_price[]", "", ["class" => "form-control ", "id" => "unit_price",])}}\
                    </td>\
                     <td class="unit_price_exit">{{Form::text("unit_price_exit[]", "", ["class" => "form-control ", "id" => "unit_price_exit",])}}\
                    </td>\
                    <td class="quantity">{{Form::text("quantity[]", "", ["class" => "form-control qtn", "id" => "quantity",])}}\
                    </td>\
                    <td class="gst">{{Form::text("gst[]", "", ["class" => "form-control ", "id" => "gst",])}}\
                    </td>\
                    <td class="total_amount">{{Form::text("total_amount[]", "", ["class" => "form-control ", "id" => "total_amount","readonly"])}}\
                    </td>\
                    <td>\
                    <a href="javascript:void(0)" id="'+i+'"  class="removeRow btn btn-danger btn-sm"><i class="fa fa-minus "></i></a>\
                    </td>\
                  </tr>');
      });
       $(document).on('click', '.removeRow', function(){  
          var button_id = $(this).attr("id");  
          $('#AddRow'+button_id+'').remove();  
      }); 
        $(document).on('change keyup keydown', '.qtn', function(){  
         // var button_id = $(this).attr("id");  
        // $(this).val());
           var thisSelf=$(this);
           var gst=thisSelf.parent().parent().find('[name^=gst]').val();
            var unit_price=thisSelf.parent().parent().find('[name^=unit_price]').val();
           gst =parseInt(gst);
           unit_price=parseInt(unit_price);
           taxvValue=(unit_price*gst)/100;
           priceWithTax=unit_price+taxvValue;
           totalPrice=priceWithTax*thisSelf.val();
           if(isNaN(totalPrice))
           {
            console.log("Please Insert valid Quantity");
           }
           else
           {
            thisSelf.parent().parent().find('[name^=total_amount]').val(totalPrice);
           }
            

      }); 
         $(document).on('change keyup keydown', '[name^=unit_price]', function(){  
         // var button_id = $(this).attr("id");  
        // $(this).val());
           var thisSelf=$(this);
           var gst=thisSelf.parent().parent().find('[name^=gst]').val();
           var quantity=thisSelf.parent().parent().find('[name^=quantity]').val();
            var unit_price=thisSelf.parent().parent().find('[name^=unit_price]').val();
           gst =parseInt(gst);
           unit_price=parseInt(unit_price);
           taxvValue=(unit_price*gst)/100;
           priceWithTax=unit_price+taxvValue;
           totalPrice=priceWithTax*quantity;
           if(isNaN(totalPrice))
           {
            console.log("Please Insert valid Quantity");
           }
           else
           {
            thisSelf.parent().parent().find('[name^=total_amount]').val(totalPrice);
           }
            

      }); 
          $(document).on('change keyup keydown', '[name^=gst]', function(){  
         // var button_id = $(this).attr("id");  
        // $(this).val());
           var thisSelf=$(this);
           var gst=thisSelf.parent().parent().find('[name^=gst]').val();
           var quantity=thisSelf.parent().parent().find('[name^=quantity]').val();
            var unit_price=thisSelf.parent().parent().find('[name^=unit_price]').val();
           gst =parseInt(gst);
           unit_price=parseInt(unit_price);
           taxvValue=(unit_price*gst)/100;
           priceWithTax=unit_price+taxvValue;
           totalPrice=priceWithTax*quantity;
           if(isNaN(totalPrice))
           {
            console.log("Please Insert valid Quantity");
           }
           else
           {
            thisSelf.parent().parent().find('[name^=total_amount]').val(totalPrice);
           }
            

      }); 
        $(document).on("change","[name^=company_name]",function(){
          var thisSelf=$(this);
      var brand = $(this).val();
      $.ajax({
        type:"POST",
        url: "{{url('/')}}/ajax/getModal",
        data:{
          "_token": "{{ csrf_token() }}",
          brand : brand,
        },
        dataType : 'html',
        cache: false,
        success: function(data){
          modalData=JSON.parse(data);
          
          // console.log(modalData.id);
          // console.log(modalData.model_name);
           thisSelf.parent().parent().find('[name^=model_number]')
               .empty()
               .append('<option selected="selected" value="">-Select -</option>');
               for (index = 0; index < modalData.length; ++index) {
               thisSelf.parent().parent().find('[name^=model_number]').append(
                '<option value="'+modalData[index]['id']+'">'+modalData[index]['model_name']+'</option>'
              );   
            }
        }
      });
     }); 
       $(document).on('change', '[name^=product_id]', function(){  
         var productId=$(this).val();
         var thisSelf=$(this);
        //  console.log(  $(this).parent().parent().find('[name^=company_name]').val("ftuyh"));
             $.ajax({
             type: "POST",
             url: "{{url('/')}}/ajax/getProduct",
             data: { 
                     "_token": "{{ csrf_token() }}",
                    productId : productId,
                   },
             dataType : 'html',
             cache: false,
             success: function(data){
                var ProductDetail=JSON.parse(data);
                company_name=ProductDetail.company_name;
                model_number=ProductDetail.model_number;
                hsn=ProductDetail.hsn;
                unit_price=ProductDetail.unit_price;
                gst=ProductDetail.gst;
                if(gst==null)
                {
                  gst=0;
                }
                thisSelf.parent().parent().find('[name^=company_name]').val(company_name);
                thisSelf.parent().parent().find('[name^=model_number]').val(model_number);
                thisSelf.parent().parent().find('[name^=hsn]').val(hsn);
                thisSelf.parent().parent().find('[name^=unit_price]').val(unit_price);
                thisSelf.parent().parent().find('[name^=gst]').val(gst);

             }
             
         }); 
      }); 
  });
</script>


@endsection