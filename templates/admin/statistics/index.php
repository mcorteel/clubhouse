<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <i class="fas fa-chart-pie fa-fw"></i> statistics
    </div>
    <ul class="nav nav-tabs card-body">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= $this->path('/admin/statistics') ?>#users" id="users_toggle">Utilisateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?= $this->path('/admin/statistics') ?>#reservations" id="reservations_toggle">Réservations</a>
        </li>
    </ul>
    <form action="" method="POST" class="tab-content">
        <div class="card-body tab-pane active" id="tab_users">
            <div class="card">
                <div class="card-header">
                    Nombre d'utilisateurs
                </div>
                <div class="card-body text-center">
                    <?= $users['count'] ?>
                </div>
            </div>
        </div>
        <div class="card-body tab-pane" id="tab_reservations">
            <div class="card bar-chart">
                <div class="card-header">
                    Heure de début la plus réservée
                </div>
                <div class="card-body">
                    <?php
                    $max = max($reservations['hours']);
                    $hours = $reservations['config']['max_hour'] - $reservations['config']['min_hour'] - 1;
                    for($i = $reservations['config']['min_hour'] ; $i < $reservations['config']['max_hour'] ; $i++) {
                        ?>
                        <div style="width: <?= 100 / $hours ?>%" class="bar-chart-column">
                            <div class="bar-chart-label"><?= $i ?>h</div>
                            <?php if(isset($reservations['hours'][$i])) {
                                $value = $reservations['hours'][$i];
                                ?>
                                <div class="bar-chart-bar" style="height:<?= round($value / $max * 100) ?>%" title="<?= $value ?>"></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
</div>
