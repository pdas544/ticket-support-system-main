<?php loadPartial(
    'header',
    [
        'title' => 'Ticket Support System | Ticket Status Form',

    ]
) ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('message') ?>


<div class="container mt-5 mb-3 col-sm-12 col-md-8 col-lg-6 border rounded-3 p-4 shadow">
    <h1 class="text-center">Ticket Details</h1>
    <form action="/tickets/search" method="POST">
        <div class="mb-3">
            <label for="" class="form-label">Ticket ID</label>
            <input
                type="text"
                class="form-control"
                name="ticket_id"
                id="ticket_id"
                aria-describedby="helpId"
                placeholder="Enter the Ticket ID" />

        </div>
        <button type="submit" class="btn btn-primary">
            View Ticket
        </button>


    </form>


</div>

<?= loadPartial('footer') ?>