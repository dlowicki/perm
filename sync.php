<?php

if(isset($_POST['path'])){

  if(isset($_POST['action']))
  {
    $perm = Shell_Exec ("powershell.exe -Command .\list_permission.ps1 -Pfad " . $_POST['path']);

    $exp = explode("FileSystemRights", $perm);


    $rights = getRightsFromDir($perm);

    foreach ($rights as $key => $value) {
      foreach ($value as $key2 => $value2) {
        echo $key2 . " - " . $value2 . "<br>";
      }
      echo "<br>";
    }



    /*foreach ($exp as $key => $value) {
      if($key == 0){
        continue;
      }
      echo "FileSystemRights " . $value . "<br>";
    }*/

    return;
  }
  echo $_POST['path'];
}

function getUserFromDir($perm) {
  $user = array();
  $exp = explode("IdentityReference : ", $perm);
  foreach ($exp as $key => $value) {
    if($key != 0){
      $sub = explode("IsInherited", $value);
      $user[$key-1] = $sub[0];
    }
  }
  return $user;
}

function getRightsFromDir($perm) {

  $rights = array();

  $types = array(
    "0" => "FileSystemRights",
    "1" => "AccessControlType",
    "2" => "IdentityReference",
    "3" => "IsInherited",
    "4" => "InheritanceFlags",
    "5" => "PropagationFlags"
  );

  $num = 0;
  $exp = explode("FileSystemRights  :", $perm);

  foreach ($exp as $key => $value) {
    if($key == 0){
      continue;
    }

    $exp2 = explode("AccessControlType :", $value);

    foreach ($exp2 as $key2 => $value2) {
      if($key2 == 0) {
        $rights[$num]['FileSystemRights'] = $value2;
        continue;
      }

      $exp3 = explode("IdentityReference : ", $value2);

      foreach ($exp3 as $key3 => $value3) {
        if($key3 == 0){
          $rights[$num]['AccessControlType'] = $value3;
          continue;
        }

        $exp4 = explode("IsInherited ", $value3);

        foreach ($exp4 as $key4 => $value4) {
          if($key4 == 0){
            $rights[$num]['IdentityReference'] = $value4;
            continue;
          }

          $exp5 = explode("InheritanceFlags ", $value4);

          foreach ($exp5 as $key5 => $value5) {
            if($key5 == 0){
              $temp = explode(": ", $value5);
              $rights[$num]["IsInherited"] = $temp[1];
              continue;
            }

            $exp6 = explode("PropagationFlags ", $value5);

            foreach ($exp6 as $key6 => $value6) {
              if($key6 == 0){
                $temp = explode(": ", $value6);
                $rights[$num]['InheritanceFlags'] = $temp[1];

                continue;
              }


              $temp2 = explode(": ", $value6);
              $rights[$num]['PropagationFlags'] = $temp[1];
              $num++;
            }

          }

        }


      }

    }

  }
  return $rights;
}


 ?>
