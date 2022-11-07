<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>{{$title}}</title>

    <!-- Styles -->
    <link href="{{asset('/assets/css/page.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{asset('/assets/img/apple-touch-icon.png')}}">
    <link rel="icon" href="{{asset('/assets/img/favicon.png')}}">

    <link rel="stylesheet" href="{{asset('/assets/iziToast/css/iziToast.min.css')}}">
    @livewireStyles
    @stack('styles')
</head>

<body>
