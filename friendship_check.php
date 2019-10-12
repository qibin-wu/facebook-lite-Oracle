<?php

session_start();

$to_email=$_SESSION["search_user"];
$from_email=$_SESSION["login_user"];


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
    $query =' select status
              from friendship
              where (from_email=\''.$from_email.'\' and to_email=\''.$to_email.'\') or (from_email=\''.$to_email.'\' and to_email=\''.$from_email.'\') ';

    $i = 0;
    $stid = oci_parse($conn, $query);
    oci_execute($stid);
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

        foreach ($row as $item) {
        if($item !== null)
        {
          $status=htmlentities($item, ENT_QUOTES);
          $i = $i +1 ;
        }
        }

    }
      if($i ==0)
      {
        $_SESSION["search_user"]=$to_email;
        header("location:main_page.php");
        exit();
      }
      else {
        session_start();
        $_SESSION["search_user"]=$to_email;
        $_SESSION["status"]=$status;
        header("location:main_page.php");
        exit();

      }






  }
oci_close($conn);
