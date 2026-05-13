
<!DOCTYPE html>
<html>
<head>
    <title>Create Bill</title>
    <style>
       label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
       .error { color: red; }
       ul { margin: 10px 0; padding-left: 20px; }
       select { width: 260px; padding: 3px; }
       select option { width: 260px; padding: 6px; }
       input { width: 250px; padding: 3px; }
    </style>
</head>
<body>
<?php /** @var array|null $errors @var array $old @var array $suppliers @var array $invoices @var array $manifests */ ?>
<h1>Create Bill</h1>
<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post" action="/bills">
    <div>
        <label for="supplier_id">Supplier:</label>
        <select name="supplier_id" id="supplier_id" required>
            <option value="">-- Select Supplier --</option>
            <?php foreach ($suppliers as $supplier): ?>
            <option value="<?= htmlspecialchars($supplier['id']) ?>"
                <?= (($old['id'] ?? '') === $supplier['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($supplier['companyName']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="invoice_id">Invoice:</label>
        <select name="invoice_id" id="invoice_id" required>
            <option value="">-- Select Invoice --</option>
            <?php foreach ($invoices as $invoice): ?>
                <option value="<?= htmlspecialchars($invoice['id']) ?>"
                    <?= (($old['id'] ?? '') == $invoice['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($invoice['invoice_id']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="manifest_id">Manifest:</label>
        <select name="manifest_id" id="manifest_id" required>
            <option value="">-- Select Manifest --</option>
            <?php foreach ($manifests as $manifest): ?>
                <option value="<?= htmlspecialchars($manifest['id']) ?>"
                    <?= (($old['id'] ?? '') == $manifest['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($manifest['id']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    <button type="submit">Save</button>
</form>
<br>
<a href="/bills">Back to List</a>
</body>
</html>
