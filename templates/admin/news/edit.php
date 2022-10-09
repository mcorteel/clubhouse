<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin/actualites') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <?php if($news['id']) { ?>
            <i class="fas fa-bullhorn fa-fw"></i> <?= $news['title']; ?>
        <?php } else { ?>
            <i class="fas fa-bullhorn fa-fw"></i> Nouvelle actualité
        <?php } ?>
    </div>
    <form action="" method="POST">
        <div class="card-body">
            <div class="mb-3">
                <input type="text" class="form-control" name="title" value="<?= $news['title']; ?>" placeholder="Titre" />
            </div>
            <div class="">
                <textarea class="form-control" name="content" style="min-height: 25rem" id="content"><?= $news['content'] ?></textarea>
            </div>
        </div>
        <div class="card-footer text-end">
            <?php if($news['id']) { ?>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Enregistrer</button>
                <a href="<?= $this->path('/admin/actualites/') . $news['id'] . '/supprimer' ?>" class="btn btn-danger float-start"><i class="fas fa-trash fa-fw"></i> Supprimer</a>
            <?php } else { ?>
                <button type="submit" class="btn btn-success"><i class="fas fa-check fa-fw"></i> Créer</button>
            <?php } ?>
        </div>
    </form>
</div>

<?php if(version_compare(PHP_VERSION, '5.3.0') >= 0) { ?>
<script>
new SimpleMDE({
    element: document.getElementById('content'),
    status: false,
    spellChecker: false,
    placeholder: 'Contenu',
});
</script>
<?php } ?>
