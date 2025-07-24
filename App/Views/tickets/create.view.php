<?php loadPartial(
    'header',
    [
        'title' => 'Ticket Support System | Home',

    ]
) ?>
<?php loadPartial('navbar'); ?>
<?= loadPartial('message'); ?>


<div class="container mt-5 mb-3 col-sm-12 col-md-8 col-lg-6 border rounded-3 p-4 shadow">
    <h1 class="text-center">Create New Ticket</h1>
    <?= loadPartial('errors', [
        'errors' => $errors ?? []
    ]) ?>
    <form action="/tickets" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Name</label>
            <input type="text" class="form-control" id="title" name="username" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <!-- <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="" disabled selected>Select a category</option>
                <option value="hardware">Hardware</option>
                <option value="network">Network</option>
                <option value="software">Software</option>
            </select>
        </div> -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Ticket</button>
</div>

<?= loadPartial('footer') ?>