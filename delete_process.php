<?php
session_start();
function delete_like(){

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
      $query ='delete member_likes where from_email =\''.$_SESSION["login_user"].' \'';


      $stid = oci_parse($conn, $query);
      $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

      if($result){
      return true;
      }
      else {
        return false;
      }
    }
  oci_close($conn);
}

function delete_response(){

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
      $query ='delete response where from_user =\''.$_SESSION["login_user"].'\' or to_user =\''.$_SESSION["login_user"].' \'';


      $stid = oci_parse($conn, $query);
      $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

      if($result){

      return true;
      }
      else {
        return false;
      }
    }
  oci_close($conn);
}

function delete_post(){

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
      $query ='delete post where from_email =\''.$_SESSION["login_user"].'\'';


      $stid = oci_parse($conn, $query);
      $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

      if($result){
            return true;
      }
      else {
        return false;
      }
    }
  oci_close($conn);
}

function delete_friendship(){

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
      $query ='delete friendship where from_email =\''.$_SESSION["login_user"].'\' or to_email=\''.$_SESSION["login_user"].'\' ';


      $stid = oci_parse($conn, $query);
      $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

      if($result){
          return true;
      }
      else {
        return false;
      }
    }
  oci_close($conn);
}
function delete_user(){

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
      $query ='delete members where email =\''.$_SESSION["login_user"].'\'';


      $stid = oci_parse($conn, $query);
      $result=oci_execute($stid,OCI_COMMIT_ON_SUCCESS);

      if($result){
        return true;
      }
      else {
        return false;
      }
    }
  oci_close($conn);
}



  $result=true;
  $result= $result&&delete_like();
  $result= $result&&delete_response();
  $result= $result&&delete_post();
  $result= $result&&delete_friendship();
  $result= $result&&delete_user();

  if ( $result) {
    $_SESSION["login_user"]=null;
    echo "<script>alert('Deleted Successfully!');location.href='index.html';</script>";
  }else {
    echo "false";
  }
