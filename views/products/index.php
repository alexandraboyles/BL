<!DOCTYPE html>
<html>
    <head>
        <title>Product</title>
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

        <h1>Products List</h1>

        <a href="/products/create">Create a product here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>Product ID</th>
                <th>Customer Name</th>
                <th>Title</th>
                <th>Description</th>
                <th>SKU</th>
                <th>Order Date</th>
                <th>Unit Of Measure</th>
                <th>Width</th>
                <th>Length</th>
                <th>Height</th>
                <th>Weight</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No Products found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $products): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($products['product_id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($products['customer_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($products['title']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($products['description']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($products['sku']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($products['orderDate']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($products['unitOfMeasure']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($products['width']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($products['length']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($products['height']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($products['weight']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/products/<?= $products['product_id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/products/<?= $products['product_id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/products/<?= $products['product_id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($products['product_id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
