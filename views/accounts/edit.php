<!DOCTYPE html>
<html>
<head>
    <title>Edit Account</title>
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
    <?php /** @var array|null $errors @var array $item */ ?>
    <h1>Edit Account</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/accounts/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <div>
            <label for="account_name">Account Name:</label>
            <input id="account_name" type="text" name="account_name" 
                   value="<?= htmlspecialchars($item['account_name'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50" placehitemer="Enter description.." required><?= htmlspecialchars($item['description'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
        <div>
            <label for="display_when_no_value">Display When No Value:</label>
            <select id="display_when_no_value" name="display_when_no_value" required>
                <option value="">-- Select --</option>
                <option value="1" <?= (($old['display_when_no_value'] ?? $item['display_when_no_value'] ?? '') == '1' || strtolower($old['display_when_no_value'] ?? $item['display_when_no_value'] ?? '') == 'yes') ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= (($old['display_when_no_value'] ?? $item['display_when_no_value'] ?? '') == '0' || strtolower($old['display_when_no_value'] ?? $item['display_when_no_value'] ?? '') == 'no') ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <br>
        <button type="submit">Update Account</button>
    </form>
    <br>
    <a href="/accounts">Cancel</a>
</body>
</html>

