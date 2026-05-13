<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Bill Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Bill Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> 
            <p><b>Supplier ID: </b><?= htmlspecialchars($item['supplier_id']) ?></p> 
            <p><b>Invoice ID: </b><?= htmlspecialchars($item['invoice_id']) ?></p>
            <p><b>Manifest ID: </b><?= htmlspecialchars($item['manifest_id']) ?></p> 
        <?php else: ?> <!-- If not found -->
            <p>Bill not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/bills">Back</a> <!-- Back link -->
    </body>
</html>
