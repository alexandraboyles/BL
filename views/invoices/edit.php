
<!DOCTYPE html>
<html>
<head>
    <title>Edit Invoice</title>
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
<?php /** @var array|null $errors @var array $item @var array $customers @var array $rateCards @var array $manifests @var array $old */ ?>
<h1>Edit Invoice</h1>
    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<form method="post" action="/invoices/<?= htmlspecialchars($item['invoice_id'], ENT_QUOTES) ?>">
     <div>
            <label for="invoice_id">ID:</label>
            <input id="invoice_id" type="number" name="invoice_id" 
                   value="<?= htmlspecialchars($item['invoice_id'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($customers as $customer): ?>
                    <?php 
                        $selected = '';
                        $val = $old['customer_id'] ?? $item['customer_id'] ?? '';
                        if ($val == $customer['id']) $selected = 'selected';
                    ?>
                    <option value="<?= htmlspecialchars($customer['id']) ?>" <?= $selected ?>>
                        <?= htmlspecialchars($customer['customer_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
         <div>
            <label for="rateCard_id">Rate Card:</label>
            <select name="rateCard_id" id="rateCard_id" required>
                <option value="">-- Select Rate Card --</option>
                <?php foreach ($rateCards as $ratecard): ?>
                    <?php 
                        $selected = '';
                        $val = $old['rateCard_id'] ?? $item['rateCard_id'] ?? '';
                        if ($val == $ratecard['id']) $selected = 'selected';
                    ?>
                    <option value="<?= htmlspecialchars($ratecard['id']) ?>" <?= $selected ?>>
                        <?= htmlspecialchars($ratecard['rates']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="manifest_id">Manifest:</label>
            <select name="manifest_id" id="manifest_id" required>
                <option value="">-- Select Manifest --</option>
                <?php foreach ($manifests as $manifest): ?>
                    <?php 
                        $selected = '';
                        $val = $old['manifest_id'] ?? $item['manifest_id'] ?? '';
                        if ($val == $manifest['id']) $selected = 'selected';
                    ?>
                    <option value="<?= htmlspecialchars($manifest['id']) ?>" <?= $selected ?>>
                        <?= htmlspecialchars($manifest['id']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="income">Income:</label>
            <input id="income" type="number" name="income" 
                   value="<?= htmlspecialchars($item['income'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="expense">Expense:</label>
            <input id="expense" type="number" name="expense" 
                   value="<?= htmlspecialchars($item['expense'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="startDate">Start Date:</label>
            <input id="startDate" type="date" name="startDate" 
                   value="<?= htmlspecialchars($item['startDate'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="endDate">End Date:</label>
            <input id="endDate" type="date" name="endDate" 
                   value="<?= htmlspecialchars($item['endDate'] ?? '', ENT_QUOTES) ?>" required>
        </div>
         <div>
            <label for="status">Status:</label>
            <input id="status" type="text" name="status" 
                   value="<?= htmlspecialchars($item['status'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="pamentStatus">Payment Status:</label>
            <input id="paymentStatus" type="text" name="paymentStatus" 
                   value="<?= htmlspecialchars($item['paymentStatus'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="emailStatus">Email Status:</label>
            <input id="emailStatus" type="text" name="emailStatus" 
                   value="<?= htmlspecialchars($item['emailStatus'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="internalReference">Internal Reference:</label>
            <input id="internalReference" type="text" name="internalReference" 
                   value="<?= htmlspecialchars($item['internalReference'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="externalReference">External Reference:</label>
            <input id="externalReference" type="text" name="externalReference" 
                   value="<?= htmlspecialchars($item['externalReference'] ?? '', ENT_QUOTES) ?>" required>
        </div>
            <br>
            <button type="submit">Update Invoice</button>
            <br><br>
            <a href="/invoices">Cancel</a>
        </form>
    </body>
</html>
