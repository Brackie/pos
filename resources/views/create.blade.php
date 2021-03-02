@extends('layouts.forms')

@section('title')
    <title>{{config('app.name', 'POS')}}</title>
@endsection
    
@section('content')
    <form id="create_form">
        <input id="barcode" name="product_code" placeholder="Enter product barcode" onmouseover="this.focus();" 
        required>
        <input type="text" id="product_name" placeholder="Enter product name" required>
        <input type="number" id="product_stock" placeholder="Enter number of items" required>
        <input type="number" id="product_price" placeholder="Enter product price" required>
        <button type="submit" class="btn-pr" id="submit-item">Submit</button>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript">
        // CSRF Token       
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function(){
            
            document.getElementById("submit-item").onclick = function(event){
                event.preventDefault();
                
                // Post product data
                var product = {
                    "product_code": document.forms.create_form.product_code.value,
                    "product_name": document.forms.create_form.product_name.value,
                    "product_stock": document.forms.create_form.product_stock.value,
                    "product_price": document.forms.create_form.product_price.value
                }

                $.ajax({
                    url:"http://127.0.0.1:8000/store/product",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        product: product
                    },
                    success: function( data ) {
                        showPrompt(data.message);
                        if (data.status == 1) {
                            window.location.assign("/");
                        }
                    },
                    error: function( error ) {
                        showPrompt("Something went wrong!", 0);
                    }
                });
            }
        
        });
    </script>
@endsection