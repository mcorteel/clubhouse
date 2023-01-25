<?php
$yesterday = clone $date;
$yesterday->modify('-1 day');
$tomorrow = clone $date;
$tomorrow->modify('+1 day');

if(!empty($resources)) {
    ?>

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-center">
            <div class="flex-grow-1"><i class="far fa-calendar fa-fw"></i> <span class="d-none d-md-inline">Réservation</span></div>
            <div class="text-center">
                <?php if($date->format('Y-m-d') === date('Y-m-d')) { ?>
                    Aujourd'hui
                <?php } elseif($tomorrow->format('Y-m-d') === date('Y-m-d')) { ?>
                    Hier
                <?php } elseif($yesterday->format('Y-m-d') === date('Y-m-d')) { ?>
                    Demain
                <?php } else { ?>
                    <?= $date->format('d/m/Y') ?>
                <?php } ?>
            </div>

            <div class="flex-grow-1 text-end">
                <a href="<?= $this->path('/reservation/' . $yesterday->format('Y-m-d')); ?>" title="Un jour avant"><i class="far fa-circle-left fa-fw"></i></a>
                <?php if($date->format('Y-m-d') !== date('Y-m-d')) { ?>
                    <a href="<?= $this->path('/reservation/') . date('Y-m-d'); ?>" title="Revenir à ajourd'hui"><i class="far fa-calendar fa-fw"></i></a>
                <?php } ?>
                <a href="<?= $this->path('/reservation/' . $tomorrow->format('Y-m-d')); ?>" title="Un jour après"><i class="far fa-circle-right fa-fw"></i></a>
            </div>
        </div>
    </div>

    <?php if(!$app['user']) { ?>
        <p class="alert alert-info">Pour réserver un court, <a href="<?= $this->path('/login') ?>">veuillez vous connecter</a>.</p>
    <?php } elseif($message) { ?>
        <p class="alert alert-info"><?= nl2br($message) ?></p>
    <?php } ?>

    <table class="table table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <th rowspan=2 style="width: 50px;"></th>
                <?php
                $resourceGroup = null;
                $count = 0;
                foreach($resources as $resource) {
                    if($resource['group_name'] !== $resourceGroup) {
                        if($resourceGroup !== null) {
                            ?>
                            <th colspan=<?= $count ?>><?= htmlentities($resourceGroup) ?></th>
                            <?php
                        }
                        $count = 1;
                    } else {
                        $count++;
                    }
                    $resourceGroup = $resource['group_name'];
                }
                ?>
                <th colspan=<?= $count ?>><?= htmlentities($resourceGroup) ?></th>
            </tr>
            <tr class="text-center">
                <?php
                foreach($resources as $resource) {
                    ?>
                    <th><?= htmlentities($resource['short_name']) ?></th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        
        <tbody>
            <?php
            for($i = $minHour * 60 ; $i < $maxHour * 60 ; $i = $i + $subdivision) {
                $h = str_pad(floor($i / 60), 2, '0', STR_PAD_LEFT);
                $m = str_pad($i % 60, 2, '0', STR_PAD_LEFT);
                ?>
                <tr class="text-center">
                    <th class="text-end text-nowrap<?= $m != 0 ? ' text-muted" style="font-weight: normal;' : '' ?>">
                        <?= $h ?>h<?= $subdivision != 60 ? $m : '' ?>
                    </th>
                    <?php foreach($resources as $r => $resource) {
                        if(isset($resource['reservations'][$i])) {
                            $reservation = $resource['reservations'][$i];
                            if($reservation !== false) {
                                $type = $types[$reservation['type']];
                                $startDate = new DateTime($reservation['date_start']);
                                $duration = $reservation['duration'] ? $reservation['duration'] : $subdivision;
                                for($j = $subdivision ; $j < $duration ; $j = $j + $subdivision) {
                                    $resources[$r]['reservations'][$i + $j] = false;
                                }
                                if($canCreate) {
                                    $players = array();
                                    foreach($reservation['players'] as $p) {
                                        // NOTE Doesn't work
                                        $players[] = $p['id'] == $app['user']['id'] ? 'Moi' : trim($p['first_name'] . ' ' . $p['last_name']);
                                    }
                                    ?>
                                    <td class="table-warning modal-link" data-url="<?= $this->path('/reservation/show/') . $reservation['id'] ?>" rowspan="<?= $duration / $subdivision ?>" style="vertical-align: middle; --bs-table-bg: <?= $type['color'] ?>" title="<?= implode(', ', $players) ?>">
                                        <i class="fas fa-<?= $type['icon'] ?> fa-fw"></i> <span class="d-none d-lg-inline"><?= count($reservation['players']) ?> joueurs</span>
                                    </td>
                                    <?php
                                } else {
                                    ?>
                                    <td class="table-warning" rowspan="<?= $duration ?>" style="vertical-align: middle; --bs-table-bg: <?= $type['color'] ?>">
                                        <i class="fas fa-<?= $type['icon'] ?> fa-fw"></i> <span class="d-none d-lg-inline"><?= count($reservation['players']) ?> joueurs</span>
                                    </td>
                                    <?php
                                }
                            }
                        } else {
                            // FIXME This should take subdivision into account
                            $reservable = bccomp($date->format('Ymd') . $h . $m, date('YmdHi')) >= 0;
                            ?>
                            <td class="<?php if($canCreate && $reservable) {?> modal-link table-success" data-url="<?= $this->path('/reservation/create', array('resource' => $resource['id'], 'time' => $date->format('Y-m-d ') . $h . ':' . $m . ':00')) ?><?php } elseif(!$canCreate && $reservable) { ?> table-success<?php } else { ?> table-secondary<?php } ?>">
                                <i class="fas fa-check fa-fw"></i> <span class="d-none d-lg-inline">Libre</span>
                            </td>
                            <?php
                        }
                    } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <div class="text-muted text-center m-5"><i class="fas fa-face-smile-wink fa-fw"></i> Aucune resource configurée, il est impossible d'afficher les réservations.</div>
<?php } ?>
