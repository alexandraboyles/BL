<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Surcharge Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Surcharge Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p>
            <p><b>Fee Category ID: </b><?= htmlspecialchars($item['feeCategory_id']) ?></p>
            <p><b>Surcharge Name: </b><?= htmlspecialchars($item['surcharge_name']) ?></p>
            <p><b>Conditions: </b><?= htmlspecialchars($item['conditions']) ?></p>
            <p><b>Surcharge: </b><?= htmlspecialchars($item['surcharge']) ?></p>
            <p><b>Status: </b><?= htmlspecialchars($item['status']) ?></p>
            <?php else: ?> <!-- If not found -->
            <p>Surcharge not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/surcharges">Back</a> <!-- Back link -->
    </body>
</html>