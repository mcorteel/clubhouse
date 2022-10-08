<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <i class="fas fa-bullhorn fa-fw"></i> Actualités
    </div>
</div>

<style>
td.title * {
    font-size: 1rem;
    font-weight: normal;
    display: inline;
}
</style>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Date</th>
            <th>Titre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($news as $_news) {
            $date = new DateTime($_news['date']);
            ?>
            <tr>
                <td><?= $date->format('d/m/Y') ?></td>
                <td class="title"><?= $_news['title'] ?></td>
                <td class="text-end">
                    <a href="<?= $this->path('/admin/actualites/' . $_news['id']); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-pencil"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<a href="<?= $this->path('/admin/actualites/nouvelle') ?>" class="btn btn-success float-start">
    <i class="fas fa-plus fa-fw"></i> Nouvelle actualité
</a>

<?= $this->pagination('/admin/actualites/page/%page%', $pagination); ?>
