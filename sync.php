<?php
require("api/functions.php");

if(isset($_POST['path'])){

  if(isset($_POST['action'])) {
    $perm = Shell_Exec ("powershell.exe -Command .\list_permission.ps1 -Pfad " . $_POST['path']);

    $exp = explode("FileSystemRights", $perm);

    // Array user wird mit allen Usern aus dem Directory gespeichert
    $user = getUserFromDir($perm);
    $userById = array();
    echo "<div class='permission_user'>";
    $t = 0;
    foreach ($user as $key => $value) {
      echo "<p id='$t' onClick='loadPermissionFor(";
      echo $t;
      echo ")'>$value</p>";
      $userById[$value] = $userById;
      $t++;
    }
    echo "</div>";

    if(isset($_POST['loadPermissionFor'])) {
      $rights = getRightsFromDir($perm);
      foreach ($rights as $key => $value) {
        if($key == $_POST['loadPermissionFor']){
          echo "<div class='permission_box'>";
          foreach ($value as $key2 => $value2) {
            echo "<p>" . $key2 . " - " . $value2 . "</p>";
          }
          echo "</div>";
        }
      }
    }
    return;
  }
  echo $_POST['path'];
} else if(isset($_POST['createToken'])){
  $vz = false;
  $aendern = false;
  $ausfuehren = false;
  $oa = false;
  $lesen  = false;
  $schreiben = false;
  $sb = false;

  if(isset($_POST['vollzugriff'])){
    $vz = 1;
  }
  if(isset($_POST['aendern'])){
    $aendern = 1;
  }
  if(isset($_POST['ausfuehren'])){
    $ausfuehren = 1;
  }
  if(isset($_POST['o_anzeigen'])){
    $oa = 1;
  }
  if(isset($_POST['lesen'])){
    $lesen = 1;
  }
  if(isset($_POST['schreiben'])){
    $schreiben = 1;
  }
  if(isset($_POST['s_berechtigungen'])){
      $sb = 1;
  }
  $pfad = str_replace('\\',"/", $_POST['pfad']);
  $name = htmlspecialchars($_POST['benutzer'], ENT_QUOTES);


  if(strlen($pfad) <= 3 || strlen($name) <= 3){
    header('Location: index.php?error=2');
    return false;
  }
  if($vz == false && $aendern == false && $ausfuehren == false && $oa == false && $lesen == false && $schreiben == false && $sb == false){
    header('Location: index.php?error=1');
    return false;
  }
  createToken($name, $pfad, $vz, $aendern, $ausfuehren, $oa, $lesen, $schreiben, $sb);




} else if(isset($_POST['tokenData'])) {
  // 38
  if(strlen($_POST['tokenData']) >= 38){
    $data = "";
    $r=0;

    $temp = readToken($_POST['tokenData']);

    if(sizeof($temp) == 0){
      echo "error";
      return;
    }

    foreach($temp as $key => $value){
      if($r==8){
        $data = $data . $value;
        break;
      }
      $data = $data . $value . "-";
      $r++;
    }
    echo $data;
    return;
  }
  echo "error";
} else if(isset($_POST['acceptToken'])){
  $vz = $_POST['vollzugriff'];
  $pfad = $_POST['pfad'];
  $benutzer = $_POST['benutzer'];
  $token = $_POST['token'];
  $data = readToken($token);


  if($vz == true && $pfad != "" && $benutzer != "" && $token != null && $data['aktiviert'] == 0){
    Shell_Exec("powershell.exe -Command .\\fullcontrol.ps1 $benutzer $pfad");
    if(activateToken($token)){
      header("Location: synchronisieren.php?updated=$token");
    } else {
      echo "Ein Fehler ist aufgetreten. Bitte bei einem Administrator melden!";
    }

  } else {
    header("Location: synchronisieren.php?error=1");
  }

}





 ?>
