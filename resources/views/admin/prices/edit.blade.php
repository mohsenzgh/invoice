@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1>ویرایش ابعاد برای {{ $product->name }}</h1>
        <hr class="sidebar-divider">
        <form action="{{ route('admin.products.prices.update', [$product->id, $price->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group col-md-3">
                <label for="length">طول</label>
                <input type="number" name="length" id="length" class="form-control" value="{{ $price->length }}" required>
            </div>
            <div class="form-group col-md-3">
                <label for="width">عرض</label>
                <input type="number" name="width" id="width" class="form-control" value="{{ $price->width }}" required>
            </div>
            <div class="form-group col-md-3">
                <label for="price">قیمت</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $price->price }}" required>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-5">به روز رسانی</button>
            <a href="{{ route('admin.products.prices.index', $product->id) }}" class="btn btn-outline-warning mt-5">بازگشت</a>
        </form>
    </div>
@endsection
