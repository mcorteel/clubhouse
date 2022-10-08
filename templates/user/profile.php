<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/utilisateur') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        Mon profil
    </div>
    <form action="" method="POST">
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Nom</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Prénom" value="<?= $app['user']['first_name']; ?>" disabled />
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Nom de famille" value="<?= $app['user']['last_name']; ?>" disabled />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">E-mail</label>
                <div class="col-md-8">
                    <input type="email" class="form-control" name="email" value="<?= $app['user']['email']; ?>" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label change-password d-none text-md-end">Mot de passe actuel</label>
                <label class="col-md-4 col-form-label text-md-end change-password"></label>
                <div class="col-md-8">
                    <input type="password" class="form-control d-none change-password" name="password" />
                    <button class="btn btn-secondary change-password" type="button" id="edit_password">Modifier mon mot de passe</button>
                </div>
            </div>
            <div class="row mb-3 d-none change-password">
                <label class="col-md-4 col-form-label text-md-end">Nouveau mot de passe</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="new_password" />
                </div>
            </div>
            <div class="row mb-3 d-none change-password">
                <label class="col-md-4 col-form-label text-md-end">Confirmation</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="password_confirmation" />
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Enregistrer</button>
        </div>
    </form>
</div>

<script>
document.getElementById('edit_password').addEventListener('click', function(e) {
    $('.change-password').toggleClass('d-none');
});
<?php if(isset($_POST['password']) && $_POST['password']) { ?>
    $('.change-password').toggleClass('d-none');
<?php } ?>
</script>
