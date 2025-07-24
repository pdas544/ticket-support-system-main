<?php if (isset($errors)) : ?>
    <?php foreach ($errors as $error) : ?>
        <div class="text-danger bg-light p-1 rounded text-center"><?= $error ?></div>
    <?php endforeach; ?>
<?php endif; ?>