@extends('errors::minimal')

@section('title', __('403 Forbidden'))
@section('code', 'Access Restricted: Forbidden')
@section('message', __('You do not have the necessary permissions to view the content on this page. If you reached this page by following a link, please ensure you have the correct user role or contact the site administrator.'))
{{-- @section('message', __($exception->getMessage() ?: 'Forbidden')) --}}
