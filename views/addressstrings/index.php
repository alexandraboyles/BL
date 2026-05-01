<!DOCTYPE html>
<html>
    <head>
        <title>Address Strings</title>
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

        <h1>Address Strings List</h1>

        <a href="/addressstrings/create">Create an address strings here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Address Name</th>
                <th>Customer Name</th>
                <th>Text</th>
                <th>Date Added</th>
                <th>Date Modified</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="6">No address strings found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $addressstring): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($addressstring['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addressstring['address_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addressstring['customer_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addressstring['text']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($addressstring['dateAdded']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($addressstring['lastModified']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/addressstrings/<?= $addressstring['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/addressstrings/<?= $addressstring['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/addressstrings/<?= $addressstring['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($addressstring['id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
