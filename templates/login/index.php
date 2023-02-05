<div class="row">
    <div class="col-md-6<?= $registration ? '' : ' offset-md-3' ?>">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-sign-in fa-fw"></i> Connexion
            </div>
            <?php if($loginError) { ?>
                <div class="card-footer alert-danger text-center">
                    <i class="fas fa-exclamation-circle fa-fw"></i> <?= $loginError ?>
                </div>
            <?php } ?>
            <form action="" method="POST" class="card-body">
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Identifiant</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="email" autofocus />
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
                        <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in fa-fw"></i> Connexion</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if($registration) { ?>
        <div class="col-md-<?= $registration ? 6 : 12 ?>">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-user-plus fa-fw"></i> Pas encore de compte ?
                </div>
                <?php if(isset($registered) && !$registrationError) { ?>
                    <div class="card-footer alert-success text-center">
                        <i class="fas fa-info-circle fa-fw"></i> Votre compte a bien été créé.
                        <?php if($verify) { ?>
                            Un administrateur doit vérifier votre compte avant de vous autoriser à vous connecter.
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <?php if($registrationError) { ?>
                        <div class="card-footer alert-danger text-center">
                            <i class="fas fa-exclamation-circle fa-fw"></i> <?= $registrationError ?>
                        </div>
                    <?php } else { ?>
                        <div class="card-footer alert-info text-center">
                            <i class="fas fa-info-circle fa-fw"></i> Pour créer un compte, veuillez saisir les informations ci-dessous.
                        </div>
                    <?php } ?>
                    <form action="<?= $this->path('/register'); ?>" method="POST" class="card-body">
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Prénom</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="first_name" value="<?= isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>" autofocus required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Nom</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="last_name" value="<?= isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>" autofocus />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Identifiant</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" autofocus required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Mot de passe</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="password" required minlength="6" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Créer mon compte</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
