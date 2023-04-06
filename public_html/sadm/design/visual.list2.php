<?
include_once dirname(__FILE__)."/../_header.php";
$navi = "기타/배너관리 > 출석배너 이미지 관리";
include_once dirname(__FILE__)."/../_template.php";

if($encData)
{
	$encArr = getDecode64($encData);
	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

if($sstr)
	$arrW[] = sprintf("%s LIKE '%%%s%%'", $skey, $sstr);

if($arrW)
	$AddW = sprintf(" AND %s", implode(" AND ", $arrW));

$sqry = sprintf("select * from %s where 1=1 and `gubun` = 'M' %s order by idx desc", SW_VISUAL, $AddW);
$db->_affected($numrows, $sqry);
$qry = $db->_execute($sqry);

while($row=mysql_fetch_array($qry))
{ 
	$arr_pc[] = $row;
}
?> 
<div class="page-header">
	<h1>
		기타/배너관리
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			출석배너 이미지 관리
		</small>
	</h1>
</div><!-- /.page-header -->
<div class="row">
	 <div class="col-xs-12">
 
	<p>
		<button type="button" onclick="Common.openLayerPopup('./ifrm.visual2.php', 600, 400, '', 'no');" class="btn btn-white btn-info" >출석배너 등록</button>
	</p>
	<table   class="table table-bordered center">
	<colgroup>
	<col width="80" /> 
	<col width="280" />
	<col width="280"/>
	<col  width="100" />
	<col width="150" />
	</colgroup>
	<thead>
	<tr>
		<th class="center">순위</th> 
		<th class="center">이미지</th>
		<th class="center">제목</th>
		<th class="center">노출여부</th>
		<th class="center">설정</th>
	</tr>
	</thead>
	<tbody>
	<?
	for($i=0; $i < count($arr_pc); $i++)
	{
	?>
	<tr onMouseOver="this.style.background='#eef3f7';" onMouseOut="this.style.background='';">
		<td><?=$arr_pc[$i]['seq']?></td>
		<td style="padding:5px;"><?=getImageTag("../../upload/design", $arr_pc[$i]['img'], 250, 100)?></td>
		<td style="text-align:left;padding:3px 10px;">
			<p class="user_addr mb5"><?=$arr_pc[$i]['title']?></p> 
		</td>
		<td><img src="/sadm/img/icon/icon_<?=($arr_pc[$i]['buse'] == "Y") ? "yes" : "no";?>.gif" /></td>
		<td> 
			<button type="button" onclick="Common.openLayerPopup('./ifrm.visual2.php?idx=<?=$arr_pc[$i]['idx']?>', 600, 400, '', 'no');" class="btn btn-white btn-info btn-sm"/>수정</button> 
			<button type="button" onclick="Del('<?=$arr_pc[$i]['idx']?>');" class="btn btn-white btn-danger btn-sm"/>삭제</button> 
		</td>
	</tr>
	<?
	}

	if(count($arr_pc) < 1)
		echo("<tr><td colspan=\"8\" height=\"100\" align=\"center\">등록된 PC버전 메인이미지가 없습니다.</td></tr>");

	?>
	</tbody>
	</table>
		<form name="dfm" action="./common.act.php" method="post">
		<input type="hidden" name="mode" value="visual" />
		<input type="hidden" name="act" value="visualdel" />
		<input type="hidden" name="idx" />
		</form>

		<script type="text/javascript">
		function Del(data)
		{
			var f = document.dfm;

			if(confirm("출석배너를  정말 삭제하시겠습니까?"))
			{
				f.idx.value = data;
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
