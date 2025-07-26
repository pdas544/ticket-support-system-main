<?php loadPartial(
    'header',
    [
        'title' => 'Ticket Support System | Agent Dashboard',

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
        <!-- Agent content -->
        <h1>Agent Dashboard</h1>
    </div>
</div> <!-- Close d-flex wrapper -->

<?php loadPartial('footer'); ?>