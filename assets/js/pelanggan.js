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
		$("#orderable-box").hide();
		$("#booking-form-box").hide();
		$.ajax({
			url: 'assets/auxs/pelanggan_aux.php',
			type: 'POST',
			data: {"apa" : "calendar-data"},
			async: false,
			success: function(response){
				json_events = response;
			}
		});
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
	
	var calendar = $('#calendar').fullCalendar({
        selectable: true,
		events: JSON.parse(json_events),
		dayClick: function(date, jsEvent, view) {
			$("#calendar-box").fadeOut(section_hide_time, function(){
				$("#orderable-box").fadeIn(section_show_time);
				$("#orderable-box").empty();
				
				$.ajax({
					url: "assets/auxs/pelanggan_aux.php",
					method: "POST",
					cache: false,
					data: {"apa" : "show-orderable", "tgl" : date.format()},
					success: function(html) {
						$("#orderable-box").html(html);
					},
					error: function(err) {
						console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
						alert("Gagal terkoneksi dengan server..");
					}
				});
				
			});
		}
    });
	
	var tabelpesanan = $("#tabel-pesanan").DataTable({
		ordering: false,
		autoWidth: true,
		ajax:{
			url : "assets/auxs/pelanggan_aux.php",
			type : "POST",
			data : function(d) {
				d.apa = "daftar-pesanan";
			}
		}
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
	
	$("#menu-home").click(function(){
		$("#booking-form-box").fadeOut(section_hide_time, function(){
			$("#orderable-box").fadeOut(section_hide_time, function(){
				$("#calendar-box").fadeIn(section_show_time);
				$.ajax({
					url: 'assets/auxs/pelanggan_aux.php',
					type: 'POST',
					data: {"apa" : "calendar-data"},
					async: false,
					success: function(response){
						json_events = response;
					}
				});
				calendar.fullCalendar('removeEvents');
				calendar.fullCalendar('addEventSource', JSON.parse(json_events));
				calendar.fullCalendar('rerenderEvents')
			});
		});
	});
	
	$("#head").on("click", ".pesan-item", function(ev){
		ev.preventDefault();
		$("#tgl").val($(this).data("tgl"))
		$("#id-gedung").val($(this).data("id"))
		$("#nama-gedung").val($(this).data("nama"))
		$("#id-waktu").val($(this).data("idwaktu"))
		$("#waktu").val($(this).data("waktu"))
		$("#harga").val($(this).data("harga"))
		
		$("#orderable-box").fadeOut(section_hide_time, function(){
			$("#booking-form-box").fadeIn(section_show_time);
		});
		
	});
	
	$("#btn-pesan").click(function(ev){
		ev.preventDefault();
		var tgl = $("#tgl").val();
		var idgedung = $("#id-gedung").val();
		var nama = $("#nama").val();
		var alamat = $("#alamat").val();
		var provinsi = $("#provinsi").text();
		var kota = $("#kota").val();
		var kodepos = $("#kodepos").val();
		var telp = $("#telp").val();
		var waktu = $("#id-waktu").val();
		var harga = $("#harga").val();
		
		$.ajax({
			url: "assets/auxs/pelanggan_aux.php",
			method: "POST",
			cache: false,
			dataType: "JSON",
			data: {"apa" : "simpan-booking", "tgl" : tgl, "idgedung" : idgedung, "nama" : nama, "alamat" : alamat, "provinsi" : provinsi, "kota" : kota, "kodepos" : kodepos, "telp" : telp, "waktu" : waktu, "harga" : harga},
			success: function(eve) {
				if (eve.status) {
					
					$("#nama").val("");
					$("#alamat").val("");
					$("#kota").val("");
					$("#kodepos").val("");
					$("#telp").val("");
					
					$('#alert-success').text(eve.msg);
					if ( !$('#alert-success').is( '.in' ) ) {
						$('#alert-success').addClass('in');

						setTimeout(function() {
							$('#alert-success').removeClass('in');
						}, 1800);
					}
					
					$("#menu-home").click();
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
	
	$("#menu-pesanan").click(function(){
		tabelpesanan.ajax.reload();
	});
	
});

