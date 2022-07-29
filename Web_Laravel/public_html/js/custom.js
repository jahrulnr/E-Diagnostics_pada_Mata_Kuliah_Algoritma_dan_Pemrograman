$(window).on("load", function(){
	$('#load_page').show();
});

$('#dark-mode').on('change', function(){
	if($(this).prop('checked'))
		Cookies.set('theme', 'on');
	else
		Cookies.set('theme', 'off');
	console.log(Cookies.get('theme'));

	theme();
});

$(document).ready(function(){
	theme();
	$('#load_page').fadeOut(2000);

	if(Cookies.get('theme') == 'dark')
		$('#dark-mode').prop('checked', true);

	var hash = window.location.hash;
	if(hash.search('&') > 0) hash = '#' + hash.split('&')[1];
	if(hash == '#berhasil_disimpan'){
		toastr.success('Data berhasil disimpan');
	}
	else if(hash == '#gagal_disimpan'){
		toastr.error('Data gagal disimpan');
	}
	else if(hash == '#berhasil_diubah'){
		toastr.success('Data berhasil diubah');
	}
	else if(hash == '#gagal_diubah'){
		toastr.error('Data gagal diubah');
	}
	else if(hash == '#berhasil_dihapus'){
		toastr.success('Data berhasil dihapus');
	}
	else if(hash == '#gagal_dihapus'){
		toastr.error('Data gagal dihapus');
	}
	else if(hash == '#password_kurang'){
		toastr.error('Password harus 5 karakter atau lebih');
	}
});

var changeTheme = "dark-bg";
function theme(){
	var mode = Cookies.get('theme');
	var waktu = new Date();

	if(!mode){
		Cookies.set('theme', 'default');
		$('#dark-mode').prop('checked', false);
	}

	waktu = waktu.toLocaleString('id-ID', { hour: 'numeric', hour12: false });
	if(((waktu < 7 || waktu > 17) || mode == 'on') && mode != 'off'){
		darkTime('on');
	}
	else {
		darkTime('off');
	}
}

function darkTime(set){
	if(set == 'on'){
		// $(".nav").addClass(changeTheme);
		$("#layoutSidenav_content").addClass(changeTheme);
		$(".modal-content").addClass(changeTheme);
		$('footer').addClass(changeTheme);
		$('.select2-container--open').addClass(changeTheme);
	}
	else {
		// $(".nav").removeClass(changeTheme);
		$("#layoutSidenav_content").removeClass(changeTheme);
		$(".modal-content").removeClass(changeTheme);
		$('footer').removeClass(changeTheme);
		$('.select2-container--open').removeClass(changeTheme);
	}
}

function getPing(){
	setInterval(function(){
		var time_stamp = new Date;
		$.ajax({ 
			type: "GET",
			url: "/ping",
			success: function(output){ 
				ping = new Date - time_stamp;
				console.log('-- Ping: ' + ping);
			}
		});
	}, 1000);
}
