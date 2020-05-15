<?php
include '../database/connexpdo.php';

//Connect BDD
try{
$db = connexpdo('pgsql:dbname=grapheactions;host=localhost;port=5433','postgres','new_password');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //pour activer l'affichage des erreurs pdo
} catch(PDOException $e){
echo 'ERROR: ' . $e->getMessage();
}

//Connect BDD
$db = connexpdo('pgsql:dbname=grapheactions;host=localhost;port=5433','postgres','new_password');

header ("Content-type: image/png");
$image = imagecreate(600,600);

$gris = imagecolorallocate($image, 125, 125, 125);
$blanc = imagecolorallocate($image, 255, 255, 255);
$vert = imagecolorallocate($image, 0, 255, 0);
$rouge = imagecolorallocate($image, 255, 0, 0);


$nbrActionsAls = 0;
$nbrActionsFor = 0;

$grapheAls=array();
$grapheFor=array();

$sqlQ1 = "SELECT valeur, action  FROM statistique";
$sqlA1 = $db->query($sqlQ1);

foreach ($sqlA1 as $data){
    if ($data['action']=="Als"){
        array_push($grapheAls, $data['valeur']);
        $nbrActionsAls++;
    }
    if ($data['action']=="For"){
        array_push($grapheFor, $data['valeur']);
        $nbrActionsFor++;
    }
}

// Add in graph values
for ($i=0; $i<10; $i++){
imageline($image, $i*60, (350-$grapheAls[$i]), ($i+1)*60, (350-$grapheAls[$i+1]), $blanc);
}
// Add in graph values
for ($i=0; $i<10; $i++){
imageline($image, $i*60, (350-$grapheFor[$i]), ($i+1)*60, (350-$grapheFor[$i+1]), $rouge);
}

//---------------------------------------------------------

imagestring($image, 4, 10, 5, "Cours des actions  Als et For en 2010", $vert);

imagestring($image, 4, 80, 560, "Als", $blanc);
imagestring($image, 4, 10, 560, "For" , $rouge);

imagepng($image);
?>