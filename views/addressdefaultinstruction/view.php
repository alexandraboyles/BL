<!DOCTYPE html>
<html>
    <head>
        <title>Address Default Instruction Detail</title>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>Address Default Instruction Detail</h1>

        <?php if ($item): ?>
            <p><b>ID: </b><?= htmlspecialchars($item['id'] ?? '') ?></p>
            <p><b>Address ID: </b><?= htmlspecialchars($item['address_id'] ?? '') ?></p>
            <p><b>Instruction: </b></p>
            <p><?= htmlspecialchars($item['instruction_text'] ?? '') ?></p>
            <p><b>Delivery Instruction: </b><?= htmlspecialchars($item['delivery_instruction'] ?? '') ?></p>
        <?php else: ?>
            <p>Instruction not found</p>
        <?php endif; ?>
        
        <a href="/addressdefaultinstructions">Back</a>
    </body>
</html>
