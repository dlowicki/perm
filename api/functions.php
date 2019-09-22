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


 ?>
