<?php loadPartial(
    'header',
    [
        'title' => 'Ticket Support System | Home',

    ]
) ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('message'); ?>


<!-- main content -->
<div class="container col-xxl-8 px-4 py-5">

    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <!-- left column -->

        <div class="col-10 col-sm-8 col-lg-6"> <img src="assets/images/heroimg.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="300" height="400" loading="lazy"> </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3 text-center">IT Desk</h1>
            <p class="lead">
                Welcome to the IT Desk. Here you can create, view, and manage your support tickets. If you have any issues or need assistance, please feel free to create a ticket.
                Our support team is here to help you resolve any technical problems you may encounter.

            </p>
            <p class="lead">
                IT department is responsible for managing the IT issues and providing support to the employees. The IT Desk is the first point of contact for employees who need assistance with their IT-related issues.
            </p>

        </div>


    </div>
</div>

<?php loadPartial('footer'); ?>