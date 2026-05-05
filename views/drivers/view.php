<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>Driver Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php /** @var array $item */?>
        <h1>Driver Detail</h1> <!-- Heading -->

        <?php if ($item): ?>
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p>
            <p><b>Driver Name: </b><?= htmlspecialchars($item['driver_name']) ?></p>
            <p><b>Email: </b><?= htmlspecialchars($item['email']) ?></p>
            <p><b>Online: </b><?= htmlspecialchars($item['is_online']) ?></p>
            <p><b>Location Access Available: </b><?= htmlspecialchars($item['location_access_available']) ?></p>
        <?php else: ?>
            <p>Driver not found</p>
        <?php endif; ?>
        
        <a href="/drivers">Back</a> <!-- Back link -->
    </body>
</html>
