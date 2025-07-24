<?php loadPartial(
    'header',
    [
        'title' => 'Ticket Support System | Show Individual Ticket',

    ]
) ?>
<?php loadPartial('navbar'); ?>
<?php //loadPartial('sidebar'); 
?>

<div class="container mt-5 mb-3 col-sm-12 col-md-8 col-lg-6 border rounded-3 p-4 shadow">
    <h1 class="text-center mb-3">Ticket Details</h1>


    <div
        class="table-responsive">
        <table
            class="table">
            <thead>
                <tr>
                    <th scope="col">Sl. No</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Description</th>
                    <th scope="col">Raised On</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    <td scope="row"><?= $ticket['id'] ?></td>
                    <td><?= $ticket['subject'] ?></td>
                    <td><?= $ticket['description'] ?></td>
                    <td><?= $ticket['created_at']; ?></td>
                    <td><?= $ticket['status'] ?></td>
                </tr>

            </tbody>
        </table>
    </div>


</div>

<?= loadPartial('footer') ?>