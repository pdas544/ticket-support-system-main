<?php loadPartial(
    'header',
    [
        'title' => 'Ticket Support System | User Dashboard',

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
        <h2 class="mb-5 text-center">My Tickets Overview</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 total-tickets">
                <div class="card">
                    <div class="card-header">My Total Tickets</div>
                    <div class="card-body"><?php echo $stats['total_by_user'] ?? "0"; ?></div>
                </div>
            </div>
            <div class="col-md-4 pending-tickets">
                <div class="card">
                    <div class="card-header">My Pending Tickets</div>
                    <div class="card-body"><?php echo $stats['pending'] ?? "0"; ?></div>
                </div>
            </div>
            <div class="col-md-4 resolved-tickets">
                <div class="card">
                    <div class="card-header">My Resolved Tickets</div>
                    <div class="card-body"><?php echo $stats['resolved'] ?? "0"; ?></div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- Close d-flex wrapper -->

<?php loadPartial('footer'); ?>