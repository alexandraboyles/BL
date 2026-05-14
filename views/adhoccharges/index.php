<!DOCTYPE html>
<html>
    <head>
        <title>Adhoc Charge</title>
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

        <h1>Adhoc Charges List</h1>

        <a href="/adhoccharges/create">Create an adhoc charge here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Adhoc Charge Name</th>
                <th>Charge Structure</th>
                <th>Rate</th>
                <th>Description Template</th>
                <th>Is Enabled</th>
                <th>Page Vision On</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="6">No Adhoc Charges found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $adhoccharges): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($adhoccharges['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($adhoccharges['adhocCharge_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($adhoccharges['chargeStructure']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($adhoccharges['rate']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($adhoccharges['descriptionTemplate']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($adhoccharges['is_enabled']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($adhoccharges['pageVisionOn']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/adhoccharges/<?= $adhoccharges['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/adhoccharges/<?= $adhoccharges['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/adhoccharges/<?= $adhoccharges['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($adhoccharges['id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
