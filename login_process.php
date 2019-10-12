<?php


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
    $query =' select *
              from Members
              where email=\''.$_POST["email"].'\' and pwd=\''.$_POST["pwd"].'\'  ';

    $i = 0;
    $stid = oci_parse($conn, $query);
    oci_execute($stid);
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

        foreach ($row as $item) {
        if($item !== null)
        {
          $i = $i +1 ;
        }
        }

    }
      if($i ==0)
      {
        echo "<script>alert('User name or password Incorrect');location.href='index.html';</script>";
      }
      else {
        session_start();
        $_SESSION["login_user"]=$_POST["email"];
        header("location:main_page.php");
      exit();

      }






  }
oci_close($conn);
