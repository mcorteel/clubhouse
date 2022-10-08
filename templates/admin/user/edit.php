<?php
$_roles = explode(',', $user['roles']);
?>
<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin/utilisateurs') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <?php if($user['id']) { ?>
            <i class="fas fa-user fa-fw"></i> <?= $user['first_name']; ?> <?= $user['last_name']; ?>
        <?php } else { ?>
            <i class="fas fa-user-plus fa-fw"></i> Nouvel utilisateur
        <?php } ?>
    </div>
    <form action="" method="POST">
        <div class="card-body">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Nom</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="first_name" placeholder="Prénom" value="<?= $user['first_name']; ?>" />
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="last_name" placeholder="Nom de famille" value="<?= $user['last_name']; ?>" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">E-mail</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="email" value="<?= $user['email']; ?>" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Permissions</label>
                <div class="col-md-8">
                    <?php foreach($roles as $value => $title) { ?>
                        <div class="mt-2 form-check">
                            <input type="checkbox" name="roles[]" value="<?= $value ?>" class="form-check-input" id="role_<?= $value ?>"<?php if(in_array($value, $_roles)) { ?> checked="checked"<?php } ?> />
                            <label class="form-check-label" for="role_<?= $value ?>"><?= $title ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Type de réservation</label>
                <div class="col-md-8">
                    <?php foreach($reservationTypes as $value => $type) { ?>
                        <div class="mt-2 form-radio">
                            <input type="radio" name="reservation_type" value="<?= $value ?>" class="form-radio-input" id="rtype_<?= $value ?>"<?php if($value === $user['reservation_type']) { ?> checked="checked"<?php } ?> />
                            <label class="form-check-label" for="rtype_<?= $value ?>"><?= $type['name'] ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Mot de passe</label>
                <div class="col-md-8">
                    <?php if($user['id']) { ?>
                        <input type="password" class="form-control d-none" name="password" id="password_field" />
                        <button class="btn btn-secondary" type="button" id="edit_password">Modifier</button>
                    <?php } else { ?>
                        <input type="password" class="form-control" name="password" />
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <?php if($user['id']) { ?>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Enregistrer</button>
            <?php } else { ?>
                <button type="submit" class="btn btn-success"><i class="fas fa-check fa-fw"></i> Créer</button>
            <?php } ?>
        </div>
    </form>
</div>

<script>
document.getElementById('edit_password').addEventListener('click', function(e) {
    const field = document.getElementById('password_field')
    field.classList.remove('d-none');
    field.focus();
    e.target.classList.add('d-none');
});
</script>
