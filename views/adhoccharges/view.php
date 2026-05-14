<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Adhoc Charge Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Adhoc Charge Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> 
            <p><b>Adhoc Charge Name: </b><?= htmlspecialchars($item['adhocCharge_name']) ?></p> 
            <p><b>Charge Structure: </b><?= htmlspecialchars($item['chargeStructure']) ?></p> 
            <p><b>Rate: </b><?= htmlspecialchars($item['rate']) ?></p> 
            <p><b>Description Template: </b><?= htmlspecialchars($item['descriptionTemplate']) ?></p> 
            <p><b>Is Enabled: </b><?= htmlspecialchars($item['is_enabled']) ?></p> 
            <p><b>Page Vision On: </b><?= htmlspecialchars($item['pageVisionOn']) ?></p> 
        <?php else: ?> <!-- If not found -->
            <p>Adhoc Charge not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/adhoccharges">Back</a> <!-- Back link -->
    </body>
</html>