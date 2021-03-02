@extends('layouts.app')

@section('title')
    <title>{{ config('app.name', 'POS') }}</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">  
    <link rel="stylesheet" href="{{asset('assets/css/cart.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/js/jqueryui/jquery-ui.min.css')}}">
@endsection

@section('content')
    <div class="sales">
        <h2>Sales Cart</h2>
        <div class="row">
            <div class="flex-bg-70">
                <div class="cart">
                    <div class="table">
                        <div class="thead">
                            <div class="trow">
                                <p class="tdata">No.</p>
                                <p class="tdata">Name</p>
                                <p class="tdata">Price</p>
                                <p class="tdata">Quantity</p>
                                <p class="tdata"></p>
                                <p class="tdata"></p>
                            </div>
                        </div>
                        <div class="tbody" id="cart-body">
                            <!-- Cart Items Go Here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-bg-30">
                <div class="checkout">
                    <form autocomplete="off">
                        <div class="row">
                            <div class="flex-bg-80">
                                <div class="autocomplete">
                                    <label for="search_item">Search</label>
                                    <input type="search" id="search" onmouseover="this.focus();" 
                                    placeholder="Enter product name">
                                </div>
                            </div>
                            <div class="flex-bg-20">
                                <button type="submit" class="btn-pr" ><span class="fa fa-search"></span></button>
                            </div>
                        </div>
                    </form>
                    <div class="prices">       
                        <p>Sub Total: <br><span id="sub-total">0</span></p>
                        <p>Vat Sub Total: <br><span id="vat-sub-total">0</span></p>
                        <p>Discount: <br><span id="discount">0</span></p>
                        <p>Total: <br><span id="total">0</span></p>
                    </div>
                    <button type="button" class="btn-pr" id="print">Print</button>
                </div>
            </div>
        </div> 
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/js/jqueryui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script type="text/javascript">
            
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function(){
            var products = [];
            $( "#search" ).autocomplete({
                source: function( request, response ) {
                    // Fetch data
                    $.ajax({
                        url:"http://127.0.0.1:8000/filterproducts",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            products = data.items;
                            var filteredArray = $.map(data.items, function(item) {
                                if( item.product_name.toLowerCase().startsWith(request.term.toLowerCase()))
                                    return item.product_name;
                                return null;
                            });
                            response(filteredArray);
                        }
                    });
                },
                
                select: function (event, ui) {
                    // Add selection
                    var select_product = $.map(products, function(item){
                        if(ui.item.value.toLowerCase() == item.product_name.toLowerCase())
                            return item;
                        return null;
                    });
                    addCartItem(select_product[0]);
                }
            });

        });
    </script>
@endsection