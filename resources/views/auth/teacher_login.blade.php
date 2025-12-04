<!DOCTYPE html>
<html>
<head>
    <title>Staff Login</title>
</head>
<body>
    <h1>Staff Login</h1>
    <form method="POST" action="{{ route('teacher.login.submit') }}">
        @csrf
        <label>Email</label>
        <input type="email" name="email" required autofocus>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>