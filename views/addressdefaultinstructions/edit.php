<!DOCTYPE html>
<html>
    <head>
        <title>Edit Address Default Instruction</title>
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
        <?php
        /** @var array $item */
        /** @var array|null $errors */
        /** @var array $addresses @var array $customers */
        ?>
        <h1>Edit Address Default Instruction</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/addressdefaultinstructions/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <div>
            <label for="address_id">Address:</label>
            <select name="address_id" id="address_id" required>
                <option value="">-- Select Address --</option>
                <?php foreach ($addresses as $address): ?>
                <option value="<?= htmlspecialchars($address['id']) ?>"
                    <?= (($address['id'] ?? '') === $address['id']) ? 'selected' : '' ?>>
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
                        <?= (($customer['id'] ?? '') == $customer['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($customer['customer_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="deliveryInstruction">Delivery Instruction:</label>
            <input id="deliveryInstruction" type="text" name="deliveryInstruction" 
                   value="<?= htmlspecialchars($item['deliveryInstruction'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="packingInstruction">Packing Instruction:</label>
            <input id="packingInstruction" type="text" name="packingInstruction" 
                   value="<?= htmlspecialchars($item['packingInstruction'] ?? '', ENT_QUOTES) ?>" required>
        </div>
            <br>
            <button type="submit">Update Address Default Instruction</button>
            <br><br>
            <a href="/addressdefaultinstructions">Cancel</a>
        </form>
    </body>
</html>