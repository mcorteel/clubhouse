<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin/images') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <?php if($picture['id']) { ?>
            <i class="fas fa-image fa-fw"></i> <?= $picture['title']; ?>
        <?php } else { ?>
            <i class="fas fa-image fa-fw"></i> Nouvelle image
        <?php } ?>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="mb-3">
                <input type="file" class="form-control" name="file" id="file" />
            </div>
            <div class="">
                <input type="text" class="form-control" name="title" id="title" value="<?= $picture['title']; ?>" placeholder="Titre" />
            </div>
            <img class="mt-3 d-none" id="picture" />
        </div>
        <div class="card-footer text-end">
            <?php if($picture['id']) { ?>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Enregistrer</button>
                <a href="<?= $this->path('/admin/images/') . $picture['id'] . '/supprimer' ?>" class="btn btn-danger float-start"><i class="fas fa-trash fa-fw"></i> Supprimer</a>
            <?php } else { ?>
                <button type="submit" class="btn btn-success"><i class="fas fa-check fa-fw"></i> Créer</button>
            <?php } ?>
        </div>
    </form>
</div>

<script>
var titleChanged = false;
$('#title').on('input', function(e) {
    titleChanged = true;
});
$('#file').change(function(e) {
    const {target} = e;
    const {files} = target;
    
    if(FileReader && files && files.length) {
        const title = document.getElementById('title');
        if(!titleChanged) {
            title.value = files[0].name;
        }
        const fr = new FileReader();
        fr.onload = function() {
            const img = document.getElementById('picture');
            img.src = fr.result;
            img.classList.remove('d-none');
        }
        fr.readAsDataURL(files[0]);
    }
});
</script>
