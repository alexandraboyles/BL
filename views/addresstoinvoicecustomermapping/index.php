<!DOCTYPE html>
<html>
    <head>
        <title>Address To Invoice Customer Mapping</title>
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

        <h1>Address To Invoice Customer Mapping List</h1>

        <a href="/addresstoinvoicecustomermapping/create">Create an address to invoice customer mapping here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Address Name</th>
                <th>Customer Name</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="3">No address strings found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $addresstoinvoicecustomermapping): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($addresstoinvoicecustomermapping['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addresstoinvoicecustomermapping['address_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addresstoinvoicecustomermapping['customer_name']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/addresstoinvoicecustomermapping/<?= $addresstoinvoicecustomermapping['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/addresstoinvoicecustomermapping/<?= $addresstoinvoicecustomermapping['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/addresstoinvoicecustomermapping/<?= $addresstoinvoicecustomermapping['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($addresstoinvoicecustomermapping['id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
