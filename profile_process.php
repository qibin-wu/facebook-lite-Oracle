<?php
$location = $_POST['location'];
 if (empty($location)) {
     echo "<script>alert('location cannot be empty!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
     exit();
 }
 $screen = $_POST['screen_name'];
  if (empty($screen)) {
      echo "<script>alert('screen_name cannot be empty!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
      exit();
  }


session_start();


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
    $query ="Update Members  set screen_name='".$screen."', status='".$_POST["status"]."', location='".$location."', vl='".$_POST["vl"]."' where email='".$_SESSION["login_user"]."'";


    $stid = oci_parse($conn, $query);
    $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

    if($result){
      echo "<script>alert('Updated Successfully!');location.href='main_page.php';</script>";
    }
    else {
      echo "<script>alert('Updated Fail');location.href='main_page.php';</script>";
    }
  }
oci_close($conn);
