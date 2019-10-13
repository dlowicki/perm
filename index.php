<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Perm | Startseite</title>
    <script src="api/jquery.min.js"></script>
    <script src="api/function.js"></script>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <div class="navigation">
      <ul>
        <li><a class="nav_current">Startseite</a></li>
        <!-- <li><a href="synchronisieren.php">Synchronisieren</a></li> -->
      </ul>
    </div>

    <div class="container">
      <div class="sidebar">
        <div class="sidebar_message">
          <p>Status STATE Sie können Rechte anfordern</p>
        </div>
        <ul>
          <li>Ordner suchen</li>
          <li id="sidebar3">Token auflösen</li>
          <li>User Management</li>
          <li>ACP</li>
        </ul>
      </div>

    <?php

      if(isset($_GET['path'])){

        $path = $_GET['path'];

        if($path == ""){
          header("Location: index.php?path=C:\\temp\\");
        }

        $dir = Shell_Exec("powershell.exe -Command .\pfad.ps1 -Pfad $path");

        $exp = explode("\n", $dir);

        /*STYLE*/
        echo "<div class='container_ordner_suchen'>";
        echo "<div class='ordner_suchen_search'>
                <h2>Ordner suchen</h2>
                <div class='ordner_suchen_search_input'>
                  <select name='laufwerk'>
                    <option value='C'>C</option>
                    <option value='D'>D</option>
                    <option value='E'>E</option>
                  </select>
                  <input type='text'>
                  <input type='submit' value='Suchen'>
                </div>
              </div>";


          echo "<div class='ordner_suchen'>";
            echo "<h3>" . $_GET['path'] . "</h3>";
            echo "<ul>";
            echo "<li><img src='dir.jpg' width='25px'><p onClick='dirBack()'>..</p></li>";

            $r = 0;
            foreach ($exp as $key => $value) {

              if($r == sizeof($exp)-1){
                break;
              }

              $link = $value;

              echo '<li><img src="dir.jpg" width="25px"><p onClick="dirChange(';
              echo "'$link'";
              echo ')">' . $link . '</p> <button onClick="dirInfo(';
              echo "'" . $link . "'";
              echo ')">Infos</button><img src="img/pen.svg" onClick="listDirectory(';
              echo "' $link '";
              echo ')" id="content_container_icon_create" class="content_container_icon_create"></li>';
              $r++;
            }

            echo "</ul>";
          echo "</div>";
        echo "</div>";
        /*STYLE*/
      } else {
        header("Location: index.php?path=C:\\temp\\");
      }

    ?>

    <div id='container_permission'>
      <form id="permission_form" action="sync.php" method="POST">
        <h2>Berechtigungen für <span class='form_directory_headline'></span></h2>

        <p>
          Hier können Sie sich Ihre gewünschten Berechtigungen aussuchen und den dazugehörigen Link generieren.
        </p>

        <fieldset>
          <table>
            <tr><th>Berechtigung</th><th class="table_right">Zulassen</th></tr>
            <tr><td>Vollzugriff: </td><td class="table_right"><input type="checkbox" name="vollzugriff"></td></tr>
            <tr><td>Ändern: </td> <td class="table_right"><input type="checkbox" name="aendern"></td></tr>
            <tr><td>Lesen, Ausführen: </td> <td class="table_right"><input type="checkbox" name="ausfuehren"></td></tr>
            <tr><td>Ordnerinhalt anzeigen: </td> <td class="table_right"><input type="checkbox" name="o_anzeigen"></td></tr>
            <tr><td>Lesen: </td> <td class="table_right"><input type="checkbox" name="lesen"></td></tr>
            <tr><td>Schreiben: </td> <td class="table_right"><input type="checkbox" name="schreiben"></td></tr>
            <tr><td>Spezielle Berechtigungen: </td> <td class="table_right"><input type="checkbox" name="s_berechtigungen"></td></tr>
          </table>
          <input type="text" name="benutzer" placeholder="Beantragen für..." required>
          <input type="hidden" name="pfad" class="form_directory_headline">
          <input type="submit" name="createToken" value="Link generieren">
        </fieldset>
      </form>
    </div>

    </div>
    <script>

      function dirChange(link) {
        var param = getParameterPath();
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

      function listDirectory(link) {
        document.getElementById("permission_form").style.display = "block";


        var param = getParameterPath();
        var verlinkung = param + link.trim();

        //document.getElementById("form_directory_headline").innerHTML = verlinkung;
        $('.form_directory_headline').text(verlinkung);
        $('.form_directory_headline').val(verlinkung);
      }

      function loadPermissionFor(value){
        var param = getParameterPath();
        var link = document.getElementById("path_headline").innerHTML;
        var verlinkung = param + link;

        $.ajax({
          url: "sync.php",
          method: "POST",
          data: {loadPermissionFor: value, path: verlinkung, action: 'info'},
          success: function(result) {
            if(result != "error"){
              document.getElementById('container_permission').innerHTML = "<h2 id='path_headline'>" + link + "</h2>" + result;
            } else {
              alert("Ein Fehler ist aufgetreten");
            }
          }
        });
      }

      function dirBack() {
        var splitted;
        var param = getParameterPath();
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
        var param = getParameterPath();
        link = link.replace(/\s/g, '');
        var verlinkung = param + link + "\\";

        $.ajax({
          url: "sync.php",
          method: "POST",
          data: {path: verlinkung, action: 'info'},
          success: function(result) {
            if(result != "error"){
              document.getElementById('container_permission').innerHTML = "<h2 id='path_headline'>" + link + "</h2>" + result;
            } else {
              alert("Ein Fehler ist aufgetreten");
            }
          }
        });
      }

      function getParameterPath() {
        var url_str = window.location.href;
        var url = new URL(url_str);
        var params = url.searchParams.get("path")
        return params;
      }


      $('#sidebar3').click(function(){
        window.location.href = "synchronisieren.php";
      });



    </script>
  </body>
</html>
