<!DOCTYPE html>
<html>
<head>
    <title>Delete Address To Invoice Customer Mapping</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Address To Invoice Customer Mapping</h1>
    <p>Are you sure you want to delete the address to invoice customer mapping for address "<strong><?= htmlspecialchars($item['address_name'] ?? '', ENT_QUOTES) ?></strong>", customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/addresstoinvoicecustomermapping/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/addresstoinvoicecustomermapping">Cancel</a>
    </form>
</body>
</html>
