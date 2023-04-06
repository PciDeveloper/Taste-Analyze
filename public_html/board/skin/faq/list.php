<ul>
	<?
	for($i=1; $row=mysql_fetch_array($qry); $i++)
	{
	?>
		<li onclick="javascript:FaqToggle('<?=$i?>');" style="cursor:pointer;"> <?=$row['title']?> </li>
		<div class="question_wrap_reply" id="answer<?=$i?>" style="display:none;">
				<?=$row['content']?>
		</div>
	<?php
}
if(!$numrows)
{
	?>
	<li><a href="#">등록된 게시물이 없습니다.</a></li>
<?php
}
?>
</ul>


<script type="text/javascript">
function FaqToggle(idx)
{
	$("div[id^='answer']").not($("#answer"+idx)).slideUp(300);

	if($("#answer"+idx).css("display") == "none")
		$("#answer"+idx).slideDown(500);
	else
		$("#answer"+idx).slideUp(500);
}
</script>
