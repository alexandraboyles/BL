<!DOCTYPE html>
<html>
    <head>
        <title>Create Address Default Instruction</title>
        <style>
            label {
                display: inline-block;
                width: 150px;
                text-align: left;
                padding: 3px;
            }
        </style>
    </head>
    <body>
        <h1>Create Address Default Instruction</h1>

        <?php if (!empty($errors)): ?>
            <div style="color: red; background: #fee;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/addressdefaultinstructions">
            <div>
                <label for="address_id">Address ID:</label>
                <input id="address_id" type="number" name="address_id" value="<?= htmlspecialchars($_POST['address_id'] ?? '', ENT_QUOTES) ?>" required>
            </div>
            <div>
                <label for="instruction_text">Instruction:</label>
                <textarea id="instruction_text" name="instruction_text" rows="5" cols="50" required><?= htmlspecialchars($_POST['instruction_text'] ?? '', ENT_QUOTES) ?></textarea>
            </div>
            <div>
                <label for="delivery_instruction">Delivery Instruction:</label>
                <input id="delivery_instruction" type="text" name="delivery_instruction" value="<?= htmlspecialchars($_POST['delivery_instruction'] ?? '', ENT_QUOTES) ?>">
            </div>
            <br>
            <button type="submit">Save</button>
        </form>
        <br>
        <a href="/addressdefaultinstructions">Back</a>
    </body>
</html>
