<!DOCTYPE html>
<html>
<head>
    <title>Delete Supplier</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Supplier</h1>
    <p>Are you sure you want to delete the supplier for rate card "<strong><?= htmlspecialchars($item['rateCard_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/suppliers/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/suppliers">Cancel</a>
    </form>
</body>
</html>
