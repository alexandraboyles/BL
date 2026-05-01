<!DOCTYPE html>
<html>
    <head>
        <title>Address To Delivery Run Mapping</title>
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

        <h1>Address To Delivery Run Mapping List</h1>

        <a href="/addresstodeliveryrunmapping/create">Create an address to delivery run mapping here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Address Type</th>
                <th>Address Name</th>
                <th>Customer Name</th>
                <th>Product Title</th>
                <th>Delivery Run Name</th>
                <th>Carrier Name</th>
                <th>Flow Direction</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No address to delivery run mapping found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $addresstodeliveryrunmapping): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($addresstodeliveryrunmapping['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addresstodeliveryrunmapping['addressType_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addresstodeliveryrunmapping['address_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addresstodeliveryrunmapping['customer_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addresstodeliveryrunmapping['product_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addresstodeliveryrunmapping['deliveryRun_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addresstodeliveryrunmapping['carrier_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addresstodeliveryrunmapping['flow_direction']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/addresstodeliveryrunmapping/<?= $addresstodeliveryrunmapping['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/addresstodeliveryrunmapping/<?= $addresstodeliveryrunmapping['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/addresstodeliveryrunmapping/<?= $addresstodeliveryrunmapping['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($addresstodeliveryrunmapping['id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
