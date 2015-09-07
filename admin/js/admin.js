// global. currently active menu item 
var current_item = 0;

// few settings
var section_hide_time = 600;
var section_show_time = 600;
var json_events;

// jQuery stuff
$(document).ready(function() {
	
	var tabelpesanan = $("#tabel-pesanan").DataTable({
		ordering: false,
		autoWidth: true,
		ajax:{
			url : "auxs/admin_aux.php",
			type : "POST",
			data : function(d) {
				d.apa = "daftar-pesanan";
			}
		}
	});
	
	var tabelgedung = $("#tabel-gedung").DataTable({
		ordering: false,
		autoWidth: true,
		ajax:{
			url : "auxs/admin_aux.php",
			type : "POST",
			data : function(d) {
				d.apa = "daftar-gedung";
			}
		}
	});
	
	var tabelcatering = $("#tabel-catering").DataTable({
		ordering: false,
		autoWidth: true,
		ajax:{
			url : "auxs/admin_aux.php",
			type : "POST",
			data : function(d) {
				d.apa = "daftar-catering";
			}
		}
	});
	
	var tabelpelanggan = $("#tabel-pelanggan").DataTable({
		ordering: false,
		autoWidth: true,
		ajax:{
			url : "auxs/admin_aux.php",
			type : "POST",
			data : function(d) {
				d.apa = "daftar-pelanggan";
			}
		}
	});
	
	var dropzoneGedung = $("#dropzone-gedung").dropzone({ 
		url: "auxs/upload-gedung.php",
		maxFilesize: 1,
		acceptedFiles: "image/*",
		init: function () {
			this.on("sending", function(file, xhr, data) {
				data.append("id", $('#id-gedung').val());
			});
			this.on("success", function(file, response) {
				$(".btn-close-modal").click();
				tabelgedung.ajax.reload();
			});
		}
	});
	
	var dropzoneCatering = $("#dropzone-catering").dropzone({ 
		url: "auxs/upload-catering.php",
		maxFilesize: 1,
		acceptedFiles: "image/*",
		init: function () {
			this.on("sending", function(file, xhr, data) {
				data.append("id", $('#id-catering').val());
			});
			this.on("success", function(file, response) {
				$(".btn-close-modal").click();
				tabelcatering.ajax.reload();
			});
		}
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
	
	$("#menu-home").click(function(){
		tabelpesanan.ajax.reload();
	});
	
	$("#logout").click(function(){
		$.ajax({
			url: "auxs/admin_aux.php",
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
	
	$("#tabel-pesanan").on("click", ".btn-cek-confirm", function(){
		var id = $(this).data("id");
		
		$("#tgltransfer").val("");
		$("#banktransfer").val("");
		$("#atasnama").val("");
		$("#jmltransfer").val("");
		$("#keterangan").val("");
		
		$('#modal-show-confirm').modal('show');
		
		$.ajax({
			url: "auxs/admin_aux.php",
			method: "POST",
			cache: false,
			dataType: "JSON",
			data: {"apa" : "cek-confirm", "id" : id},
			success: function(eve) {
				if (eve.status) {
					$("#tgltransfer").val(eve.tgl);
					$("#banktransfer").val(eve.bank);
					$("#atasnama").val(eve.nama);
					$("#jmltransfer").val(eve.jml);
					$("#keterangan").val(eve.ket);
				}
			},
			error: function(err) {
				console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
				alert("Gagal terkoneksi dengan server..");
			}
		});
		
	});
	
	$("#tabel-pesanan").on("click", ".btn-cek-bukti", function(){
		var id = $(this).data("id");
		
		$.ajax({
			url: "auxs/admin_aux.php",
			method: "POST",
			cache: false,
			dataType: "JSON",
			data: {"apa" : "cek-bukti", "id" : id},
			success: function(eve) {
				if (eve.status) {
					if (eve.img != "-") {
						window.open("../assets/images/bukti-bayar/"+eve.img, "_blank");
					} else {
						alert("Belum ada bukti konfirmasi !");
					}
				}
			},
			error: function(err) {
				console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
				alert("Gagal terkoneksi dengan server..");
			}
		});
	});
	
	$("#tabel-pesanan").on("click", ".btn-acc", function(){
		var id = $(this).data("id");
		
		if (confirm('Setuju acc pesanan ini ?')) {
			$.ajax({
				url: "auxs/admin_aux.php",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"apa" : "acc-pesanan", "id" : id},
				success: function(eve) {
					if (eve.status) {
						
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
		}
	});
	
	$("#tabel-pesanan").on("click", ".btn-tolak", function(){
		var id = $(this).data("id");
		
		if (confirm('Setuju tolak pesanan ini ?')) {
			$.ajax({
				url: "auxs/admin_aux.php",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"apa" : "tolak-pesanan", "id" : id},
				success: function(eve) {
					if (eve.status) {
						
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
		}
	});
	
	$("#gedung").on("click", ".btn-show-gedung", function(){
		var mode = $(this).data("mode");
		
		if (mode == "tambah") {
			$('#modal-data-gedung').modal('show');
			$("#mode-gedung").val("simpan-gedung");
			$("#id-gedung").val("");
		} else if (mode == "ubah") {
			$('#modal-data-gedung').modal('show');
			$("#mode-gedung").val("ubah-gedung");
			$("#id-gedung").val($(this).data("id"));
		}
	});
	
	$("#btn-simpan-gedung").click(function(){
		var apa = $("#mode-gedung").val();
		var id = $("#id-gedung").val();
		var nama = $("#nama-gedung").val();
		var kapasitas = $("#kapasitas").val();
		var dp = $("#dp-gedung").val();
		
		$.ajax({
			url: "auxs/admin_aux.php",
			method: "POST",
			cache: false,
			dataType: "JSON",
			data: {"apa" : apa, "nama" : nama, "kapasitas" : kapasitas, "dp" : dp, "id" : id},
			success: function(eve) {
				if (eve.status) {
					$('#alert-success').text(eve.msg);
					if ( !$('#alert-success').is( '.in' ) ) {
						$('#alert-success').addClass('in');

						setTimeout(function() {
							$('#alert-success').removeClass('in');
						}, 1800);
					}
					$(".btn-close-modal").click();
					tabelgedung.ajax.reload();
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
	
	$("#tabel-gedung").on("click", ".btn-upload-gedung", function(){
		$('#modal-upload-gedung').modal('show');
		$("#id-gedung").val($(this).data("id"));
	});
	
	$("#catering").on("click", ".btn-show-catering", function(){
		var mode = $(this).data("mode");
		
		if (mode == "tambah") {
			$('#modal-data-catering').modal('show');
			$("#mode-catering").val("simpan-catering");
			$("#id-catering").val("");
		} else if (mode == "ubah") {
			$('#modal-data-catering').modal('show');
			$("#mode-catering").val("ubah-catering");
			$("#id-catering").val($(this).data("id"));
		}
	});
	
	$("#btn-simpan-catering").click(function(){
		var apa = $("#mode-catering").val();
		var id = $("#id-catering").val();
		var nama = $("#nama-catering").val();
		var alamat = $("#alamat-catering").val();
		var telp = $("#telp-catering").val();
		var link = $("#link-catering").val();
		var dp = $("#dp-catering").val();
		
		$.ajax({
			url: "auxs/admin_aux.php",
			method: "POST",
			cache: false,
			dataType: "JSON",
			data: {"apa" : apa, "nama" : nama, "alamat" : alamat, "telp" : telp, "link" : link, "dp" : dp, "id" : id},
			success: function(eve) {
				if (eve.status) {
					$('#alert-success').text(eve.msg);
					if ( !$('#alert-success').is( '.in' ) ) {
						$('#alert-success').addClass('in');

						setTimeout(function() {
							$('#alert-success').removeClass('in');
						}, 1800);
					}
					$(".btn-close-modal").click();
					tabelcatering.ajax.reload();
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
	
	$("#tabel-catering").on("click", ".btn-upload-catering", function(){
		$('#modal-upload-catering').modal('show');
		$("#id-catering").val($(this).data("id"));
	});
	
	$("#pelanggan").on("click", ".btn-show-pelanggan", function(){
		var mode = $(this).data("mode");
		
		if (mode == "tambah") {
			$('#modal-data-pelanggan').modal('show');
			$("#mode-pelanggan").val("simpan-pelanggan");
			$("#id-pelanggan").val("");
		} else if (mode == "ubah") {
			$('#modal-data-pelanggan').modal('show');
			$("#mode-pelanggan").val("ubah-pelanggan");
			$("#id-pelanggan").val($(this).data("id"));
		}
	});
	
	$("#btn-simpan-pelanggan").click(function(){
		var apa = $("#mode-pelanggan").val();
		var id = $("#id-pelanggan").val();
		var nama = $("#nama-pelanggan").val();
		var gender = $("#gender-pelanggan").val();
		var alamat = $("#alamat-pelanggan").val();
		var email = $("#email-pelanggan").val();
		var telp = $("#telp-pelanggan").val();
		var user = $("#user-pelanggan").val();
		var pass = $("#pass-pelanggan").val();
		
		$.ajax({
			url: "auxs/admin_aux.php",
			method: "POST",
			cache: false,
			dataType: "JSON",
			data: {"apa" : apa, "nama" : nama, "gender" : gender, "alamat" : alamat, "email" : email, "telp" : telp, "user" : user, "pass" : pass, "id" : id},
			success: function(eve) {
				if (eve.status) {
					$('#alert-success').text(eve.msg);
					if ( !$('#alert-success').is( '.in' ) ) {
						$('#alert-success').addClass('in');

						setTimeout(function() {
							$('#alert-success').removeClass('in');
						}, 1800);
					}
					$(".btn-close-modal").click();
					tabelpelanggan.ajax.reload();
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

