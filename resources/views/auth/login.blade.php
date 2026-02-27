<!DOCTYPE html>
<html>
<head>
    <title>Test Login</title>
</head>
<body>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">

    <button type="submit">LOGIN TEST</button>
</form>

</body>
</html>