<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Perm | Startseite</title>
  </head>
  <body>
    <?php
      $path = "C:\\temp\\";
      //echo exec("powershell.exe -Command \"C:\Users\dlowicki\Desktop\pfad.ps1\" $path");
      echo Shell_Exec ("powershell.exe -Command .\pfad.ps1 -Pfad $path");
    ?>
  </body>
</html>
