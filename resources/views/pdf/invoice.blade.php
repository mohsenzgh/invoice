<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'bnazanin', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
        }

        .header {
            font-family: 'btitr' , sans-serif;
            text-align: center;
            margin-bottom: 40px;
        }

        .header img {
            width: 100px;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 24px;
            margin: 0;
            padding: 0;
        }

        .invoice-info {
            margin-bottom: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
            font-family: 'btitr', sans-serif;
            color: #333;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total {
            font-family: 'btitr', sans-serif;
            text-align: left;
            margin-top: 20px;
            font-size: 18px;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 30px;
            border-top: 1px solid #dddddd;
            padding-top: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        {{-- <img src="{{ asset('images/logo.png') }}" alt="لوگو"> --}}
        <h1>پیش‌فاکتور</h1>
    </div>

    <div class="invoice-info">
        <p>شماره سفارش: {{ $orderId }}</p>
        <p>تاریخ: {{ \Carbon\Carbon::now()->format('Y/m/d') }}</p>
    </div>

    @foreach ($allSystems as $product)
        <h2>محصول شماره {{ $product['product_id'] }}</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>طول</th>
                    <th>عرض</th>
                    <th>تعداد</th>
                    <th>مساحت</th>
                    <th>قیمت واحد</th>
                    <th>قیمت نور</th>
                    <th>قیمت کل</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product['systems'] as $system)
                    <tr>
                        <td>{{ $system['length'] }} متر</td>
                        <td>{{ $system['width'] }} متر</td>
                        <td>{{ $system['count'] }}</td>
                        <td>{{ $system['area'] }} متر مربع</td>
                        <td>{{ number_format($system['unit_price']) }} ریال</td>
                        <td>{{ number_format($system['light_price']) }} ریال</td>
                        <td>{{ number_format($system['final_price']) }} ریال</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="total">
        
    </div>

    <div class="footer">
        <p>آدرس: خیابان فلان، تهران</p>
        <p>تلفن: ۰۲۱-۱۲۳۴۵۶۷۸</p>
    </div>
</body>
</html>