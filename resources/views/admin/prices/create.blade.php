@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1>ایجاد ابعاد جدید برای {{ $product->name }}</h1>
        <hr class="sidebar-divider">
        <form action="{{ route('admin.products.prices.store', $product->id) }}" method="POST">
            @csrf
            <div class="form-group col-md-3">
                <label for="length col-md-3">طول</label>
                <input type="number" name="length" id="length" class="form-control" required>
            </div> 
            <div class="form-group col-md-3">
                <label for="width">عرض</label>
                <input type="number" name="width" id="width" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label for="price">قیمت</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-5">ایجاد</button>
            <a href="{{ route('admin.products.prices.index', $product->id) }}" class="btn btn-outline-warning mt-5">بازگشت</a>
        </form>
    </div>
@endsection
