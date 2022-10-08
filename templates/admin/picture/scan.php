<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin/images') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <i class="fas fa-image fa-fw"></i> Scanner les images
    </div>
</div>

<ul class="fa-ul">
    <?php
    $count = 0;
    foreach($pictures as $picture) {
        $count += (int)!$picture['exists'];
        ?>
        <li><i class="fas fa-li fa-<?= $picture['exists'] ? 'check text-success' : 'times text-danger' ?>"></i> <?= $picture['file'] ?></li>
    <?php } ?>
</ul>

<?php if($count > 0) { ?>
    <a href="<?= $this->path('/admin/images/scan') . '?dir=' . $dir . '&confirm=1' ?>" class="btn btn-primary"><i class="fas fa-plus fa-fw"></i> Créer les images manquantes</a>
<?php } ?>
