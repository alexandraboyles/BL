
<!DOCTYPE html>
<html>
<head>
    <title>Create Address To Invoice Customer Mapping</title>
    <style>
       label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
       .error { color: red; }
       ul { margin: 10px 0; padding-left: 20px; }
       select { width: 260px; padding: 3px; }
       select option { width: 260px; padding: 6px; }
       input { width: 250px; padding: 3px; }     
       form textarea { margin-top: 7px; }
    </style>
</head>
<body>
<?php /** @var array|null $errors @var array $old @var array $addresses @var array $customers*/ ?>
<h1>Create Address To Invoice Customer Mapping</h1>
    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<form method="post" action="/addresstoinvoicecustomermapping">
    <div>
        <label for="id">ID:</label>
        <input id="id" type="number" name="id"
               value="<?= htmlspecialchars($old['id'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div>
        <label for="address_id">Address:</label>
        <select name="address_id" id="address_id" required>
            <option value="">-- Select Address --</option>
            <?php foreach ($addresses as $address): ?>
            <option value="<?= htmlspecialchars($address['id']) ?>"
                <?= (($old['address_id'] ?? '') == $address['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($address['address_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="customer_id">Customer:</label>
        <select name="customer_id" id="customer_id" required>
            <option value="">-- Select Customer --</option>
            <?php foreach ($customers as $customer): ?>
                <option value="<?= htmlspecialchars($customer['id']) ?>"
                    <?= (($old['customer_id'] ?? '') == $customer['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($customer['customer_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    <button type="submit">Save</button>
</form>
<br><br>
<a href="/addresstoinvoicecustomermapping">Back to List</a>
</body>
</html>
