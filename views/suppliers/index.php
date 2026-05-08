<!DOCTYPE html>
<html>
    <head>
        <title>Supplier</title>
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

        <h1>Suppliers List</h1>

        <a href="/suppliers/create">Create a supplier here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Rate Card</th>
                <th>Company Name</th>
                <th>Email</th>
                <th>Telephone Number</th>
                <th>Accounting Connector</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No suppliers found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $suppliers): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($suppliers['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($suppliers['rateCard_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($suppliers['companyName']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($suppliers['email']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($suppliers['telNo']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($suppliers['accountingConnector']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/suppliers/<?= $suppliers['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/suppliers/<?= $suppliers['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/suppliers/<?= $suppliers['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($suppliers['id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
