<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    
        <title>Laravel</title>

         </head>
    <body>
        <h1>Projeto Estudo Laravel</h1>
        <p>Data Atual: {{\Carbon\Carbon::now()->format('d/m/Y H:i:s')}} </p>
    </body>
</html>
