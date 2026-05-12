<!DOCTYPE html>
<html>
<head>
    <title>Create Customer</title>
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
    <h1>Create Customer</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/customers">
        <div>
            <label for="customer_name">Customer Name:</label>
            <input id="customer_name" type="text" name="customer_name" 
                   value="<?= htmlspecialchars($old['customer_name'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="contact_phone">Contact Phone:</label>
            <input id="contact_phone" type="text" name="contact_phone" 
                   value="<?= htmlspecialchars($old['contact_phone'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="contact_email">Contact Email:</label>
            <input id="contact_email" type="text" name="contact_email" 
                   value="<?= htmlspecialchars($old['contact_email'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <br>
        <button type="submit">Save</button>
    </form>
    <br>
    <a href="/customers">Back to List</a>
</body>
</html>