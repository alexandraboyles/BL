<!DOCTYPE html>
<html>
<head>
    <title>Create Address</title>
    <style>
        label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
        .error { color: red; }
        ul { margin: 10px 0; padding-left: 20px; }
        input { width: 250px; padding: 3px; }
    </style>
</head>
<body>
    <?php /** @var array|null $errors @var array $old */ ?>
    <h1>Create Address</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/addresses">
        <div>
            <label for="address_id">ID:</label>
            <input id="address_id" type="number" name="address_id"
                   value="<?= htmlspecialchars($old['address_id'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="address_name">Name:</label>
            <input id="address_name" type="text" name="address_name" 
                   value="<?= htmlspecialchars($old['address_name'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="street_1">Street 1:</label>
            <input id="street_1" type="text" name="street_1" 
                   value="<?= htmlspecialchars($old['street_1'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="street_2">Street 2:</label>
            <input id="street_2" type="text" name="street_2" 
                   value="<?= htmlspecialchars($old['street_2'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div>
            <label for="suburb">Suburb:</label>
            <input id="suburb" type="text" name="suburb" 
                   value="<?= htmlspecialchars($old['suburb'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="state">State:</label>
            <input id="state" type="text" name="state" 
                   value="<?= htmlspecialchars($old['state'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="postcode">Postcode:</label>
            <input id="postcode" type="number" name="postcode" 
                   value="<?= htmlspecialchars($old['postcode'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <br>
        <button type="submit">Save</button>
    </form>
    <br>
    <a href="/addresses">Back to List</a>
</body>
</html>