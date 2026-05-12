<!DOCTYPE html>
<html>
    <head>
        <title>Edit Rate Card</title>
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
        /** @var array|null $errors @var array $customers */
        ?>
        <h1>Edit Rate Card</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/ratecards/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
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
                    <label for="rates">Rates:</label>
                    <input id="rates" type="text" name="rates" 
                        value="<?= htmlspecialchars($item['rates'] ?? '', ENT_QUOTES) ?>" required>
            </div>  
            <div>
                    <label for="contact_email">Contact Email:</label>
                    <input id="contact_email" type="text" name="contact_email" 
                        value="<?= htmlspecialchars($item['contact_email'] ?? '', ENT_QUOTES) ?>" required>
            </div>       
            <br>
            <button type="submit">Update Rate Card</button>
            <br><br>
            <a href="/ratecards">Cancel</a>
        </form>
    </body>
</html>