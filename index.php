<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Perm | Startseite</title>
    <script src="api/jquery.min.js"></script>
  </head>
  <body>
    <?php

      if(isset($_GET['path'])){

        $path = $_GET['path'];

        if($path == ""){
          header("Location: index.php?path=C:\\temp\\");
        }

        $dir = Shell_Exec ("powershell.exe -Command .\pfad.ps1 -Pfad $path");
        $exp = explode("\n", $dir);

        echo "<ul>";
        echo "<li><p onClick='dirBack()'>..</p></li>";

        $r = 0;
        foreach ($exp as $key => $value) {


          if($r == sizeof($exp)-1){
            break;
          }


          $link = $value;

          echo '<li><p onClick="dirChange(';
          echo "' $link '";
          echo ')">' . $link . '</p> <button onClick="dirInfo(';
          echo "'" . $link . "'";
          echo ')">Infos</button></li>';
          $r++;
        }
        echo "</ul>";
      } else {
        header("Location: index.php?path=C:\\temp\\");
      }

    ?>

    <p id='desc'>

    </p>

    <script>

      function dirChange(link) {
        var param = getParameter();
        link = link.replace(/\s/g, '');
        var verlinkung = param + link + "\\";

        $.ajax({
          url: "sync.php",
          method: "POST",
          data: {path: verlinkung},
          success: function(result) {
            if(result != "error"){
              window.location.href = "index.php?path=" + result;
            } else {
              alert("Ein Fehler ist aufgetreten");
            }
          }
        });
      }

      function dirBack() {
        var splitted;
        var param = getParameter();
        var split = param.split("\\");
        var length = (split.length-2);

        for(d = 0; d<length; d++){
          if(d==0){
            splitted = split[0] + "\\";
            continue;
          }
          splitted = splitted + split[d] + "\\";
        }

        $.ajax({
          url: "sync.php",
          method: "POST",
          data: {path: splitted},
          success: function(result) {
            if(result != "error"){
              window.location.href = "index.php?path=" + result;
            } else {
              alert("Ein Fehler ist aufgetreten");
            }
          }
        });
      }

      function dirInfo(link) {
        var param = getParameter();
        link = link.replace(/\s/g, '');
        var verlinkung = param + link + "\\";

        $.ajax({
          url: "sync.php",
          method: "POST",
          data: {path: verlinkung, action: 'info'},
          success: function(result) {
            if(result != "error"){
              document.getElementById('desc').innerHTML = result;
            } else {
              alert("Ein Fehler ist aufgetreten");
            }
          }
        });
      }

      function getParameter() {
        var url_str = window.location.href;
        var url = new URL(url_str);
        var params = url.searchParams.get("path")
        return params;
      }
    </script>
  </body>
</html>
