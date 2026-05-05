<!DOCTYPE html>
<html>
    <head>
        <title>Users</title>
        <style>
            table, th, td {
                border:1px solid black;
                border-collapse: collapse;
                padding: 4px;
            }
        </style>
    </head>
    <body>
        <?php /** @var array $items @var array $roles */ ?>
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div style="color: green; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <h1>Users List</h1>

        <a href="/users/create">Create a user here</a><br><br>

        <table style="width: 100%;">
            <tr>
                <th>Customer Name</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Warehouse</th>
                <th>MFA</th>
                <th>Email Verified</th>
                <th>Actions</th>
            </tr>
    <?php if (empty($items)): ?>
            <tr><td colspan="8">No users found</td></tr>
        <?php else: ?>
            <?php foreach ($items as $users): ?>
                <tr>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($users['customer_name']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($users['fullName']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($users['email']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?php
                            $rolesData = $users['roles'];
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
                        ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($users['warehouse'] ?? '') ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars($users['mfa']) ?>
                    </td>
                    <td style="text-align: left;">
                        <?= htmlspecialchars((bool)$users['is_email_verified'] ? 'Yes' : 'No') ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="/users/<?= $users['id'] ?>" style="margin-right: 5px;">View</a>
                        <a href="/users/<?= $users['id'] ?>/edit" style="margin-right: 5px;">Edit</a>
                        <a href="/users/<?= $users['id'] ?>/delete" style="margin-right: 5px; color: red;" 
                           onclick="return confirm('Delete user `<?= htmlspecialchars($users['fullName']) ?>`?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
        <br>

        <a href="/home">Back</a>
    </body>
</html>
