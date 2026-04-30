<!DOCTYPE html>
<html>
<head>
    <title>Delete Address Default Instruction</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Address Default Instruction</h1>
    <p>Are you sure you want to delete the instruction for address "<strong><?= htmlspecialchars($item['address_name'] ?? '', ENT_QUOTES) ?></strong>" and customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/addressdefaultinstructions/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/addressdefaultinstructions">Cancel</a>
    </form>
</body>
</html>
