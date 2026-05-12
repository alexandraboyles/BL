<!DOCTYPE html>
<html>
<head>
    <title>Delete Rate Card</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Rate Card</h1>
    <p>Are you sure you want to delete the rate card for customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/ratecards/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/ratecards">Cancel</a>
    </form>
</body>
</html>
