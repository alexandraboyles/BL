<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Address To Delivery Run Mapping Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Address To Delivery Run Mapping Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> <!-- UUID -->
            <p><b>Address Type: </b><?= htmlspecialchars($item['addressType_id']) ?></p> <!-- AddressType ID -->
            <p><b>Address ID: </b><?= htmlspecialchars($item['address_id']) ?></p> <!-- Address ID -->
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p> <!-- Customer ID -->
            <p><b>Product ID: </b><?= htmlspecialchars($item['product_id']) ?></p> <!-- Product ID -->
            <p><b>Delivery Run ID: </b><?= htmlspecialchars($item['deliveryRun_id']) ?></p> <!-- Delivery Run ID -->
            <p><b>Carrier ID: </b><?= htmlspecialchars($item['carrier_id']) ?></p> <!-- Carrier ID -->
            <p><b>Flow Direction ID: </b><?= htmlspecialchars($item['flowDirection_id']) ?></p> <!-- Flow Direction ID -->
        <?php else: ?> <!-- If not found -->
            <p>Address To Delivery Run Mapping not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/addresstodeliveryrunmapping">Back</a> <!-- Back link -->
    </body>
</html>