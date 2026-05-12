<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Document Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Document Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p>
            <p><b>Sale Order ID: </b><?= htmlspecialchars($item['saleOrder_id']) ?></p>
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id'] ?? 'N/A') ?></p>
            <p><b>Consignment ID: </b><?= htmlspecialchars($item['consignment_id']) ?></p>
            <p><b>File Type: </b><?= htmlspecialchars($item['fileType']) ?></p>
            <?php else: ?> <!-- If not found -->
            <p>Document not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/documents">Back</a> <!-- Back link -->
    </body>
</html>