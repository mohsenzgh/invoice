@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1>ایجاد محصول جدید</h1>
        <hr class="sidebar-divider">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="form-group col-md-3">
                <label for="name">نام محصول را وارد کنید</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-outline-primary mt-5">ایجاد</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-warning mt-5">بازگشت</a>
        </form>
    </div>
@endsection
