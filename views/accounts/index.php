<!DOCTYPE html>
<html>
    <head>
        <title>Account</title>
        <style>
            table, th, td {
                border:1px solid black;
                border-collapse: collapse;
                padding: 4px;
            }
        </style>
    </head>
    <body>
        <?php /** @var array $items */ ?>
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div style="color: green; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <h1>Accounts List</h1>

        <a href="/accounts/create">Create an account here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Account Name</th>
                <th>Description</th>
                <th>Display When No Value</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No accounts found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $accounts): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($accounts['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($accounts['account_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($accounts['description']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars((bool)$accounts['display_when_no_value'] ? 'Yes' : 'No') ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/accounts/<?= $accounts['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/accounts/<?= $accounts['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/accounts/<?= $accounts['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete account `<?= htmlspecialchars($accounts['account_name']) ?>`?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
