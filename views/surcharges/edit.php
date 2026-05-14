<!DOCTYPE html>
<html>
    <head>
        <title>Edit Surcharge</title>
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
        /** @var array|null $errors @var array $feecategories */
        ?>
        <h1>Edit Surcharge</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/surcharges/<?= htmlspecialchars($item['id'], ENT_QUOTES) ?>">
        <div>
            <label for="feeCategory_id">Fee Category:</label>
            <select name="feeCategory_id" id="feeCategory_id" required>
                <option value="">-- Select feeCategory --</option>
                <?php foreach ($feecategories as $feecategory): ?>
                    <option value="<?= htmlspecialchars($feecategory['id']) ?>"
                        <?= (($item['feeCategory_id'] ?? '') == $feecategory['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($feecategory['feeCategory_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
                <label for="surcharge_name">Surcharge Name:</label>
                <input id="surcharge_name" type="text" name="surcharge_name" 
                    value="<?= htmlspecialchars($item['surcharge_name'] ?? '', ENT_QUOTES) ?>" required>
        </div>  
        <div>
                <label for="conditions">Conditions:</label>
                <input id="conditions" type="text" name="conditions" 
                    value="<?= htmlspecialchars($item['conditions'] ?? '', ENT_QUOTES) ?>" required>
        </div>  
        <div>
            <label for="surcharge">Surcharge:</label>
            <input id="surcharge" type="text" name="surcharge" 
                    value="<?= htmlspecialchars($item['surcharge'] ?? '', ENT_QUOTES) ?>" required>
        </div>   
        <div>
                <label for="status">Status:</label>
                <input id="status" type="text" name="status" 
                    value="<?= htmlspecialchars($item['status'] ?? '', ENT_QUOTES) ?>" required>
        </div>        
            <br>
            <button type="submit">Update Surcharge</button>
            <br><br>
            <a href="/surcharges">Cancel</a>
        </form>
    </body>
</html>