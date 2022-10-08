<div class="row">
    <?php if($permissions['users']) { ?>
        <div class="col-md-4">
            <a href="<?= $this->path('/admin/utilisateurs'); ?>" class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-users fa-fw"></i> Utilisateurs
                </div>
                <div class="card-body">
                    Gérer les utilisateurs
                </div>
            </a>
        </div>
    <?php } ?>
    <?php if($permissions['news']) { ?>
        <div class="col-md-4">
            <a href="<?= $this->path('/admin/actualites'); ?>" class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-bullhorn fa-fw"></i> Actualités
                </div>
                <div class="card-body">
                    Ajouter des actualités
                </div>
            </a>
        </div>
    <?php } ?>
    <?php if($permissions['pictures']) { ?>
        <div class="col-md-4">
            <a href="<?= $this->path('/admin/images'); ?>" class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-image fa-fw"></i> Images
                </div>
                <div class="card-body">
                    Gérer les images
                </div>
            </a>
        </div>
    <?php } ?>
    <?php if($permissions['partners']) { ?>
        <div class="col-md-4">
            <a href="<?= $this->path('/admin/partenaires'); ?>" class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-user-tie fa-fw"></i> Partenaires
                </div>
                <div class="card-body">
                    Gérer les partenaires
                </div>
            </a>
        </div>
    <?php } ?>
    <?php if($permissions['config']) { ?>
        <div class="col-md-4">
            <a href="<?= $this->path('/admin/config'); ?>" class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-wrench fa-fw"></i> Configuration
                </div>
                <div class="card-body">
                    Gérer la configuration
                </div>
            </a>
        </div>
    <?php } ?>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-code fa-fw"></i> Informations techniques
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-md-4 text-md-end">Version de PHP</dt>
            <dd class="col-md-8"><?= phpversion() ?></dd>
            <dt class="col-md-4 text-md-end">Version de MySQL</dt>
            <dd class="col-md-8"><?= $db_version ?></dd>
        </dl>
    </div>
</div>
