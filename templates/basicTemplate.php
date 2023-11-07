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
        <div class="row header">
            <div class="title">
                <h1>Frolyak Ivan WP Plugin</h1>
                <h3>Users Data</h3>
            </div>
        </div>
        <div class="row plugin-content">
            <?php if (!isset($data['error'])): ?>
                <table id="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>USERNAME</th>
                            <th>PHONE</th>
                            <th>WEBSITE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $user): ?>
                            <tr>
                                <td><a onclick="return false" href="" class="user-details" data-userId="<?= $user['id'] ?>">
                                    <?= "#". htmlspecialchars($user['id'] ?? '') ?>
                                </a></td>
                                <td><a onclick="return false" href="" class="user-details" data-userId="<?= $user['id'] ?>">
                                    <?= htmlspecialchars($user['name'] ?? '') ?>
                                </a></td>
                                <td><a onclick="return false" href="" class="user-details" data-userId="<?= $user['id'] ?>">
                                    <?= htmlspecialchars($user['username'] ?? '') ?>
                                </a></td>
                                <td><?= htmlspecialchars($user['phone'] ?? '') ?: '-' ?></td>
                                <td><?= htmlspecialchars($user['website'] ?? '') ?: '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <!-- Error message in case data is empty -->
                <div class="error-container">
                    <p><b>Error:</b> <?= $data['error']; ?></p>
                    <p><b>Message:</b> <?= $data['message']; ?></p>
                </div>
            <?php endif; ?>

        </div>

        <div class="row">
            <!-- User details -->
            <div id="user-details"></div>
        </div>

        <div class="row bottom">
            <small>
                Data source:
                    <a href="https://jsonplaceholder.typicode.com/" target="_blank">
                        https://jsonplaceholder.typicode.com/
                    </a>
            </small>
        </div>

        <div class="row">

        </div>
    </section>

    <?php wp_footer(); ?>
</body>
</html>
