<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="/event/create">
        @csrf
        <input name="name" />
        <input name="venue" />
        <input name="location" />
        <input type="submit">
    </form>
</body>
</html>