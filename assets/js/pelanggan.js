// global. currently active menu item 
var current_item = 0;

// few settings
var section_hide_time = 600;
var section_show_time = 600;

// jQuery stuff
$(document).ready(function() {
	
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
	
	$('#calendar').fullCalendar({
        // put your options and callbacks here
    });
	
	$("#logout").click(function(){
		$.ajax({
			url: "assets/auxs/pelanggan_aux.php",
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

