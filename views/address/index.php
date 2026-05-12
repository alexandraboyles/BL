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
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div style="color: green; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <h1>Addresses List</h1>

        <a href="/addresses/create">Create an address here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>Address ID</th>
                <th>Address Name</th>
                <th>Street 1</th>
                <th>Street 2</th>
                <th>Suburb</th>
                <th>State</th>
                <th>Postcode</th>
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
                    <td style="text-align: left;">
                        <?= htmlspecialchars($address['street_1']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($address['street_2']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($address['suburb']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($address['state']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($address['postcode']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/addresses/<?= $address['address_id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/addresses/<?= $address['address_id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/addresses/<?= $address['address_id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($address['address_id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
