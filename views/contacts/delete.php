<!DOCTYPE html>
<html>
<head>
    <title>Delete Contact</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Contact</h1>
    <p>Are you sure you want to delete the contact "<strong><?= htmlspecialchars($item['contact_name'] ?? '', ENT_QUOTES) ?></strong>" for customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/contacts/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/contacts">Cancel</a>
    </form>
</body>
</html>
    