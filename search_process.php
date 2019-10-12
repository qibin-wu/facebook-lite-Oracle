<?php

$email = $_POST['email'];

   if (empty($email)) {
       echo "<script>alert('email cannot empty!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
       exit();
   }

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
              where email=\''.$email.'\'';

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
        echo "<script>alert('Email Incorrect');location.href='main_page.php';</script>";
      }
      else {
        session_start();
        $_SESSION["search_user"]=$email;
        header("location:friendship_check.php");
      exit();

      }






  }
oci_close($conn);
