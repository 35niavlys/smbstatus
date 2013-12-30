<?
    if(isset($_GET['kill'])){
		echo shell_exec("sudo ./smbkill ".escapeshellcmd($_GET['kill'])." 2>&1");
    }
?>
