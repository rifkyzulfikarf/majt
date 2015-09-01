// global. currently active menu item 
var current_item = 0;

// few settings
var section_hide_time = 600;
var section_show_time = 600;

// jQuery stuff
$(document).ready(function() {
	
	init();
	
	function init() {
		$("#signup-box").hide();
	};
	
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
	
	$("#btn-show-login").click(function(){
		$("#signup-box").fadeOut(section_hide_time, function(){
			$("#login-box").fadeIn(section_show_time);
		});
	});
	
	$("#btn-show-signup").click(function(){
		$("#login-box").fadeOut(section_hide_time, function(){
			$("#signup-box").fadeIn(section_show_time);
		});
	});
	
	$("#btn-login").click(function(ev){
		ev.preventDefault();
		var user = $("#login-username").val();
		var pass = $("#login-password").val();
		
		$.ajax({
			url: "assets/auxs/index_aux.php",
			method: "POST",
			cache: false,
			dataType: "JSON",
			data: {"apa" : "cek-login", "user" : user, "pass" : pass},
			success: function(eve) {
				if (eve.status) {
					window.location.href = "pelanggan.php";
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
	
	$("#btn-signup").click(function(ev){
		ev.preventDefault();
		var nama = $("#nama").val();
		var gender = $("#gender").text();
		var alamat = $("#alamat").val();
		var telp = $("#telp").val();
		var email = $("#email").val();
		var user = $("#username").val();
		var pass1 = $("#password").val();
		var pass2 = $("#password2").val();
		
		if (pass1 == pass2) {
			$.ajax({
				url: "assets/auxs/index_aux.php",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"apa" : "daftar-baru", "nama" : nama, "gender" : gender, "alamat" : alamat, "telp" : telp, "email" : email, "user" : user, "pass" : pass1},
				success: function(eve) {
					if (eve.status) {
						
						$("#nama").val("");
						$("#alamat").val("");
						$("#telp").val("");
						$("#email").val("");
						$("#username").val("");
						$("#password").val("");
						$("#password2").val("");
						
						$('#alert-success').text(eve.msg);
						if ( !$('#alert-success').is( '.in' ) ) {
							$('#alert-success').addClass('in');

							setTimeout(function() {
								$('#alert-success').removeClass('in');
							}, 1800);
						}
						
						$("#btn-show-login").click();
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
		} else {
			$('#alert-failed').text("Password tidak cocok !");
			if ( !$('#alert-failed').is( '.in' ) ) {
				$('#alert-failed').addClass('in');

				setTimeout(function() {
					$('#alert-failed').removeClass('in');
				}, 1800);
			}
		}
		
	});
	
});

