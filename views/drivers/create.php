<!DOCTYPE html>
<html>
<head>
    <title>Create Driver</title>
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
    <h1>Create Driver</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/drivers">
        <div>
            <label for="driver_name">Name:</label>
            <input id="driver_name" type="text" name="driver_name" 
                   value="<?= htmlspecialchars($old['driver_name'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input id="email" type="text" name="email" 
                   value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="is_online">Online:</label>
            <select id="is_online" name="is_online" required>
                <option value="">-- Select --</option>
                <option value="1" <?= (($old['is_online'] ?? '') == '1' || strtolower($old['is_online'] ?? '') == 'yes') ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= (($old['is_online'] ?? '') == '0' || strtolower($old['is_online'] ?? '') == 'no') ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <div>
            <label for="location_access_available">Location Access Available:</label>
            <select id="location_access_available" name="location_access_available" required>
                <option value="">-- Select --</option>
                <option value="1" <?= (($old['location_access_available'] ?? '') == '1' || strtolower($old['location_access_available'] ?? '') == 'yes') ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= (($old['location_access_available'] ?? '') == '0' || strtolower($old['location_access_available'] ?? '') == 'no') ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <br>
        <button type="submit">Save</button>
    </form>
    <br>
    <a href="/drivers">Back to List</a>
</body>
</html>