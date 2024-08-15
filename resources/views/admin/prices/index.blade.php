@extends('admin.layouts.admin')


@section('content')
    <div class="container">
        <h1>قیمت برای {{ $product->name }}</h1>
        <hr class="sidebar-divider">
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold"> لیست قیمت ها </h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.prices.create', $product->id) }}">
                    <i class="fa fa-plus"></i>
                    اضافه کردن ابعاد جدید
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>طول</th>
                            <th>عرض</th>
                            <th>قیمت</th>
                            <th>عملیات</th>
                
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prices as $key => $price)
                            <tr>
                                <th>
                                    {{$price->length}}
                                </th>
                                <th>
                                    {{ $price->width }}
                                </th>
                                <th>
                                    {{ $price->price }}
                                </th>
                                <th>
                                    <a href="{{ route('admin.products.prices.edit', [$product->id, $price->id]) }}" class="btn btn-warning">ویرایش</a>
                                    <form action="{{ route('admin.products.prices.destroy', [$product->id, $price->id]) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

       

