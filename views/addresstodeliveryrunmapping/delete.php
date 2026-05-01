<!DOCTYPE html>
<html>
<head>
    <title>Delete Address To Delivery Run Mapping</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Address To Delivery Run Mapping</h1>
    <p>Are you sure you want to delete the address to delivery run mapping for address type "<strong><?= htmlspecialchars($item['addressType_name'] ?? '', ENT_QUOTES) ?></strong>", address "<strong><?= htmlspecialchars($item['address_name'] ?? '', ENT_QUOTES) ?></strong>", customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>", product "<strong><?= htmlspecialchars($item['product_name'] ?? '', ENT_QUOTES) ?></strong>", delivery run "<strong><?= htmlspecialchars($item['deliveryRun_name'] ?? '', ENT_QUOTES) ?></strong>", carrier "<strong><?= htmlspecialchars($item['carrier_name'] ?? '', ENT_QUOTES) ?></strong>", and flow direction "<strong><?= htmlspecialchars($item['flow_direction'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/addresstodeliveryrunmapping/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/addresstodeliveryrunmapping">Cancel</a>
    </form>
</body>
</html>
