<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Fee Category Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php /** @var array $item */?>
        <h1>Fee Category Detail</h1> <!-- Heading -->

        <?php if ($item): ?>
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p>
            <p><b>Applies To: </b><?= htmlspecialchars($item['appliesTo']) ?></p>
            <p><b>Account: </b><?= htmlspecialchars($item['account']) ?></p>
            <p><b>Fee Category Name: </b><?= htmlspecialchars($item['feeCategory_name']) ?></p>
            <p><b>Counts Toward Minimum Charges: </b><?= htmlspecialchars($item['counts_toward_minimum_charges']) ?></p>
            <p><b>Name Editable: </b><?= htmlspecialchars($item['is_name_editable']) ?></p>
        <?php else: ?>
            <p>Fee Category not found</p>
        <?php endif; ?>
        
        <a href="/feecategories">Back</a> <!-- Back link -->
    </body>
</html>
