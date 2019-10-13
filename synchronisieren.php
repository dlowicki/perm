<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Perm | Synchronisieren</title>
    <link href="css/style.css" rel="stylesheet">
    <script src="api/jquery.min.js"></script>
  </head>
  <body>
    <div class="navigation">
      <ul>
        <li><a href="index.php">Startseite</a></li>
        <!-- <li><a class="nav_current">Synchronisieren</a></li> -->
      </ul>
    </div>

    <div class="container">
      <div class="sidebar">
        <div class="sidebar_message">
          <p>Rechtesystem online. Sie können Rechte anfordern</p>
        </div>
        <ul>
          <li id="sidebar1">Ordner suchen</li>
          <li id="sidebar3">Token auflösen</li>
          <li>User Management</li>
          <li>ACP</li>
        </ul>
      </div>
      <div class="container_listToken">
        <h2>Token einfügen und die geforderten Rechte auslesen lassen</h2>
        <form id="form_listToken">
          <input type="text" name="listToken_text" id="listToken_text" placeholder="Token einfügen...">
          <input type="submit" name="listToken_submit" value="Auslesen">
        </form>
      </div>



      <form id="permission_form" class="permission_form_edit" action="sync.php" method="POST">
        <h2>Berechtigungen für den Ordner <span class='form_directory_headline'></span></h2>

        <p>
          Der Benutzer <b><span class="benutzer"></span></b> möchte folgende Rechte für den Ordner <b><span class='form_directory_headline'></span></b> erhalten.
          Sie haben die Möglichkeit, die Rechte zu editieren, oder die Forderung abzulehnen.
        </p>

        <fieldset>
          <table>
            <tr><th>Berechtigung</th><th class="table_right">Zulassen</th></tr>
            <tr><td>Vollzugriff: </td><td class="table_right"><input type="checkbox" name="vollzugriff" id="vollzugriff"></td></tr>
            <tr><td>Ändern: </td> <td class="table_right"><input type="checkbox" name="aendern" id="aendern"></td></tr>
            <tr><td>Lesen, Ausführen: </td> <td class="table_right"><input type="checkbox" name="ausfuehren" id="ausfuehren"></td></tr>
            <tr><td>Ordnerinhalt anzeigen: </td> <td class="table_right"><input type="checkbox" name="o_anzeigen" id="o_anzeigen"></td></tr>
            <tr><td>Lesen: </td> <td class="table_right"><input type="checkbox" name="lesen" id="lesen"></td></tr>
            <tr><td>Schreiben: </td> <td class="table_right"><input type="checkbox" name="schreiben" id="schreiben"></td></tr>
            <tr><td>Spezielle Berechtigungen: </td> <td class="table_right"><input type="checkbox" name="s_berechtigungen" id="s_berechtigungen"></td></tr>
          </table>
          <input type="text" name="benutzer" class="benutzer" placeholder="Beantragen für..." readonly>
          <input type="hidden" name="token" class="form_directory_hidden_token" readonly>
          <input type="hidden" name="pfad" class="form_directory_headline" readonly>
          <input type="submit" name="acceptToken" value="Ausführen">
          <input type="submit" name="declineToken" value="Ablehnen">
        </fieldset>
      </form>

    </div>

    <script>
      function listDirectory(link) {
        document.getElementById("permission_form").style.display = "block";


        var param = getParameterPath();
        var verlinkung = param + link.trim();

        //document.getElementById("form_directory_headline").innerHTML = verlinkung;
        $('.form_directory_headline').text(verlinkung);
        $('.form_directory_headline').val(verlinkung);
      }

      $("#form_listToken").submit(function(event){
        event.preventDefault();
        var token = $("#listToken_text").val();

        $.ajax({
          url: "sync.php",
          method: "POST",
          data: {tokenData: token, },
          success: function(result) {
            if(result != "error"){
              document.getElementById("permission_form").style.display = "block";
              var splitted = result.split("-");
              $(".benutzer").val(splitted[0]);
              $(".benutzer").text(splitted[0]);
              $(".form_directory_headline").text(splitted[1]);
              $(".form_directory_headline").val(splitted[1]);
              $(".form_directory_hidden_token").val(token);


              if(splitted[2] == 1){
                $("#vollzugriff").prop('checked', true);
              }

              if(splitted[3] == 1){
                $("#aendern").prop('checked', true);
              }

              if(splitted[4] == 1){
                $("#ausfuehren").prop('checked', true);
              }

              if(splitted[5] == 1){
                $("#o_anzeigen").prop('checked', true);
              }

              if(splitted[6] == 1){
                $("#lesen").prop('checked', true);
              }

              if(splitted[7] == 1){
                $("#schreiben").prop('checked', true);
              }

              if(splitted[8] == 1){
                $("#s_berechtigungen").prop('checked', true);
              }

            } else {
              alert("Ein Fehler ist aufgetreten");
            }
          }
        });

      });
      $('#sidebar1').click(function(){
        window.location.href = "index.php";
      });










    </script>
  </body>
</html>
