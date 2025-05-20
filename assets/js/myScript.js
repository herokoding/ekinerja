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

	$('#tblRole').DataTable({
		"processing": true,
		"responsive": true,
		"scrollx": true,

		"ajax": {
			"url": API_GET_ROLE,
			"type": 'GET',
			"dataSrc": 'data',
		},

		"columns": [
			{
				data: "role_id",
				orderable: false,
				searchable: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				data: 'role_name'
			},
			{
				data: null,
				orderable: false,
				searchable: false,
				render: function (row) {
					return `<button class="btn btn-sm btn-primary edit-btn" data-id="${row.role_id}">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn" data-id="${row.role_id}">
					Hapus</button>`;
				},
			}
		]
	});

	$('#tblDepart').DataTable({
		"processing": true,
		"responsive": true,

		"ajax": {
			"url": API_GET_DEPART,
			"type": 'GET',
			"dataSrc": 'data',
		},

		"columns": [
			{
				data: "depart_id",
				orderable: false,
				searchable: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				data: 'depart_name'
			},
			{
				data: null,
				orderable: false,
				searchable: false,
				render: function (row) {
					return `<button class="btn btn-sm btn-primary edit-btn" data-id="${row.depart_id}">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn" data-id="${row.depart_id}">
					Hapus</button>`;
				},
			}
		]
	});

	$('#tblUser').DataTable({
		"processing": true,
		"responsive": true,
		"scrollX": true,

		"ajax": {
			"url": API_GET_USER,
			"type": 'GET',
			"dataSrc": 'data',
		},

		"columns": [
			{
				data: "user_id",
				orderable: false,
				searchable: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				data: 'user_nik'
			},
			{
				data: 'user_fullname',
				width: 150
			},
			{
				data: 'user_email'
			},
			{
				data: 'username'
			},
			{
				data: 'role_name'
			},
			{
				data: 'depart_name'
			},
			{
				data: 'user_is_active',
				width: 100
			},
			{
				data: 'user_gender'
			},
			{
				data: null,
				orderable: false,
				searchable: false,
				width: 200,
				render: function (row) {
					return `<button class="btn btn-sm btn-primary edit-btn" data-id="${row.user_id}">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn" data-id="${row.user_id}">
					Hapus</button>`;
				},
			}
		]
	});
});