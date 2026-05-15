<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
    <style>
       label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
       .error { color: red; }
       ul { margin: 10px 0; padding-left: 20px; }
       select { width: 260px; padding: 3px; }
       select option { width: 260px; padding: 6px; }
       input { width: 250px; padding: 3px; }
        .checkbox-group {
            display: inline-block;
            width: 260px;
            padding: 6px 0;
        }
        .checkbox-group label {
            display: block;
            width: auto;
            padding: 3px 0;
        }
        input[type="checkbox"] {
            width: auto;
            margin-right: 6px;
        }
</style>
    </style>
</head>
<body>
    <?php /** @var array|null $errors @var array $old @var array $customers */ ?>
    <h1>Create Product</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/products">
        <div>
            <label for="product_id">Product ID:</label>
            <input id="product_id" type="number" name="product_id" 
                   value="<?= htmlspecialchars($old['product_id'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="customer_id">Customer:</label>
            <select name="customer_id" id="customer_id" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= htmlspecialchars($customer['id']) ?>"
                        <?= (($old['customer_id'] ?? '') == $customer['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($customer['customer_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="title">Title:</label>
            <input id="title" type="text" name="title" 
                   value="<?= htmlspecialchars($old['title'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50" placeholder="Enter description.." required><?= htmlspecialchars($old['description'] ?? '', ENT_QUOTES) ?></textarea>
        </div>
        <div>
            <label for="sku">SKU:</label>
            <input id="sku" type="text" name="sku" 
                   value="<?= htmlspecialchars($old['sku'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="unitOfMeasure">Unit of Measure:</label>
            <input id="unitOfMeasure" type="text" name="unitOfMeasure" 
                   value="<?= htmlspecialchars($old['unitOfMeasure'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
            <label for="width">Width:</label>
            <input id="width" type="text" name="width" 
                    value="<?= htmlspecialchars($old['width'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
        <label for="length">Length:</label>
        <input id="length" type="text" name="length" 
                value="<?= htmlspecialchars($old['length'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
        <label for="height">Height:</label>
        <input id="height" type="text" name="height" 
                value="<?= htmlspecialchars($old['height'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <div>
        <label for="weight">Weight:</label>
        <input id="weight" type="text" name="weight" 
                value="<?= htmlspecialchars($old['weight'] ?? '', ENT_QUOTES) ?>" required>
        </div>
        <br>
        <button type="submit">Save</button>
    </form>
    <br>
    <a href="/products">Back to List</a>
</body>
</html>
