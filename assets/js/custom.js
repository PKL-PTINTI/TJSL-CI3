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

// table-mitra

let url_mitra = "http://localhost:3000/admin/mitra/get_data_mitra";

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
	}

	if (
		segment == "normal" ||
		segment == "masalah" ||
		segment == "khusus" ||
		segment == "wo"
	) {
		$(".sektor-masalah").removeClass("d-none");
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
let url = "http://localhost:3000/admin/jurnal/get_jurnal";

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
