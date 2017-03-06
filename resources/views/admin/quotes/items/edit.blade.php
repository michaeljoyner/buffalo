@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endsection

@section('content')
    <quote-app :quote-id="{{ $quote->id }}"
               quote_number="{{ $quote->quote_number }}"
    ></quote-app>
@endsection