<!DOCTYPE html>
<html>
    <head>
        <title>Address Default Instructions</title>
        <style>
            table, th, td {
                border:1px solid black;
                border-collapse: collapse;
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <?php
        /** @var array $items */
        ?>
        <h1>Address Default Instructions List</h1>

        <a href="/addressdefaultinstructions/create">Create an instruction here</a><br><br>

        <table style="width: 40%;">
            <tr>
                <th>ID</th>
                <th>Address ID</th>
                <th>Instruction</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($items as $instruction): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($instruction['id'] ?? '') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($instruction['address_id'] ?? '') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars(substr($instruction['instruction_text'] ?? '', 0, 50)) ?>...
                    </td>
                    <td style="text-align: center;">
                        <button type="button" onclick="window.location.href = '/addressdefaultinstructions/<?= $instruction['id'] ?>'">View</button>
                        <button type="button" onclick="window.location.href = '/addressdefaultinstructions/<?= $instruction['id'] ?>/edit'">Edit</button>
                        <form method="POST" action="/addressdefaultinstructions/<?= $instruction['id'] ?>/delete" style="display:inline;">
                            <button type="submit" onclick="return confirm('Delete this instruction?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
