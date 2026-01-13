<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Products
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Products</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/products/new" class="btn btn-sm btn-primary">Create New Product</a>
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
                <th scope="col">SKU</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Cost</th>
                <th scope="col">Margin</th>
                <th scope="col">Stock</th>
                <th scope="col">Unit</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="10" class="text-center">No products found</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <code><?= esc($product['sku']) ?></code>
                        </td>
                        <td>
                            <?= esc($product['name']) ?>
                        </td>
                        <td>
                            <?= $product['category_name'] ? esc($product['category_name']) : '<span class="text-muted">-</span>' ?>
                        </td>
                        <td>
                            Rp
                            <?= number_format($product['price'], 0, ',', '.') ?>
                        </td>
                        <td>
                            <?php if ($product['cost_price']): ?>
                                Rp
                                <?= number_format($product['cost_price'], 0, ',', '.') ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($product['cost_price'] && $product['price'] > 0): ?>
                                <?php
                                $margin = (($product['price'] - $product['cost_price']) / $product['price']) * 100;
                                $badgeClass = $margin < 20 ? 'bg-danger' : ($margin < 40 ? 'bg-warning' : 'bg-success');
                                ?>
                                <span class="badge <?= $badgeClass ?>">
                                    <?= number_format($margin, 1) ?>%
                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $stockClass = '';
                            if ($product['stock'] <= 0) {
                                $stockClass = 'text-danger fw-bold';
                            } elseif ($product['stock'] <= $product['min_stock']) {
                                $stockClass = 'text-warning fw-bold';
                            }
                            ?>
                            <span class="<?= $stockClass ?>">
                                <?= $product['stock'] ?>
                            </span>
                            <?php if ($product['stock'] <= $product['min_stock']): ?>
                                <span class="badge bg-warning text-dark" title="Low Stock">
                                    <i class="bi bi-exclamation-triangle"></i> Low
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= esc($product['unit']) ?>
                        </td>
                        <td>
                            <?php if ($product['is_active']): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/products/<?= $product['id'] ?>/edit" class="btn btn-sm btn-outline-secondary">
                                Edit
                            </a>
                            <form action="/products/<?= $product['id'] ?>/toggle" method="post" style="display:inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="PATCH">
                                <button type="submit"
                                    class="btn btn-sm btn-outline-<?= $product['is_active'] ? 'warning' : 'success' ?>"
                                    title="<?= $product['is_active'] ? 'Deactivate' : 'Activate' ?>">
                                    <?= $product['is_active'] ? 'Deactivate' : 'Activate' ?>
                                </button>
                            </form>
                            <form action="/products/<?= $product['id'] ?>/delete" method="post" style="display:inline"
                                onsubmit="return confirm('Are you sure you want to delete this product?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>