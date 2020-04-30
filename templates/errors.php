<?php if ($errors) : ?>
    <div class="alert alert-danger alert-dismissible shadow-sm mb-0 text-md-center border-radius-0" role="alert">
        <?= @$errors[0]; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (isset($update_ann_errors) and $update_ann_errors) : ?>
    <div class="alert alert-danger alert-dismissible shadow-sm mb-0 text-md-center border-radius-0" role="alert">
        <?= @$update_ann_errors[0]; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>