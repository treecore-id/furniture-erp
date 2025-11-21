@extends('errors::minimal')

@section('title', __('500 Server Error'))
@section('code', 'Internal Server Error')
@section('message', __('Something went wrong on the server side. We apologize for the inconvenience and are working to fix the issue. Please try again later.'))
