<!DOCTYPE html>
<html>
<head>
    <title>Create Fee Category</title>
    <style>
        label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
        .error { color: red; }
        ul { margin: 10px 0; padding-left: 20px; }
        input { width: 250px; padding: 3px; }
        select { width: 260px; padding: 3px; }
        select option { width: 260px; padding: 6px; }
    </style>
</head>
<body>
    <?php /** @var array|null $errors @var array $old */ ?>
    <h1>Create Fee Category</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/feecategories">
        <div>
            <label for="id">ID:</label>
            <input id="id" type="number" name="id" 
                   value="<?= htmlspecialchars($old['id'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="appliesTo">Applies To:</label>
            <input id="appliesTo" type="text" name="appliesTo" 
                   value="<?= htmlspecialchars($old['appliesTo'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="account">Account:</label>
            <input id="account" type="text" name="account" 
                   value="<?= htmlspecialchars($old['account'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="feeCategory_name">Fee Category Name:</label>
            <input id="feeCategory_name" type="text" name="feeCategory_name" 
                   value="<?= htmlspecialchars($old['feeCategory_name'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="counts_toward_minimum_charges">Counts Toward Minimum Charges:</label>
            <select id="counts_toward_minimum_charges" name="counts_toward_minimum_charges" required>
                <option value="">-- Select --</option>
                <option value="1" <?= (($old['counts_toward_minimum_charges'] ?? '') == '1' || strtolower($old['counts_toward_minimum_charges'] ?? '') == 'yes') ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= (($old['counts_toward_minimum_charges'] ?? '') == '0' || strtolower($old['counts_toward_minimum_charges'] ?? '') == 'no') ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <div>
            <label for="is_name_editable">Name Editable:</label>
            <select id="is_name_editable" name="is_name_editable" required>
                <option value="">-- Select --</option>
                <option value="1" <?= (($old['is_name_editable'] ?? '') == '1' || strtolower($old['is_name_editable'] ?? '') == 'yes') ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= (($old['is_name_editable'] ?? '') == '0' || strtolower($old['is_name_editable'] ?? '') == 'no') ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <br>
        <button type="submit">Save</button>
    </form>
    <br>
    <a href="/feecategories">Back to List</a>
</body>
</html>