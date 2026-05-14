
<!DOCTYPE html>
<html>
<head>
    <title>Create Surcharge</title>
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
<?php /** @var array|null $errors @var array $old @var array $feecategories */ ?>
<h1>Create Surcharge</h1>
    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<form method="post" action="/surcharges">
    <div>
        <label for="feeCategory_id">Fee Category:</label>
        <select name="feeCategory_id" id="feeCategory_id" required>
            <option value="">-- Select feeCategory --</option>
            <?php foreach ($feecategories as $feecategory): ?>
                <option value="<?= htmlspecialchars($feecategory['id']) ?>"
                    <?= (($old['feeCategory_id'] ?? '') == $feecategory['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($feecategory['feeCategory_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
            <label for="surcharge_name">Surcharge Name:</label>
            <input id="surcharge_name" type="text" name="surcharge_name" 
                   value="<?= htmlspecialchars($old['surcharge_name'] ?? '', ENT_QUOTES) ?>" required>
    </div>  
    <div>
            <label for="conditions">Conditions:</label>
            <input id="conditions" type="text" name="conditions" 
                   value="<?= htmlspecialchars($old['conditions'] ?? '', ENT_QUOTES) ?>" required>
    </div>  
    <div>
        <label for="surcharge">Surcharge:</label>
        <input id="surcharge" type="text" name="surcharge" 
                value="<?= htmlspecialchars($old['surcharge'] ?? '', ENT_QUOTES) ?>" required>
    </div>   
    <div>
            <label for="status">Status:</label>
            <input id="status" type="text" name="status" 
                   value="<?= htmlspecialchars($old['status'] ?? '', ENT_QUOTES) ?>" required>
    </div>           
    <br>
    <button type="submit">Save</button>
</form>
<br><br>
<a href="/surcharges">Back to List</a>
</body>
</html>
