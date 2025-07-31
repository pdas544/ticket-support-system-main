<?php loadPartial(
    'header',
    [
        'title' => 'Ticket Support System | Home',

    ]
) ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('message'); ?>

<div class="d-flex">
    <?php loadPartial('sidebar'); ?>

    <div class="container mt-5 main-content">
       <div class="row mt-5">
           <div class="col md-12 text-center"><h2>All Tickets</h2></div>
       </div>
        <div class="table-responsive">
            <table id="ticketsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Select</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $serial = 1;
                if (isset($tickets) && is_array($tickets)) {
                    foreach ($tickets as $ticket) {
                        echo "<tr>";
                        echo "<td>{$serial}</td>";
                        echo "<td>{$ticket['subject']}</td>";
                        echo "<td>{$ticket['description']}</td>";
                        echo "<td>{$ticket['created_at']}</td>";
                        echo "<td>{$ticket['status']}</td>";
                        echo "<td><a href='/tickets/{$ticket['id']}' class='btn btn-sm btn-primary update-icon' style='display:none;'><i class='fas fa-edit'></i></a></td>";
                        echo "<td><input type='checkbox' class='update-checkbox' name='ticket_id[]' value='{$ticket['id']}'></td>";
                        echo "</tr>";
                        $serial++;
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
</div>
</div>

<?php loadPartial('footer'); ?>