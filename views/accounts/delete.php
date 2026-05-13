<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Account</h1>
    <p>Are you sure you want to delete this account "<strong><?= htmlspecialchars($item['account_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/accounts/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="account_id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/accounts">Cancel</a>
    </form>
</body>
</html>
