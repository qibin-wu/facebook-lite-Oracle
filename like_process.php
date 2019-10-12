<?php
session_start();
$url_pra=explode("=", $_SERVER["QUERY_STRING"]);
$pr_id=$url_pra[0];
$from_user=$_SESSION["login_user"];


function checkLike()
{
  $url_pra=explode("=", $_SERVER["QUERY_STRING"]);
  $liked_id=$url_pra[0];
  $from_user=$_SESSION["login_user"];

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
      $query ="select * from member_likes where P_R_ID='".$pr_id."' and from_email='".$from_user."'";


      $stid = oci_parse($conn, $query);
      oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
      $i=0;
      while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

          foreach ($row as $item) {
          if($item !== null)
          {

            $i = $i +1 ;
          }
          }

      }
  oci_close($conn);
}
if($i==0)
{
  return false;
}
else {
  return true;
}
}
function like()

{
  $url_pra=explode("=", $_SERVER["QUERY_STRING"]);
  $liked_id=$url_pra[0];
  $from_user=$_SESSION["login_user"];
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
      $query ='Insert into member_likes values (\''.uniqid().'\',\''.$liked_id.'\',
                   \''.$from_user.'\')';



      $stid = oci_parse($conn, $query);
      $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
      if($result){
      return true;
      }
      else {
        return false;
      }

  oci_close($conn);


}
}

if(checkLike())
{
    echo "<script>alert('You already Liked it!');location.href='main_page.php';</script>";
}
else {
    if(like())
    {echo "<script>alert('Liked Successfully!');location.href='main_page.php';</script>";}
    else {
    echo "<script>alert('Like Fail!');location.href='main_page.php';</script>";

    }
}
