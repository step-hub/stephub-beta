<div aria-live="polite" aria-atomic="true" style="position: relative;">
    <!-- Activate -->
    <div id="activate" class="toast shadow-lg mr-2 mt-2 d-none d-md-block" data-animation="true" data-delay="10000">
        <div class="toast-header">
            <i class="fas fa-exclamation-circle text-warning mr-2"></i>
            <strong class="mr-auto">Активація акаунта</strong>
            <small>Щойно</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Ваша електронна адреса <strong><?= $_SESSION['logged_user']['email'] ?></strong> успішно підтверженна!
        </div>
    </div>
</div>