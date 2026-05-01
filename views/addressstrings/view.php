<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Address String Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Address String Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> <!-- UUID -->
            <p><b>Address ID: </b><?= htmlspecialchars($item['address_id']) ?></p> <!-- Address ID -->
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p> <!-- Customer ID -->
            <p><b>Text: </b><?= htmlspecialchars($item['text']) ?></p> <!-- Text -->
            <p><b>Date Added: </b><?= htmlspecialchars($item['dateAdded']) ?></p> <!-- Date Added -->
            <p><b>Date Modified: </b><?= htmlspecialchars($item['lastModified']) ?></p> <!-- Date Modified -->
        <?php else: ?> <!-- If not found -->
            <p>Address String not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/addressstrings">Back</a> <!-- Back link -->
    </body>
</html>