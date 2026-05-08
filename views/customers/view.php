<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Customer Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php /** @var array $item */?>
        <h1>Customer Detail</h1> <!-- Heading -->

        <?php if ($item): ?>
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p>
            <p><b>Name: </b><?= htmlspecialchars($item['customer_name']) ?></p>
            <p><b>Phone: </b><?= htmlspecialchars($item['contact_phone']) ?></p>
            <p><b>Email: </b><?= htmlspecialchars($item['contact_email']) ?></p>
        <?php else: ?>
            <p>Customer not found</p>
        <?php endif; ?>
        
        <a href="/customers">Back</a> <!-- Back link -->
    </body>
</html>
