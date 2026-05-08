<!DOCTYPE html>
<html>
    <head>
        <title>Customers</title>
        <style>
            table, th, td {
                border:1px solid black;
                border-collapse: collapse;
                padding: 4px;
            }
        </style>
    </head>
    <body>
        <?php /** @var array $items */ ?>
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div style="color: green; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <h1>Customers List</h1>

        <a href="/customers/create">Create a customer here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>Customer Name</th>
                <th>Contact Phone</th>
                <th>Contact Email</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No customers found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $customers): ?>
                <tr>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($customers['customer_name']) ?>
                    </td>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($customers['contact_phone']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($customers['contact_email']) ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/customers/<?= $customers['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/customers/<?= $customers['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/customers/<?= $customers['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete customer `<?= htmlspecialchars($customers['customer_name']) ?>`?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
