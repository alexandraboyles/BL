<!DOCTYPE html>
<html>
    <head>
        <title>Fee Category</title>
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

        <h1>Fee Categories List</h1>

        <a href="/feecategories/create">Create a fee category here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Applies To</th>
                <th>Account</th>
                <th>Fee Category Name</th>
                <th>Counts Toward Minimum Charges</th>
                <th>Is Name Editable</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No fee categories found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $feecategories): ?>
                <tr>
                    <td style="text-align: right;">
                        <?= htmlspecialchars($feecategories['id']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($feecategories['appliesTo']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($feecategories['account']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($feecategories['feeCategory_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars((bool)$feecategories['counts_toward_minimum_charges'] ? 'Yes' : 'No') ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars((bool)$feecategories['is_name_editable'] ? 'Yes' : 'No') ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/feecategories/<?= $feecategories['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/feecategories/<?= $feecategories['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/feecategories/<?= $feecategories['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete fee category `<?= htmlspecialchars($feecategories['feeCategory_name']) ?>`?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
