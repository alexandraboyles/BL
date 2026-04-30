<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Address Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Address Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> <!-- UUID -->
            <p><b>Address ID: </b><?= htmlspecialchars($item['address_id']) ?></p> <!-- Address ID -->
            <p><b>Name: </b><?= htmlspecialchars($item['address_name']) ?></p> <!-- Name -->
            <p><b>Street_1: </b><?= htmlspecialchars($item['street_1']) ?></p> <!-- Street_1 -->
            <p><b>Street_2: </b><?= htmlspecialchars($item['street_2']) ?></p> <!-- Street_2 -->
            <p><b>Suburb: </b><?= htmlspecialchars($item['suburb']) ?></p> <!-- Suburb -->
            <p><b>State: </b><?= htmlspecialchars($item['state']) ?></p> <!-- State -->
            <p><b>Postcode: </b><?= htmlspecialchars($item['postcode']) ?></p> <!-- Postcode -->
        <?php else: ?> <!-- If not found -->
            <p>Address not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/addresses">Back</a> <!-- Back link -->
    </body>
</html>
