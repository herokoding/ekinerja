$(function () {
	$('#tblMenu').DataTable({
		"processing": true,
		"responsive": true,
		"ajax": {
			"url": API_GET_MENU,
			"type": 'GET',
			"dataSrc": 'data',
		},

		"columns": [
			{ 
				data: 'menu_id',
				orderable: false,
				searchable: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{ data: 'menu_name' },
			{
				data: null,
				orderable: false,
				searchable: false,
				render: function (row) {
					return `<button class="btn btn-sm btn-primary edit-btn" data-id="${row.menu_id}">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn" data-id="${row.menu_id}">
					Hapus</button>`;
				},
			}
		],
	});

	$('#tblMenu tbody').on('click', '.edit-btn', function() {
		const id = $(this).data('id');
    // misal: buka modal edit, lalu $.getJSON(...) dst.
	});

	$('#tblSubMenu').DataTable({
		"processing": true,
		"responsive": true,
		"scrollx": true,

		"ajax": {
			"url": API_GET_SUB_MENU,
			"type": 'GET',
			"dataSrc": 'data',
		},

		"columns": [
			{
				data: "id",
				orderable: false,
				searchable: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				data: 'sub_title'
			},
			{
				data: 'menu_name'
			},
			{
				data: 'sub_url'
			},
			{
				data: 'sub_icon'
			},
			{
				data: 'is_active',

			},
			{
				data: null,
				orderable: false,
				searchable: false,
				render: function (row) {
					return `<button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
					Hapus</button>`;
				},
			}
		]
	});
});