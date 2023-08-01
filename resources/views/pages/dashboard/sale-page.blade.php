@extends('layout.sidenav-layout')
@section('content')
    @include('components.sale.sale-list')
    @include('components.sale.sale-delete')
    @include('components.sale.sale-create')
@endsection
