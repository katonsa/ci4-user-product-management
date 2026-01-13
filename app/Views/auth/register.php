<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>Register<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="form-auth text-center">
    <form action="/register" method="post">
        <h1 class="h3 mb-3 fw-normal">Please Register</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger text-start">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= csrf_field() ?>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" autocomplete="name"
                required>
            <label for="name">Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                autocomplete="email" required>
            <label for="email">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                autocomplete="new-password" required>
            <label for="password">Password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                placeholder="Confirm Password" autocomplete="new-password" required>
            <label for="password_confirm">Confirm Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
        <p class="mt-3 mb-3 text-muted">
            <a href="/login">Already have an account? Login here.</a>
        </p>
    </form>
</main>
<?= $this->endSection() ?>