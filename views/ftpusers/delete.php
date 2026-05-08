<!DOCTYPE html>
<html>
<head>
    <title>Delete FTP User</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete FTP User</h1>
    <p>Are you sure you want to delete this FTP user "<strong><?= htmlspecialchars($item['ftpUser_id'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/ftpusers/<?= htmlspecialchars($item['ftpUser_id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="ftpUser_id" value="<?= htmlspecialchars($item['ftpUser_id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/ftpusers">Cancel</a>
    </form>
</body>
</html>
