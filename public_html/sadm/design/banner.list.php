<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기타/배너관리 > 배너 리스트";
include_once dirname(__FILE__)."/../_template.php";

//$arGrp = listBannerGrp();
if($encData)
{
	$encArr = getDecode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

if($code)
	$arrW[] = sprintf("code='%s'", $code);

if($sstr)
	$arrW[] = sprintf("%s LIKE '%%%s%%'", $skey, $sstr);

if($sday && $eday)
	$arrW[] = "(regdt BETWEEN DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59'))";
else if($sday)
	$arrW[] = "regdt >= DATE_FORMAT('{$sday}', '%Y-%m-%d 00:00:00')";
else if($eday)
	$arrW[] = "regdt <= DATE_FORMAT('{$eday}', '%Y-%m-%d 23:59:59')";

if($arrW)
	$AddW = sprintf(" AND %s", implode(" AND ", $arrW));

$sqry = sprintf("select * from %s where 1=1 %s", SW_BANNER, $AddW);
$db->_affected($numrows, $sqry);
$pgLimit = ($pgnum) ? $pgnum : 20;
$pgBlock = 10;
$start = ($start) ? $start : 0;
$letter_no = $numrows - $start;

$sqry .= sprintf(" order by idx desc limit %d, %d", $start, $pgLimit);
$qry = $db->_execute($sqry);

### Paging Parameter ###
$param['skey'] = ($sstr) ? $skey : "";
$param['sstr'] = $sstr;
$param['pgnum'] = $pgnum;
$param['code'] = $code;
########################
include_once dirname(__FILE__)."/../../lib/class.page.php";
$pg = new getPage($start, $pgLimit, $pgBlock, $numrows, $param);
$encData = getEncode64($pg->getparm);
?>
<div class="page-header">
	<h1>
		기타/배너관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			배너 리스트
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">

	<p>
		<button type="button" onclick="javascript:location.href='./banner.write.php'" class="btn btn-white btn-info" >배너 등록</button>
	</p>
	<table   class="table table-bordered center">
    <colgroup>
  <col width="50" />
  <col  />
  <col width="300" />
  <col />
  <col width="120" />
  <col span="2" width="100" />
  </colgroup>
  <thead>
  <tr>
  	<th>번호</th>
  	<th>이미지</th>
  	<th>배너명</th>
  	<th>노출기간</th>
  	<th>설정</th>
  </tr>
  </thead>
  <tbody>
  <?
  for($i=1; $row=mysql_fetch_array($qry); $i++)
  {
  	$encData = getEncode64("idx=".$row['idx']."&start=".$start."&".$pg->getparm);
  ?>
  <tr onMouseOver="this.style.background='#eef3f7';" onMouseOut="this.style.background='';">
  	<td><?=$letter_no?></td>
  	<td style="padding:5px;"><img src="/upload/design/<?=$row['img']?>" width="280px"></td>
  	<td style="text-align:left;padding:3px 10px;">
  		<p class="user_addr mb5"><?=$row['name']?></p>
  		<p class="user_tel mb5">타켓 : <?=($row['target'] == "_blank") ? "새창" : (($row['target']=="_parent") ? "현재창" : "링크없음")?></p>
  		<p class="user_tel">링크 : <?=($row['url']) ? "<a href='".$row['url']."' target='_blank'>".$row['url']."</a>" : "링크없음";?>
  	</td>
  	<td><?=$row['sday']?> 부터<br /><?=$row['eday']?> 까지</td>
  	<td>
      <button type="button" onclick="javascript:location.href='./banner.edit.php?encData=<?=$encData?>'" class="btn btn-white btn-info btn-sm"/>수정</button>
      <button type="button" onclick="Del('<?=$encData?>');" class="btn btn-white btn-danger btn-sm"/>삭제</button>

  	</td>
  </tr>
  <?
  	$letter_no--;
  }

  if($numrows < 1)
  	echo("<tr><td colspan=\"8\" height=\"100\" align=\"center\">등록된 배너가 없습니다.</td></tr>");

  ?>
  </tbody>
  </table>
  <p id="paging"><?=$pg->page_return;?></p>

<form name="dfm" action="./common.act.php" method="post">
<input type="hidden" name="mode" value="banner" />
<input type="hidden" name="act" value="del" />
<input type="hidden" name="encData" />
</form>

<script type="text/javascript">
function Del(data)
{
	var f = document.dfm;

	if(confirm("해당 배너를 정말 삭제하시겠습니까?"))
	{
		f.encData.value = data;
		f.submit();
	}
}
</script>
	 	</div>
 	</div>
</div>
<?
include_once dirname(__FILE__)."/../html_footer.php";
?>
