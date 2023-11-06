<?php
    use Frolyak\FrolyakIvanWpPlugin\View\ViewController;
    $viewControllerInstance = ViewController::instance();
    $data = $viewControllerInstance->getData();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Frolyak Ivan WP Plugin</title>

    <?php wp_head(); ?>

</head>
<body>
    <section id="content">
        <div class="row">
            <div class="title">
                <h1>User Data</h1>
            </div>
        </div>
        <div class="row">
            <table id="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>USERNAME</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $user): ?>
                        <tr>
                            <td><a onclick="return false" href="" class="user-details" data-userId="<?= $user['id'] ?>">
                                <?= htmlspecialchars($user['id']) ?>
                            </a></td>
                            <td><a onclick="return false" href="" class="user-details" data-userId="<?= $user['id'] ?>">
                                <?= htmlspecialchars($user['name']) ?>
                            </a></td>
                            <td><a onclick="return false" href="" class="user-details" data-userId="<?= $user['id'] ?>">
                                <?= htmlspecialchars($user['username']) ?>
                            </a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div id="user-details">
                <!-- User details -->
            </div>
        </div>
    </section>

    <?php wp_footer(); ?>
</body>
</html>
