<!DOCTYPE html>
<html>
<head>
    <title>Delete Driver</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Driver</h1>
    <p>Are you sure you want to delete this driver "<strong><?= htmlspecialchars($item['driver_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/drivers/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="driver_id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/drivers">Cancel</a>
    </form>
</body>
</html>
