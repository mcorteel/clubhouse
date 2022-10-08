<style>
#duration + .selectize-control {
    display: inline-block;
    width: 80px;
}
</style>

<div class="modal-header">
    <h5 class="modal-title">
        Réserver
        <small><?= htmlentities($resource['name']) ?></small>
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
</div>

<?php if(!$authorized) { ?>
    <div class="modal-body bg-warning">
        Désolé, tu as déjà une réservation sur <?= count($reservations) === 1 ? 'le créneau suivant' : 'les créneaux suivants' ?> :
        <ul class="mb-0">
            <?php foreach($reservations as $reservation) {
                $startDate = new DateTime($reservation['date_start']);
                $endDate = new DateTime($reservation['date_start']);
                $endDate->modify('+' . ($reservation['duration'] ? $reservation['duration'] : 1) . ' hours');
                ?>
                <li>
                    <?= $startDate->format('d/m/Y') ?> de <?= $startDate->format('G') ?>h à <?= $endDate->format('G') ?>h (<a href="<?= $this->path('/reservation/show/') . $reservation['id'] ?>" class="modal-link">Voir</a>)
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } else { ?>
    <form method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
        <div class="modal-body">
            <div class="row">
                <label class="form-label col-md-3 text-md-end p-md-1">Date</label>
                <div class="col-md-9 p-1 px-3">
                    <?= $time->format('d/m/Y') ?>
                </div>
            </div>
            <?php if($admin) { ?>
                <div class="row mb-1">
                    <label class="form-label col-md-3 text-md-end p-md-1">Type</label>
                    <div class="col-md-9">
                        <select id="type" name="type">
                            <option value="normal">Normal</option>
                            <option value="training">Entraînement</option>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="row mb-1">
                <label class="form-label col-md-3 text-md-end p-md-1 py-md-2">Horaire</label>
                <div class="col-md-9">
                    <?php if($maxDuration > 1) { ?>
                        <span class="d-inline-block py-2">De <?= $time->format('G') ?>h à</span>
                        <select name="duration" id="duration">
                            <?php for($i = 1 ; $i <= $maxDuration ; $i++) { ?>
                                <option value="<?= $i ?>"><?= (int)$time->format('G') + $i ?>h</option>
                            <?php } ?>
                        </select>
                    <?php } else { ?>
                        <span class="d-inline-block py-2">De <?= $time->format('G') ?>h à <?= (int)$time->format('G') + 1 ?>h</span>
                        <input type="hidden" name="duration" value="1" />
                    <?php } ?>
                </div>
            </div>
            <div class="row mb-1">
                <label class="form-label col-md-3 text-md-end p-md-1">Joueurs</label>
                <div class="col-md-9">
                    <select id="players" multiple name="players[]"></select>
                </div>
            </div>
            <?php if($admin) { ?>
                <div class="row mb-1">
                    <label class="form-label col-md-3 text-md-end p-md-1">Récurrence</label>
                    <div class="col-md-9">
                        <select id="recurrence" name="recurrence">
                            <option value="none">Aucune</option>
                            <option value="daily">Tous les jours</option>
                            <option value="weekly">Toutes les semaines</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-1 d-none" id="date_end">
                    <label class="form-label col-md-3 text-md-end p-md-1">Date de fin</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" name="date_end" />
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="reservation_submit">Réserver</button>
        </div>
    </form>
<?php } ?>

<script>
    function checkReservation() {
        let ok = (
            playerSelect.getValue().length >= <?= $minPlayers ?>
        &&
            playerSelect.getValue().length <= <?= $maxPlayers ?>
        );
        console.log(playerSelect.getValue().length);
        $('#reservation_submit').prop('disabled', !ok);
    }
    
    var playerSelect = $('#players').selectize({
        placeholder: 'Rechercher un joueur',
        options: [
            <?php foreach($players as $player) { ?>
                {value: <?= $player['id'] ?>, text: <?= json_encode(trim($player['first_name'] . ' ' . $player['last_name'])) ?>},
            <?php } ?>
            {value: 0, text: 'Invité'},
        ],
        items: [
            '<?= $app['user']['id'] ?>',
        ],
        maxItems: <?= $admin ? 10 : $maxPlayers ?>,
        onItemRemove: function(value) {
            if(value == <?= $app['user']['id'] ?>) {
                this.addItem(value);
            }
            checkReservation();
        },
        onItemAdd: function(value) {
            checkReservation();
        },
    })[0].selectize;
    
    checkReservation();
    
    $('#recurrence').selectize({
        onChange: function(value) {
            $('#date_end').toggleClass('d-none', value === 'none');
        }
    });
    $('#type, #duration').selectize();
</script>
