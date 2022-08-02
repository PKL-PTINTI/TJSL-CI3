/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$("#table-cicilan-1").dataTable({
	columnDefs: [{ sortable: false, targets: [2, 3] }],
});

$("#table-cicilan-2").dataTable({
	columnDefs: [{ sortable: false, targets: [2, 3] }],
});

$("#table-jurnal-bank").dataTable({
	columnDefs: [{ sortable: false, targets: [2, 3] }],
});

let table_perioda = $("#table-jurnal-perioda").dataTable({
	columns: [
		{ data: 'no' },
		{ data: 'id_opex' },
		{ data: 'id_akun' },
		{ data: 'tanggal' },
		{ data: 'pemasukan' },
		{ data: 'pengeluaran' },
		{ data: 'saldo' },
		{ data: 'deskripsi' },
		{ data: 'keterangan' },
		{ data: 'nobukti' },
		{ data: 'action' },
	],
});

$("#form-perioda").on("submit", function (e) {
	e.preventDefault();
	var form = $(this);
	var url = window.location.origin + "/admin/jurnal/perioda_data";
	var data = form.serialize();
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		dataType: "JSON",
		success: function (response) {
			table_perioda.fnClearTable();
			table_perioda.fnAddData(response.data);
		}
	});
});

$("#button_delete_perioda").on("click", function (e) {
	let url = this.dataset.url;
	$.ajax({
		type: "GET",
		url: url,
		success: function (response) {
			iziToast.success({title: 'Success',message: 'Data Jurnal Berhasil Dihapus',position: 'bottomRight'});
		}
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

let url_mitra = window.location.origin + "/admin/mitra/get_data_mitra";

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
				changeUrlMitra(
					window.location.origin + "/admin/mitra/get_data_mitra/koleksektor/" +
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
				changeUrlMitra(
					window.location.origin + "/admin/mitra/get_data_mitra/masalahsektor/" +
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
	ajax: {
		url: url_mitra,
		method: "POST",
	},
});

function changeUrlMitra(url, title) {
	table_mitra.ajax.url(url).load();
	$("#header").text(title);
	changeMenu(url);
}

// init datatable serverside
let url = window.location.origin + "/admin/jurnal/get_jurnal";

let table = $("#table-jurnal").DataTable({
	processing: true,
	serverSide: true,
	order: [],
	ajax: {
		url: url,
		method: "POST",
	},
});

function changeUrlJurnal(url, title) {
	table.ajax.url(url).load();
	$("#header").text(title);
}

$('.amount').priceFormat({
	prefix: "",
	centsLimit: 0,
	thousandsSeparator: ".",
});

