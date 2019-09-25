<?php

function changePermissionName($permission) {
  // Lesen ausführen -> InheritanceFlags = ContainerInherit, ObjectInherit
  //                    PropagationFlags = ContainerInherit, ObjectInherit

  // Ändern = InheritanceFlags = ContainerInherit, ObjectInherit
  //          PropagationFlags = ContainerInherit, ObjectInherit
  //

  // InheritanceFlags = Flags, die die Vererbungseigenschaften für diesen ACE (Access Control Entry) angeben.
  // PropagationFlags = Flags, die die Eigenschaften der Vererbungsweitergabe für diesen ACE angeben.
  // IsInherited = Wird vererbt
  // IdentityReference = Benutzername


  $perm = array(
    "FullControl" => "Vollzugriff",
    "Write, Synchronize" => "Schreiben, Synchronisieren",
    "Read, Synchronize" => "Lesen, Synchronisieren",
    "ReadAndExecute" => "Ordnerinhalt anzeigen, Synchronisieren",
    "Modify, Synchronize" => "Ändern, Synchronisieren",
    "Write, ReadAndExecute, Synchronize" => "Schreiben, Lesen und Ausführen, Synchronisieren",
    "ContainerInherit" => "von untergeordneten Containerobjekten geerbt.",
    "ObjectInherit" => "von untergeordneten Endobjekten geerbt.",
    "InheritOnly" => "nur an untergeordnete Objekte weitergegeben wird. Dies schließt untergeordnete Container- und Endobjekte ein.",
    "NoPropagateInherit" => "nicht an untergeordnete Objekte weitergegeben wird."
  );
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
