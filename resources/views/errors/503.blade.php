@extends('errors::minimal')

@section('title', __('503 Service Unavailable'))
@section('code', 'Service Temporarily Unavailable')
@section('message', __('The server is currently unable to handle the request due to maintenance or being overloaded. Please check back shortly.'))
