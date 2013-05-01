pid="";

function kill() {
    $.get("kill.php?kill=" + pid, function(data) {
        $('#afterKillText').html(data);
    	$("#afterKill").popup("open");
    });
}

function ajax()
{
    var xhr=null;
 
    if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr.onreadystatechange = function() { alert_ajax(xhr); };
 
    xhr.open("GET", "xml.php", true);
    xhr.send(null);
}
 
function alert_ajax(xhr)
{
    if (xhr.readyState==4) 
    {
    	var docXML= xhr.responseXML;
    	var users = docXML.getElementsByTagName("user");
    	var result = "";

	if(users.length>0)
	{
            for (i=0;i<users.length;i++)
	    {
		result += "<li data-role=\"list-divider\">";
		result += "<div data-role=\"content\"><div class=\"ui-grid-a\">"
		result += "<div class=\"ui-block-a\">";
		result += "<a href=\"#popupDialog\" onClick=\"javascript:pid=" + users.item(i).getAttribute("pid") + "\" data-rel=\"popup\" data-position-to=\"window\" >";
		result += "<span class=\"imgkill\" title=\"kill\" ></span>";
		result += "</a>";
		result += "<a title=\"" + users.item(i).getAttribute("pid") + "\" style=\"margin-left: 20px\">" + users.item(i).getAttribute("machine") + " ("+users.item(i).getAttribute("username")+")</a></div>";
		result += "<div class=\"ui-block-b\"><a class=\"ip\">"+users.item(i).getAttribute("ip")+"</a></div>";
		result += "</div></li>";

		var services = users.item(i).getElementsByTagName("service");
		for(j=0;j<services.length;j++)
		{
		    if(services.item(j).getAttribute("service") == "IPC$")
			continue;
		    result += "<li>";
		    result += "<h4>"+services.item(j).getAttribute("service")+"</h4>";
		    result += "<p class=\"ui-li-aside\">"+services.item(j).getAttribute("date")+"</p>";
		   
		    var locks = services.item(j).getElementsByTagName("locks");
		    for(k=0;k<locks.length;k++)
		    {
			result += "<p><a title=\"" + locks.item(k).getAttribute("time") + "\">"+locks.item(k).getAttribute("name")+"</a></p>";
		    }

		    result += "</li>";
		}

            }
	}
	else
	{
	    result = "<li>";
    	    result += "<div class=\"center\">Nobody is connected</div>";
	    result +="</li>";
	}
	$(function() {
	    $('#message').html(result);
	    $('#message').listview('refresh');
            $('.test').button('refresh');
	});
    }
}

