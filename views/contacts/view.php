<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Contact Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Contact Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> <!-- UUID -->
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p> <!-- Contact ID -->
            <p><b>Contact Name: </b><?= htmlspecialchars($item['contact_name']) ?></p> <!-- Contact Name -->
            <p><b>Email: </b><?= htmlspecialchars($item['email']) ?></p> <!-- Email -->
            <p><b>Phone: </b><?= htmlspecialchars($item['phone']) ?></p> <!-- Phone -->
        <?php else: ?> <!-- If not found -->
            <p>Contact not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/contacts">Back</a> <!-- Back link -->
    </body>
</html>
