<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Parser Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Parser Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p>
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p>
            <p><b>Parser Name: </b><?= htmlspecialchars($item['parser_name']) ?></p>
            <p><b>Class Name: </b><?= htmlspecialchars($item['className']) ?></p>
            <p><b>Class: </b><?= htmlspecialchars($item['class']) ?></p>
            <p><b>Type: </b><?= htmlspecialchars($item['type']) ?></p>
            <p><b>Accepted File Types: </b><?= htmlspecialchars($item['acceptedFileTypes']) ?></p>
            <p><b>To Address: </b><?= htmlspecialchars($item['toAddress']) ?></p>
            <?php else: ?> <!-- If not found -->
            <p>Parser not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/parsers">Back</a> <!-- Back link -->
    </body>
</html>