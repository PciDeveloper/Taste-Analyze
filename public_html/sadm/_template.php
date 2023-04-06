<?php include_once dirname(__FILE__)."/./html_header.php"; ?>
<div class="main-content">
    <div class="main-content-inner">
      <div class="breadcrumbs" id="breadcrumbs"> 
        <script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>
        <ul class="breadcrumb">
          <li> <?=$navi?></li>
        </ul>
        <!-- /.breadcrumb -->  
      </div>
      <div class="page-content">
         <!-- /.ace-settings-container -->
             <?=$buffer?>