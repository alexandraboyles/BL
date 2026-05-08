<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>FTP User Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php
        /** @var array $item */
        ?>
        <h1>FTP User Detail</h1> <!-- Heading -->

        <?php if ($item): ?> <!-- Check item -->
            <p><b>ID: </b><?= htmlspecialchars($item['id']) ?></p> <!-- UUID -->
            <p><b>FTP User ID: </b><?= htmlspecialchars($item['ftpUser_id']) ?></p> <!-- FTP User ID -->
            <p><b>Username: </b><?= htmlspecialchars($item['username']) ?></p> <!-- Username -->
            <p><b>Password: </b><?= htmlspecialchars($item['password']) ?></p> <!-- Password -->
            <p><b>Subdirectory: </b><?= htmlspecialchars($item['subDirectory']) ?></p> <!-- Subdirectory -->
        <?php else: ?> <!-- If not found -->
            <p>FTP User not found</p> <!-- Message -->
        <?php endif; ?>
        
        <a href="/ftpusers">Back</a> <!-- Back link -->
    </body>
</html>
