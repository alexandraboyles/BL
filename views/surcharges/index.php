<!DOCTYPE html>
<html>
    <head>
        <title>Surcharge</title>
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

        <h1>Surcharges List</h1>

        <a href="/surcharges/create">Create a surcharge here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Fee Category Name</th>
                <th>Surcharge Name</th>
                <th>Conditions</th>
                <th>Surcharge</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No surcharges found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $surcharges): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($surcharges['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($surcharges['feeCategory_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($surcharges['surcharge_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($surcharges['conditions']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($surcharges['surcharge']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($surcharges['status']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/surcharges/<?= $surcharges['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/surcharges/<?= $surcharges['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/surcharges/<?= $surcharges['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete <?= htmlspecialchars($surcharges['surcharge_name']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
