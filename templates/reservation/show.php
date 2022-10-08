<?php
$startDate = new DateTime($reservation['date_start']);
$endDate = new DateTime($reservation['date_start']);
$endDate->modify('+' . ($reservation['duration'] ? $reservation['duration'] : 1) . ' hours');
?>
<div class="modal-header">
    <h5 class="modal-title">
        Réservation
        <small><?= htmlentities($reservation['resource']['name']) ?></small>
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
</div>
<div class="modal-header">
    De <?= $startDate->format('G') ?>h à <?= $endDate->format('G') ?>h
</div>

<style>
.table .team span:not(:last-child)::after {
    content: '/';
    color: #AAA;
}
.tie-break {
    display: inline-block;
    padding: 0.2rem;
    width: 3rem;
}
</style>

<?php if($app['user']['id'] === $reservation['user']) { ?>
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Score</th>
                <?php foreach(array('A', 'B') as $team) { ?>
                    <td class="text-center">
                        <span class="team">
                            <?php foreach($reservation['players'] as $player) {
                                if($player['team'] === $team) { ?>
                                    <span>
                                        <?= $player['first_name'] ?> <?= $player['last_name'] ?>
                                    </span>
                                <?php }
                            } ?>
                        </span>
                    </td>
                <?php } ?>
            </tr>
        </thead>
        <tbody id="score">
            <tr id="set_1">
                <td>
                    1<sup>er</sup> set
                </td>
                <td class="team-A">
                    <?php for($i = 1 ; $i <= 7 ; $i++ ) { ?>
                        <button class="btn btn-light"><?= $i ?></button>
                    <?php } ?>
                    <input type="number" class="tie-break form-control" value="5" title="Tie-break" />
                </td>
                <td class="team-B">
                    <?php for($i = 1 ; $i <= 7 ; $i++ ) { ?>
                        <button class="btn btn-light"><?= $i ?></button>
                    <?php } ?>
                    <input type="number" class="tie-break form-control" value="5" title="Tie-break" />
                </td>
            </tr>
            <tr id="set_2">
                <td>
                    2<sup>ème</sup> set
                </td>
                <td class="team-A">
                    <?php for($i = 1 ; $i <= 7 ; $i++ ) { ?>
                        <button class="btn btn-light"><?= $i ?></button>
                    <?php } ?>
                    <input type="number" class="tie-break form-control" value="5" title="Tie-break" />
                </td>
                <td class="team-B">
                    <?php for($i = 1 ; $i <= 7 ; $i++ ) { ?>
                        <button class="btn btn-light"><?= $i ?></button>
                    <?php } ?>
                    <input type="number" class="tie-break form-control" value="5" title="Tie-break" />
                </td>
            </tr>
            <tr id="set_3">
                <td>
                    3<sup>ème</sup> set
                </td>
                <td class="team-A">
                    <?php for($i = 1 ; $i <= 7 ; $i++ ) { ?>
                        <button class="btn btn-light"><?= $i ?></button>
                    <?php } ?>
                    <input type="number" class="tie-break form-control" value="5" title="Tie-break" />
                </td>
                <td class="team-B">
                    <?php for($i = 1 ; $i <= 7 ; $i++ ) { ?>
                        <button class="btn btn-light"><?= $i ?></button>
                    <?php } ?>
                    <input type="number" class="tie-break form-control" value="5" title="Tie-break" />
                </td>
            </tr>
        </tbody>
    </table>
    <script>
    function updateScore() {
        $('#score .tie-break').addClass('d-none');
        let score = [
            {
                A: parseInt($('#set_1 .team-A .btn-success').text()) || null,
                B: parseInt($('#set_1 .team-B .btn-success').text()) || null,
            },
            {
                A: parseInt($('#set_2 .team-A .btn-success').text()) || null,
                B: parseInt($('#set_2 .team-B .btn-success').text()) || null,
            },
            {
                A: parseInt($('#set_3 .team-A .btn-success').text()) || null,
                B: parseInt($('#set_3 .team-B .btn-success').text()) || null,
            },
        ];
        
        score.forEach((set, i) => {
            set.wins = set.A > set.B ? 'A' : set.A < set.B ? 'B' : null;
            if(set.A !== null && set.B !== null) {
                if(set.A - set.B === 1) {
                    $('#set_' + (i + 1) + ' .team-B .tie-break').removeClass('d-none');
                } else if(set.B - set.A === 1) {
                    $('#set_' + (i + 1) + ' .team-A .tie-break').removeClass('d-none');
                }
            }
        });
        
        $('#set_2').toggleClass('d-none', score[0].wins === null);
        $('#set_3').toggleClass('d-none', score[0].wins === score[1].wins || score[2].wins === null);
        
        console.log(score);
    }
    $('#set_3').addClass('d-none');
    $('#set_2').addClass('d-none');
    $('#score .btn').click(function() {
        $(this).siblings().removeClass('btn-success').addClass('btn-light');
        $(this).removeClass('btn-light').addClass('btn-success');
        updateScore();
    });
    updateScore();
    </script>
<?php } else { ?>
    <table class="table mb-0">
        <tbody>
            <?php foreach(array('A', 'B') as $team) { ?>
                <tr>
                    <td class="ps-3">
                        <span class="team">
                            <?php foreach($reservation['players'] as $player) {
                                if($player['team'] === $team) { ?>
                                    <span>
                                        <?= $player['first_name'] ?> <?= $player['last_name'] ?>
                                    </span>
                                <?php }
                            } ?>
                        </span>
                        <?php if($score && $team === $score['wins']) { ?>
                            <i class="fas fa-trophy text-warning"></i>
                        <?php } ?>
                    </td>
                    <?php if($score) {
                        foreach($score['sets'] as $set) { ?>
                            <td>
                                <?= $set[$team] ?>
                                <?php if($set['break'] && $team !== $set['wins']) { ?>
                                    <sup><?= $set['break'] ?></sup>
                                <?php } ?>
                            </td>
                        <?php
                        }
                    } ?>
                </tr>
            <?php  } ?>
        </tbody>
    </table>
<?php } ?>

<?php if($app['user']['id'] === $reservation['user'] && (int)$startDate->format('YmdH') >= (int)date('YmdH')) { ?>
    <div class="modal-body d-flex justify-content-end">
        <a href="<?= $this->path('/reservation/cancel/') . $reservation['id'] ?>" class="btn btn-danger"><i class="fas fa-ban fa-fw"></i> Annuler la réservation</a>
    </div>
<?php } ?>
