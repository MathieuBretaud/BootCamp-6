<a href="<?= $router->generate('user-add') ?>" class="btn btn-success float-right">Ajouter</a>
<h2>Liste des utilisateurs</h2>
<table class="table table-hover mt-4">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Email</th>
            <th scope="col">role</th>
            <th scope="col">status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listeUser as $user) : ?>
        <tr>
            <th scope="row"><?=$user->getID()?></th>
            <td><?=$user->getEmail()?></td>
            <td><?=$user->getRole()?></td>
            <td>
            <?php if ($user->getStatus() === "1"): ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-toggle2-on" viewBox="0 0 16 16">
                <path d="M7 5H3a3 3 0 0 0 0 6h4a4.995 4.995 0 0 1-.584-1H3a2 2 0 1 1 0-4h3.416c.156-.357.352-.692.584-1z"/>
                <path d="M16 8A5 5 0 1 1 6 8a5 5 0 0 1 10 0z"/>
                </svg>
            <?php endif; ?>
            <?php if ($user->getStatus() === "2"): ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-toggle2-off" viewBox="0 0 16 16">
                <path d="M9 11c.628-.836 1-1.874 1-3a4.978 4.978 0 0 0-1-3h4a3 3 0 1 1 0 6H9z"/>
                <path d="M5 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1A5 5 0 1 0 5 3a5 5 0 0 0 0 10z"/>
                </svg>
            <?php endif; ?>

</td>
            <td class="text-right">
                <a href="#" class="btn btn-sm btn-warning">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <!-- Example single danger button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
                        <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>