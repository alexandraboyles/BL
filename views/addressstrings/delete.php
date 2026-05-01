<!DOCTYPE html>
<html>
<head>
    <title>Delete Address Strings</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Address Strings</h1>
    <p>Are you sure you want to delete the address string for address "<strong><?= htmlspecialchars($item['address_name'] ?? '', ENT_QUOTES) ?></strong>" and customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/addressstrings/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/addressstrings">Cancel</a>
    </form>
</body>
</html>
