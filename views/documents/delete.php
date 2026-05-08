<!DOCTYPE html>
<html>
<head>
    <title>Delete Document</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Document</h1>
    <p>Are you sure you want to delete the document for sales order "<strong><?= htmlspecialchars($item['saleOrder_human_id'] ?? '', ENT_QUOTES) ?></strong>", customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>" and consignment "<strong><?= htmlspecialchars($item['consignment_human_id'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/documents/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/documents">Cancel</a>
    </form>
</body>
</html>
