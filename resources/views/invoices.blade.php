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
                    <p class="tdata">Total</p>
                    <p class="tdata">Paid</p>
                    <p class="tdata"></p>
                </div>
            </div>
            <div class="tbody" id="invoices_table">         
                
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
                url:"http://127.0.0.1:8000/allinvoices",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN
                },
                success: function( data ) {
                    if(data.items.length < 1) showPrompt("No invoices found", 0);
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
                let div = `<div class="trow" id="invoice_${item.id}">
                    <p class="tdata">${item.id}</p>
                    <p class="tdata">${item.total}</p>
                    <p class="tdata">${item.paid}</p>
                    <p class="tdata"><button class="pay" id="${item.id}">Pay</button></p>
                </div>`;
                $('#invoices_table').append(div);
            }
        }

        $(document).ready(function(){
            $(document).on('click', '.pay', function (event) {
                event.preventDefault();
                const id = $(this).attr('id');

                $.ajax({
                    url:"http://127.0.0.1:8000/pay/invoice",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        product_id: id
                    },
                    success: function( data ) {
                        showPrompt(data.message, data.status);
                        setTimeout(() => {
                            window.location.assign("/invoices");
                        }, 2000);
                    },
                    error: function( error ) {
                        showPrompt("Something went wrong!", 0);
                    }
                });
            });
        });
    </script>
@endsection