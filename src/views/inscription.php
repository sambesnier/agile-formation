
<h1>Inscription</h1>
<form method="post">
    <div class="form-group">
        <input type="text" name="nom" placeholder="Nom" class="form-control">
        <input type="text" name="prenom" placeholder="Prénom" class="form-control">
        <input type="email" name="email" placeholder="Email" class="form-control">
        <input type="password" name="password" placeholder="Mot de passe" class="form-control">
        <input type="password" name="confirm" placeholder="Confirmation" class="form-control">
    </div>
    <hr>
    <div class="form-group">
        <input type="text" name="telephone" placeholder="Numéro de téléphone" class="form-control">
        <label>Homme
            <input type="radio" name="sexe" value="Homme">
        </label>
        <label>Femme
            <input type="radio" name="sexe" value="Femme">
        </label>
        <input type="number" name="numero" placeholder="Numéro de voie" class="form-control">
        <input type="text" name="voie" placeholder="Nom de la voie" class="form-control">
        <input type="text" name="ville" placeholder="Ville" class="form-control">
        <input type="text" name="codepostal" placeholder="Code postal" class="form-control">
        <input type="text" name="pays" placeholder="Pays" class="form-control">
        <label>
            <input type="checkbox" name="newsletter"> Ne pas recevoir la newsletter
        </label>

    </div>
    <div class="g-recaptcha" data-sitekey="6LctZyoUAAAAAP9artWahYZHcsHKuDNZrqGkSPCX"></div>
    <div class="form-group">
        <button class="btn btn-primary" name="submit" type="submit">Inscription</button>
    </div>
</form>
