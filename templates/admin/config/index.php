<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <i class="fas fa-wrench fa-fw"></i> Configuration
    </div>
    <ul class="nav nav-tabs card-body">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?= $this->path('/admin/config') ?>#general" id="general_toggle">Général</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= $this->path('/admin/config') ?>#users" id="users_toggle">Utilisateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= $this->path('/admin/config') ?>#reservation" id="reservation_toggle">Réservations</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= $this->path('/admin/config') ?>#other" id="other_toggle">Autres</a>
        </li>
    </ul>
    <form action="" method="POST" class="tab-content">
        <div class="card-body tab-pane active" id="tab_general">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Titre du site</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="config[meta_title]" value="<?= $config['meta_title'] ?>" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Description du site</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="config[meta_description]" value="<?= $config['meta_description'] ?>" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Mots-clés du site</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="config[meta_keywords]" value="<?= $config['meta_keywords'] ?>" />
                    <div class="text-muted">
                        <i class="fas fa-info-circle fa-fw"></i> Ces mots-clés permettent d'améliorer l'indexation du site sur les moteurs de recherche.
                    </div>
                </div>
            </div>
            <hr />
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Adresse du club</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="config[club_address]"><?= $config['club_address'] ?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">E-mail du club</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="config[club_email]" value="<?= $config['club_email'] ?>" />
                </div>
            </div>
        </div>
        <div class="card-body tab-pane" id="tab_users">
            <div class="row mb-3 toggle-root" data-target=".if-user-registration-allow">
                <div class="col-md-8 offset-md-4">
                    <input type="checkbox" class="form-check-input" id="user_registration_allow" name="config[user_registration_allow]"<?= $config['user_registration_allow'] ? ' checked' : '' ?> />
                    <label class="form-check-label" for="user_registration_allow">Autoriser la création de compte</label>
                </div>
            </div>
            <div class="row mb-3 if-user-registration-allow">
                <div class="col-md-8 offset-md-4">
                    <input type="checkbox" class="form-check-input" id="user_registration_verify" name="config[user_registration_verify]"<?= $config['user_registration_verify'] ? ' checked' : '' ?> />
                    <label class="form-check-label" for="user_registration_verify">Vérifier les comptes créés</label>
                    <div class="text-muted">
                        <i class="fas fa-exclamation-triangle fa-fw"></i> Si cette option est désactivée, n'importe qui pourra se connecter dès la création de son compte.
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Permissions par défaut</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="config[user_registration_roles]" value="<?= $config['user_registration_roles'] ?>" />
                    <div class="text-muted">
                        <i class="fas fa-info-circle fa-fw"></i> Clé de chaque permission, séparées par des virgules.
                    </div>
                </div>
            </div>
            <hr />
            <div class="alert alert-info">
                <i class="fas fa-info-circle fa-fw"></i>  Si vous souhaitez empêcher des robots de créer des comptes sur votre site (ce qui est fortement recommandé), vous pouvez utiliser le service reCAPTCHA. Pour cela, <a href="https://www.google.com/recaptcha/admin" target="_blank">rendez-vous sur le site de reCAPTCHA</a> et suivez la configuration pour <a href="https://www.google.com/recaptcha/admin/create" target="_blank">créer des identifiants reCAPTCHA v2</a>.
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Clé reCAPTCHA</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="config[recaptcha_key]" value="<?= $config['recaptcha_key'] ?>" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Clé secrète reCAPTCHA</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="config[recaptcha_secret]" value="<?= $config['recaptcha_secret'] ?>" />
                </div>
            </div>
        </div>
        <div class="card-body tab-pane" id="tab_reservation">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Message du panneau de réservation</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="config[reservation_message]"><?= $config['reservation_message'] === null ? '' : $config['reservation_message'] ?></textarea>
                </div>
            </div>
            <hr />
            <div class="row mb-3">
                <div class="col-md-8 offset-md-4">
                    <input type="checkbox" class="form-check-input" id="reservation_include_self" name="config[reservation_include_self]"<?= $config['reservation_include_self'] ? ' checked' : '' ?> />
                    <label class="form-check-label" for="reservation_include_self">Ne pas permettre de réserver pour les autres</label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-8 offset-md-4">
                    <input type="checkbox" class="form-check-input" id="reservation_allow_guests" name="config[reservation_allow_guests]"<?= $config['reservation_allow_guests'] ? ' checked' : '' ?> />
                    <label class="form-check-label" for="reservation_allow_guests">Autoriser les invités</label>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Nombre maximum de réservations</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="config[reservation_limit]" value="<?= $config['reservation_limit'] ?>" min="1" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Subdivision des réservations</label>
                <div class="col-md-4">
                    <select name="config[reservation_subdivision]">
                        <option value="15"<?= $config['reservation_subdivision'] == 15 ? ' selected' : '' ?>>15 minutes</option>
                        <option value="30"<?= $config['reservation_subdivision'] == 30 ? ' selected' : '' ?>>30 minutes</option>
                        <option value="60"<?= $config['reservation_subdivision'] == 60 ? ' selected' : '' ?>>1 heure</option>
                    </select>
                </div>
                <div class="offset-md-4 col-md-8 text-muted">
                    <i class="fas fa-exclamation-triangle fa-fw"></i> Le changement de cette configuration peut casser l'affichage du tableau des réservations déjà effectuées.
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Durée maximale de réservation (subdivisions)</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="config[reservation_max_duration]" value="<?= $config['reservation_max_duration'] ?>" min="1" />
                </div>
            </div>
            <hr />
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Horaire minimal de réservation</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="config[reservation_min_hour]" value="<?= $config['reservation_min_hour'] ?>" min="1" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Horaire maximal de réservation</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="config[reservation_max_hour]" value="<?= $config['reservation_max_hour'] ?>" min="1" />
                </div>
            </div>
            <hr />
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Nombre minimal de joueurs</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="config[reservation_min_players]" value="<?= $config['reservation_min_players'] ?>" min="1" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Nombre maximal de joueurs</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="config[reservation_max_players]" value="<?= $config['reservation_max_players'] ?>" min="1" />
                </div>
            </div>
        </div>
        <div class="card-body tab-pane" id="tab_other">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Dossier de stockage des photos</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="config[picture_dir]" value="<?= $config['picture_dir'] ?>" />
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Enregistrer</button>
        </div>
    </form>
</div>
<script>
$('select').selectize();
$('input[type=checkbox]').each(function() {
    $(this).parent().append('<input type="hidden" value="' + ($(this).prop('checked') ? '1' : '0') + '" name="' + $(this).attr('name') + '" />');
    $(this).on('change', function() {
        $(this).parent().find('input[type=hidden]').val($(this).prop('checked') ? '1' : '0');
    });
});
</script>
