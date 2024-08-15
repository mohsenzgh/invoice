@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1>ویرایش محصول</h1>
        
        <hr class="sidebar-divider">
       
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class=" form-group col-md-3">
                <label for="name">نام جدید محصول را وارد کنید</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-5">به روز رسانی</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-warning mt-5">بازگشت</a>
        </form>
    </div>
@endsection
