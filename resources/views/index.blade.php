@extends('layouts.app')

@section('title')
    <title>{{config('app.name', 'POS')}}</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">  
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}">  
    <link rel="stylesheet" href="{{asset('assets/css/inventory.css')}}">
@endsection

@section('content')   

<div class="inventory">
        <h2>Inventory</h2>
        <div class="table">
            <div class="thead">
                <div class="trow">
                    <p class="tdata">ID</p>
                    <p class="tdata">Item Code</p>
                    <p class="tdata">Item Name</p>
                    <p class="tdata">Available</p>
                    <p class="tdata">Price</p>
                </div>
            </div>
            <div class="tbody" id="products_table">         
                
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            // Fetch data
            $.ajax({
                url:"http://127.0.0.1:8000/allproducts",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN
                },
                success: function( data ) {
                    if(data.items.length < 1) showPrompt("No products found", 0);
                    populateTable(data.items);
                },
                error: function( error ) {
                    showPrompt("Something went wrong!", 0);
                }
            });
        });

        function populateTable(items){
            for(let i = 0; i < items.length; i++){
                let item = items[i];
                let div = `<div class="trow" id="product_${item.id}">
                    <p class="tdata">${item.id}</p>
                    <p class="tdata">${item.product_code}</p>
                    <p class="tdata">${item.product_name}</p>
                    <p class="tdata">${item.product_stock}</p>
                    <p class="tdata">${item.product_price}</p>
                </div>`;
                $('#products_table').append(div);
            }
        }
    </script>
@endsection