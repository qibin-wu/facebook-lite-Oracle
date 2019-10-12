<?php
$password = $_POST['pwd'];
   $confirmPassword = $_POST['pwd_c'];
   if ($password != $confirmPassword) {
       echo "<script>alert('Password should same!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
       exit();
   }

$data=$_POST['dob'];
$is_date=strtotime($data)?strtotime($data):false;

if($is_date===false){
  echo "<script>alert('Incorrect Date of birth!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
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
    $query ='Insert into Members values (\''.$_POST["email"].'\',\''.$_POST["pwd"].'\',
                 \''.$_POST["full_name"].'\',\''.$_POST["screen_name"].'\',to_date(\''.$_POST["dob"].'\',\'dd-MM-yyyy\'),
                 \''.$_POST["gender"].'\',\''.$_POST["status"].'\',\''.$_POST["location"].'\',
                 \''.$_POST["vl"].'\')';


    $stid = oci_parse($conn, $query);
    $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

    if($result){
                session_start();
                $_SESSION["login_user"]=$_POST["email"];

      echo "<script>alert('Register Successfully!');location.href='main_page.php';</script>";
    }
    else {
      echo "<script>alert('Register Fail');location.href='index.html';</script>";
    }
  }
oci_close($conn);
