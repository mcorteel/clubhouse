<style>
.roles span:not(:last-child)::after {
    content: ',';
}
</style>

<div class="card mb-3">
    <div class="card-header">
        <a href="<?= $this->path('/admin') ?>" class="btn btn-sm btn-light float-end">
            <i class="fas fa-arrow-left fa-fw"></i> Retour
        </a>
        <i class="fas fa-users fa-fw"></i> Utilisateurs
    </div>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Identifiant</th>
            <th>Roles</th>
            <th>Date de création</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user) {
            $_roles = array_filter(explode(',', $user['roles']));
            ?>
            <tr<?= $user['active'] ? '' : ' class="table-danger"' ?>>
                <td><?= $user['first_name']; ?> <?= $user['last_name']; ?></td>
                <td><?= $user['email']; ?></td>
                <td class="roles">
                    <?php if(isset($_roles[0]) && isset($roles[$_roles[0]])) { ?>
                        <?= $roles[$_roles[0]] ?>
                    <?php } ?>
                    <?php if(isset($_roles[1])) { ?>
                        <span class="badge bg-info">+ <?= count($_roles) - 1 ?></span>
                    <?php } ?>
                </td>
                <td><?= $this->date($user['created_at']); ?></td>
                <td class="text-end">
                    <a href="<?= $this->path('/admin/utilisateurs/' . $user['id']); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-pencil"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<a href="<?= $this->path('/admin/utilisateurs/nouveau') ?>" class="btn btn-success float-start">
    <i class="fas fa-user-plus fa-fw"></i> Nouvel utilisateur
</a>

<?= $this->pagination('/admin/utilisateurs/page/%page%', $pagination); ?>
