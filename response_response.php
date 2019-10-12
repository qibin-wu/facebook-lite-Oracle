<?php
session_start();
$url=explode("=", $_SERVER["QUERY_STRING"]);
$response_id=$url[0];

$para=explode("*",$url[1]);
$response=$para[0];
$root_post=$para[1];
$to_user=$para[2];

$from_user=$_SESSION["login_user"];

$response=str_replace("%20"," ",$response);


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
    $query ='Insert into response values (\''.uniqid().'\',\''.$response_id.'\',
                 \''.$root_post.'\',\''.$response.'\',\''.$from_user.'\',sysdate,\''.$to_user.'\',\'to_response\')';

    $stid = oci_parse($conn, $query);
    $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
    if($result){
      echo "<script>alert('Response Successfully!');location.href='main_page.php';</script>";

    }
    else {
      echo "<script>alert('Response Fail!');location.href='main_page.php';</script>";

    }

oci_close($conn);
}
