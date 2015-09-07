// global. currently active menu item 
var current_item = 0;

// few settings
var section_hide_time = 600;
var section_show_time = 600;
var json_events;

// jQuery stuff
$(document).ready(function() {
	
	init();
	
	function init() {
		$.ajax({
			url: 'auxs/catering_aux.php',
			type: 'POST',
			data: {"apa" : "calendar-data"},
			async: false,
			success: function(response){
				json_events = response;
			}
		});
	};
	
	var calendar = $('#calendar').fullCalendar({
        selectable: true,
		events: JSON.parse(json_events),
    });
	
	// Switch section
	$("a", '.mainmenu').click(function() 
	{
		if( ! $(this).hasClass('active') ) { 
			current_item = this;
			// close all visible divs with the class of .section
			$('.section:visible').fadeOut( section_hide_time, function() { 
				$('a', '.mainmenu').removeClass( 'active' );  
				$(current_item).addClass( 'active' );
				var new_section = $( $(current_item).attr('href') );
				new_section.fadeIn( section_show_time );
			} );
		}
		return false;
	});

	// Dropdown
	$(".dropdown-menu li a").click(function(){
	  var selText = $(this).text();
	  $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
	});
	
	$("#logout").click(function(){
		$.ajax({
			url: "auxs/catering_aux.php",
			method: "POST",
			cache: false,
			dataType: "JSON",
			data: {"apa" : "logout"},
			success: function(eve) {
				if (eve.status) {
					window.location.href = "index.html";
				}
			},
			error: function(err) {
				console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
				alert("Gagal terkoneksi dengan server..");
			}
		});
	});
	
});

