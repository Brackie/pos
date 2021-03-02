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
        <link rel="stylesheet" href="{{asset('assets/css/forms.css')}}"> 

        @yield('css') 	
    </head>
    <body>    
        <div class="forms">
            <img src="{{asset('assets/images/logo.png')}}">
            <div class="dialog slide_from_right">
                <h1 class="title">{{$page}}</h1>   
                @yield('content')
            </div>
        </div>
        <div class="prompt">
            <span class="fa fa-check" id="prompt-icon"></span>
            <p class="prompt-message"></p>
        </div>
        <script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
    	<script src="{{asset('assets/js/config.js')}}"></script>
    	<script src="{{asset('assets/js/general.js')}}"></script>
        <script>     
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
                    echo "showPrompt(\"{$message}\", 0);";
                }  
            @endphp
        </script>
        @yield('scripts')
    </body>
</html>
