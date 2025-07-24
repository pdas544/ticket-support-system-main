<?= loadPartial('header', [
    'title' => 'Error | Unauthorized'
]) ?>
<?php loadPartial('navbar'); ?>


<section>
    <div class="container mx-auto">
        <div class="row m-5">
            <div class="col-3 text-dark text-center w-25 fs-3 mx-auto  border-end"><?= $status ?></div>
            <div class="col-6">
                <p class="text-center fs-3">
                    <?= $message ?>
                </p>
            </div>

        </div>



    </div>
</section>

<?= loadPartial('footer') ?>