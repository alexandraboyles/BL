<!DOCTYPE html>
<html>
<head>
    <title>Create Invoice</title>
    <style>
       label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
       .error { color: red; }
       ul { margin: 10px 0; padding-left: 20px; }
       select { width: 260px; padding: 3px; }
       select option { width: 260px; padding: 6px; }
       input { width: 250px; padding: 3px; }
        .checkbox-group {
            display: inline-block;
            width: 260px;
            padding: 6px 0;
        }
        .checkbox-group label {
            display: block;
            width: auto;
            padding: 3px 0;
        }
        input[type="checkbox"] {
            width: auto;
            margin-right: 6px;
        }
</style>
    </style>
</head>
<body>
    <?php /** @var array|null $errors @var array $old @var array $customers @var array $rateCards @var array $manifests */ ?>
    <h1>Create Invoice</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/invoices">
        <div>
            <label for="invoice_id">Invoice ID:</label>
            <input id="invoice_id" type="number" name="invoice_id" 
                   value="<?= htmlspecialchars($old['invoice_id'] ?? '', ENT_QUOTES) ?>" required>
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
        <div>
            <label for="rateCard_id">Rate Card:</label>
            <select name="rateCard_id" id="rateCard_id" required>
                <option value="">-- Select Rate Card--</option>
                <?php foreach ($rateCards as $rateCard): ?>
                <option value="<?= htmlspecialchars($rateCard['id']) ?>"
                    <?= (($old['rateCard_id'] ?? '') == $rateCard['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($rateCard['rates']) ?>
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
                        <?= (($old['manifest_id'] ?? '') == $manifest['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($manifest['id']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="income">Income:</label>
            <input id="income" type="number" name="income" 
                   value="<?= htmlspecialchars($old['income'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="expense">Expense:</label>
            <input id="expense" type="number" name="expense" 
                   value="<?= htmlspecialchars($old['expense'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="startDate">Start Date:</label>
            <input id="startDate" type="date" name="startDate" 
                   value="<?= htmlspecialchars($old['startDate'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="endDate">End Date:</label>
            <input id="endDate" type="date" name="endDate" 
                   value="<?= htmlspecialchars($old['endDate'] ?? '', ENT_QUOTES) ?>" required>
        </div>
         <div>
            <label for="status">Status:</label>
            <input id="status" type="text" name="status" 
                   value="<?= htmlspecialchars($old['status'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="paymentStatus">Payment Status:</label>
            <input id="paymentStatus" type="text" name="paymentStatus" 
                   value="<?= htmlspecialchars($old['paymentStatus'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="emailStatus">Email Status:</label>
            <input id="emailStatus" type="text" name="emailStatus" 
                   value="<?= htmlspecialchars($old['emailStatus'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="internalReference">Internal Reference:</label>
            <input id="internalReference" type="text" name="internalReference" 
                   value="<?= htmlspecialchars($old['internalReference'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="externalReference">External Reference:</label>
            <input id="externalReference" type="text" name="externalReference" 
                   value="<?= htmlspecialchars($old['externalReference'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <br>
        <button type="submit">Save</button>
    </form>
    <br>
    <a href="/invoices">Back to List</a>
</body>
</html>
