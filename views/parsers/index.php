<!DOCTYPE html>
<html>
    <head>
        <title>Parser</title>
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

        <h1>Parsers List</h1>

        <a href="/parsers/create">Create a parser here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Parser Name</th>
                <th>Class Name</th>
                <th>Class</th>
                <th>Type</th>
                <th>Accepted File Types</th>
                <th>To Address</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No parsers found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $parsers): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($parsers['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($parsers['customer_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($parsers['parser_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($parsers['className']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($parsers['class']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($parsers['type']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($parsers['acceptedFileTypes']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($parsers['toAddress']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/parsers/<?= $parsers['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/parsers/<?= $parsers['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/parsers/<?= $parsers['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete <?= htmlspecialchars($parsers['parser_name']) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
