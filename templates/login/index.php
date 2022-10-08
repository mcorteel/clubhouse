<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-sign-in fa-fw"></i> Connexion
    </div>
    <?php if($error) { ?>
        <div class="card-footer alert-danger text-center">
            <i class="fas fa-exclamation-circle fa-fw"></i> <?= $error ?>
        </div>
    <?php } ?>
    <form action="" method="POST" class="card-body">
        <div class="row mb-3">
            <label class="col-md-4 col-form-label text-md-end">E-mail</label>
            <div class="col-md-8">
                <input type="text" class="form-control" name="email" />
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-md-4 col-form-label text-md-end">Mot de passe</label>
            <div class="col-md-8">
                <input type="password" class="form-control" name="password" />
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">Connexion</button>
            </div>
        </div>
    </form>
</div>
