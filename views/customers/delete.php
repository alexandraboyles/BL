<!DOCTYPE html>
<html>
<head>
    <title>Delete Customer</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Customer</h1>
    <p>Are you sure you want to delete this customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/customers/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="customer_id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/customers">Cancel</a>
    </form>
</body>
</html>
