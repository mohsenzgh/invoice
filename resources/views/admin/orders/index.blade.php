
@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1>پیش فاکتورها</h1>
        <hr class="sidebar-divider">
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold"> لیست پیش فاکتورها </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>شماره فاکتور</th>
                            <th>نام مشتری</th>
                            <th>شماره تماس</th>
                            <th>نام شرکت</th>
                
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $key => $order)
                            <tr>
                                <th>
                                    {{$order->id}}
                                </th>
                                <th>
                                    {{$order->customer_name}}
                                </th>
                                <th>
                                    {{$order->customer_phone}}
                                </th>
                                <th>
                                    {{$order->customer_company}}
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
        
@endsection
