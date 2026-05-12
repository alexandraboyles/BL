<!DOCTYPE html> <!-- HTML5 -->
<html>
    <head>
        <title>User Detail</title> <!-- Title -->
        <style>
             p { padding: 5px; }
        </style>
    </head>
    <body>
        <?php /** @var array $item @var array $roles */?>
        <h1>User Detail</h1> <!-- Heading -->

        <?php if ($item): ?>
            <p><b>UUID: </b><?= htmlspecialchars($item['id']) ?></p>
            <p><b>Customer ID: </b><?= htmlspecialchars($item['customer_id']) ?></p>
            <p><b>Full Name: </b><?= htmlspecialchars($item['fullName']) ?></p>
            <p><b>Email: </b><?= htmlspecialchars($item['email']) ?></p>
            <p><b>Roles: </b><?php
                $rolesData = $item['roles'];
                if ($rolesData) {
                    $rolesArray = json_decode($rolesData, true);
                    if (is_array($rolesArray) && !empty($rolesArray)) {
                        $roleNames = [];
                        foreach ($rolesArray as $roleId) {
                            foreach ($roles as $role) {
                                if ($role['id'] == $roleId) {
                                    $roleNames[] = $role['role_name'];
                                    break;
                                }
                            }
                        }
                        echo htmlspecialchars(implode(', ', $roleNames));
                    } else {
                        echo 'None';
                    }
                } else {
                    echo 'None';
                }
            ?></p>
            <p><b>Warehouses ID: </b><?= htmlspecialchars($item['warehouses_id'] ?? '') ?></p>
            <p><b>MFA: </b><?= htmlspecialchars($item['mfa']) ?></p>
            <p><b>Is Email Verified: </b><?= htmlspecialchars($item['is_email_verified']) ?></p>
        <?php else: ?>
            <p>User not found</p>
        <?php endif; ?>
        
        <a href="/users">Back</a> <!-- Back link -->
    </body>
</html>
