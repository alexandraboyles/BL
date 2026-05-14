<!DOCTYPE html>
<html>
<head>
    <title>Delete Surcharge</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Surcharge</h1>
    <p>Are you sure you want to delete the surcharge for fee category "<strong><?= htmlspecialchars($item['feeCategory_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/surcharges/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/surcharges">Cancel</a>
    </form>
</body>
</html>
