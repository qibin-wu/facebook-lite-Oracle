<?php
session_start();
$ID_response=explode("=", $_SERVER["QUERY_STRING"]);
$TO_ID=$ID_response[0];

$response_to_user=explode("*",$ID_response[1]);
$response=$response_to_user[0];
$to_user=$response_to_user[1];

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
    $query ='Insert into response values (\''.uniqid().'\',\''.$TO_ID.'\',
                 \''.$TO_ID.'\',\''.$response.'\',\''.$from_user.'\',sysdate,\''.$to_user.'\',\'to_post\')';



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
