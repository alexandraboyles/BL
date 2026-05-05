<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete User</h1>
    <p>Are you sure you want to delete the user "<strong><?= htmlspecialchars($item['fullName'] ?? '', ENT_QUOTES) ?></strong>" for customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/users/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/users">Cancel</a>
    </form>
</body>
</html>
    