<!DOCTYPE html>
<html>
    <head>
        <title>Rate Card</title>
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

        <h1>Rate Cards List</h1>

        <a href="/ratecards/create">Create a rate card here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Rates</th>
                <th>Contact Email</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No rate cards found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $ratecards): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($ratecards['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($ratecards['customer_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($ratecards['rates']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($ratecards['contact_email']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/ratecards/<?= $ratecards['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/ratecards/<?= $ratecards['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/ratecards/<?= $ratecards['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete <?= htmlspecialchars($ratecards['rates']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
