<!DOCTYPE html>
<html>
    <head>
        <title>Document</title>
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

        <h1>Documents List</h1>

        <a href="/documents/create">Create a document here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Sale Order ID</th>
                <th>Customer Name</th>
                <th>Consignment ID</th>
                <th>File Type</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="3">No documents found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $documents): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($documents['id']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($documents['saleOrder_human_id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($documents['customer_name'] ?? 'N/A') ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($documents['consignment_human_id']) ?>
                    </td>
                        <td style="text-align: left;">
                        <?= htmlspecialchars($documents['fileType']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/documents/<?= $documents['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/documents/<?= $documents['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/documents/<?= $documents['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($documents['id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
