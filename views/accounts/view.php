<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Account Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php /** @var array $item */?>
        <h1>Account Detail</h1> <!-- Heading -->

        <?php if ($item): ?>
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p>
            <p><b>Account Name: </b><?= htmlspecialchars($item['account_name']) ?></p>
            <p><b>Description: </b><?= htmlspecialchars($item['description']) ?></p>
            <p><b>Display When No Value: </b><?= htmlspecialchars($item['display_when_no_value']) ?></p>
        <?php else: ?>
            <p>Account not found</p>
        <?php endif; ?>
        
        <a href="/accounts">Back</a> <!-- Back link -->
    </body>
</html>
