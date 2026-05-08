
<!DOCTYPE html>
<html>
<head>
    <title>Create Parser</title>
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
<?php /** @var array|null $errors @var array $old @var array $customers */ ?>
<h1>Create Parser</h1>
    <?php if (!empty($errors)): ?>
        <div style="color: red; background: #fee;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<form method="post" action="/parsers">
    <div>
        <label for="id">ID:</label>
        <input id="id" type="number" name="id"
               value="<?= htmlspecialchars($old['id'] ?? '', ENT_QUOTES) ?>" required>
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
            <label for="parser_name">Parser Name:</label>
            <input id="parser_name" type="text" name="parser_name" 
                   value="<?= htmlspecialchars($old['parser_name'] ?? '', ENT_QUOTES) ?>" required>
    </div>  
    <div>
            <label for="className">Class Name:</label>
            <input id="className" type="text" name="className" 
                   value="<?= htmlspecialchars($old['className'] ?? '', ENT_QUOTES) ?>" required>
    </div> 
    <div>
            <label for="class">Class:</label>
            <input id="class" type="text" name="class" 
                   value="<?= htmlspecialchars($old['class'] ?? '', ENT_QUOTES) ?>" required>
    </div>   
    <div>
            <label for="type">Type:</label>
            <input id="type" type="text" name="type" 
                   value="<?= htmlspecialchars($old['type'] ?? '', ENT_QUOTES) ?>" required>
    </div>
    <div>
            <label for="acceptedFileTypes">Accepted Files:</label>
            <input id="acceptedFileTypes" type="text" name="acceptedFileTypes" 
                   value="<?= htmlspecialchars($old['acceptedFileTypes'] ?? '', ENT_QUOTES) ?>" required>
    </div>  
    <div>
            <label for="toAddress">To Address:</label>
            <input id="toAddress" type="text" name="toAddress" 
                   value="<?= htmlspecialchars($old['toAddress'] ?? '', ENT_QUOTES) ?>" required>
    </div>              
    <br>
    <button type="submit">Save</button>
</form>
<br><br>
<a href="/parsers">Back to List</a>
</body>
</html>
