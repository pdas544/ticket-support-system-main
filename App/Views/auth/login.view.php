<?= loadPartial('header', [
    'title' => 'Login',

]) ?>
<?= loadPartial('navbar') ?>
<?php loadPartial('message'); ?>

<div class="container mt-5 col-sm-12 col-md-4 col-lg-4 border rounded-3 p-4 shadow">

    <h1 class="text-center">Login</h1>
    <?= loadPartial('errors', [
        'errors' => $errors ?? []
    ]) ?>
    <form method="POST" action="/auth/login">
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" placeholder="Email Address" class="form-control" />
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" placeholder="Password" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary w-100">
            Login
        </button>

        <p class="mt-4 text-secondary text-center">
            Don't have an account?
            <a class="text-primary" href="/register">Register</a>
        </p>
    </form>
</div>
</div>

<?= loadPartial('footer') ?>