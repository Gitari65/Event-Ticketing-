<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" action="/register">
        @csrf
        <input name="name" />
        <input name="email" />
        <input name="password" />
        <input type="submit">
    </form>
</body>
</html>