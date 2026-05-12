<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Rate Card Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Rate Card Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p>
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p>
            <p><b>Rates: </b><?= htmlspecialchars($item['rates']) ?></p>
            <p><b>Contact Email: </b><?= htmlspecialchars($item['contact_email']) ?></p>
            <?php else: ?> <!-- If not found -->
            <p>Rate Card not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/ratecards">Back</a> <!-- Back link -->
    </body>
</html>