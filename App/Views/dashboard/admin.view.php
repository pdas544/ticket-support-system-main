
<?php loadPartial(
    'header',
    [
        'title' => 'Ticket Support System | Admin Dashboard',

    ]
) ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('message'); ?>

<!-- Wrapper for sidebar and main content -->
<div class="d-flex">
    <!-- Include sidebar -->
    <?php loadPartial('sidebar'); ?>
    
    <!-- Main content -->
    <div class="container mt-5 main-content">

    <h2 class="mb-5 text-center">Ticket Statistics</h2>
    <div class="row d-flex justify-content-center">
        <div class="col-md-3 total-tickets">
            <div class="card">
                <div class="card-header">Total Tickets</div>
                <div class="card-body"><?php echo $stats['total'] ?? ""; ?></div>
            </div>
        </div>
        <div class="col-md-3 today-tickets">
            <div class="card">
                <div class="card-header">Tickets Raised Today</div>
                <div class="card-body"><?php echo $stats['today'] ?? ""; ?></div>
            </div>
        </div>
        <div class="col-md-3 pending-tickets">
            <div class="card">
                <div class="card-header">Pending Tickets</div>
                <div class="card-body"><?php echo $stats['pending'] ?? ""; ?></div>
            </div>
        </div>
        <div class="col-md-3 resolved-tickets">
            <div class="card">
                <div class="card-header">Resolved Tickets</div>
                <div class="card-body"><?php echo $stats['resolved'] ?? ""; ?></div>
            </div>
        </div>
    </div>
</div>
</div> <!-- Close d-flex wrapper -->

<?php loadPartial('footer'); ?>