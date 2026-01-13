<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            <form action="/login" method="post">
                <?= csrf_field() ?>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>

        <div>
            <a href="/register">Don't have an account? Register here.</a>
        </div>
    </div>
</body>

</html>