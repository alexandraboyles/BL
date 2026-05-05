<!DOCTYPE html>
<html>
    <head>
        <title>Contacts</title>
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

        <h1>Contacts List</h1>

        <a href="/contacts/create">Create a contact here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>Customer Name</th>
                <th>Contact Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="5">No contacts found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $contacts): ?>
                <tr>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($contacts['customer_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($contacts['contact_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($contacts['email']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($contacts['phone']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/contacts/<?= $contacts['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/contacts/<?= $contacts['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/contacts/<?= $contacts['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete contact `<?= htmlspecialchars($contacts['contact_name']) ?>`?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
