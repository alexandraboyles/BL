<!DOCTYPE html>
<html>
<head>
    <title>Delete Adhoc Charge</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Adhoc Charge</h1>
    <p>Are you sure you want to delete this adhoc charge?</p>
    
    <form method="post" action="/adhoccharges/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/adhoccharges">Cancel</a>
    </form>
</body>
</html>
