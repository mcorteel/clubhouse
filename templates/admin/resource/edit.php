<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin/ressources') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <?php if($resource['id']) { ?>
            <i class="fas fa-user-tie fa-fw"></i> <?= $resource['name']; ?>
        <?php } else { ?>
            <i class="fas fa-user-tie fa-fw"></i> Nouvelle ressource
        <?php } ?>
    </div>
    <form action="" method="POST">
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Nom</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" value="<?= $resource['name']; ?>" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Groupe</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="group_name" value="<?= $resource['group_name']; ?>" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Nom court</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="short_name" value="<?= $resource['short_name']; ?>" />
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <?php if($resource['id']) { ?>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Enregistrer</button>
                <a href="<?= $this->path('/admin/ressources/') . $resource['id'] . '/supprimer' ?>" class="btn btn-danger float-start"><i class="fas fa-trash fa-fw"></i> Supprimer</a>
            <?php } else { ?>
                <button type="submit" class="btn btn-success"><i class="fas fa-check fa-fw"></i> Créer</button>
            <?php } ?>
        </div>
    </form>
</div>
