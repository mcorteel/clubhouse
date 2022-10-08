<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <i class="fas fa-user-tie fa-fw"></i> Partenaires
    </div>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Informations</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($partners as $partner) { ?>
            <tr>
                <td><?= $partner['name'] ?></td>
                <td><?= nl2br($partner['description']) ?></td>
                <td class="text-end">
                    <a href="<?= $this->path('/admin/partenaires/' . $partner['id']); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-pencil"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<a href="<?= $this->path('/admin/partenaires/nouveau') ?>" class="btn btn-success float-start">
    <i class="fas fa-plus fa-fw"></i> Nouveau partenaire
</a>

<?= $this->pagination('/admin/partenaires/page/%page%', $pagination); ?>
