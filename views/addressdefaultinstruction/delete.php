<?php
/** @var array $item */
?>
<h1>Delete Address Default Instruction</h1>

<p>Are you sure you want to delete the instruction for address "<strong><?= htmlspecialchars($item['address_id'] ?? '', ENT_QUOTES) ?></strong>"?</p>

<form method="post" action="/addressdefaultinstructions/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
    <button type="submit">Delete</button>
    <a href="/addressdefaultinstructions">Cancel</a>
</form>
