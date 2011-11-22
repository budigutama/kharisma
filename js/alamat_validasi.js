$(document).ready(function(){
	$("#registrationform").validate({
		rules: {
			jeniskirim1 : "required"
		},
	
		messages: { 
				jeniskirim1: {
					required: '. Jenis Pengiriman harus diisi'
				}
		},
		 
		 success: function(label) {
			label.text('OK!').addClass('valid');
		}
	});
});

$(document).ready(function(){
	$("#alamatform").validate({
		rules: {
			nama2: "required",
			alamat2: "required",
			kodepos2: {
				required: true,
				number: true,
				minlength: 5,
				maxlength: 5
			},
			provinsi : "required",
			jeniskirim2 : "required",
			idkota2 : "required",
			telp2: {
				required: true,
				number: true,
				minlength: 7,
				maxlength: 15
			}
		},
	
		messages: { 
				nama2: {
					required: '. Nama harus diisi'
				},
				kodepos2: {
					required: '. Kodepos harus diisi',
					number  : '. Hanya boleh di isi Angka',
					minlength: '. Kodepos minimal 5 karakter',
					maxlength: '. Kodepos maksimal 5 karakter'
				},
				alamat2: {
					required: '. Alamat harus diisi'
				},
				provinsi: {
					required: '. Provinsi harus diisi'
				},
				jeniskirim2: {
					required: '. Jenis Pengiriman harus diisi'
				},
				idkota2: {
					required: '. Kota harus diisi'
				},
				telp2: {
					required: '. No Telepon harus di isi',
					number  : '. Hanya boleh di isi Angka',
					minlength: '. Telepon minimal 7 Angka',
					maxlength: '. Telepon maksimal 15 Angka'
				}
		},
		 
		 success: function(label) {
			label.text('OK!').addClass('valid');
		}
	});
});
