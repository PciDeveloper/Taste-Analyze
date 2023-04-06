<?
include_once(dirname(__FIlE__)."/../inc/_header.php");
switch($act)
{
  case "imgdel" :
    $row = $db->_fetch("select * from sw_member where idx='".$_REQUEST['idx']."'");

    $sql = "update sw_member set photo='' where idx='".$row['idx']."'";
    if($db->_execute($sql))
    {
      @FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member");
      @FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member/thum");
      msgGoUrl("사진이 삭제되었습니다.", "./setting.php");
    }
    else
    {
      ErrorHtml($sql);
    }
  break;
  case 'leave':
    // 탈퇴
    $usqry = sprintf("update %s set `status`=0, `leave`='1', leave_date= now() where userid='%s'", SW_MEMBER,   $_REQUEST['idx']);
    if($db->_execute($usqry)){
      unset($_SESSION['SES_USERID'], $_SESSION['SES_USEREM'], $_SESSION['SES_USERNM'], $_SESSION['SES_USERLV'], $_SESSION['SES_USERIDX'], $_SESSION['SES_GUEST'] ,$_SESSION['$user_info_json'] , $_SESSION['SES_KAKAO'] , $_SESSION['SES_NAVER']);
      msgGoUrl("회원탈퇴 되었습니다.\n 이용해 주셔서 감사합니다.", "../index.php");
    }else{
      ErrorHtml($isqry);
    }
  break;
  case "changepwd" :
  // 비밀번호 변경
  $addQry = sprintf(", pwd='%s'", $db->_password($pwd));
    $sqry = "update sw_member set pwd ='".$db->_password($pwd)."' where idx='".$_SESSION['SES_USERIDX']."'";
    if($db->_execute($sqry))
    {
      msgGoUrl("비밀번호가 변경되었습니다.", "/mypage/index.php");
    }
  break;
  case "cancel" :
    $isqry  = "update sw_booking set
                status = '99',
                updt = now()
              where
                idx ='".$_REQUEST['idx']."'
    ";
    if($db->_execute($isqry))
    {
      msgGoUrl("정상적으로 예약이 취소되었습니다.", "./index.php");
    }
  break;
  //좋아요
  case "like" :

          $isqry = "delete from  sw_like where idx='".$_REQUEST['gidx']."'";
          if($db->_execute($isqry)){
            echo("001");
            exit;
          }else{
            echo("002");
            exit;
          }

  break;

  //메인좋아요
  case "mainlike" :
  echo $_REQUEST['gidx'];
  $row = $db->_fetch("select count(*) from sw_like where wr_id='".$_REQUEST['gidx']."' and mb_id='".$_SESSION['SES_USERID']."'");
  if ($row[0] > 0) {
    echo ("003");
    exit;
  }
  $isqry = "insert into sw_like set
        bo_table = 'goods',
        wr_id = '".$_REQUEST['gidx']."',
        useridx='".$_SESSION['SES_USERIDX']."',
        mb_id='".$_SESSION['SES_USERID']."',
        good = '1',
        regdt = now()
      ";

  if($db->_execute($isqry)){
    echo("001");
    exit;
  }else{
    echo("002");
    exit;
  }

  break;
  default :

    $row = $db->_fetch("select * from sw_member where idx='".$_REQUEST['idx']."'");

    if ($_REQUEST['oldpwd']){
      if(!strcmp($db->_password($_REQUEST['oldpwd']), $row['pwd']))
  		{
        if(!empty($_FILES['img1']['name']))
        {
          @FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member");
          @FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member/thum");

          $imgName1 = FileUpload($_FILES['img1'], $row['photo'], $_SERVER[DOCUMENT_ROOT].'/upload/member');
          crateThumImg1($imgName1, $_SERVER[DOCUMENT_ROOT].'/upload/member/', $_SERVER[DOCUMENT_ROOT].'/upload/member/thum/',"300");
        }
        else
        {
          if(${'old_pic1'})
          {
            $imgName1 = $row['photo'];
          }
          else
          {
            @FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member");
            @FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member/thum");

            $imgName1 = "";
          }
        }

        if($_REQUEST['pwd']){
          $addQry = sprintf(", pwd='%s'", $db->_password($_REQUEST['newpwd']));
        }


        $isqry = " update sw_member set
                    nick = '".$nick."',
                    hp = '".$hp."'
                    $addQry
                where
                  idx ='".$_REQUEST['idx']."'
        ";
        if ($db->_execute($isqry)){

        }
      }else{
        msgGoUrl("현재 비밀번호가 일치하지 않습니다.", "./setting.php");
      }

    }else{
      if(!empty($_FILES['img1']['name']))
      {
        @FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member");
        @FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member/thum");

        $imgName1 = FileUpload($_FILES['img1'], $row['photo'], $_SERVER[DOCUMENT_ROOT].'/upload/member');
        crateThumImg1($imgName1, $_SERVER[DOCUMENT_ROOT].'/upload/member/', $_SERVER[DOCUMENT_ROOT].'/upload/member/thum/',"300");
      }
      else
      {
        if(${'old_pic1'})
        {
          $imgName1 = $row['photo'];
        }
        else
        {
          @FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member");
          @FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member/thum");

          $imgName1 = "";
        }
      }

      if($_REQUEST['pwd']){
        $addQry = sprintf(", pwd='%s'", $db->_password($_REQUEST['newpwd']));
      }


      $isqry = " update sw_member set
                  nick = '".$nick."',
                  hp = '".$hp."',
                  photo = '".$imgName1."'
                  $addQry
              where
                idx ='".$_REQUEST['idx']."'
      ";
      if ($db->_execute($isqry)){
          msgGoUrl("회원정보가 수정되었습니다.", "./setting.php");
      }
    }


  break;

}
?>
