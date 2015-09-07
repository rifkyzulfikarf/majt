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
	
	$("#btn-login").click(function(ev){
		ev.preventDefault();
		var user = $("#login-username").val();
		var pass = $("#login-password").val();
		var hak = $("#hak").text();
		
		if (hak == "Admin ") {
			hak = "1";
		} else {
			hak = "2";
		}
		
		console.log(hak);
		
		$.ajax({
			url: "auxs/index_aux.php",
			method: "POST",
			cache: false,
			dataType: "JSON",
			data: {"apa" : "cek-login", "user" : user, "pass" : pass, "hak" : hak},
			success: function(eve) {
				if (eve.status) {
					if (hak == "1") {
						window.location.href = "admin.php";
					} else {
						window.location.href = "catering.php";
					}
				} else {
					$('#alert-failed').text(eve.msg);
					if ( !$('#alert-failed').is( '.in' ) ) {
						$('#alert-failed').addClass('in');

						setTimeout(function() {
							$('#alert-failed').removeClass('in');
						}, 1800);
					}
				}
			},
			error: function(err) {
				console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
				alert("Gagal terkoneksi dengan server..");
			}
		});
	});
	
});

