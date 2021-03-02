<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @yield('title')

        <!-- Icon for site-->
        <link rel="icon" href="{{asset('favicon.ico')}}">

        <!--Icon stylesheets-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <!--Google Fonts-->
	    <link href="https://fonts.googleapis.com/css?family=Dosis|Abril+Fatface|Montserrat|Pacifico|Roboto
		|Slabo+13px|Poppins:wght@300|Ultra|Nunito:wght@300|Comic+Neue&display=swap" rel="stylesheet">

	    <!--Style for this site -->
        <link rel="stylesheet" href="{{asset('assets/css/animations.css')}}"> 
        <link rel="stylesheet" href="{{asset('assets/css/general.css')}}"> 

        @yield('css') 	
    </head>
    <body>
        <div class="navbar">
            <div class="nav-container">
                <div class="nav-brand">
                    <a href="" class="nav-toggle"><span class="fa fa-bars"></span></a>
                    <a><h1>{{config('app.name', 'POS')}}<span>{{$page}}</span></h1></a>
                </div>
            </div>
            <nav class="nav-side">
                <span class="fa fa-close" id="close-sidenav"></span>
                <ul id="nav-side">
                    <li><a href="/" class="nav-link active" id="home">
                        <span class="fa fa-home"></span>Dashboard</a></li>
                    <li><a href="/invoices" class="nav-link" id="invoices">
                        <span class="fa fa-book"></span>Invoices</a></li>
                    <li><a href="/cart" class="nav-link" id="cart">
                        <span class="fa fa-shopping-cart"></span>Cart</a></li>
                    <li><a href="/create/product" class="nav-link" id="create">
                        <span class="fa fa-plus-square"></span>Add Inventory</a></li>
                </ul>
            </nav>
        </div>
        <div class="container">     
            @yield('content')
        </div>
        <div class="prompt">
            <span class="fa fa-check" id="prompt-icon"></span>
            <p class="prompt-message"></p>
        </div>
        <script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{asset('assets/js/jqueryui/jquery-ui.min.js')}}" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    	<script src="{{asset('assets/js/config.js')}}"></script>
    	<script src="{{asset('assets/js/general.js')}}"></script>
        <script type="text/javascript">    
            @if (session('success'))       
                showPrompt("{{ session('success') }}");
            @endif  
            @if (session('error'))       
                showPrompt("{{ session('error') }}");
            @endif
            @php
                if ($errors->any()){
                    $message = "";
                    foreach ($errors->all() as $error){
                        $message .= $error . "<br>";
                    }
                    echo "showPrompt(\"{ $message }\", 0);";
                }  
            @endphp
            $(".nav-side ul li").children().removeClass("active");
            $("#" + "{{ $page }}").addClass("active");
        </script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        @yield('scripts')
    </body>
</html>