<!DOCTYPE html>
<html>
<head>
    <title>Delete Parser</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Parser</h1>
    <p>Are you sure you want to delete the parser for customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/parsers/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/parsers">Cancel</a>
    </form>
</body>
</html>
