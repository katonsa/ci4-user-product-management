<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>User Management
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">User Management</h1>
</div>

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

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?= $user['id'] ?>
                    </td>
                    <td>
                        <?= esc($user['name']) ?>
                    </td>
                    <td>
                        <?= esc($user['email']) ?>
                    </td>
                    <td>
                        <?php foreach ($user['groups'] as $group): ?>
                            <span class="badge bg-secondary">
                                <?= esc($group['name']) ?>
                            </span>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php if ($user['is_active']): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/users/<?= $user['id'] ?>/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="/users/<?= $user['id'] ?>/delete" method="post" style="display:inline;"
                            onsubmit="return confirm('Are you sure?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>