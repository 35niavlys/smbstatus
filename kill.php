<?
    if(isset($_GET['kill'])){
	echo shell_exec("sudo ./smbkill ".$_GET['kill']." 2>&1");
    }
?>
