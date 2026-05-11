<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Invoice Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Invoice Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> <!-- UUID -->
            <p><b>Invoice ID: </b><?= htmlspecialchars($item['invoice_id']) ?></p> <!-- Invoice ID -->
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p> <!-- Customer ID -->
            <p><b>Rate Card ID: </b><?= htmlspecialchars($item['rateCard_id']) ?></p> <!-- Rate Card ID -->
            <p><b>Manifest ID: </b><?= htmlspecialchars($item['manifest_id']) ?></p> <!-- Manifest ID -->
            <p><b>Income: </b><?= htmlspecialchars($item['income']) ?></p> <!-- Income -->
            <p><b>Expense: </b><?= htmlspecialchars($item['expense']) ?></p> <!-- Expense -->
            <p><b>Start Date: </b><?= htmlspecialchars($item['startDate']) ?></p> <!-- Start Date -->
            <p><b>End Date: </b><?= htmlspecialchars($item['endDate']) ?></p> <!-- End Date -->
            <p><b>Status: </b><?= htmlspecialchars($item['status']) ?></p> <!-- Status -->
            <p><b>Payment Status: </b><?= htmlspecialchars($item['paymentStatus']) ?></p> <!-- Payment Status -->
            <p><b>Email Status: </b><?= htmlspecialchars($item['emailStatus']) ?></p> <!-- Email Status -->
            <p><b>Internal Reference: </b><?= htmlspecialchars($item['internalReference']) ?></p> <!-- Internal Reference -->
            <p><b>External Reference: </b><?= htmlspecialchars($item['externalReference']) ?></p> <!-- External Reference -->
        <?php else: ?> <!-- If not found -->
            <p>Invoice not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/invoices">Back</a> <!-- Back link -->
    </body>
</html>