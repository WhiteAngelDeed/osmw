<?php
if (isset($_SESSION['authentification']) && $_SESSION['privilege'] >= 3)
{
    echo '<p class="pull-right"><span class="label label-danger">Espace Securise Niveau '.$_SESSION['privilege'].'</span></p>';
    echo '<h1>Configuration du Manager</h1>';
    echo '<div class="clearfix"></div>';

    echo '<p>Simulateur selectionne ';
    echo '<strong class="label label-info">'.$_SESSION['opensim_select'].' '.INI_Conf_Moteur($_SESSION['opensim_select'], "version").'</strong>';
    echo '</p>';

    $btnN1 = "disabled"; $btnN2 = "disabled"; $btnN3 = "disabled";
    if ($_SESSION['privilege'] == 4) {$btnN1 = ""; $btnN2 = ""; $btnN3 = "";}   // Niv 4	
    if ($_SESSION['privilege'] == 3) {$btnN1 = ""; $btnN2 = ""; $btnN3 = "";}   // Niv 3
    if ($_SESSION['privilege'] == 2) {$btnN1 = ""; $btnN2 = "";}                // Niv 2
    if ($_SESSION['privilege'] == 1) {$btnN1 = "";}                             // Niv 1
    // if ($moteursOK == true) {if( $_SESSION['privilege'] == 1) {$btnN1 = ""; $btnN2 = ""; $btnN3 = "";}}

    if (isset($_POST['cmd']))
    {
        if ($_POST['cmd'] == 'Enregistrer')
        {	
            $sqlIns = "
                UPDATE `config` 
                SET `cheminAppli` = '".$_POST['cheminAppli']."',
                    `destinataire` = '".$_POST['destinataire']."',
                    `Autorized` = '".$_POST['Autorized']."',
                    `NbAutorized` = '".$_POST['NbAutorized']."',
                    `VersionOSMW` = '".$_POST['VersionOSMW']."' 
                WHERE `config`.`id` = 1
            ";
            $reqIns = mysqli_query($db, $sqlIns) or die('Erreur SQL !<p>'.$sqlIns.'</p>'.mysql_error($db));
            echo "<p class='alert alert-success alert-anim'>";
            echo "<i class='glyphicon glyphicon-ok'></i>";
            echo " Configuration sauvée avec succes</p>";
        }
    }

    $sql = 'SELECT * FROM config';
    $req = mysqli_query($db, $sql) or die('Erreur SQL !<p>'.$sql.'</p>'.mysqli_error($db));
    
    while($data = mysqli_fetch_assoc($req))
    {
        echo '<form class="form-group" method="post" action="">';
        echo '<table class="table table-hover">';
        echo '<tr>';
        echo '<td>Chemin du Manager (ex: /manager/):</td>';
        echo '<td><input class="form-control" type="text" value="'.$data['cheminAppli'].'" name="cheminAppli" '.$btnN3.'></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Email Administrateur:</td>';
        echo '<td><input class="form-control" type="text" value="'.$data['destinataire'].'" name="destinataire" '.$btnN3.'></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Autorisation NO LIMIT region:</td>';
        echo '<td><input class="form-control" type="text" value="'.$data['Autorized'].'" name="Autorized" '.$btnN3.'></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Autorisation Nb LIMIT region:</td>';
        echo '<td><input class="form-control" type="text" value="'.$data['NbAutorized'].'" name="NbAutorized" '.$btnN3.'></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Version du Manager:</td>';
        echo' <td><input class="form-control" type="text" value="'.$data['VersionOSMW'].'" name="VersionOSMW" '.$btnN3.'></td>';
        echo '</tr>';
        echo '</form>';
        echo '</table>';
        echo' <button type="submit" class="btn btn-success" name="cmd" value="Enregistrer" '.$btnN3.'>';
        echo '<i class="glyphicon glyphicon-ok"></i> Enregistrer</button>';
    }
    mysqli_close($db);
}
else {header('Location: index.php');}
?>
