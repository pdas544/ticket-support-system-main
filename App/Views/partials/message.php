<?php
// partials/message.php
use App\Core\Session;

$flash = null;        // holds the message text
$flashType = null;    // “success” or “error”

foreach (['success', 'error'] as $type) {
    $msg = Session::getFlashMessage($type);
    if ($msg) {
        $flash     = $msg;
        $flashType = $type;
        break;
    }
}

if (!$flash) {
    //check the query string for a logout message
    if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
        $flash     = 'You have been logged out successfully.';
        $flashType = 'success';
    }
}

// define the types you care about + their Bootstrap settings
if ($flash && $flashType):
    $cfg = [
        'success' => [
            'id'    => 'modalFlashSuccess',
            'bg'    => 'bg-success',
            'btn'   => 'btn-success',
            'title' => 'Success'
        ],
        'error' => [
            'id'    => 'modalFlashError',
            'bg'    => 'bg-danger',
            'btn'   => 'btn-danger',
            'title' => 'Error'
        ]
    ][$flashType];
    $safeMsg = htmlspecialchars($flash);
?>


    <!-- Modal -->
    <div class="modal fade" id="<?= $cfg['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header <?= $cfg['bg'] ?> text-white">
                    <h5 class="modal-title"><?= $cfg['title'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?= $safeMsg ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn <?= $cfg['btn'] ?>" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-show script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let flashEl = document.getElementById('<?= $cfg['id'] ?>');
            let modal = new bootstrap.Modal(flashEl);
            modal.show();

            //set the timeout to auto-hide the modal
            setTimeout(() => {
                modal.hide();
            }, 1000);
        });
    </script>
<?php
endif;
