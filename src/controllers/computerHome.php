<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 25/07/2017
 * Time: 09:49
 */

$connexion = getPDO();
$sql = 'SELECT * FROM pcs';
$listPC = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM reservations';
$listReserv = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$listDate = [];
foreach ($listReserv as $item){
    if (time() > strtotime($item['fin'])){
        $id_PC = $item['id_pc'];
        $sql = 'UPDATE pcs SET libre=0 WHERE id_pc=:id_pc';
        $param['id_pc'] = $id_PC;
        $stm = $connexion->prepare($sql);
        $stm->execute($param);

        $sql = 'DELETE FROM reservations WHERE id_pc=:id_pc';
        $stm = $connexion->prepare($sql);
        $stm->execute($param);
    }
    $date = explode(" ",$item['fin']);
    $listDate[$item['id_pc']] = $date[1];
}





renderView(
    'computerHome',
    [
        'pageTitle' => 'Bienvenue au Cyber Café',
        'listPC' => $listPC,
        'listDate' => $listDate
    ]
);