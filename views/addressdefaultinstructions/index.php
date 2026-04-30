<!DOCTYPE html>
<html>
    <head>
        <title>Address Default Instructions</title>
        <style>
            table, th, td {
                border:1px solid black;
                border-collapse: collapse;
                padding: 4px;
            }
        </style>
    </head>
    <body>
        <?php
        /** @var array $items */
        ?>
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div style="color: green; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <h1>Address Default Instruction List</h1>

        <a href="/addressdefaultinstructions/create">Create an address default instruction here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Delivery Instruction</th>
                <th>Packing Instruction</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="4">No address default instructions found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $addressdefaultinstruction): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($addressdefaultinstruction['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addressdefaultinstruction['deliveryInstruction']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($addressdefaultinstruction['packingInstruction']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/addressdefaultinstructions/<?= $addressdefaultinstruction['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/addressdefaultinstructions/<?= $addressdefaultinstruction['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/addressdefaultinstructions/<?= $addressdefaultinstruction['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete id = <?= htmlspecialchars($addressdefaultinstruction['id']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
