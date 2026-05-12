<!DOCTYPE html>
<html>
    <head>
        <title>Edit FTP User</title>
        <style>
        label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
        .error { color: red; }
        ul { margin: 10px 0; padding-left: 20px; }
        input { width: 250px; padding: 3px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        /** @var array|null $errors */
        ?>
        <h1>Edit FTP User</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/ftpusers/<?= htmlspecialchars($item['ftpUser_id'], ENT_QUOTES) ?>">
            <div>
                <label for="ftpUser_id">FTP User ID:</label>
                <input id="ftpUser_id" type="number" name="ftpUser_id" value="<?= htmlspecialchars($item['ftpUser_id'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="username">Username:</label>
                <input id="username" type="text" name="username" value="<?= htmlspecialchars($item['username'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="text" name="password" value="<?= htmlspecialchars($item['password'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="subDirectory">Subdirectory:</label>
                <input id="subDirectory" type="text" name="subDirectory" value="<?= htmlspecialchars($item['subDirectory'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <br>
            <button type="submit">Update FTP User</button>
            <br><br>
            <a href="/ftpusers">Cancel</a>
        </form>
    </body>
</html>
