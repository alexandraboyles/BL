<!DOCTYPE html>
<html>
    <head>
        <title>Delivery Address to Onforwarder Address Mapping</title>
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

        <h1>Delivery Address to Onforwarder Address Mapping List</h1>

        <a href="/deliveryaddresstoonforwarderaddressmapping/create">Create a delivery address to onforwarder address mapping here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Address Name</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="4">No delivery address to onforwarder address mappings found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $deliveryaddresstoonforwarderaddressmapping): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($deliveryaddresstoonforwarderaddressmapping['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($deliveryaddresstoonforwarderaddressmapping['address_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($deliveryaddresstoonforwarderaddressmapping['customer_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($deliveryaddresstoonforwarderaddressmapping['product_name']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/deliveryaddresstoonforwarderaddressmapping/<?= $deliveryaddresstoonforwarderaddressmapping['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/deliveryaddresstoonforwarderaddressmapping/<?= $deliveryaddresstoonforwarderaddressmapping['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/deliveryaddresstoonforwarderaddressmapping/<?= $deliveryaddresstoonforwarderaddressmapping['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($deliveryaddresstoonforwarderaddressmapping['id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
