<h1>Bienvenue <?=$_SESSION['user']['prenom']?> <?=$_SESSION['user']['nom']?> sur votre Espace Client</h1>

<h2>Vos informations</h2>
<form method="post">
    <div class="form-group">
        <label>Votre nom</label>
        <input type="text" class="form-control" name="name" value="<?=$_SESSION['user']['nom']?>">
    </div>
    <div class="form-group">
        <label>Votre prénom</label>
        <input type="text" class="form-control" name="firstname" value="<?=$_SESSION['user']['prenom']?>">
    </div>
    <div class="form-group">
        <label>Votre numéro de téléphone</label>
        <input type="text" class="form-control" name="telephone" value="<?=$_SESSION['user']['telephone']?>">
    </div>
    <button type="submit" name="submitInfo" class="btn btn-default">Modifier</button>
</form>

<br>
<h2>Votre crédit</h2>
<form>
    <div class="form-group">
        <h3>Votre crédit à ce jour est de <?=$_SESSION['user']['credit']?> €</h3>
    </div>
</form>

<br>
<h2>Newsletter</h2>
<form method="post">
    <div class="form-group">
        <?php if ($_SESSION['user']['newsletter'] == "O"):?>
        <h3>Vous êtes inscrit à la newsletter</h3>
        <button type="submit" name="submitLetter" class="btn btn-default">Se désinscrire</button>
        <?php else:?>
        <h3>Vous n'êtes pas inscrit à la newsletter</h3>
        <button type="submit" name="submitLetter" class="btn btn-default">S'inscrire</button>
        <?php endif;?>
    </div>
</form>
