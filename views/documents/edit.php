<!DOCTYPE html>
<html>
    <head>
        <title>Edit Document</title>
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
        /** @var array|null $errors @var array $saleOrders @var array $customers @var array $consignments */
        ?>
        <h1>Edit Document</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/documents/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
       <div>
        <label for="saleOrder_id">Sale Order:</label>
        <select name="saleOrder_id" id="saleOrder_id" required>
            <option value="">-- Select Sale Order --</option>
            <?php foreach ($saleOrders as $saleOrder): ?>
            <option value="<?= htmlspecialchars($saleOrder['id']) ?>"
                <?= (($item['saleOrder_id'] ?? '') == $saleOrder['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($saleOrder['saleOrder_id']) ?>
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
        <label for="consignment_id">Consignment:</label>
        <select name="consignment_id" id="consignment_id" required>
            <option value="">-- Select Consignment --</option>
            <?php foreach ($consignments as $consignment): ?>
                <option value="<?= htmlspecialchars($consignment['id']) ?>"
                    <?= (($item['consignment_id'] ?? '') == $consignment['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($consignment['consignment_id']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
            <label for="fileType">File Type:</label>
            <input id="fileType" type="text" name="fileType" 
                   value="<?= htmlspecialchars($item['fileType'] ?? '', ENT_QUOTES) ?>" required>
    </div>   
            <br>
            <button type="submit">Update Document</button>
            <br><br>
            <a href="/documents">Cancel</a>
        </form>
    </body>
</html>