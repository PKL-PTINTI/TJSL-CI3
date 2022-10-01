/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

var cicilan = $("#table-cicilan-1").dataTable({
	columnDefs: [{ sortable: false, targets: [2, 3] }],
	scrollX: true,
});

$("#table-cicilan-2").dataTable({
	columnDefs: [{ sortable: false, targets: [2, 3] }],
	scrollX: true,
});

$("#table-cicilan-3").dataTable({
	columnDefs: [{ sortable: false, targets: [2, 3] }],
	scrollX: true,
});

$("#table-cicilan-4	").dataTable({
	columnDefs: [{ sortable: false, targets: [2, 3] }],
	scrollX: true,
});

$("#table-jurnal-bank").dataTable({
	columnDefs: [{ sortable: false, targets: [2, 3] }],
	scrollX: true,
});

$("#table-agingrate").dataTable({
	columnDefs: [{ sortable: false, targets: [2, 3] }],
	scrollX: true,
});

let table_perioda = $("#table-jurnal-perioda").dataTable({
	scrollX: true,
	columns: [
		{ data: "no" },
		{ data: "id_opex" },
		{ data: "id_akun" },
		{ data: "tanggal" },
		{ data: "pemasukan" },
		{ data: "pengeluaran" },
		{ data: "saldo" },
		{ data: "deskripsi" },
		{ data: "keterangan" },
		{ data: "nobukti" },
		{ data: "action" },
	],
});

$("#form-perioda").on("submit", function (e) {
	e.preventDefault();
	var form = $(this);
	var url = window.location.origin + '' + "/admin/jurnal/perioda_data";
	var data = form.serialize();
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		dataType: "JSON",
		success: function (response) {
			if(response.data){
				table_perioda.fnClearTable();
				table_perioda.fnAddData(response.data);
			} else {
				iziToast.success({
					title: "Heyyyy",
					message: "Datanya tidak ada lohhhh",
					position: "bottomRight",
				});
			}
		},
	});
});

$("#button_delete_perioda").on("click", function (e) {
	let url = this.dataset.url;
	$.ajax({
		type: "GET",
		url: url,
		success: function (response) {
			iziToast.success({
				title: "Success",
				message: "Data Jurnal Berhasil Dihapus",
				position: "bottomRight",
			});
		},
	});
});

// let table_kartu = $("#table-jurnal-kartu").dataTable({
// 	columns: [
// 		{ data: 'no' },
// 		{ data: 'id_akun' },
// 		{ data: 'korek' },
// 		{ data: 'deskripsi' },
// 		{ data: 'tanggal' },
// 		{ data: 'pemasukan' },
// 		{ data: 'pengeluaran' },
// 		{ data: 'saldo' },
// 		{ data: 'keterangan' },
// 		{ data: 'nobukti' },
// 		{ data: 'action' },
// 		{ data: 'tot_pemasukan' },
// 		{ data: 'tot_pengeluaran' },
// 		{ data: 'updated' },
// 		{ data: 'tglUpdate' },
// 	],
// });

// table-mitra

let url_mitra = window.location.origin + '' + "/admin/mitra/get_data_mitra";

function changeMenu(url) {
	let segment = url.substring(url.lastIndexOf("/") + 1);
	if (
		segment == "lancar" ||
		segment == "kuranglancar" ||
		segment == "diragukan" ||
		segment == "macet"
	) {
		$(".sektor-kolek").removeClass("d-none");
		$(".mitra").addClass("d-none");

		const listItems = document.querySelectorAll(".menu-kolek a");
		const listArray = [...listItems];

		listArray.forEach((item) => {
			item.onclick = function () {
				changeUrlMitraKoleksektor(
					window.location.origin + '' +
						"/admin/mitra/get_data_mitra/koleksektor/" +
						segment +
						"/" +
						item.dataset.sektor,
					segment.toUpperCase() + " " + item.innerText
				);
			};
		});
	}

	if (
		segment == "normal" ||
		segment == "masalah" ||
		segment == "khusus" ||
		segment == "wo"
	) {
		$(".sektor-masalah").removeClass("d-none");
		$(".sektor-kolek").addClass("d-none");

		const listItems = document.querySelectorAll(".menu-masalah a");
		const listArray = [...listItems];

		listArray.forEach((item) => {
			item.onclick = function () {
				changeUrlMitraMasalahSektor(
					window.location.origin + '' +
						"/admin/mitra/get_data_mitra/masalahsektor/" +
						segment +
						"/" +
						item.dataset.sektor,
					segment.toUpperCase() + " " + item.innerText
				);
			};
		});
	}
}

let table_mitra = $("#table-mitra").DataTable({
	processing: true,
	serverSide: true,
	order: [],
	scrollX: true,
	ajax: {
		url: url_mitra,
		method: "POST",
	},
});

function changeUrlMitraMasalah(url, title) {
	var url = window.location.origin + '/' + url;
	table_mitra.ajax.url(url).load();
	$("#header").text(title);
	changeMenu(url);
}

function changeUrlMitraMasalahSektor(url, title) {
	table_mitra.ajax.url(url).load();
	$("#header").text(title);
	changeMenu(url);
}

