<!DOCTYPE html>
<html>
<head>
    <title>Product Form</title>
</head>
<body>
    <form action="/export" method="POST">
        <!-- امنیت CSRF در لاراول -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <h3>Product 1</h3>
        <label for="phone">Product ID:</label>
        <input type="text" id="phone" name="phone" required><br>

        

        <button type="submit">Submit</button>
    </form>
</body>
</html>
