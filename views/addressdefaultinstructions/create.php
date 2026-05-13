
<!DOCTYPE html>
<html>
<head>
    <title>Create Address Default Instructions</title>
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
<?php /** @var array|null $errors @var array $old @var array $addresses @var array $customers */ ?>
<h1>Create Address Default Instructions</h1>
<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post" action="/addressdefaultinstructions">
    <div>
        <label for="address_id">Address:</label>
        <select name="address_id" id="address_id" required>
            <option value="">-- Select Address --</option>
            <?php foreach ($addresses as $address): ?>
            <option value="<?= htmlspecialchars($address['id']) ?>"
                <?= (($old['id'] ?? '') === $address['id']) ? 'selected' : '' ?>>
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
                    <?= (($old['id'] ?? '') == $customer['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($customer['customer_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
            <label for="deliveryInstruction">Delivery Instruction:</label>
            <textarea id="deliveryInstruction" name="deliveryInstruction" rows="4" cols="50" placeholder="Enter delivery instruction.." required><?= htmlspecialchars($old['deliveryInstruction'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <div>
        <label for="packingInstruction">Packing Instruction:</label>
        <textarea id="packingInstruction" name="packingInstruction" rows="4" cols="50" placeholder="Enter packing instruction.." required><?= htmlspecialchars($old['packingInstruction'] ?? '', ENT_QUOTES) ?></textarea>
    </div>
    <br>
    <button type="submit">Save</button>
</form>
<br>
<a href="/addressdefaultinstructions">Back to List</a>
</body>
</html>
