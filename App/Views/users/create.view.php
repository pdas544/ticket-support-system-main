<?php loadPartial(
    'header',
    [
        'title' => 'Ticket Support System | Register',

    ]
) ?>
<?php loadPartial('navbar'); ?>


<div class="container mt-5 col-md-4 border rounded-3 p-4 shadow">
    <h1 class="text-center">Register</h1>
    <?= loadPartial('errors', [
        'errors' => $errors ?? []
    ]) ?>
    <form method="POST" action="/register">
        <div class="mb-3">
            <label for="title" class="form-label">Name</label>
            <input type="text" class="form-control" id="title" name="name" placeholder="Enter your Name" value="<?= $user['name'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Official Email ID" value="<?= $user['email'] ?? '' ?>" required>
        </div>


        <div class="mb-4">
            <label for="title" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-trigger="focus"
                data-bs-html="true"
                title="<strong>Password Requirements:</strong><ul class='mb-0 ps-3'>
                    <li>At least 6 characters</li>
                    <li>1 uppercase letter</li>
                    <li>1 lowercase letter</li>
                    <li>1 number</li>
                    <li>1 special character</li>
                </ul>">
        </div>
        <div class="mb-4">
            <label for="title" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary w-100">
            Register
        </button>

        <p class="mt-4 text-secondary text-center">
            Already have an account?
            <a class="text-primary" href="/auth/login">Login</a>
        </p>
    </form>
</div>

<?= loadPartial('footer') ?>