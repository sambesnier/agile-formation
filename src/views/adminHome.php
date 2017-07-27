<h1>Panneau d'administration</h1>

    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Gestion des PCs</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse in">
                <div class="panel-body">
                        <div class="list-group">
                            <?php foreach ($listPC as $item): ?>
                                <?php if ($item['libre'] == 0){
                                    $color = "green";
                                    $state = "";
                                } else {
                                    $color = "red";
                                    $state = "disabled";
                                }

                                ?>

                                <a href="index.php?controller=gestionPC&id=<?=$item['id_pc']?>" class="list-group-item <?=$state?>">
                                    <h3 class="list-group-item-heading"><?= $item["nom"] ?></h3>
                                    <span class="glyphicon glyphicon-object-align-bottom" style="color: <?=$color?>"></span>

                                </a>
                            <?php endforeach; ?>
                        </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Gestion des utilisateurs</a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered" id="table-users">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>email</th>
                                    <th>Téléphone</th>
                                    <th>Sexe</th>
                                    <th>Role</th>
                                </tr>
                                <?php foreach ($users as $user): ?>
                                    <tr class="lines">
                                        <td><?= $user['nom'] ?></td>
                                        <td><?= $user['prenom'] ?></td>
                                        <td id="email"><?= $user['email'] ?></td>
                                        <td><?= $user['telephone'] ?></td>
                                        <td><?= $user['sexe'] ?></td>
                                        <td><?= $user['role'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <div class="col-md-4" id="role-form">
                            <h3 id="role-form-title"></h3>
                            <form method="post">
                                <div class="form-group">
                                <label for="role">Nouveau rôle</label>
                                    <select name="role" class="form-control">
                                        <option value="0">-</option>
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="USER">USER</option>
                                    </select>
                                </div>
                                <input type="email" name="email" id="email-hidden" hidden>
                                <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>