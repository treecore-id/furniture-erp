@extends('errors::minimal')

@section('title', __('401 Unauthorized'))
@section('code', 'Access Denied: Please Log In')
@section('message', __('You must be logged in or provide valid credentials to view this resource. If you believe this is an error, please try logging in again.'))
