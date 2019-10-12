<html>
<head>
  <script type="text/javascript">
  function disp_prompt(post_id,to_user)
    {
    var response=prompt("Please enter your Response","")
    if (response!=null && response!="")
      {
      document.location="resopnse_post.php?"+post_id+"="+response+"*"+to_user;
      }
    }
    function disp_prompt2(response_id,root_post,to_user)
      {
      var response=prompt("Please enter your Response","")
      if (response!=null && response!="")
        {
        document.location="response_response.php?"+response_id+"="+response+"*"+root_post+"*"+to_user;
        }
      }
  </script>
    <title>Main Page</title>
    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
        }
        .main{
            width: 90%;
            height: 100%;
            position: absolute;

        }
        .top{
            width: 100%;
            height: 0px;
            float: left;
        }
        .bottom{
            width: 100%;
            height: auto ;
            float: left;
        }
        .left{

            width: 30%;
            height: 1000px;
            float: left;
        }
        .middle{
            width: 40%;
            height: 500px;
            float: left;
        }
        .right{
            width: 30%;
            height: 1000px;
            float: left;
        }
        .white{
          background-color: #FFFFFF;
        }
        .button{
            height: 45px;
            width: 90px;
        }
        .button2{
            height: 25px;
            width: 100px;
        }
        .button3{
            height: 25px;
            width: 100px;
            margin-left:60px;
        }
        .button4{
            height: 25px;
            width: 100px;
            margin-left:30px;
        }


    </style>
