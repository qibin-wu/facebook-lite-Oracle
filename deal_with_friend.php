<?php

session_start();
$emailstatus=explode("=", $_SERVER["QUERY_STRING"]);
$email=$emailstatus[0];
$status=$emailstatus[1];

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
  if($status=="Accepted")
    {
      $query ="Update friendship set status='".$status."',start_time=sysdate where to_email='".$_SESSION["login_user"]."' and from_email='".$email."'";
    }
    else {
        $query ="Update friendship set status='".$status."' where to_email='".$_SESSION["login_user"]."' and from_email='".$email."'";
    }


    $stid = oci_parse($conn, $query);
    $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

    if($result){


      echo "<script>alert('Successful ".$status."!');location.href='main_page.php';</script>";
    }
    else {
      echo "<script>alert('Fail to ".$status." !');location.href='main_page.php';</script>";
    }
  }
oci_close($conn);
