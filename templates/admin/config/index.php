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
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">Lien du calendrier</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="config[calendar_link]" value="<?= $config['calendar_link'] ?>" />
                    <div class="text-muted"><i class="fas fa-info-circle fa-fw"></i> Lien public du calendrier Nextcloud.</div>
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
</script>
