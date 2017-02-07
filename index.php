<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>


<style>
.toggle{ font-size: 25px; width: 240px; }
.center{ text-align: center; }
.Absolute-Center {
  margin: auto;
  position: absolute;
  top: 0; left: 0; bottom: 0; right: 0;
}
table{ width: 100%; }

.inuse{ background: red; }
.free{ background: green; }
.lunch{ background: yellow; }
.swampStatus{ font-size: 80px; } 
</style>

<table class="center Absolute-Center">
<tr><td class='swampStatus'> Swamp Status: <span id='swampStatus'>Loading...</span></td></tr>
<tr><td><button id='setButton1' class="toggle" onclick='setStatus(0)'>Mark Open</button> <button id='setButton2' class="toggle" onclick='setStatus(1)'>Mark In Use</button></td></tr>
</table>



<script>
function getStatus(){
	$.getJSON( "/api/?action=get", function( json ) {
		status = json['status'];
		changeStatus(status);
		setTimeout(getStatus, 4000);
 	});
}

function setStatus(status){
	status = parseInt(status);
	if (typeof user !== 'undefined') {
    		purpose = user;
	}else{ purpose = "none"; }

        $.getJSON( "/api/?action=set&status="+status+"&purpose="+purpose+"&duration=100", function( json ) {
		getStatus();
        });
}

function changeStatus(status){
	switch(parseInt(status)){
		case 0: $('body').addClass('free').removeClass('inuse').removeClass('lunch'); $('#swampStatus').html('OPEN'); break;
		case 1: $('body').addClass('inuse').removeClass('free').removeClass('lunch'); $('#swampStatus').html('IN USE'); break;
		case 2: $('body').addClass('inuse').removeClass('free').removeClass('lunch'); $('#swampStatus').html('TEAM MEETING'); break;
                case 3: $('body').addClass('lunch').removeClass('inuse').removeClass('free'); $('#swampStatus').html('LUNCH'); break;
		default: $('body').addClass('free').removeClass('inuse').removeClass('lunch'); $('#swampStatus').html('OPEN');
	}
	switch(parseInt(status)){
                case 0: $('#setButton2').attr("onclick", "setStatus(1)").html("Mark In Use"); break;
                case 1: $('#setButton2').attr("onclick", "setStatus(2)").html("Mark Team Meeting"); break;
                case 2: $('#setButton2').attr("onclick", "setStatus(3)").html("Mark Lunch"); break;
                case 3: $('#setButton2').attr("onclick", "setStatus(1)").html("Mark In Use"); break;
		default: $('#setButton2').attr("onclick", "setStatus(1)").html("Mark In Use");
        }
}

getStatus();


</script>
