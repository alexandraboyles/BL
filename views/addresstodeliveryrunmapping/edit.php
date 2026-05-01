
<!DOCTYPE html>
<html>
<head>
    <title>Create Address To Delivery Run Mapping</title>
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
<?php /** @var array|null $errors @var array $item @var array $addresstypes @var array $addresses @var array $customers @var array $products @var array $deliveryruns @var array $carriers @var array $flowdirections*/ ?>
<h1>Create Address To Delivery Run Mapping</h1>
    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<form method="post" action="/addresstodeliveryrunmapping/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
    <div>
        <label for="id">ID:</label>
        <input id="id" type="number" name="id"
               value="<?= htmlspecialchars($item['id'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div>
        <label for="addressType_id">Address Type:</label>
        <select name="addressType_id" id="addressType_id" required>
            <option value="">-- Select Address Type--</option>
            <?php foreach ($addresstypes as $addresstype): ?>
            <option value="<?= htmlspecialchars($addresstype['id']) ?>"
                <?= (($item['addressType_id'] ?? '') == $addresstype['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($addresstype['addressType_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="address_id">Address:</label>
        <select name="address_id" id="address_id" required>
            <option value="">-- Select Address --</option>
            <?php foreach ($addresses as $address): ?>
            <option value="<?= htmlspecialchars($address['id']) ?>"
                <?= (($item['address_id'] ?? '') == $address['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($address['address_name']) ?>
            </option>s
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
    <div>
        <label for="deliveryRun_id">Delivery Run:</label>
        <select name="deliveryRun_id" id="deliveryRun_id" required>
            <option value="">-- Select Delivery Run --</option>
            <?php foreach ($deliveryruns as $deliveryrun): ?>
                <option value="<?= htmlspecialchars($deliveryrun['id']) ?>"
                    <?= (($item['deliveryRun_id'] ?? '') == $deliveryrun['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($deliveryrun['deliveryRun_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
        <div>
        <label for="carrier_id">Carrier:</label>
        <select name="carrier_id" id="carrier_id" required>
            <option value="">-- Select Carrier --</option>
            <?php foreach ($carriers as $carrier): ?>
                <option value="<?= htmlspecialchars($carrier['id']) ?>"
                    <?= (($item['carrier_id'] ?? '') == $carrier['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($carrier['carrier_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="flowDirection_id">Flow Direction:</label>
        <select name="flowDirection_id" id="flowDirection_id" required>
            <option value="">-- Select Flow Direction--</option>
            <?php foreach ($flowdirections as $flowdirection): ?>
            <option value="<?= htmlspecialchars($flowdirection['id']) ?>"
                <?= (($item['flowDirection_id'] ?? '') == $flowdirection['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($flowdirection['flowDirection']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
            <br>
            <button type="submit">Update Address Delivery Run Mapping</button>
            <br><br>
            <a href="/addresstodeliveryrunmapping">Cancel</a>
        </form>
    </body>
</html>
