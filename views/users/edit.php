<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
       label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
       .error { color: red; }
       ul { margin: 10px 0; padding-left: 20px; }
       select { width: 260px; padding: 3px; }
       select option { width: 260px; padding: 6px; }
       input { width: 250px; padding: 3px; }
       .checkbox-group {
            display: inline-block;
            width: 260px;
            padding: 6px 0;
        }
        .checkbox-group label {
            display: block;
            width: auto;
            padding: 3px 0;
        }
        input[type="checkbox"] {
            width: auto;
            margin-right: 6px;
        }
    </style>
</head>
<body>
    <?php /** @var array|null $errors @var array $item @var array $customers @var array $roles @var array $warehouses */ ?>
    <h1>Edit User</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/users/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <div>
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= htmlspecialchars($customer['id']) ?>"
                        <?= (($old['customer_id'] ?? $item['customer_id'] ?? '') == $customer['id']) ? 'selected' : '' ?> >
                        <?= htmlspecialchars($customer['customer_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="fullName">Full Name:</label>
            <input id="fullName" type="text" name="fullName" 
                   value="<?= htmlspecialchars($item['fullName'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input id="email" type="text" name="email" 
                   value="<?= htmlspecialchars($item['email'] ?? '', ENT_QUOTES) ?>">
        </div>
        <div>
            <label>Roles:</label>
            <div class="checkbox-group">
                <?php
                $selectedRoles = $old['roles_id'] ?? $item['roles_id'] ?? [];
                ?>
                <?php foreach ($roles as $role): ?>
                    <label>
                        <input type="checkbox"
                            name="roles_id[]"
                            value="<?= htmlspecialchars($role['id']) ?>"
                            <?= in_array($role['id'], $selectedRoles) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($role['role_name']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        <div>
            <label for="warehouses_id">Warehouses:</label>
            <select name="warehouses_id" id="warehouses_id" required>
                <option value="">-- Select Warehouse --</option>
                <?php foreach ($warehouses as $warehouse): ?>
                    <option value="<?= htmlspecialchars($warehouse['id']) ?>"
                        <?= (($old['warehouses_id'] ?? $item['warehouses_id'] ?? '') == $warehouse['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($warehouse['warehouse']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
         <div>
            <label for="mfa">MFA:</label>
            <input id="mfa" type="text" name="mfa" 
                   value="<?= htmlspecialchars($item['mfa'] ?? '', ENT_QUOTES) ?>" required>
        </div>
         <div>
            <label for="is_email_verified">Email Verified:</label>
            <select id="is_email_verified" name="is_email_verified" required>
                <option value="">-- Select --</option>
                <option value="1" <?= (($old['is_email_verified'] ?? $item['is_email_verified'] ?? '') == '1' || strtolower($old['is_email_verified'] ?? $item['is_email_verified'] ?? '') == 'yes') ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= (($old['is_email_verified'] ?? $item['is_email_verified'] ?? '') == '0' || strtolower($old['is_email_verified'] ?? $item['is_email_verified'] ?? '') == 'no') ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <br>
        <button type="submit">Update User</button>
    </form>
    <br>
    <a href="/users">Cancel</a>
</body>
</html>