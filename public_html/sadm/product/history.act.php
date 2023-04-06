
<?php
include_once(dirname(__FILE__)."/../_header.php");

if(!empty($_FILES['video']['name'])){
			$fileName	= fileUpload($_FILES['video'], "", $_SERVER[DOCUMENT_ROOT]."/upload/goods/big/");
			$orgName	= $_FILES['video']['name'];
			// $thum = fileUpload($_FILES['thum'],$_FILES['thum'], $_SERVER[DOCUMENT_ROOT].'/upload/goods/big');
}

		$mood    = sprintf("%s」「%s」「%s", $_REQUEST['mood']);
		$emotion	= ($emotion) ? $emotion : 0;

		$isqry = "insert into sw_taste set
					useridx   = '".$_SESSION['SES_USERIDX']."',
					title    	= '".$title."',
					content 	= '".$content."',
					video 		= '".$fileName."',
					swhappy 		= '".$swhappy."',
					swsad 	 		= '".$swsad."',
					swangry 	  = '".$swangry."',
					swsurpr 	  = '".$swsurpr."',
					swscar 	    = '".$swscar."',
					swdisgus 	  = '".$swdisgus."',
					bhappy 		= '".$bithappy."',
					bsad 	 		= '".$bitsad."',
					bangry 	  = '".$bitangry."',
					bsurpr 	  = '".$bitsurpr."',
					bscar 	    = '".$bitscar."',
					bdisgus 	  = '".$bitdisgus."',
					slthappy 		= '".$sthappy."',
					sltsad 	 		= '".$stsad."',
					sltangry 	  = '".$stangry."',
					sltsurpr 	  = '".$stsurpr."',
					sltscar 	    = '".$stscar."',
					sltdisgus 	  = '".$stdisgus."',
					sourhappy 		= '".$sohappy."',
					soursad 	 		= '".$sosad."',
					sourangry 	  = '".$soangry."',
					soursurpr 	  = '".$sosurpr."',
					sourscar 	    = '".$soscar."',
					sourdisgus 	  = '".$sodisgus."',
					spchappy 		= '".$sphappy."',
					spcsad 	 		= '".$spsad."',
					spcangry 	  = '".$spangry."',
					spcsurpr 	  = '".$spsurpr."',
					spcscar 	    = '".$spscar."',
					spcdisgus 	  = '".$spdisgus."',
					emotion 		= '".$emotion."',
					sweetstp 		= '".$mood1."',
					bitstp 			= '".$mood2."',
					saltstp 			= '".$mood3."',
					sourstp 			= '".$mood4."',
					spicystp 			= '".$mood5."',
					regdt		  = now(),
					updt 		  = now()";

					// echo $isqry;
					// exit();


		if($db->_execute($isqry))
		{
			msgGoUrl("등록이 완료되었습니다.", "/sadm/product/index.php");
		}
		else
			ErrorHtml($isqry);

?>
