<!DOCTYPE html>
<html>
<head>
    <title>Delete Fee Category</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Fee Category</h1>
    <p>Are you sure you want to delete this fee category "<strong><?= htmlspecialchars($item['feeCategory_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/feecategories/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="feeCategory_id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/feecategories">Cancel</a>
    </form>
</body>
</html>
