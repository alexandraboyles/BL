<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Delivery Address to Onforwarder Address Mapping Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Delivery Address to Onforwarder Address Mapping Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> <!-- UUID -->
            <p><b>Address ID: </b><?= htmlspecialchars($item['address_id']) ?></p> <!-- Address ID -->
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p> <!-- Customer ID -->
            <p><b>Product ID: </b><?= htmlspecialchars($item['product_id']) ?></p> <!-- Product ID -->
        <?php else: ?> <!-- If not found -->
            <p>Delivery Address to Onforwarder Address Mapping not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/deliveryaddresstoonforwarderaddressmapping">Back</a> <!-- Back link -->
    </body>
</html>