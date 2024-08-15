
@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1>محصولات</h1>
        <hr class="sidebar-divider">
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold"> لیست محصولات </h5>
                <a class="btn btn-sm btn-outline-primary" href="{{route('admin.products.create')}}">
                    <i class="fa fa-plus"></i>
                    ایجاد محصول جدید
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام محصول</th>
                            <th>عملیات</th>
                
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                            <tr>
                                <th>
                                    {{$products->firstItem() + $key}}
                                </th>
                                <th>
                                    {{$product->name}}
                                </th>
                                <th>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">ویرایش</a>
                                    <a href="{{ route('admin.products.prices.index', $product->id) }}" class="btn btn-secondary">مدیریت قیمت ها</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
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
