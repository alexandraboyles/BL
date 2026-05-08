<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Supplier Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Supplier Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> <!-- UUID -->
            <p><b>Rate Card ID: </b><?= htmlspecialchars($item['rateCard_id']) ?></p> <!-- Rate Card ID -->
            <p><b>Company Name: </b><?= htmlspecialchars($item['companyName']) ?></p> <!-- Company Name -->
            <p><b>Email: </b><?= htmlspecialchars($item['email']) ?></p> <!-- Email -->
            <p><b>Telephone Number: </b><?= htmlspecialchars($item['telNo']) ?></p> <!-- Telephone Number -->
            <p><b>Accounting Connector: </b><?= htmlspecialchars($item['accountingConnector']) ?></p> <!-- Accounting Connector -->
        <?php else: ?> <!-- If not found -->
            <p>Supplier not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/suppliers">Back</a> <!-- Back link -->
    </body>
</html>