<?php
require("api/functions.php");
if(isset($_POST['path'])){

  if(isset($_POST['action']))
  {
    $perm = Shell_Exec ("powershell.exe -Command .\list_permission.ps1 -Pfad " . $_POST['path']);

    $exp = explode("FileSystemRights", $perm);

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

    if(isset($_POST['loadPermissionFor']))
    {
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
}
?>
