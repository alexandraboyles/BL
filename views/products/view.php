<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Product Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Product Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>UUID: </b><?= htmlspecialchars($item['id']) ?></p> 
            <p><b>Product ID: </b><?= htmlspecialchars($item['product_id']) ?></p> 
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p> 
            <p><b>Title: </b><?= htmlspecialchars($item['title']) ?></p> 
            <p><b>Description: </b><?= htmlspecialchars($item['description']) ?></p> 
            <p><b>SKU: </b><?= htmlspecialchars($item['sku']) ?></p>
            <p><b>Order Date: </b><?= htmlspecialchars($item['orderDate']) ?></p> 
            <p><b>Unit of Measure: </b><?= htmlspecialchars($item['unitOfMeasure']) ?></p> 
            <p><b>Width: </b><?= htmlspecialchars($item['width']) ?></p> 
            <p><b>Length: </b><?= htmlspecialchars($item['length']) ?></p> 
            <p><b>Height: </b><?= htmlspecialchars($item['height']) ?></p> 
            <p><b>Weight: </b><?= htmlspecialchars($item['weight']) ?></p> 
        <?php else: ?> <!-- If not found -->
            <p>Product not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/products">Back</a> <!-- Back link -->
    </body>
</html>