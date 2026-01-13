<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div>
        <h2>Hi, welcome to your dashboard!</h2>
    </div>
    <div>
        <form action="/logout" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>