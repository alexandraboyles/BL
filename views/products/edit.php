
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
       label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
       .error { color: red; }
       ul { margin: 10px 0; padding-left: 20px; }
       select { width: 260px; padding: 3px; }
       select option { width: 260px; padding: 6px; }
       input { width: 250px; padding: 3px; }     
       form textarea { margin-top: 7px; }
    </style>
</head>
<body>
<?php /** @var array|null $errors @var array $item @var array $customers */ ?>
<h1>Edit Product</h1>
    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<form method="post" action="/products/<?= htmlspecialchars($item['product_id'], ENT_QUOTES) ?>">
        <div>
            <label for="product_id">Product ID:</label>
            <input id="product_id" type="number" name="product_id" 
                   value="<?= htmlspecialchars($item['product_id'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= htmlspecialchars($customer['id']) ?>"
                        <?= (($item['customer_id'] ?? '') == $customer['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($customer['customer_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="title">Title:</label>
            <input id="title" type="text" name="title" 
                   value="<?= htmlspecialchars($item['title'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50" placehitemer="Enter description.." required><?= htmlspecialchars($item['description'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
        <div>
            <label for="sku">SKU:</label>
            <input id="sku" type="text" name="sku" 
                   value="<?= htmlspecialchars($item['sku'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="unitOfMeasure">Unit of Measure:</label>
            <input id="unitOfMeasure" type="text" name="unitOfMeasure" 
                   value="<?= htmlspecialchars($item['unitOfMeasure'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="width">Width:</label>
            <input id="width" type="text" name="width" 
                    value="<?= htmlspecialchars($item['width'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
        <label for="length">Length:</label>
        <input id="length" type="text" name="length" 
                value="<?= htmlspecialchars($item['length'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
        <label for="height">Height:</label>
        <input id="height" type="text" name="height" 
                value="<?= htmlspecialchars($item['height'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
        <label for="weight">Weight:</label>
        <input id="weight" type="text" name="weight" 
                value="<?= htmlspecialchars($item['weight'] ?? '', ENT_QUOTES) ?>" required>
        </div>
            <br>
            <button type="submit">Update Product</button>
            <br><br>
            <a href="/products">Cancel</a>
        </form>
    </body>
</html>
