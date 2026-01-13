<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Categories
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Categories</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/categories/new" class="btn btn-sm btn-primary">Create New</a>
    </div>
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
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td>
                        <?= $category['id'] ?>
                    </td>
                    <td>
                        <?= esc($category['name']) ?>
                    </td>
                    <td>
                        <?= esc($category['slug']) ?>
                    </td>
                    <td>
                        <a href="/categories/<?= $category['id'] ?>/edit" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="/categories/<?= $category['id'] ?>/delete" method="post" style="display:inline"
                            onsubmit="return confirm('Are you sure?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>