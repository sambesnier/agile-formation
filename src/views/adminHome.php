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
                            <?php $counter = 0; ?>
                            <?php foreach ($listPC as $item): ?>
                                <?php if ($item['libre'] == 0){
                                    $color = "green";
                                    $state = "";
                                } else {
                                    $color = "red";
                                    $state = "disabled";
                                }

                                ?>
                                <?php if ($counter == 0) : ?>
                                    <div class="row" style="margin-bottom: 10px;">
                                <?php endif; ?>
                                    <div class="col-md-4">
                                        <a href="index.php?controller=reservation&id=<?=$item['id_pc']?>" class="list-group-item <?=$state?>">
                                            <h3 class="list-group-item-heading"><?= $item["nom"] ?></h3>
                                            <i class="material-icons" style="font-size:48px; color: <?=$color?>">laptop_windows</i>
                                            <?php if ($color=="red"):?>
                                                <p>Fin à <?=$listDate[$item['id_pc']] ?></p>
                                        </a>
                                        <button type="submit" name="annulation">annuler reservation</button>
                                            <?php else :?>
                                                <p>Libre</p>
                                        </a>
                                            <?php endif ?>


                                    </div>
                                    <?php $counter++; ?>
                                    <?php if ($counter > 2) {
                                        $counter = 0;
                                    }
                                    ?>
                                <?php if ($counter == 0) : ?>
                                    </div>
                                 <?php endif; ?>
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
                                    <th>Crédit</th>
                                </tr>
                                <?php foreach ($users as $user): ?>
                                    <tr class="lines">
                                        <td><?= $user['nom'] ?></td>
                                        <td><?= $user['prenom'] ?></td>
                                        <td id="email"><?= $user['email'] ?></td>
                                        <td><?= $user['telephone'] ?></td>
                                        <td><?= $user['sexe'] ?></td>
                                        <td><?= $user['role'] ?></td>
                                        <td><?= $user['credit'] ?></td>
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
                        <div class="col-md-4" id="credit-form">
                            <h3 id="credit-form-title"></h3>
                            <form method="post">
                                <div class="form-group">
                                    <label for="credit">Nouveau crédit</label>
                                    <input type="number" min="0" name="credit" class="form-control">
                                </div>
                                <input type="email" name="emailCredit" id="emailCredit-hidden" hidden>
                                <button type="submit" name="submitCredit" class="btn btn-primary">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>