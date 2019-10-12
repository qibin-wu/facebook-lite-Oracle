<?php



session_start();

$to_email=$_SESSION["to_user"];
$from_email=$_SESSION["login_user"];
$_SESSION["to_user"]=null;

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
    $query ="Insert into friendship values('".$from_email."','".$to_email."','Pending',null)";


    $stid = oci_parse($conn, $query);
    $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

    if($result){


      echo "<script>alert('Friendship request has been sent!');location.href='main_page.php';</script>";
    }
    else {
      echo "<script>alert('Friendship request sent fail!');location.href='main_page.php';</script>";
    }
  }
oci_close($conn);
