
<HTML>

<BODY>
  <h1>Profile Maintenance</h1>

  <?php
      session_start();

  $l_user= $_SESSION["login_user"];
  $aa=array();

  $username = 'S3650616';
  $password = 'Bbq12345';
  $servername = 'talsprddb01.int.its.rmit.edu.au';
  $servicename = 'CSAMPR1.ITS.RMIT.EDU.AU';
  $connection = $servername."/".$servicename;

  $conn = oci_connect($username, $password, $connection);
  if(!$conn)
  {
      $e = oci_error();
      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
  }
  else
  {
      $query ="select screen_name,location from members where email='".$l_user."'";


      $stid = oci_parse($conn, $query);
      oci_execute($stid);

      while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

          foreach ($row as $item) {
              if($item !== null)
              {
                $b=htmlentities($item, ENT_QUOTES);
                $aa[]=$b;
              }

          }
          echo "</tr>\n";
      }


    }
  oci_close($conn);
  ?>
  <form action="profile_process.php" method="post">
    <table cellspacing="10">
      <tr>
        <td>Screen Name:</td>
        <?php

        echo "<td><input type=\"text\" name=\"screen_name\" value=\"".$aa[0]."\"></td>";
        ?>
      </tr>
      <tr>
        <td>Status:</td>
        <td><select name="status">
            <option value="single">Single</option>
            <option value="married">Married</option>
            <option value="divorced">Divorced</option>
          </select></td>
      </tr>
      <tr>
        <td>Location:</td>
          <?php
          echo "<td><input type=\"text\" name=\"location\" value=\"".$aa[1]."\"></td>";
          ?>
      </tr>
      <tr>
        <td>Visibility Level:</td>
        <td><select name="vl">
         <option value="private">Private</option>
         <option value="friends_only">Friends-only</option>
         <option value="everyone">Everyone</option>
       </select></td>
     </tr>
      <tr>
        <td><input type="submit"></td>
        <td><a href="main_page.php">Cancel</a></td>
      </tr>
    </table>

  </form>



</BODY>
</HTML>
