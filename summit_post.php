<?php
  $body = $_POST['post'];
   if (empty($body)) {
       echo "<script>alert('Post cannot be empty!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
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
{   session_start();
    $query ='Insert into Post values (\''.uniqid().'\',\''.$_POST["post"].'\',
                 \''.$_SESSION["login_user"].'\',sysdate)';


    $stid = oci_parse($conn, $query);
    $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

    if($result){


      echo "<script>alert('Post Successfully!');location.href='main_page.php';</script>";
    }
    else {
      echo "<script>alert('Post Fail!');location.href='main_page.php';</script>";
    }
  }
oci_close($conn);
