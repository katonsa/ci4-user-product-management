<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Edit Category
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Category</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/categories" class="btn btn-sm btn-outline-secondary">Back to List</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <form action="/categories/<?= $category['id'] ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li>
                                <?= esc($error) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?= old('name', $category['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug"
                    value="<?= old('slug', $category['slug']) ?>" required>
                <div class="form-text">Unique identifier for URL.</div>
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>