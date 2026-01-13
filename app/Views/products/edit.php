<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Edit Product
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Product</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/products" class="btn btn-sm btn-outline-secondary">Back to List</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="/products/<?= $product['id'] ?>" method="post">
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

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?= old('name', $product['name']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sku" name="sku"
                            value="<?= old('sku', $product['sku']) ?>" required>
                        <div class="form-text">Unique product identifier</div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= old('category_id', $product['category_id']) == $category['id'] ? 'selected' : '' ?>>
                            <?= esc($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"
                    rows="3"><?= old('description', $product['description']) ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Selling Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="price" name="price"
                                value="<?= old('price', $product['price']) ?>" step="0.01" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="cost_price" class="form-label">Cost Price (COGS)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="cost_price" name="cost_price"
                                value="<?= old('cost_price', $product['cost_price']) ?>" step="0.01" min="0">
                        </div>
                        <div class="form-text">For profit margin calculation</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock" name="stock"
                            value="<?= old('stock', $product['stock']) ?>" min="0" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="min_stock" class="form-label">Min Stock <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="min_stock" name="min_stock"
                            value="<?= old('min_stock', $product['min_stock']) ?>" min="0" required>
                        <div class="form-text">Reorder alert level</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                        <select class="form-select" id="unit" name="unit" required>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?= $unit ?>" <?= old('unit', $product['unit']) == $unit ? 'selected' : '' ?>>
                                    <?= ucfirst($unit) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="url" class="form-control" id="image_url" name="image_url"
                    value="<?= old('image_url', $product['image_url']) ?>" placeholder="https://example.com/image.jpg">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                    <?= old('is_active', $product['is_active']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_active">
                    Active (Product will be visible and available)
                </label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="/products" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>