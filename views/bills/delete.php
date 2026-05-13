<!DOCTYPE html>
<html>
<head>
    <title>Delete Bill</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Bill</h1>
    <p>Are you sure you want to delete the bill for supplier "<strong><?= htmlspecialchars($item['supplier_name'] ?? '', ENT_QUOTES) ?></strong>", invoice "<strong><?= htmlspecialchars($item['invoice_id'] ?? '', ENT_QUOTES) ?></strong>" and manifest "<strong><?= htmlspecialchars($item['manifest_id'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/bills/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/bills">Cancel</a>
    </form>
</body>
</html>
 