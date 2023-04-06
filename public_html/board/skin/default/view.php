
		<ul>
				<li class="head">
						<div class="title"><?=$vdata['title']?></div>
						<div class="writer"><?=$vdata['name']?></div>
						<div class="date"><?=str_replace("-", ".", substr($vdata['regdt'], 0, 10));?></div>
				</li>
				<li class="notice_content">
					<?php
					$file_img = $db->_fetch("select * from sw_boardfile where bidx='".$vdata['idx']."' and filetype = 0");
					$video_img = $db->_fetch("select * from sw_boardfile where bidx='".$vdata['idx']."' and filetype = 1");
					$attach_img = $db->_fetch("select * from sw_boardfile where bidx='".$vdata['idx']."' and filetype = 2");
					 ?>
					<div class="notice_file">
						<?php if($file_img['upfile']){?>
						<img src="/img/icon/clip_2.png">
						<button type="button" onclick="javascript:location.href='/board/download.php?file=<?=$file_img['upfile']?>&org=<?=$file_img['upreal']?>'"><?=$file_img['upreal']?></button>
					<?php }?>
				</div>
				<div class="notice_file">
					<?php if($video_img['upfile']){?>
					<img src="/img/icon/clip_2.png">
					<button type="button" onclick="javascript:location.href='/board/download.php?file=<?=$video_img['upfile']?>&org=<?=$video_img['upreal']?>'"><?=$video_img['upreal']?></button>
				<?php }?>
			</div>
			<div class="notice_file">
				<?php if($attach_img['upfile']){?>
				<img src="/img/icon/clip_2.png">
				<button type="button" onclick="javascript:location.href='/board/download.php?file=<?=$attach_img['upfile']?>&org=<?=$attach_img['upreal']?>'"><?=$attach_img['upreal']?></button>
			<?php }?>
					</div>

						<p><?=$vdata['content']?></p>
				</li>
				<?if($vdata['status']=="Y"){?>
				<li class="comment_view">
						<p class="name">체험넷</p>
						<p class="date"><?=str_replace("-", ".", substr($vdata['updt'], 0, 10));?></p>
						<p><?=stripslashes($vdata['re_content'])?></p>
				</li>
			<?php }?>
		 </ul>
