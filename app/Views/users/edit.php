<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Edit User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit User: <?= esc($user['name']) ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/users" class="btn btn-sm btn-outline-secondary">Back to List</a>
    </div>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/users/<?= $user['id'] ?>" method="post">
    <?= csrf_field() ?>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $user['name']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password (Leave blank to keep current)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?= old('is_active', $user['is_active']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_active">Account Active</label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Roles
                </div>
                <div class="card-body">
                    <?php foreach ($groups as $group): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="groups[]" value="<?= $group['id'] ?>" id="group_<?= $group['id'] ?>" 
                                <?= in_array($group['id'], $userGroupIds) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="group_<?= $group['id'] ?>">
                                <?= esc($group['name']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Update User</button>
    </div>
</form>

<?= $this->endSection() ?>
