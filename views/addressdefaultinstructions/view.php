<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Address Default Instruction Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Address Default Instruction Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> <!-- UUID -->
            <p><b>Address ID: </b><?= htmlspecialchars($item['address_id']) ?></p> <!-- Address ID -->
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p> <!-- Customer ID -->
            <p><b>Delivery Instruction: </b><?= htmlspecialchars($item['deliveryInstruction']) ?></p> <!-- Delivery Instruction -->
            <p><b>Packing Instruction: </b><?= htmlspecialchars($item['packingInstruction']) ?></p> <!-- Packing Instruction -->
        <?php else: ?> <!-- If not found -->
            <p>Address default instruction not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/addressdefaultinstructions">Back</a> <!-- Back link -->
    </body>
</html>