function changeUrlMitra(url, title) {
	url = window.location.origin + '' +  '/' + url;
	table_mitra.ajax.url(url).load();
	$("#header").text(title);
	changeMenu(url);
}

function changeUrlMitraKoleksektor(url, title) {
	table_mitra.ajax.url(url).load();
	$("#header").text(title);
	changeMenu(url);
}

// init datatable serverside
let url = window.location.origin + '' + "/admin/jurnal/get_jurnal";

let table_jurnal = $("#table-jurnal").DataTable({
	processing: true,
	serverSide: true,
	scrollX: true,
	order: [],
	ajax: {
		url: url,
		method: "POST",
	},
});

function changeUrlJurnal(url, title) {
	url = window.location.origin + '' +  '/' + url;
	if(window.location.pathname == "/admin/jurnal"){
		table_jurnal.ajax.url(url).load();
		$("#header").text(title);
	} else {
		window.location.href = window.location.origin + '' + "/admin/jurnal";
		document.on('ready', function () {
			table_jurnal.ajax.url(url).load();
			$("#header").text(title);
		});
	}
}

$(".amount").priceFormat({
	prefix: "",
	centsLimit: 0,
	thousandsSeparator: ".",
});

// $("#add_more").click(function(){
// 	var html = $(".elementpasangan").html();
// 	$(".elementpasangan").after(html);
// });


$(".repeater, .repeater-default").repeater({
	show: function () {
		$(this).slideDown();
		$('.select2-container').remove();
		$('.select2').select2({
			placeholder: "Pilih Kode Rekening",
			allowClear: true
		});
		$('.select2-container').css('width','100%');
		$(".amount").priceFormat({
			prefix: "",
			centsLimit: 0,
			thousandsSeparator: ".",
		});
	},
	hide: function (e) {
		confirm("Are you sure you want to delete this element?") &&
			$(this).slideUp(e);
	},
});


// var statistics_chart = document.getElementById("myChart2").getContext('2d');

// var myChart = new Chart(statistics_chart, {
// 	type: 'line',
// 	data: {
// 		labels: ["1","2","3","4","5","6","7","8"],
// 		datasets: [{
// 		label: 'Statistics',
// 		data: [268047679,410375127,681945896,216738467,229448758,653627299,409544552,16717281],
// 		borderWidth: 5,
// 		borderColor: '#6777ef',
// 		backgroundColor: 'transparent',
// 		pointBackgroundColor: '#fff',
// 		pointBorderColor: '#6777ef',
// 		pointRadius: 4
// 		}]
// 	},
// 	options: {
// 		legend: {
// 		display: false
// 		},
// 		scales: {
// 		yAxes: [{
// 			gridLines: {
// 			display: false,
// 			drawBorder: false,
// 			},
// 			ticks: {
// 			stepSize: 150
// 			}
// 		}],
// 		xAxes: [{
// 			gridLines: {
// 			color: '#fbfbfb',
// 			lineWidth: 2
// 			}
// 		}]
// 		},
// 	}
// });

let table_perkiraans = $("#table-jurnal-perkiraan").dataTable({
	scrollX: true,
	columns: [
		{ data: "no" },
		{ data: "id_opex" },
		{ data: "tanggal" },
		{ data: "pemasukan" },
		{ data: "pengeluaran" },
		{ data: "saldo" },
		{ data: "keterangan" },
	],
});

$("#form-perkiraan").on("submit", function (e) {
	e.preventDefault();
	var form = $(this);
	var url = window.location.origin + '' + "/admin/saldo/kartu_perkiraan_data";
	var data = form.serialize();
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		dataType: "JSON",
		success: function (response) {
			if(response.data){
				table_perkiraans.fnClearTable();
				table_perkiraans.fnAddData(response.data);
			} else {
				iziToast.success({
					title: "Heyyyy",
					message: "Datanya tidak ada lohhhh",
					position: "bottomRight",
				});
			}
		},
	});
});

function delete_jurnal(element){
	var url = window.location.origin + '' + "/admin/jurnal/destroy";

	var opex = element.dataset.opex;

	// $("#swal-6").click(function() {
		swal({
			title: 'Kamu Serius?',
			text: 'Saolnya data ini bakal dihapus lhooo..',
			icon: 'warning',
			buttons: true,
			dangerMode: true,
		  })
		  .then((willDelete) => {
			if (willDelete) {
				$.ajax({
					type: "POST",
					url: url,
					data: {opex: opex},
					dataType: "JSON",
				});
				swal('Berhasil', 'Yeayy! Datanya sudah berhasil dihapus.', 	{
				icon: 'success',
				});
				table_jurnal.ajax.reload(null, false);
			} else {
				swal('Gak Jadi Di H	apus', 'Datanya aman kok!', 'info');
			}
		  });
	//   });
}

$('.duallistbox').bootstrapDualListbox();

$('#bootstrap-duallistbox-nonselected-list_permission_id').css({
	'display': 'inline-block',
	'background-color': '#fff',
	'position': 'relative'
});