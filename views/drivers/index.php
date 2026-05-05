<!DOCTYPE html>
<html>
    <head>
        <title>Drivers</title>
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

        <h1>Drivers List</h1>

        <a href="/drivers/create">Create a driver here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>Driver Name</th>
                <th>Email</th>
                <th>Online</th>
                <th>Location Access Available</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No drivers found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $drivers): ?>
                <tr>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($drivers['driver_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($drivers['email']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars((bool)$drivers['is_online'] ? 'Yes' : 'No') ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars((bool)$drivers['location_access_available'] ? 'Yes' : 'No') ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/drivers/<?= $drivers['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/drivers/<?= $drivers['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/drivers/<?= $drivers['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete driver `<?= htmlspecialchars($drivers['driver_name']) ?>`?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
