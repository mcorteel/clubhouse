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
            <div class="card bar-chart mb-3">
                <div class="card-header">
                    Heure de début la plus réservée
                </div>
                <div class="card-body">
                    <?php
                    $max = empty($reservations['hours']) ? 0 : max($reservations['hours']);
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
            <div class="card bar-chart mb-3">
                <div class="card-header">
                    Réservations par semaine
                </div>
                <div class="card-body">
                    <?php
                    $max = empty($reservations['weeks']) ? 0 : max($reservations['weeks']);
                    for($date = new DateTime('52 weeks ago') ; $date->format('Ymd') <= date('Ymd') ; $date->modify('+1 week')) {
                        ?>
                        <div style="width: <?= 100 / 52 ?>%" class="bar-chart-column">
                            <div class="bar-chart-label" title="Semaine <?= (int)$date->format('W') ?> <?= $date->format('Y') ?>"><?= (int)$date->format('W') ?></div>
                            <?php if(isset($reservations['weeks'][$date->format('YW')])) {
                                $value = $reservations['weeks'][$date->format('YW')];
                                ?>
                                <div class="bar-chart-bar" style="height:<?= round($value / $max * 100) ?>%" title="<?= $value ?>"></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card bar-chart mb-3">
                <div class="card-header">
                    Resources les plus réservées
                </div>
                <div class="card-body">
                    <?php
                    $max = empty($reservations['resources']) ? 0 : max($reservations['resources']);
                    foreach($reservations['resources'] as $name => $value) {
                        ?>
                        <div style="width: <?= 100 / count($reservations['resources']) ?>%" class="bar-chart-column">
                            <div class="bar-chart-label"><?= $name ?></div>
                            <div class="bar-chart-bar" style="height:<?= round($value / $max * 100) ?>%" title="<?= $value ?>"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
</div>
