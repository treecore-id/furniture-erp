@extends('errors::minimal')

@section('title', __('429 Too Many Requests'))
@section('code', 'Slow Down! Too Many Requests')
@section('message', __('You have sent too many requests in a short period. Please wait a few minutes before attempting to access the resource again.'))