</head>
<body style="background-color:#E9EBEE;">

    <div class="main">
        <div class="left" align="right">
          <table cellspacing="15">
            <tr>
              <td><h2>Managing account</h2></td>
            </tr>
            <tr>
              <td><li><a href="profile.php">Profile Maintenance</a></li></td>
            </tr>
              <tr>
                <td><li><a href="delete.php">Delete Account</a></li></td>
              </tr>
              <tr>
                <td><li><a href="http://titan.csit.rmit.edu.au/~s3650616/">Log Out</a></li></td>
              </tr>
          </table>

        </div>
        <div class="middle" align="center" >

          <table>
            <tr>
              <td>
                <form action="summit_post.php" method="post">
                  <table cellspacing="20" >
                    <tr>
                      <td> <textarea name="post" rows="6"  style="width:400px; height:100px"></textarea></td>
                    </tr>
                      <tr>
                        <td> <input type="submit" value="Post" class="button"></td>
                      </tr>
                      <tr>
                        <td>
                          <?php
                          session_start();
                          function getscreen_name($email){
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
                                $query =  'SELECT screen_name
                                              FROM members
                                              WHERE email= \'' . $email . '\'';

                              $stid = oci_parse($conn, $query);
                                oci_execute($stid);

                                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                    foreach ($row as $item) {
                                      $screen_name=htmlentities($item, ENT_QUOTES);
                                    }
                                }
                            }

                            oci_close($conn);
                                return $screen_name;

                          }
                          function getPost()
                          {
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
                                $query =  'SELECT from_email,body,to_char(post_time, \'dd-mm-yyyy hh24:mi\') as p_time,post_id
                                FROM post join members on post.from_email=members.email
                                where members.vl=\'everyone\'
                                union
                                SELECT from_email,body,to_char(post_time, \'dd-mm-yyyy hh24:mi\')as p_time,post_id
                                FROM post join members on post.from_email=members.email
                                where members.vl=\'friends_only\' and FROM_EMAIL in(select to_email from friendship where (from_email=\''.$_SESSION["login_user"].'\' or to_email=\''.$_SESSION["login_user"].'\') and status=\'Accepted\')
                                union
                                SELECT from_email,body,to_char(post_time, \'dd-mm-yyyy hh24:mi\')as p_time,post_id
                                FROM post
                                where FROM_EMAIL=\''.$_SESSION["login_user"].'\'
                                order by p_time desc';
                              $stid = oci_parse($conn, $query);
                                oci_execute($stid);



                              $post=array();
                                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                    foreach ($row as $item) {
                                      $p_item=htmlentities($item, ENT_QUOTES);
                                      $post[]=$p_item;

                                    }
                                }
                            }

                            oci_close($conn);
                                return $post;
                          }

                          function showToPost($postID)
                          {
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
                                $query =  'SELECT from_user,body,to_char(response_time,\'dd-mm-yyyy hh24:mi\'),response_id
                                              FROM response
                                              WHERE root_post= \'' . $postID . '\' and type=\'to_post\'
                                              Order by response_time Desc';

                              $stid = oci_parse($conn, $query);
                                oci_execute($stid);



                              $response=array();
                                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                    foreach ($row as $item) {
                                      $p_item=htmlentities($item, ENT_QUOTES);
                                      $response[]=$p_item;

                                    }
                                }
                            }

                            oci_close($conn);
                                return $response;
                          }
                          function showToResponse($postID)
                          {
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
                                $query =  'SELECT from_user,body,to_char(response_time,\'dd-mm-yyyy hh24:mi\'),response_id,to_user
                                              FROM response
                                              WHERE root_post= \'' . $postID . '\' and type=\'to_response\'
                                              Order by response_time Desc';

                              $stid = oci_parse($conn, $query);
                                oci_execute($stid);



                              $response=array();
                                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                    foreach ($row as $item) {
                                      $p_item=htmlentities($item, ENT_QUOTES);
                                      $response[]=$p_item;

                                    }
                                }
                            }

                            oci_close($conn);
                                return $response;
                          }


                          $post=getPost();
                          $num=count($post);

                          $timekey=array();
                          $idkey=array();
                          $namekey=array();

                          //4n+2
                          for($j=0;$j<$num;$j++)
                          {
                            $timekey[$j]=($j*4)+2;

                          }
                          for($j=0;$j<$num;$j++)
                          {
                            $idkey[$j]=($j*4)+3;

                          }
                          for($j=0;$j<$num;$j++)
                          {
                            $namekey[$j]=($j*4);

                          }


                          $to_RID_key=array();
                          $to_time_key=array();
                          $to_fromUser_key=array();


                          for($l=0;$l<$num;$l++)
                          {
                            $to_RID_key[$l]=$l*5+3;
                          }

                          for($l=0;$l<$num;$l++)
                          {
                            $to_fromUser_key[$l]=$l*5;
                          }
                          for($l=0;$l<$num;$l++)
                          {
                            $to_time_key[$l]=$l*5+2;
                          }




                          echo "<table class=\"white\"   style=\"width:400px\"  cellspacing=\"5\">\n";

                            for($j=0;$j<$num;$j++)
                            {
                              // ignore id
                              if(in_array($j, $idkey))
                             {
                                continue;
                             }
                             // show screen name
                             if(in_array($j, $namekey))
                            {
                              echo "<tr>";
                              echo "<td>";
                              if($j!=0){
                              echo"<HR width=\"101%\" color=#9F35FF SIZE=10>";}
                              echo"<b><font color=\"blue\" size=\"4\">".getscreen_name($post[$j])."</font></b>";
                              echo "</td>";
                              echo "</tr>";
                               continue;
                            }


                                // show body and follow buttons and responses
                                  if(in_array($j, $timekey))
                                 {
                                   echo "<tr>";
                                   echo "<td>";
                                   echo"<font size=\"1\">".$post[$j]."</font>";
                                   echo "</td>";
                                   echo "</tr>";

                                   echo "<tr style=\"background-color:#E9EBEE;\">";
                                    echo"<td><a href=\"like_process.php?".$post[$j+1]."=1\"><button type=\"button\" class=\"button3\">Like</button></a><input type=\"button\" onclick=\"disp_prompt('".$post[$j+1]."','".$post[$j-2]."')\"
                                    value=\"Response\" class=\"button3\" /></td>";
                                    echo "</tr>";

                                    //show responses to post
                                    $response=showToPost($post[$j+1]);
                                    $response_num=count($response);

                                    echo "<tr>";

                                    for($k=0;$k<$response_num;$k++)
                                    {
                                      if(in_array($k, $idkey))
                                     {
                                        continue;
                                     }
                                     if(in_array($k, $namekey))
                                    {
                                      echo "<td style=\"word-wrap:break-word;word-break:break-all;padding-left:20px\">";
                                      echo"<b><font color=\"blue\">".getscreen_name($response[$k])."</font></b>";
                                      echo"&nbsp;&nbsp;".$response[$k+1]."";
                                      echo "</td>";
                                       continue;
                                    }
                                    if(in_array($k, $timekey))
                                    {
                                      echo "</tr>";
                                      echo "<tr>";
                                      echo "<td style=\"word-wrap:break-word;word-break:break-all;padding-left:20px\">";
                                      echo"<font size=\"1\">".$response[$k]."</font>";
                                      echo "</td>";
                                      echo "<tr>";
                                       echo"<td align=\"right\"><a href=\"like_process.php?".$response[$k+1]."=1\"><button type=\"button\" class=\"button2\">Like</button></a><input type=\"button\" onclick=\"disp_prompt2('".$response[$k+1]."','".$post[$j+1]."','".$response[$k-2]."')\"
                                       value=\"Response\" class=\"button4\" /></td>";
                                       echo "</tr>";

                                      continue;
                                    }
                                    }
                                    echo "</tr>";
                                      echo "<tr>";
                                    //to response

                                    $to_response=showToResponse($post[$j+1]);
                                    $to_response_num=count($to_response);
                                    for($l=0;$l<$to_response_num;$l++)
                                    {
                                      if(in_array($l, $to_RID_key))
                                     {
                                        continue;
                                     }
                                     if(in_array($l, $to_fromUser_key))
                                    {
                                      echo "<td style=\"word-wrap:break-word;word-break:break-all;padding-left:20px\">";
                                      echo"<b><font color=\"blue\">".getscreen_name($to_response[$l])."</font></b>";
                                      echo"&nbsp;&nbsp;<font color=\"blue\">".getscreen_name($to_response[$l+4])."</font>";
                                      echo"&nbsp;&nbsp;".$to_response[$l+1]."";
                                      echo "</td>";
                                       continue;
                                    }
                                    if(in_array($l, $to_time_key))
                                    {
                                      echo "</tr>";
                                      echo "<tr>";
                                      echo "<td style=\"word-wrap:break-word;word-break:break-all;padding-left:20px\">";
                                      echo"<font size=\"1\">".$to_response[$l]."</font>";
                                      echo "</td>";
                                      echo "<tr >";
                                       echo"<td align=\"right\"><a href=\"like_process.php?".$to_response[$l+1]."=1\"><button type=\"button\" class=\"button2\">Like</button></a><input type=\"button\" onclick=\"disp_prompt2('".$to_response[$l+1]."','".$post[$j+1]."','".$to_response[$l-2]."')\"
                                       value=\"Response\" class=\"button4\" /></td>";
                                       echo "</tr>";

                                      continue;
                                    }
                                    }
                                      echo "</tr>";

                                     continue;
                                 }

                                 echo "<tr>";
                                 echo "<td>";
                                 echo"".$post[$j]."";
                                 echo "</td>";
                                 echo "</tr>";

                            }

                          echo "</table>\n";


                          ?>

                        </td>
                      </tr>
                  </table>
                  </form>
              </td>
            </tr>


            </table>

        </div>
        <div class="right" align="left">

          <table cellspacing="10" class="white" style="width:500px;margin-top:20px">
            <tr>
              <td><h2>Friendship Requests</h2></td>
            </tr>



                        <?php
                        $aa=array();
                        $i=0;
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
                            $query =' select from_email
                                      from friendship
                                      where to_email=\''.$_SESSION["login_user"].'\' and status=\'Pending\'  ';

                            $stid = oci_parse($conn, $query);
                            oci_execute($stid);
                            while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

                                foreach ($row as $item) {
                                if($item !== null)
                                {
                                  $b=htmlentities($item, ENT_QUOTES);
                                  $aa[]=$b;

                                  $i = $i +1 ;
                                }
                                }

                            }
                              if($i !=0)
                              {
                                for($k=0; $k<$i; $k++)
                                  {
                                    echo "
                                      <tr><td>".$aa[$k]."</td><td><a href=\"deal_with_friend.php?".$aa[$k]."=Accepted\"><button type=\"button\" class=\"button2\">Accept</button></a></td>
                                      <td><a href=\"deal_with_friend.php?".$aa[$k]."=Declined\"><button type=\"button\" class=\"button2\">Decline</button></a></td> </tr>
                                       ";
                                  }
                              }
                          }
                        oci_close($conn);
                        ?>





          </table>


          <form action="search_process.php" method="post" >
            <table cellspacing="10" class="white" style="width:500px; margin-top:30px">
              <tr>
                <td><h2>Search a friend</h2></td>
              </tr>
              <tr>
                  <td>E-mail:</td>
                  <td><input type="text" name="email">
                  </td><td><input type="submit" value="Search" class="button2"></td>
              </tr>
              <?php

              if(!empty($_SESSION["search_user"]))
              {

                if(empty($_SESSION["status"]))
                {
                  echo "<tr>
                  <td>".$_SESSION["search_user"]."</td>
                  <td></td>
                  <td><a href=\"add_friend.php\"><button type=\"button\" class=\"button2\">Add Friend</button></a></td>
                </tr>";
                $_SESSION["to_user"]=$_SESSION["search_user"];
                $_SESSION["search_user"]=NULL;
                $_SESSION["status"]=NULL;
              }else{
                echo "<tr>
                <td>".$_SESSION["search_user"]."</td>
                <td></td>
                <td>".$_SESSION["status"]."</td>
              </tr>";
              $_SESSION["search_user"]=NULL;
              $_SESSION["status"]=NULL;
              }

              }



              ?>
            </table>
          </form>



        </div>
    </div>
</body>
</html>
