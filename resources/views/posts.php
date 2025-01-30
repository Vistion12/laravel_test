<?php include "menu.php";?>
    <h2>Посты</h2>
<?php foreach ($posts as $post): ?>
    <a href="<?= route('post', ['id' => $post['slug']]) ?>"><?= $post['title'] ?></a><br>
<?php endforeach; ?>
