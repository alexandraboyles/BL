<!DOCTYPE html>
<html>
    <head>
        <title>Edit Address String</title>
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
        <h1>Edit Address String</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/addressstrings/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <div>
            <label for="id">ID:</label>
            <input id="id" type="number" name="id"
                   value="<?= htmlspecialchars($item['id'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="address_id">Address:</label>
            <select name="address_id" id="address_id" required>
                <option value="">-- Select Address --</option>
                <?php foreach ($addresses as $address): ?>
                <option value="<?= htmlspecialchars($address['id']) ?>"
                    <?= (($item['address_id'] ?? '') == $address['id']) ? 'selected' : '' ?>>
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
                        <?= (($item['customer_id'] ?? '') == $customer['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($customer['customer_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="text">Text:</label>
            <textarea id="text" name="text" rows="4" cols="50" required><?= htmlspecialchars($item['text'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
            <br>
            <button type="submit">Update Address String</button>
            <br><br>
            <a href="/addressstrings">Cancel</a>
        </form>
    </body>
</html>