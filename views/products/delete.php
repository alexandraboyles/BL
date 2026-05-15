<!DOCTYPE html>
<html>
<head>
    <title>Delete Product</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Product</h1>
    <p>Are you sure you want to delete the product for customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/products/<?= htmlspecialchars($item['product_id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['product_id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/products">Cancel</a>
    </form>
</body>
</html>
