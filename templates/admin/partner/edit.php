<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin/partenaires') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <?php if($partner['id']) { ?>
            <i class="fas fa-user-tie fa-fw"></i> <?= $partner['name']; ?>
        <?php } else { ?>
            <i class="fas fa-user-tie fa-fw"></i> Nouveau partenaire
        <?php } ?>
    </div>
    <form action="" method="POST">
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Nom</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" value="<?= $partner['name']; ?>" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Description</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="description"><?= $partner['description']; ?></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <?php if($partner['id']) { ?>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Enregistrer</button>
                <a href="<?= $this->path('/admin/partenaires/') . $partner['id'] . '/supprimer' ?>" class="btn btn-danger float-start"><i class="fas fa-trash fa-fw"></i> Supprimer</a>
            <?php } else { ?>
                <button type="submit" class="btn btn-success"><i class="fas fa-check fa-fw"></i> Créer</button>
            <?php } ?>
        </div>
    </form>
</div>
