<?php
include '../database/connexpdo.php';

//Connect BDD
try{
    $db = connexpdo('pgsql:dbname=graphenotes;host=localhost;port=5433','postgres','new_password');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //pour activer l'affichage des erreurs pdo
} catch(PDOException $e){
    echo 'ERROR: ' . $e->getMessage();
}

//Connect BDD
$db = connexpdo('pgsql:dbname=graphenotes;host=localhost;port=5433','postgres','new_password');

header ("Content-type: image/png");
$image = imagecreate(600,200);

$grey = imagecolorallocate($image, 125, 125, 125);
$blanc = imagecolorallocate($image, 255, 255, 255);
$orange = imagecolorallocate($image, 255, 128, 0);
$bleu = imagecolorallocate($image, 0, 0, 255);
$bleuclair = imagecolorallocate($image, 156, 227, 254);
$noir = imagecolorallocate($image, 0, 0, 0);

$notesE1=0;
$nbrNotesE1=0;
$notesE2=0;
$nbrNotesE2=0;

$sqlQ1 = "SELECT note, etudiant FROM notes";
$sqlA1 = $db->query($sqlQ1);

foreach ($sqlA1 as $data){
    if ($data['etudiant']=="E1"){
        $notesE1 = $notesE1 + $data['note'];
        $nbrNotesE1++;
    }
    if ($data['etudiant']=="E2"){
        $notesE2 = $notesE2 + $data['note'];
        $nbrNotesE2++;
    }
}
$moyenneE1=$notesE1/$nbrNotesE1;
$moyenneE2=$notesE2/$nbrNotesE2;

//---------------------------------------------------------

imagestring($image, 4, 200, 5, "Notes des etudiants E1 et E2", $noir);

imagestring($image, 4, 350, 150, "Moyenne des notes de E1 : ".$moyenneE1 , $noir);
imagestring($image, 4, 350, 175, "Moyenne des notes de E2 : ".$moyenneE2 , $noir);
imagestring($image, 4, 5, 125, "E1" , $blanc);
imagestring($image, 4, 50, 125, "E2", $bleu);


imagepng($image);
?>