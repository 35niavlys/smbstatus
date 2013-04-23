<html>
    <head>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" href="./css/jquery.mobile-1.3.1.min.css" />
	<link rel="stylesheet" href="./css/css.css" />
	<script src="./js/jquery-1.9.1.min.js"></script>
        <script src="./js/js.js"></script>
	<script src="./js/jquery.mobile-1.3.1.min.js"></script>
    </head>
    <body>
	<div data-role="page">
      	    <div data-role="header" data-theme="b">
         	<div id='refresh-button' class="ui-btn-right" data-role="fieldcontain">
                    <select name="slider" id="slider" data-role="slider">
                        <option value="off">Off</option>
                        <option value="on">On</option>
                    </select>
                </div>
		<h1>Samba</h1>
      	    </div>
	    <div data-role="content">
	        <ul id="message" data-role="listview" data-inset="true">
		</ul>
	    </div>

	    <div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" class="ui-corner-all">
		<div data-role="header" data-theme="a" class="ui-corner-top">
        	    <h1>Kill this user?</h1>
		</div>
		<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
	            <h3 class="ui-title">Do you really want to kill this user?</h3>
	            <a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>
	            <a href="#" onClick="javascript:kill()" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Kill</a>
	        </div>
	    </div>


	    <div data-role="popup" id="afterKill" class="ui-corner-all">
		<div id="afterKillText" data-theme="d" class="ui-corner-bottom ui-content">
    		    User killed...
		</div>
	    </div>
	</div>
	<script>
	    $(document).ready(function() {
		ajax();
		var myswitch = $("select#slider");
		myswitch[0].selectedIndex = 1;
		myswitch.slider("refresh");
		setInterval(
		    function ()
		    {
			if(myswitch[0].value == "on")
			    ajax();
		    }, 5000);
	    });
	</script>
    </body>
</html>
