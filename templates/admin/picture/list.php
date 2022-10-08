<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <i class="fas fa-image fa-fw"></i> Images
    </div>
</div>

<div class="row row-cols-4">
    <?php foreach($pictures as $picture) {
        $date = new DateTime($picture['created_at']);
        ?>
        <div class="col mb-3">
            <div class="card">
                <img src="/<?= $picture['file'] ?>" class="card-img-top">
                <div class="card-body">
                    <?= $picture['title'] ?>
                </div>
                <div class="card-footer text-muted">
                    <a href="<?= $this->path('/admin/images/') . $picture['id'] ?>" class="float-end"><i class="fas fa-pencil"></i></a>
                    <?= $date->format('d/m/Y') ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<a href="<?= $this->path('/admin/images/nouvelle') ?>" class="btn btn-success float-start">
    <i class="fas fa-plus fa-fw"></i> Nouvelle image
</a>

<?= $this->pagination('/admin/images/page/%page%', $pagination); ?>
