<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <div>
        <div>
            <?php if (session()->getFlashdata('errors')) : ?>
                <ul style="color:red;">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <form action="/register" method="post">
                <?= csrf_field() ?>
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="password_confirm">Confirm Password:</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
        <div>
            <a href="/login">Already have an account? Login here.</a>
        </div>
    </div>
</body>

</html>