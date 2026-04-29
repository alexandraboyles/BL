<!DOCTYPE html>
<html>
<head>
    <title>Delete Address</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Address</h1>
    <p>Are you sure you want to delete this address "<strong><?= htmlspecialchars($item['address_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/addresses/<?= htmlspecialchars($item['address_id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="address_id" value="<?= htmlspecialchars($item['address_id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/addresses">Cancel</a>
    </form>
</body>
</html>
