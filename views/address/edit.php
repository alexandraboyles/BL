<!DOCTYPE html>
<html>
    <head>
        <title>Edit Address</title>
        <style>
        label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
        .error { color: red; }
        ul { margin: 10px 0; padding-left: 20px; }
        input { width: 250px; padding: 3px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        /** @var array|null $errors */
        ?>
        <h1>Edit Address</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/addresses/<?= htmlspecialchars($item['address_id'], ENT_QUOTES) ?>">
            <div>
                <label for="address_id">Address ID:</label>
                <input id="address_id" type="number" name="address_id" value="<?= htmlspecialchars($item['address_id'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="address_name">Address Name:</label>
                <input id="address_name" type="text" name="address_name" value="<?= htmlspecialchars($item['address_name'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="street_1">Street 1:</label>
                <input id="street_1" type="text" name="street_1" value="<?= htmlspecialchars($item['street_1'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="street_2">Street 2:</label>
                <input id="street_2" type="text" name="street_2" value="<?= htmlspecialchars($item['street_2'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="suburb">Suburb:</label>
                <input id="suburb" type="text" name="suburb" value="<?= htmlspecialchars($item['suburb'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="state">State:</label>
                <input id="state" type="text" name="state" value="<?= htmlspecialchars($item['state'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="postcode">Postcode:</label>
                <input id="postcode" type="number" name="postcode" value="<?= htmlspecialchars($item['postcode'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <br>
            <button type="submit">Update Address</button>
            <br><br>
            <a href="/addresses">Cancel</a>
        </form>
    </body>
</html>
