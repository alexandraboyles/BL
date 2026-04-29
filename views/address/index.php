<!DOCTYPE html>
<html>
    <head>
        <title>Addresses</title>
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
        <h1>Addresses List</h1>

        <a href="/addresses/create">Create an address here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Address Name</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="3">No addresses found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $address): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($address['address_id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($address['address_name']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/addresses/<?= $address['address_id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/addresses/<?= $address['address_id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/addresses/<?= $address['address_id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete <?= htmlspecialchars($address['address_name']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
