<!DOCTYPE html>
<html>
<head>
    <title>Delete Delivery Address To Onforwarder Address Mapping</title>
</head>
<body>
    <?php
    /** @var array $item */
    ?>
    <h1>Delete Delivery Address To Onforwarder Address Mapping</h1>
    <p>Are you sure you want to delete the delivery address to onforwarder address mapping for address "<strong><?= htmlspecialchars($item['address_name'] ?? '', ENT_QUOTES) ?></strong>", customer "<strong><?= htmlspecialchars($item['customer_name'] ?? '', ENT_QUOTES) ?></strong>" and product "<strong><?= htmlspecialchars($item['product_name'] ?? '', ENT_QUOTES) ?></strong>"?</p>
    
    <form method="post" action="/deliveryaddresstoonforwarderaddressmapping/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <button type="submit">Yes</button>
        <a href="/deliveryaddresstoonforwarderaddressmapping">Cancel</a>
    </form>
</body>
</html>
