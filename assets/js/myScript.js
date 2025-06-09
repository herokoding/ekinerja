$(function () {
	const now = new Date();
	const currentMonth = now.getMonth() + 1;
	const currentYear = now.getFullYear();
	const urlParams = new URLSearchParams(window.location.search);
	const selMonth = urlParams.get('month') || currentMonth;
	const selYear = urlParams.get('year') || currentYear;
	const baseUrl = "<?= base_url() ?>";

	const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
		'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

		$('#month').empty().append('<option value="">Pilih Bulan</option>');
		monthNames.forEach((month, index) => {
			$('#month').append(new Option(month, index + 1, false, index + 1 == selMonth));
		});

		$('#year').empty().append('<option value="">Pilih Tahun</option>');
		for (let y = currentYear; y >= currentYear - 2; y--) {
			$('#year').append(new Option(y, y, false, y == selYear));
		};

  // Fade out alerts
		setTimeout(() => {
			$('.alert').fadeTo(500, 0).slideUp(500, function() { $(this).remove(); });
		}, 4000);

	// Initialize datetimepicker for Add form (wrapper id: addkinerjaDate)
		$('#addkinerjaDate').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss',
			useCurrent: false,
			allowInputToggle: true,
			widgetPositioning: {horizontal: 'auto', vertical: 'bottom'},
			icons: {
				time: 'fas fa-clock', date: 'fas fa-calendar', up: 'fas fa-arrow-up',
				down: 'fas fa-arrow-down', previous: 'fas fa-chevron-left', next: 'fas fa-chevron-right',
				today: 'fas fa-calendar-check', clear: 'fas fa-trash', close: 'fas fa-times'
			}
		});

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
						return `<a href="roleAccess/${row.role_id}" class="btn btn-sm btn-info role-btn-access">
						Access</a>
						<button class="btn btn-sm btn-primary edit-btn" data-id="${row.role_id}">
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
						return `<button class="btn btn-sm btn-primary edit-btn-user" data-id="${row.user_id}">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn-user" data-id="${row.user_id}">
						Hapus</button>`;
					},
				}
			]
		});

		$('#tblUser tbody').on('click', '.edit-btn-user', function() {
			const id = $(this).data('id');
			const $form = $('#editForm');
			$form[0].reset();

			$.getJSON(API_EDIT_USER + id)
			.done(res => {
				if (!res.success || !res.data) {
					return alert('Error: ' + (res.message || 'No data'));
				}
				const d = res.data;
				$form.find('#editRecordId').val(d.record_id);
				$form.find('#recordDesc').val(d.record_desc || '');
				if (res.document?.document_name) {
					$('#currentFile').html(
						`<a href="${res.document.document_path}" target="_blank">
              <i class="far fa-file-alt"></i> ${res.document.document_name}
					</a>`
					);
				}
				pendingDate = d.record_date ? moment(d.record_date) : null;
				$('#editModal').modal('show');
			})
			.fail(xhr => console.error('AJAX error:', xhr));
		})

	// --- Initialize Datatable ---
		const tblKinerja = $('#tblKinerja').DataTable({
			processing: true,
			responsive: true,
			ajax: {
				url: API_GET_PERFORMANCE,
				type: 'GET',
				data: function() {
					return {
						month: $('#month').val() || currentMonth,
						year: $('#year').val() || currentYear
					};
				},
				dataSrc: function(json) {
					return (json && json.data) ? json.data : [];
				},
				error: function(xhr, status, error) {
					console.error('AJAX Error:', status, error);

					$('#tblKinerja').DataTable().clear().draw();
					$('#tblKinerja tbody').html(
						'<tr><td colspan="5" class="text-center text-danger">'+
						'Gagal memuat data. Silakan coba lagi atau hubungi administrator.'+
						'</td></tr>'
						);
				},
			},
			columns: [
				{ data: 'record_id', orderable: false, searchable: false,
					render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
				},
				{ data: 'record_date', render: (raw, type) => type === 'display' ? moment(raw).format('DD MMM YYYY') : raw },
				{ data: 'record_desc' },
				{ data: 'document_path', orderable: false, searchable: false,
					render: (path, type) => {
						if (type !== 'display') return path;
						if (!path) return '<span class="text-muted">–</span>';
						const ext = path.split('.').pop().toLowerCase();
						const name = path.split('/').pop();
						let icon = 'fa-file-alt', color = 'text-secondary';
						if (ext === 'pdf') { icon = 'fa-file-pdf'; color = 'text-danger'; }
						if (['doc','docx'].includes(ext)) { icon = 'fa-file-word'; color = 'text-primary'; }
						if (['xls','xlsx'].includes(ext)) { icon = 'fa-file-excel'; color = 'text-success'; }
						if (['jpg','jpeg','png','gif'].includes(ext)) { icon = 'fa-file-image'; color = 'text-info'; }
						return `<div class="file-preview">
                    <div class="file-icon ${color}"><i class="far ${icon} fa-2x"></i>
                      <small class="file-name d-block">${name}</small>
                    </div>
                    <div class="file-actions mt-2">
                      <a href="${path}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> Lihat
                      </a>
                      <a href="${path}" download class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-download"></i> Unduh
                      </a>
                    </div>
					</div>`;
				}
			},
			{ data: null, orderable: false, searchable: false,
				render: row =>
				`<button class="btn btn-sm btn-primary edit-btn-kinerja" data-id="${row.record_id}" data-toggle="modal" data-target="#editModal">Edit</button>
				<button class="btn btn-sm btn-danger delete-btn-kinerja" data-id="${row.record_id}">Hapus</button>`
			}
		]
	});

		$('#filteredForm').on('submit', function(e) {
			e.preventDefault();
			const month = $('#month').val();
			const year = $('#year').val();

			tblKinerja.ajax.url(API_GET_PERFORMANCE + '?month=' + month + '&year=' + year).load();
		});

		let editPickerInitialized = false;
		let pendingDate = null;

		$('#tblKinerja tbody').on('click', '.edit-btn-kinerja', function() {
			const id = $(this).data('id');
			pendingDate = null;
			const $form = $('#editForm');
			$form[0].reset();
			$('#currentFile').empty();

			$.getJSON(API_EDIT_PERFORMANCE + id)
			.done(res => {
				if (!res.success || !res.data) {
					return alert('Error: ' + (res.message || 'No data'));
				}
				const d = res.data;
				$form.find('#editRecordId').val(d.record_id);
				$form.find('#recordDesc').val(d.record_desc || '');
				if (res.document?.document_name) {
					$('#currentFile').html(
						`<a href="${res.document.document_path}" target="_blank">
              <i class="far fa-file-alt"></i> ${res.document.document_name}
					</a>`
					);
				}
				pendingDate = d.record_date ? moment(d.record_date) : null;
				$('#editModal').modal('show');
			})
			.fail(xhr => console.error('AJAX error:', xhr));
		});

	 // --- On modal show: set date field ---
		$('#editModal').on('shown.bs.modal', function() {
			const $wrapper = $('#editkinerjaDate');
			if (!editPickerInitialized) {
      // Initialize datetimepicker now that element exists
				$wrapper.datetimepicker({
					format: 'YYYY-MM-DD HH:mm:ss',
					useCurrent: false,
					allowInputToggle: true,
					widgetPositioning: {horizontal: 'auto', vertical: 'bottom'},
					icons: {
						time: 'fas fa-clock', date: 'fas fa-calendar', up: 'fas fa-arrow-up',
						down: 'fas fa-arrow-down', previous: 'fas fa-chevron-left', next: 'fas fa-chevron-right',
						today: 'fas fa-calendar-check', clear: 'fas fa-trash', close: 'fas fa-times'
					}
				});
      // Sync picker changes to input
				$wrapper.on('change.datetimepicker', function(e) {
					if (e.date) {
						$('#editForm').find('input[name="record_date"]').val(e.date.format('YYYY-MM-DD HH:mm:ss'));
					}
				});
				editPickerInitialized = true;
			}

    // Set the pending date into picker and input
			if (pendingDate) {
				$wrapper.datetimepicker('date', pendingDate);
				$('#editForm').find('input[name="record_date"]').val(pendingDate.format('YYYY-MM-DD HH:mm:ss'));
			}
		});

		$('#editForm').on('submit', function(e) {
			e.preventDefault();
			const formEl = this;  

			const fd = new FormData(formEl);

			const recordId = fd.get('record_id');

			$.ajax({
				url: API_UPDATE_PERFORMANCE + recordId,
				type: 'POST',
				data: fd,
				processData: false,  
				contentType: false,  
				dataType: 'json'
			})
			.done(res => {
				if (res.success) {
					$('#editModal').modal('hide');
					$('#tblKinerja').DataTable().ajax.reload(null, false);
					alert('Kinerja updated successfully');
				} else {
					alert('Update failed: ' + (res.message || 'Unknown error'));
				}
			})
			.fail(xhr => {
				console.error('Update AJAX error:', xhr);
				alert('Error ' + xhr.status + ': ' + xhr.statusText);
			});
		});

		$('#tblCheckKinerja').DataTable({
			processing: true,
			responsive: true,
		});

		const tblApprove = $('#tblApprove').DataTable({
			processing: true,
			responsive: true,

			ajax: {
				url: API_APPROVAL,
				type: 'GET',
				data: function() {
					return {
						month: $('#month').val() || currentMonth,
						year: $('#year').val() || currentYear,
						user: $('#user').val(),
					};
				},
				dataSrc: function(json) {
					return (json && json.data) ? json.data : [];
				},
				error: function(xhr, status, error) {
					console.error('AJAX Error:', status, error);

					$('#tblApprove').DataTable().clear().draw();
					$('#tblApprove tbody').html(
						'<tr><td colspan="5" class="text-center text-danger">'+
						'Gagal memuat data. Silakan coba lagi atau hubungi administrator.'+
						'</td></tr>'
						);
				},
			},

			columns: [
				{ data: 'record_id', orderable: false, searchable: false,
					render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
				},
				{ data: 'record_date', render: (raw, type) => type === 'display' ? moment(raw).format('DD MMM YYYY') : raw },
				{ data: 'record_desc' },
				{ data: 'document_path', orderable: false, searchable: false,
					render: (path, type) => {
						if (type !== 'display') return path;
						if (!path) return '<span class="text-muted">–</span>';
						const ext = path.split('.').pop().toLowerCase();
						const name = path.split('/').pop();
						let icon = 'fa-file-alt', color = 'text-secondary';
						if (ext === 'pdf') { icon = 'fa-file-pdf'; color = 'text-danger'; }
						if (['doc','docx'].includes(ext)) { icon = 'fa-file-word'; color = 'text-primary'; }
						if (['xls','xlsx'].includes(ext)) { icon = 'fa-file-excel'; color = 'text-success'; }
						if (['jpg','jpeg','png','gif'].includes(ext)) { icon = 'fa-file-image'; color = 'text-info'; }
						return `<div class="file-preview">
                    <div class="file-icon ${color}"><i class="far ${icon} fa-2x"></i>
                      <small class="file-name d-block">${name}</small>
                    </div>
                    <div class="file-actions mt-2">
                      <a href="${path}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> Lihat
                      </a>
                      <a href="${path}" download class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-download"></i> Unduh
                      </a>
                    </div>
					</div>`;
				}
			},
			{ data: null, orderable: false, searchable: false,
				render: row =>
				`<a href="updateStatus/${row.record_id}/1" class="btn btn-sm btn-primary"
       		onclick="return confirm('Approve kinerja ini?')">
       		Approve
    		</a>
    		<a href="${baseUrl}approval/updateStatus/${row.record_id}/2" class="btn btn-sm btn-danger"
       		onclick="return confirm('Reject kinerja ini?')">
       		Reject
				</a>`
			}
		]
	});
	});