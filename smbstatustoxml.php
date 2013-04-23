<?
exec("smbstatus",$smbstatus);

$i=4;
while(($i<sizeof($smbstatus)) && (!trim($smbstatus[$i])=="")) {
    $part1[] = split("[ ]+",$smbstatus[$i],4);

    $pid = $part1[$i-4][0];
    $username = $part1[$i-4][1];
    $group = $part1[$i-4][2];
    $machine = trim(preg_replace("#(.*)\(.*#s", "$1", $part1[$i-4][3]));
    $ip = preg_replace("#.*\((.*)\).*#s", "$1", $part1[$i-4][3]);

    $users[] = array($machine,$pid,$username,$group,$ip);
    $i++;
}

$j=$i+3;
while(($j<sizeof($smbstatus)) && (!trim($smbstatus[$j])=="")) {
    $part2[] = split("[ ]+",$smbstatus[$j],4);
    $service = $part2[$j-$i-3][0];
    $pid = $part2[$j-$i-3][1];
    $machine = $part2[$j-$i-3][2];
    $date = $part2[$j-$i-3][3];
    $services[] = array($service,$pid,$machine,$date);
    $j++;
}

$k=$j+3;
while(($k<sizeof($smbstatus)) && (!trim($smbstatus[$k])=="")) {
    $part3[] = split("[ ]+",$smbstatus[$k],8);

    $pid = $part3[$k-$j-3][0];
    $uid = $part3[$k-$j-3][1];
    $deny_mode = $part3[$k-$j-3][2];
    $access = $part3[$k-$j-3][3];
    $rw = $part3[$k-$j-3][4];
    $oplock = $part3[$k-$j-3][5];
    $service = end(explode("/",$part3[$k-$j-3][6]));
    $name = htmlspecialchars(trim(substr_replace($part3[$k-$j-3][7],"",-25)));
    $time = trim(substr($part3[$k-$j-3][7], strlen($part3[$k-$j-3][7])-25, 25));

    $locks[] = array($name,$pid,$uid,$deny_mode,$access,$rw,$oplock,$service,$time);
    $k++;
}

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\"?>\n";
echo "<xml>\n";
asort($users);
arsort($locks); //Permet de les locks a l'inverse de l'ordre alphabetique
foreach($users as $user){
    list($user_machine,$user_pid,$user_username,$user_group,$user_ip) = $user;
    echo "\t<user pid=\"".$user_pid."\" username=\"".$user_username."\" group=\"".$user_group."\" machine=\"".$user_machine."\" ip=\"".$user_ip."\">\n";

    foreach($services as $service){
	list($service_service,$service_pid,$service_machine,$service_date) = $service;
	if($user_pid==$service_pid){
	    echo "\t\t<service service=\"".$service_service."\" date=\"".$service_date."\">\n";

	    //arsort($locks); //Permet de les locks a l'inverse de l'ordre alphabetique
	    $oldlink = ""; //Permet de se souvenir du dernier lock ecrit afin de supprimer les suivants si similaire
	    $locksxml = ""; //Permet de remettre les locks dans l'ordre alphabetique
	    foreach($locks as $lock){
		list($lock_name,$lock_pid,$lock_uid,$lock_deny_mode,$lock_access,$lock_rw,$lock_oplock,$lock_service,$lock_time) = $lock;

                if(($service_pid==$lock_pid) && ($service_service==$lock_service)){
		    if ((strstr(trim($oldlink), trim($lock_name)) != false) || (trim($lock_name) == '.'))
            		continue;

		    $locksxml = "\t\t\t<locks name=\"".$lock_name."\" deny_mode =\"".$lock_deny_mode."\" time=\"".$lock_time."\" />\n".$locksxml;
		    $oldlink = $lock_name;
		}
	    }
	echo $locksxml;
	echo "\t\t</service>\n";
	}
    }
    echo "\t</user>\n";
}
echo "</xml>";
?>
