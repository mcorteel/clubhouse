<style>
.players span:not(:last-child)::after {
    content: ',';
}
</style>

<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/utilisateur') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <i class="fas fa-users fa-fw"></i> Mes réservations
    </div>
</div>

<table class="table table-hover mb-1">
    <thead>
        <tr>
            <th>Date</th>
            <th>Joueurs</th>
            <th class="d-none">Score</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($reservations as $reservation) {
            $date = new DateTime($reservation['date_start']);
            ?>
            <tr<?php if((int)$date->format('YmdH') < (int)date('YmdH')) { ?> class="table-secondary"<?php } ?>>
                <td><?= $date->format('d/m/Y \à H'); ?>h</td>
                <td class="players">
                    <?php foreach($reservation['players'] as $player) {
                        if($player['id'] === $app['user']['id']) {
                            continue;
                        }
                        ?>
                        <span><?= trim($player['name']) ?></span>
                    <?php } ?>
                </td>
                <td class="d-none"><?= $reservation['score'] ?></td>
                <td class="text-end">
                    <?php if($reservation['user'] === $app['user']['id']) { ?>
                        <a href="<?= $this->path('/reservation/show/' . $reservation['id']); ?>" class="btn btn-sm btn-primary modal-link">
                            <i class="fas fa-pencil"></i>
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<p class="text-muted"><i class="fas fa-info-circle"></i> Les réservations récurrentes ne sont pas affichées.</p>

<?= $this->pagination('/utilisateur/reservations/page/%page%', $pagination); ?>
