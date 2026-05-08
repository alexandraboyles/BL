<!DOCTYPE html>
<html>
<head>
    <title>Create FTP User</title>
    <style>
        label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
        .error { color: red; }
        ul { margin: 10px 0; padding-left: 20px; }
        input { width: 250px; padding: 3px; }
    </style>
</head>
<body>
    <?php /** @var array|null $errors @var array $old */ ?>
    <h1>Create FTP User</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/ftpusers">
        <div>
            <label for="ftpUser_id">ID:</label>
            <input id="ftpUser_id" type="number" name="ftpUser_id"
                   value="<?= htmlspecialchars($old['ftpUser_id'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="username">Username:</label>
            <input id="username" type="text" name="username" 
                   value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input id="password" type="text" name="password" 
                   value="<?= htmlspecialchars($old['password'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="subDirectory">Subdirectory:</label>
            <input id="subDirectory" type="text" name="subDirectory" 
                   value="<?= htmlspecialchars($old['subDirectory'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <br>
        <button type="submit">Save</button>
    </form>
    <br>
    <a href="/ftpusers">Back to List</a>
</body>
</html>