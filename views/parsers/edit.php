<!DOCTYPE html>
<html>
    <head>
        <title>Edit Parser</title>
        <style>
       label { display: inline-block; width: 150px; text-align: left; padding: 10px; }
       .error { color: red; }
       ul { margin: 10px 0; padding-left: 20px; }
       select { width: 260px; padding: 3px; }
       select option { width: 260px; padding: 6px; }
       input { width: 250px; padding: 3px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        /** @var array|null $errors @var array $customers */
        ?>
        <h1>Edit Parser</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/parsers/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <div>
            <label for="id">ID:</label>
            <input id="id" type="number" name="id"
                   value="<?= htmlspecialchars($item['id'] ?? '', ENT_QUOTES) ?>" required>
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
                    <label for="parser_name">Parser Name:</label>
                    <input id="parser_name" type="text" name="parser_name" 
                        value="<?= htmlspecialchars($item['parser_name'] ?? '', ENT_QUOTES) ?>" required>
            </div>  
            <div>
                    <label for="className">Class Name:</label>
                    <input id="className" type="text" name="className" 
                        value="<?= htmlspecialchars($item['className'] ?? '', ENT_QUOTES) ?>" required>
            </div> 
            <div>
                    <label for="class">Class:</label>
                    <input id="class" type="text" name="class" 
                        value="<?= htmlspecialchars($item['class'] ?? '', ENT_QUOTES) ?>" required>
            </div>   
            <div>
                    <label for="type">Type:</label>
                    <input id="type" type="text" name="type" 
                        value="<?= htmlspecialchars($item['type'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                    <label for="acceptedFileTypes">Accepted Files:</label>
                    <input id="acceptedFileTypes" type="text" name="acceptedFileTypes" 
                        value="<?= htmlspecialchars($item['acceptedFileTypes'] ?? '', ENT_QUOTES) ?>" required>
            </div>  
            <div>
                    <label for="toAddress">To Address:</label>
                    <input id="toAddress" type="text" name="toAddress" 
                        value="<?= htmlspecialchars($item['toAddress'] ?? '', ENT_QUOTES) ?>" required>
            </div>              
            <br>
            <button type="submit">Update Parser</button>
            <br><br>
            <a href="/parsers">Cancel</a>
        </form>
    </body>
</html>