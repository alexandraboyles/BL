<!DOCTYPE html>
<html>
    <head>
        <title>Edit Contact</title>
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
        /** @var array $customers */
        ?>
        <h1>Edit Contact</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/contacts/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
            <div>
                <label for="customer_id">Customer:</label>
                <select name="customer_id" id="customer_id" required>
                    <option value="">-- Select Customer --</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= htmlspecialchars($customer['id']) ?>"
                            <?= (($item['customer_id'] ?? '') == $customer['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($customer['customer_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="contact_name">Contact Name:</label>
                <input id="contact_name" type="text" name="contact_name" 
                    value="<?= htmlspecialchars($item['contact_name'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input id="email" type="text" name="email" 
                    value="<?= htmlspecialchars($item['email'] ?? '', ENT_QUOTES) ?>">
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input id="phone" type="text" name="phone" 
                    value="<?= htmlspecialchars($item['phone'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <br>
            <button type="submit">Update Address</button>
            <br><br>
            <a href="/contacts">Cancel</a>
        </form>
    </body>
</html>
