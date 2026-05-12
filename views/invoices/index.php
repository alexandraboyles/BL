<!DOCTYPE html>
<html>
    <head>
        <title>Invoice</title>
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

        <h1>Invoices List</h1>

        <a href="/invoices/create">Create an invoice here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>Invoice ID</th>
                <th>Customer Name</th>
                <th>Rate Card Name</th>
                <th>Manifest ID</th>
                <th>Income</th>
                <th>Expense</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Email Status</th>
                <th>Internal Reference</th>
                <th>External Reference</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No Invoices found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $invoices): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($invoices['invoice_id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($invoices['customer_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($invoices['rateCard_name']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($invoices['manifest_id']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($invoices['income']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($invoices['expense']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($invoices['startDate']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($invoices['endDate']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($invoices['status']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($invoices['paymentStatus']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($invoices['emailStatus']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($invoices['internalReference']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($invoices['externalReference']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/invoices/<?= $invoices['invoice_id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/invoices/<?= $invoices['invoice_id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/invoices/<?= $invoices['invoice_id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($invoices['invoice_id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
