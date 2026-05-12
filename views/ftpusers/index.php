<!DOCTYPE html>
<html>
    <head>
        <title>FTP Users</title>
        <style>
            table, th, td {
                border:1px solid black;
                border-collapse: collapse;
                padding: 4px;
            }
        </style>
    </head>
    <body>
        <?php
        /** @var array $items */
        ?>
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div style="color: green; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <h1>FTP Users List</h1>

        <a href="/ftpusers/create">Create a FTP User here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>FTP User sID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Subdirectory</th>
                <th>Last Login</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="3">No FTP Users found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $ftpUsers): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($ftpUsers['ftpUser_id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($ftpUsers['username']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($ftpUsers['password']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($ftpUsers['subDirectory']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($ftpUsers['lastLogin']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/ftpusers/<?= $ftpUsers['ftpUser_id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/ftpusers/<?= $ftpUsers['ftpUser_id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/ftpusers/<?= $ftpUsers['ftpUser_id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($ftpUsers['ftpUser_id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
