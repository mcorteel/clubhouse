<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <i class="fas fa-user-tie fa-fw"></i> Ressources
    </div>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Group</th>
            <th>Nom court</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($resources as $resource) { ?>
            <tr>
                <td><?= $resource['name'] ?></td>
                <td><?= $resource['group_name'] ?></td>
                <td><?= $resource['short_name'] ?></td>
                <td class="text-end">
                    <a href="<?= $this->path('/admin/ressources/' . $resource['id']); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-pencil"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<a href="<?= $this->path('/admin/ressources/nouvelle') ?>" class="btn btn-success float-start">
    <i class="fas fa-plus fa-fw"></i> Nouvelle ressource
</a>

<?= $this->pagination('/admin/ressources/page/%page%', $pagination); ?>
