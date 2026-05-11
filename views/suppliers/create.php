
<!DOCTYPE html>
<html>
<head>
    <title>Create Supplier</title>
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
<?php /** @var array|null $errors @var array $old @var array $rateCards */ ?>
<h1>Create Supplier</h1>
    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<form method="post" action="/suppliers">
    <div>
        <label for="id">ID:</label>
        <input id="id" type="number" name="id"
               value="<?= htmlspecialchars($old['id'] ?? '', ENT_QUOTES) ?>" required>
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
            <label for="companyName">Company Name:</label>
            <input id="companyName" type="text" name="companyName" 
                   value="<?= htmlspecialchars($old['companyName'] ?? '', ENT_QUOTES) ?>" required>
    </div> 
    <div>
            <label for="email">Email:</label>
            <input id="email" type="text" name="email" 
                   value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div>
            <label for="telNo">Telephone Number:</label>
            <input id="telNo" type="text" name="telNo" 
                   value="<?= htmlspecialchars($old['telNo'] ?? '', ENT_QUOTES) ?>" required>
    </div>     
     <div>
            <label for="accountingConnector">Accounting Connector:</label>
            <input id="accountingConnector" type="text" name="accountingConnector" 
                   value="<?= htmlspecialchars($old['accountingConnector'] ?? '', ENT_QUOTES) ?>" required>
    </div>          
    <br>
    <button type="submit">Save</button>
</form>
<br><br>
<a href="/suppliers">Back to List</a>
</body>
</html>
