<?
include_once(dirname(__FILE__)."/./zm_crypt_ref.php");
$zPw = ZmMakePw();
$zEncrypt = ZmEncrypt($zPw);

echo <<< SCRIPT
	<script type="text/javascript">
	parent.document.getElementById("crypt_img").src = "/lib/zm_crypt_img.php?zCode={$zEncrypt}";
	parent.document.getElementById("antiSpamCode").value = "{$zEncrypt}";
	</script>
SCRIPT;
?>
