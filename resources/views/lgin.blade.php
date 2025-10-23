<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    buenas noches
    <form action="{{ route('login.attempt') }}" method="post">
    @csrf
    <input type="text" name="email" placeholder="Email">
</form>
</body>
</html>