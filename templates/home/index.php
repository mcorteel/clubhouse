<?php

$parsedown = null;
if(version_compare(PHP_VERSION, '5.3.0') >= 0) {
    require(dirname(__FILE__) . '/../../vendor/Parsedown.php');
    $parsedown = new Parsedown();
}

foreach($articles as $article) { ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-calendar fa-fw"></i> <?= $this->date($article['date'], true) ?> <em>par <?= $article['name'] ?></em>
            <?php if($this->isGranted($app['user'], 'admin_news')) { ?>
                <a href="<?= $this->path('/admin/actualites/' . $article['id']) ?>" class="float-end link-light"><i class="fas fa-pencil"></i></a>
            <?php } ?>
        </div>
        <div class="card-body">
            <h2><?= $article['title'] ?></h2>
            <?= $parsedown ? $parsedown->text($article['content']) : $article['content'] ?>
        </div>
    </div>
<?php }
if(empty($articles)) { ?>
    <div class="text-muted text-center m-5"><i class="fas fa-face-smile-wink fa-fw"></i> Pas de nouvelles, bonne nouvelle !</div>
<?php } ?>

<?= $this->pagination('/actualites/page/%page%', $pagination); ?>
