$(function () {
	const urlParams = new URLSearchParams(window.location.search);
	const selMonth = urlParams.get('month');
	const selYear  = urlParams.get('year');

	const $mn = $('#month');
	const $yr = $('#year');
	const now = new Date();

	for (let i = 0; i < 6; i++) {
		const d = new Date(now.getFullYear(), now.getMonth() - i, 1);
		const mVal = d.getMonth() + 1;
		const yVal = d.getFullYear();
		const mText = d
		.toLocaleString('id-ID', { month: 'short' })
		.toUpperCase();

		$('<option>')
		.val(mVal)
		.text(mText)
		.prop('selected', selMonth == mVal)
		.appendTo($mn);

		if ($yr.find(`option[value="${yVal}"]`).length === 0) {
			$('<option>')
			.val(yVal)
			.text(yVal)
			.prop('selected', selYear == yVal)
			.appendTo($yr);
		}
	}

	

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

	var tblKinerja = $('#tblKinerja').DataTable({
		"processing": true,
		"responsive": true,

		"ajax": {
			"url": API_GET_PERFORMANCE,
			"type": 'GET',
			dataSrc: function(json) {
				if (!json || !json.data) {
					console.error('Unexpected JSON structure:', json);
					return [];
				}
				return json.data;
			},
			error: function(xhr, status, error) {
				console.error('AJAX Error:', status, error);
				console.error('Response:', xhr.responseText);
			}
		},

		"columns": [
			{
				data: "record_id",
				orderable: false,
				searchable: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				data: "record_date",
				render: function (rawDate, type, row) {
					if (type !== 'display') {
						return rawDate;
					}
					return moment(rawDate).format('DD MMM YYYY');
				}
			},
			{
				data: "record_desc"
			},
			{
				data: 'document_path',    // gunakan 'document_path' untuk URL
				orderable: false,
				searchable: false,
				render: function(path, type, row, meta) {
					if (type !== 'display') {
						return path;
					}
					if (!path) {
						return '<span class="text-muted">–</span>';
					}

					const fileExt = path.split('.').pop().toLowerCase();
					const fileName = path.split('/').pop();

					let fileIcon, iconColor;
					switch(fileExt) {
					case 'pdf':
						fileIcon = 'fa-file-pdf';
						iconColor = 'text-danger';
						break;
					case 'doc':
					case 'docx':
						fileIcon = 'fa-file-word';
						iconColor = 'text-primary';
						break;
					case 'xls':
					case 'xlsx':
						fileIcon = 'fa-file-excel';
						iconColor = 'text-success';
						break;
					case 'jpg':
					case 'jpeg':
					case 'png':
					case 'gif':
						fileIcon = 'fa-file-image';
						iconColor = 'text-info';
						break;
					default:
						fileIcon = 'fa-file-alt';
						iconColor = 'text-secondary';
					}

					return `
            			<div class="file-preview">
            			    <div class="file-icon ${iconColor}">
            			        <i class="far ${fileIcon} fa-2x"></i>
            			        <small class="file-name d-block">${fileName}</small>
            			    </div>
            			    <div class="file-actions mt-2">
            			        <a href="${path}" target="_blank" class="btn btn-sm btn-outline-primary">
            			            <i class="fas fa-eye"></i> Lihat
            			        </a>
            			        <a href="${path}" download class="btn btn-sm btn-outline-secondary">
            			            <i class="fas fa-download"></i> Unduh
            			        </a>
            			    </div>
            			</div>
					`;
				}
			},
			{
				data: null,
				orderable: false,
				searchable: false,
				render: function (row) {
					return `<button class="btn btn-sm btn-primary edit-btn-kinerja" data-id="${row.record_id}" data-toggle="modal" data-target="#editModal">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn-kinerja" data-id="${row.record_id}">
					Hapus</button>`;
				},
			}
		],
	});

	tblKinerja.on('click', '.edit-btn-kinerja', function() {
		var id = $(this).data('id');
		console.log('Edit button clicked, ID:', id);

		$.ajax({
			url: API_EDIT_PERFORMANCE + id,
			type: 'GET',
			dataType: 'json',

			beforeSend: function() {
				console.log('Sending request to:', API_EDIT_PERFORMANCE + id);
			},

			success: function(response) {
				console.log('Full response:', response);

				if (response && response.success) {
					console.log('Response data:', response.data);
					console.log('Response document:', response.document);

					$('#editRecordId').val(response.data.record_id || '');
					$('#kinerjaDate input').val(response.data.record_date || '');
					$('#recordDesc').val(response.data.record_desc || '');

					if (response.document) {
						console.log('Document path:', response.document.document_path);
						var fileLink = `<a href="${response.document.document_path}" target="_blank">
                        <i class="far fa-file-alt"></i> ${response.document.document_name}
						</a>`;
						$('#currentFile').html('File saat ini: ' + fileLink);
					} else {
						console.log('No document found');
						$('#currentFile').html('Tidak ada file');
					}

					$('#kinerjaDate').datetimepicker('destroy');
					$('#kinerjaDate').datetimepicker({
						format: 'YYYY-MM-DD'
					});

					$('#editModal').modal('show');
				} else {
					console.error('Invalid response format:', response);
					alert('Gagal memuat data: ' + (response.message || 'Format response tidak valid'));
				}
			},

			error: function(xhr, status, error) {
				console.error('AJAX Error:', status, error);
				console.error('Response text:', xhr.responseText);
				alert('Terjadi kesalahan saat memuat data. Lihat console untuk detail.');
			}
		});
	});

	$('#kinerjaDate').datetimepicker({
		format: 'YYYY/MM/DD HH:mm:ss',
		useCurrent: false,
		icons: {
			time: 'fas fa-clock',
			date: 'fas fa-calendar-alt',
			up: 'fas fa-arrow-up',
			down: 'fas fa-arrow-down',
			previous: 'fas fa-chevron-left',
			next: 'fas fa-chevron-right',
			today: 'fas fa-calendar-check',
			clear: 'fas fa-trash',
			close: 'fas fa-times'
		}
	}).on('change.datetimepicker', function(e) {
		if (e.date) {
			$('input[name="record_date"]').val(e.date.format('YYYY-MM-DD HH:mm:ss'));
		}
	});
});