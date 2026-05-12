<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
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
    <h1>Edit Customer</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/customers/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <div>
            <label for="customer_name">Customer Name:</label>
            <input id="customer_name" type="text" name="customer_name" 
                   value="<?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="contact_phone">Contact Phone:</label>
            <input id="contact_phone" type="text" name="contact_phone" 
                   value="<?= htmlspecialchars($item['contact_phone'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="contact_email">Contact Email:</label>
            <input id="contact_email" type="text" name="contact_email" 
                   value="<?= htmlspecialchars($item['contact_email'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <br>
        <button type="submit">Update customer</button>
    </form>
    <br>
    <a href="/customers">Cancel</a>
</body>
</html>

