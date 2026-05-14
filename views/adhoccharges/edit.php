<!DOCTYPE html>
<html>
    <head>
        <title>Edit Adhoc Charge</title>
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
        ?>
        <h1>Edit Adhoc Charge</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/adhoccharges/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <div>
            <label for="id">ID:</label>
            <input id="id" type="number" name="id"
                value="<?= htmlspecialchars($item['id'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="adhocCharge_name">Adhoc Charge Name:</label>
            <input id="adhocCharge_name" type="text" name="adhocCharge_name" 
                    value="<?= htmlspecialchars($item['adhocCharge_name'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="chargeStructure">Charge Structure:</label>
            <input id="chargeStructure" type="text" name="chargeStructure" 
                    value="<?= htmlspecialchars($item['chargeStructure'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="rate">Rate:</label>
            <input id="rate" type="text" name="rate" 
                    value="<?= htmlspecialchars($item['rate'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="descriptionTemplate">Description Template:</label>
            <input id="descriptionTemplate" type="text" name="descriptionTemplate" 
                    value="<?= htmlspecialchars($item['descriptionTemplate'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="is_enabled">Is Enabled:</label>
            <select id="is_enabled" name="is_enabled" required>
                <option value="">-- Select --</option>
                <option value="1" <?= (($old['is_enabled'] ?? $item['is_enabled'] ?? '') == '1' || strtolower($old['is_enabled'] ?? $item['is_enabled'] ?? '') == 'yes') ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= (($old['is_enabled'] ?? $item['is_enabled'] ?? '') == '0' || strtolower($old['is_enabled'] ?? $item['is_enabled'] ?? '') == 'no') ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <div>
            <label for="pageVisionOn">Page Vision On:</label>
            <input id="pageVisionOn" type="text" name="pageVisionOn" 
                    value="<?= htmlspecialchars($item['pageVisionOn'] ?? '', ENT_QUOTES) ?>" required>
        </div>
            <br>
            <button type="submit">Update Adhoc Charge</button>
            <br><br>
            <a href="/adhoccharges">Cancel</a>
        </form>
    </body>
</html>