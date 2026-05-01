<!DOCTYPE html>
<html>
    <head>
        <title>Edit Delivery Address to Onforwarder Address Mapping</title>
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
        /** @var array $addresses @var array $customers @var array $products*/
        ?>
        <h1>Edit Delivery Address to Onforwarder Address Mapping</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/deliveryaddresstoonforwarderaddressmapping/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
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
            <label for="product_id">Product:</label>
            <select name="product_id" id="product_id" required>
                <option value="">-- Select Product --</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= htmlspecialchars($product['id']) ?>"
                        <?= (($item['product_id'] ?? '') == $product['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($product['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
            <br>
            <button type="submit">Update Delivery Address to Onforwarder Address Mapping</button>
            <br><br>
            <a href="/deliveryaddresstoonforwarderaddressmapping">Cancel</a>
        </form>
    </body>
</html>