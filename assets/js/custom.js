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
