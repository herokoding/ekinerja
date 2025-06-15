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

		function loadRoles() {
			return $.getJSON(API_GET_ROLE).then(res => {
				if (res.data) {
					return res.data;
				}

				return [];
			})
		}

		function loadDepart() {
			return $.getJSON(API_GET_DEPART).then(res => {
				if (res.data) {
					return res.data;
				}

				return [];
			})
		}

		function loadMenus() {
			return $.getJSON(API_GET_MENU).then(res => {
				if (res.data) {
					return res.data;
				}

				return [];
			})
		}

  // Fade out alerts
		window.setTimeout(function() {
			$('.alert')
        .fadeTo(500, 0)        // over 0.5 s fade to opacity 0
        .slideUp(500, function() {
          $(this).remove();    // then remove from the DOM
        });
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
						return `<button class="btn btn-sm btn-primary edit-btn-menu" data-id="${row.menu_id}" data-toggle="modal" data-target="#editMenu">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn-menu" data-id="${row.menu_id}" data-toggle="modal" data-target="#deleteMenu">
						Hapus</button>`;
					},
				}
			],
		});

		$('#tblMenu tbody').on('click', '.edit-btn-menu', function() {
			const id     = $(this).data('id');
			const $modal = $('#editMenu');
			const $body  = $modal.find('.modal-body');
			const $form  = $('#editMenuForm');

			console.log('Tombol edit diklik, ID =', id);

			$form[0].reset();
			$body.addClass('loading');
			$modal.modal('show');

			$.getJSON(API_EDIT_MENU + id)
			.done(function(res) {
				console.log('Response API:', res);
				if (res.success && res.data) {
					$form.find('#menuId').val   (res.data.menu_id);
					$form.find('#menuName').val (res.data.menu_name);
				} else {
					$body.html(
						'<div class="alert alert-warning text-center m-0 p-3">' +
						'Gagal memuat data: ' + res.message +
						'</div>'
						);
				}
			})
			.fail(function(jqXHR, textStatus, err) {
				console.error('AJAX error:', textStatus, err);
				$body.html(
					'<div class="alert alert-danger text-center m-0 p-3">' +
					'Terjadi kesalahan saat memuat data (' + textStatus + ')' +
					'</div>'
					);
			})
			.always(function() {
				$body.removeClass('loading');
			});
		});

		$('#editMenuForm').on('submit', function(e) {
			e.preventDefault();

			const $form = $(this);
			const id     = $form.find('#menuId').val();
			const name   = $form.find('#menuName').val().trim();
			const $modal = $('#editMenu');
			const $body  = $modal.find('.modal-body');

			if (!name) {
				$form.find('#menuName').addClass('is-invalid')
				.next('.invalid-feedback').remove();
				$form.find('#menuName').after('<div class="invalid-feedback">Nama menu tidak boleh kosong</div>');
				return;
			}

			const $btn = $form.find('button[type="submit"]')
			.prop('disabled', true).text('Menyimpan...');

			$.ajax({
        url: API_UPDATE_MENU + id,
        method: 'POST',
        dataType: 'json',
        data: { menu_name: name },
      })
			.done(function(res) {
				if (res.success) {
					$modal.modal('hide');
					$('#tblMenu').DataTable().ajax.reload(null, false);
				} else {
					$body.prepend(
						`<div class="alert alert-warning text-center m-0 p-3">
                    Gagal update: ${res.message}
					</div>`
					);
				}
			})
			.fail(function(jqXHR, textStatus) {
				$body.prepend(
					`<div class="alert alert-danger text-center m-0 p-3">
                Terjadi kesalahan (${textStatus})
				</div>`
				);
			})
			.always(function() {
				$btn.prop('disabled', false).text('Update');
			});
		});

		$('#tblMenu tbody').on('click', '.delete-btn-menu', function() {
			const menuId = $(this).data('id');
			const menuName = $(this).closest('tr').find('td:eq(1)').text();

			$('#deleteConfirmModal').modal('show');

			$('#deleteConfirmModal .user-name').text(menuName);

			$('#confirmDeleteBtn').off('click').on('click', function() {
				deleteMenu(menuId);
			});
		})

		function deleteMenu(menuId) {
			$.ajax({
				url: `${API_DELETE_MENU}/${menuId}`,
				type: 'DELETE',
				dataType: 'json',
				beforeSend: function() {
					$('#confirmDeleteBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');
				},
				success: function(response) {
					if (response.success) {
						alert('User berhasil dihapus');
						$('#tblMenu').DataTable().ajax.reload();
					} else {
						alert('Error: ' + (response.message || 'Gagal menghapus user'));
					}
					$('#deleteConfirmModal').modal('hide');
				},
				error: function(xhr) {
					console.error('Error:', xhr);
					let errorMsg = 'Terjadi kesalahan saat menghapus data';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMsg = xhr.responseJSON.message;
					}
					alert(errorMsg);
					$('#deleteConfirmModal').modal('hide');
				},
				complete: function() {
					$('#confirmDeleteBtn').prop('disabled', false).html('Ya, Hapus');
				}
			});
		}

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
						return `<button class="btn btn-sm btn-primary edit-btn-submenu" data-id="${row.id}" data-toggle="modal" data-target="#editSubMenu">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn-submenu" data-id="${row.id}" data-toggle="modal" data-target="#deleteConfirmModal">
						Hapus</button>`;
					},
				}
			]
		});

		$('#tblSubMenu tbody').on('click', '.edit-btn-submenu', function() {
			const id = $(this).data('id');
			const $form = $('#formEditSubMenu');
			$form[0].reset();

			Promise.all([
				$.getJSON(API_EDIT_SUBMENU + id),
				loadMenus(),
			])
			.then(function(results) {
				const [submenuResponse, menus] = results;

				if (!submenuResponse.success || !submenuResponse.data) {
					throw new Error(submenuResponse.message || 'No submenu data');
				}

				const submenuData = submenuResponse.data;

				$form.find('#submenuId').val(submenuData.id);
				$form.find('#subTitle').val(submenuData.sub_title);
				$form.find('#subUrl').val(submenuData.sub_url);
				$form.find('#subIcon').val(submenuData.sub_icon);

				if (submenuData.is_active) {
					$form.find('#is_active').prop('checked', !!submenuResponse.data.is_active);
				}

				const $menuSelect = $form.find('#menuId');
				$menuSelect.empty().append('<option value="">-- Pilih Menu --</option>');

				menus.forEach(function(menu) {
					$menuSelect.append(
						$('<option>', {
							value: menu.menu_id,
							text: menu.menu_name
						})
						);
				});

				if (submenuData.menu_id) {
					$menuSelect.val(submenuData.menu_id);
				}

				$('#editSubMenu').modal('show');
			})
			.catch(function(error) {
				console.error('Error:', error);
				alert('Gagal memuat data: ' + error.message);
			})
			.finally(function() {
				$('#editSubMenu').find('.modal-body').removeClass('loading');
			});
		});

		$('#formEditSubMenu').on('submit', function(e) {
			e.preventDefault();
			const $form    = $(this);
			const id       = $form.find('#submenuId').val();
			const menuId   = $form.find('#menuId').val();
			const subTitle = $form.find('#subTitle').val().trim();
			const subUrl   = $form.find('#subUrl').val().trim();
			const subIcon  = $form.find('#subIcon').val().trim();
			const active   = $form.find('#is_active').prop('checked') ? 1 : 0;
			const $modal   = $('#editSubMenu');
			const $body    = $modal.find('.modal-body');

			if (!subTitle) {
				$form.find('#subTitle')
				.addClass('is-invalid')
				.next('.invalid-feedback').remove();
				$form.find('#subTitle')
				.after('<div class="invalid-feedback">Nama submenu tidak boleh kosong</div>');
				return;
			}

			const $btn = $form.find('button[type="submit"]')
			.prop('disabled', true)
			.text('Menyimpan...');

			$.ajax({
				url:    API_UPDATE_SUBMENU + id,
				method: 'POST',
				dataType: 'json',
				data: {
					menu_id:   menuId,
					sub_title: subTitle,
					sub_url:   subUrl,
					sub_icon:  subIcon,
					is_active: active
				}
			})
			.done(function(res) {
				if (res.success) {
					$modal.modal('hide');
					$('#tblSubMenu').DataTable().ajax.reload(null, false);
				} else {
					$body.prepend(`
        <div class="alert alert-warning text-center m-0 p-3">
          Gagal update: ${res.message}
					</div>`);
				}
			})
			.fail(function(jqXHR, textStatus) {
				$body.prepend(`
      <div class="alert alert-danger text-center m-0 p-3">
        Terjadi kesalahan (${textStatus})
				</div>`);
			})
			.always(function() {
				$btn.prop('disabled', false).text('Update');
			});
		});

		$('#tblSubMenu tbody').on('click', '.delete-btn-submenu', function() {
			const id = $(this).data('id');
			const subMenuName = $(this).closest('tr').find('td:eq(1)').text();

			$('#deleteConfirmModal').modal('show');

			$('#deleteConfirmModal .user-name').text(subMenuName);

			$('#confirmDeleteBtn').off('click').on('click', function() {
				deleteSubMenu(id);
			});
		});

		function deleteSubMenu(id) {
			$.ajax({
				url: `${API_DELETE_SUBMENU}/${id}`,
				type: 'DELETE',
				dataType: 'json',
				beforeSend: function() {
					$('#confirmDeleteBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');
				},
				success: function(response) {
					if (response.success) {
						alert('User berhasil dihapus');
						$('#tblSubMenu').DataTable().ajax.reload();
					} else {
						alert('Error: ' + (response.message || 'Gagal menghapus submenu'));
					}
					$('#deleteConfirmModal').modal('hide');
				},
				error: function(xhr) {
					console.error('Error:', xhr);
					let errorMsg = 'Terjadi kesalahan saat menghapus data';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMsg = xhr.responseJSON.message;
					}
					alert(errorMsg);
					$('#deleteConfirmModal').modal('hide');
				},
				complete: function() {
					$('#confirmDeleteBtn').prop('disabled', false).html('Ya, Hapus');
				}
			});
		}

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
						<button class="btn btn-sm btn-primary edit-btn-role" data-id="${row.role_id}" data-toggle="modal" data-target="#editRole">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn-role" data-id="${row.role_id}" data-toggle="modal" data-target="#deleteConfirmModal">
						Hapus</button>`;
					},
				}
			]
		});

		$('#tblRole tbody').on('click', '.edit-btn-role', function() {
			const id = $(this).data('id');
			const $modal = $('#editRole');
			const $body = $modal.find('.modal-body');
			const $form = $('#formEditRole');

			$form[0].reset();
			$body.addClass('loading');
			$modal.modal('show');

			$.getJSON(API_EDIT_ROLE + id)
				.done(function(res) {
					if (res.success && res.data) {
						$form.find('#roleId').val(res.data.role_id);
						$form.find('#roleName').val(res.data.role_name);
					} else {
						$body.html(
						'<div class="alert alert-warning text-center m-0 p-3">' +
						'Gagal memuat data: ' + res.message +
						'</div>'
						);
					}
				})
				.fail(function(jqXHR, textStatus, err) {
					$body.html(
						'<div class="alert alert-danger text-center m-0 p-3">' +
						'Terjadi kesalahan saat memuat data (' + textStatus + ')' +
						'</div>'
						);
				})
				.always(function() {
					$body.removeClass('loading');
				});
		});

		$('#formEditRole').on('submit', function(e) {
			e.preventDefault();

			const $form = $(this);
			const id = $form.find('#roleId').val();
			const role = $form.find('#roleName').val().trim();
			const $modal = $('#editRole');
			const $body = $modal.find('.modal-body')

			if (!role) {
				$form.find('#roleName').addClass('is-invalid')
				.next('.invalid-feedback').remove();
				$form.find('#roleName').after('<div class="invalid-feedback">Nama role tidak boleh kosong</div>');
				return;
			}

			const $btn = $form.find('button[type="submit"]')
			.prop('disabled', true).text('Menyimpan...');

			$.ajax({
				url: API_UPDATE_ROLE + id,
				method: 'POST',
				dataType: 'json',
				data: { role_name: role },
			})
			.done(function(res) {
				if (res.success) {
					$modal.modal('hide');
					$('#tblRole').DataTable().ajax.reload(null, false);
				} else {
					$body.prepend(
						`<div class="alert alert-warning text-center m-0 p-3">
                    Gagal update: ${res.message}
					</div>`
					);
				}
			})
			.fail(function(jqXHR, textStatus) {
				$body.prepend(
					`<div class="alert alert-danger text-center m-0 p-3">
                Terjadi kesalahan (${textStatus})
				</div>`
				);
			})
			.always(function() {
				$btn.prop('disabled', false).text('Update');
			});
		});

		$('#tblRole tbody').on('click', '.delete-btn-role', function() {
			const roleId = $(this).data('id');
			const roleName = $(this).closest('tr').find('td:eq(1)').text();

			$('#deleteConfirmModal').modal('show');

			$('#deleteConfirmModal .user-name').text(roleName);

			$('#confirmDeleteBtn').off('click').on('click', function() {
				deleteRole(roleId);
			});
		});

		function deleteRole(roleId) {
			$.ajax({
				url: `${API_DELETE_ROLE}/${roleId}`,
				type: 'DELETE',
				dataType: 'json',
				beforeSend: function() {
					$('#confirmDeleteBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');
				},
				success: function(response) {
					if (response.success) {
						alert('User berhasil dihapus');
						$('#tblRole').DataTable().ajax.reload();
					} else {
						alert('Error: ' + (response.message || 'Gagal menghapus user'));
					}
					$('#deleteConfirmModal').modal('hide');
				},
				error: function(xhr) {
					console.error('Error:', xhr);
					let errorMsg = 'Terjadi kesalahan saat menghapus data';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMsg = xhr.responseJSON.message;
					}
					alert(errorMsg);
					$('#deleteConfirmModal').modal('hide');
				},
				complete: function() {
					$('#confirmDeleteBtn').prop('disabled', false).html('Ya, Hapus');
				}
			});
		}

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
						return `<button class="btn btn-sm btn-primary edit-btn-depart" data-id="${row.depart_id}" data-toggle="modal" data-target="#editDepart">
						Edit</button>
            		<button class="btn btn-sm btn-danger delete-btn-depart" data-id="${row.depart_id}" data-toggle="modal" data-target="#deleteConfirmModal">
						Hapus</button>`;
					},
				}
			]
		});

		$('#tblDepart tbody').on('click', '.edit-btn-depart', function() {
			const id = $(this).data('id');
			const $modal = $('#editDepart');
			const $body = $modal.find('.modal-body');
			const $form = $('#formEditDepart');

			$form[0].reset();
			$body.addClass('loading');
			$modal.modal('show');

			$.getJSON(API_EDIT_DEPART + id)
			.done(function(res) {
				if (res.success && res.data) {
					$form.find('#departId').val(res.data.depart_id);
					$form.find('#departName').val(res.data.depart_name);
				} else {
					$body.html(
						'<div class="alert alert-warning text-center m-0 p-3">' +
						'Gagal memuat data: ' + res.message +
						'</div>'
						);
				}
			})
			.fail(function(jqXHR, textStatus, err) {
				$body.html(
					'<div class="alert alert-danger text-center m-0 p-3">' +
					'Terjadi kesalahan saat memuat data (' + textStatus + ')' +
					'</div>'
					);
			})
			.always(function() {
				$body.removeClass('loading');
			});
		});

		$('#formEditDepart').on('submit', function(e) {
			e.preventDefault();

			const $form = $(this);
			const id = $form.find('#departId').val();
			const departs = $form.find('#departName').val().trim();
			const $modal = $('#editDepart');
			const $body = $modal.find('.modal-body')

			if (!departs) {
				$form.find('#departName').addClass('is-invalid')
				.next('.invalid-feedback').remove();
				$form.find('#departName').after('<div class="invalid-feedback">Nama Bagian tidak boleh kosong</div>');
				return;
			}

			const $btn = $form.find('button[type="submit"]')
			.prop('disabled', true).text('Menyimpan...');

			$.ajax({
				url: API_UPDATE_DEPART + id,
				method: 'POST',
				dataType: 'json',
				data: { depart_name: departs },
			})
			.done(function(res) {
				if (res.success) {
					$modal.modal('hide');
					$('#tblDepart').DataTable().ajax.reload(null, false);
				} else {
					$body.prepend(
						`<div class="alert alert-warning text-center m-0 p-3">
                    Gagal update: ${res.message}
					</div>`
					);
				}
			})
			.fail(function(jqXHR, textStatus) {
				$body.prepend(
					`<div class="alert alert-danger text-center m-0 p-3">
                Terjadi kesalahan (${textStatus})
				</div>`
				);
			})
			.always(function() {
				$btn.prop('disabled', false).text('Update');
			});
		});

		$('#tblDepart tbody').on('click', '.delete-btn-depart', function() {
			const departId = $(this).data('id');
			const departName = $(this).closest('tr').find('td:eq(1)').text();

			$('#deleteConfirmModal').modal('show');

			$('#deleteConfirmModal .user-name').text(departName);

			$('#confirmDeleteBtn').off('click').on('click', function() {
				deleteDepart(departId);
			});
		});

		function deleteDepart(departId) {
			$.ajax({
				url: `${API_DELETE_DEPART}/${departId}`,
				type: 'DELETE',
				dataType: 'json',
				beforeSend: function() {
					$('#confirmDeleteBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');
				},
				success: function(response) {
					if (response.success) {
						alert('User berhasil dihapus');
						$('#tblDepart').DataTable().ajax.reload();
					} else {
						alert('Error: ' + (response.message || 'Gagal menghapus user'));
					}
					$('#deleteConfirmModal').modal('hide');
				},
				error: function(xhr) {
					console.error('Error:', xhr);
					let errorMsg = 'Terjadi kesalahan saat menghapus data';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMsg = xhr.responseJSON.message;
					}
					alert(errorMsg);
					$('#deleteConfirmModal').modal('hide');
				},
				complete: function() {
					$('#confirmDeleteBtn').prop('disabled', false).html('Ya, Hapus');
				}
			});
		};

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
					data: 'pw_text'
				},
				{
					data: 'role_name'
				},
				{
					data: 'depart_name'
				},
				{
					data: 'user_is_active',
					width: 100,
					render: function (data, type, row) {
						return data == 1 ? 'Active' : 'Nonactive';
					}
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
						return `<button class="btn btn-sm btn-primary edit-btn-user" data-id="${row.user_id}" data-toggle="modal" data-target="#editUser">
						Edit</button>
            			<button class="btn btn-sm btn-danger delete-btn-user" data-id="${row.user_id}" data-toggle="modal" data-target="#deleteConfirmModal">
						Hapus</button>`;
					},
				}
			]
		});

		$('#tblUser tbody').on('click', '.edit-btn-user', function() {
			const id = $(this).data('id');
			const $form = $('#editUserForm');
			$form[0].reset();

			Promise.all([
				$.getJSON(API_EDIT_USER + id),
				loadRoles(),
				loadDepart()
			])
			.then(function(results) {
				const [userResponse, roles, departs] = results;

				if (!userResponse.success || !userResponse.data) {
					throw new Error(userResponse.message || 'No user data');
				}

				const userData = userResponse.data;

				$form.find('#userId').val(userData.user_id);
				$form.find('#userNik').val(userData.user_nik);
				$form.find('#fullName').val(userData.user_fullname);
				$form.find('#userEmail').val(userData.user_email);
				$form.find('#userName').val(userData.username);

				if (userData.user_gender) {
					$form.find(`input[name="user_gender"][value="${userData.user_gender}"]`).prop('checked', true);
				}

				const $roleSelect = $form.find('#roleId');
				$roleSelect.empty().append('<option value="">-- Pilih Role --</option>');

				roles.forEach(function(role) {
					$roleSelect.append(
						$('<option>', {
							value: role.role_id,
							text: role.role_name
						})
						);
				});

				if (userData.role_id) {
					$roleSelect.val(userData.role_id);
				}

				const $departSelect = $form.find('#departId');
				$departSelect.empty().append('<option value="">-- Pilih Divisi --</option>');

				departs.forEach(function(depart) {
					$departSelect.append(
						$('<option>', {
							value: depart.depart_id,
							text: depart.depart_name
						})
					);
				});

				if (userData.department_id) {
					$departSelect.val(userData.department_id);
				}

				$('#editUser').modal('show');
			})
			.catch(function(error) {
				console.error('Error:', error);
				alert('Gagal memuat data: ' + error.message);
			})
			.finally(function() {
				$('#editUser').find('.modal-body').removeClass('loading');
			});
		});

		$('#editUserForm').on('change', 'input[name="change_password"]', function() {
			const showPasswordFields = $(this).val() === '1';
			$('#passwordFields').toggle(showPasswordFields);

			$('#pw1, #pw2').prop('disabled', !showPasswordFields);

			if (!showPasswordFields) {
				$('#pw1, #pw2').val('');
			}
		});

		$('#editUserForm').on('submit', function(e) {
			e.preventDefault();
			const $form = $(this);
			const $submitBtn = $form.find('button[type="submit"]');
			const userId = $('#userId').val(); 

			const changePassword = $form.find('input[name="change_password"]:checked').val() === '1';
			if (changePassword) {
				const pw1 = $('#pw1').val();
				const pw2 = $('#pw2').val();

				if (pw1 !== pw2) {
					alert('Password dan konfirmasi password tidak sama!');
					return false;
				}

				if (pw1.length < 6) {
					alert('Password minimal 6 karakter!');
					return false;
				}
			}

			const formData = new FormData($form[0]);
			const data = {
				user_id: userId 
			};

			formData.forEach((value, key) => {
				if (!changePassword && (key === 'password' || key === 'password_confirmation')) {
					return;
				}
				data[key] = value;
			});

			data.change_password = changePassword;

			if (!userId) {
				alert('User ID tidak ditemukan!');
				return;
			}

			$submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

			$.ajax({
				url: `${API_UPDATE_USER}/${userId}`, 
				type: 'POST',
				data: JSON.stringify(data), 
				contentType: 'application/json',
				dataType: 'json',
				success: function(response) {
					if (response && response.success) {
						alert('Data berhasil diperbarui');
						$('#editUser').modal('hide');
						$('#tblUser').DataTable().ajax.reload();
					} else {
						const msg = response ? response.message : 'Respon tidak valid dari server';
						alert('Error: ' + msg);
					}
				},
				error: function(xhr) {
					console.error('Error:', xhr);
					let errorMsg = 'Terjadi kesalahan saat mengupdate data';

					if (xhr.responseJSON) {
						errorMsg = xhr.responseJSON.message || 
						(xhr.responseJSON.error ? xhr.responseJSON.error : errorMsg);
					} else if (xhr.responseText) {
						try {
							const resp = JSON.parse(xhr.responseText);
							errorMsg = resp.message || errorMsg;
						} catch (e) {
							errorMsg = xhr.responseText;
						}
					}

					alert(errorMsg);
				},
				complete: function() {
					$submitBtn.prop('disabled', false).html('Simpan Perubahan');
				}
			});
		});

		$('#tblUser tbody').on('click', '.delete-btn-user', function() {
			const userId = $(this).data('id');
			const userName = $(this).closest('tr').find('td:eq(2)').text(); 

			$('#deleteConfirmModal').modal('show');

			$('#deleteConfirmModal .user-name').text(userName);

			$('#confirmDeleteBtn').off('click').on('click', function() {
				deleteUser(userId);
			});
		});

		function deleteUser(userId) {
			$.ajax({
				url: `${API_DELETE_USER}/${userId}`,
				type: 'DELETE',
				dataType: 'json',
				beforeSend: function() {
					$('#confirmDeleteBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');
				},
				success: function(response) {
					if (response.success) {
						alert('User berhasil dihapus');
						$('#tblUser').DataTable().ajax.reload();
					} else {
						alert('Error: ' + (response.message || 'Gagal menghapus user'));
					}
					$('#deleteConfirmModal').modal('hide');
				},
				error: function(xhr) {
					console.error('Error:', xhr);
					let errorMsg = 'Terjadi kesalahan saat menghapus data';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMsg = xhr.responseJSON.message;
					}
					alert(errorMsg);
					$('#deleteConfirmModal').modal('hide');
				},
				complete: function() {
					$('#confirmDeleteBtn').prop('disabled', false).html('Ya, Hapus');
				}
			});
		}

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
				<button class="btn btn-sm btn-danger delete-btn-kinerja" data-id="${row.record_id}" data-toggle="modal" data-target="#deleteConfirmModal">Hapus</button>`
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

		$('#tblKinerja tbody').on('click', '.delete-btn-kinerja', function() {
			const recordId = $(this).data('id');
			const recordDesc = $(this).closest('tr').find('td:eq(2)').text();

			$('#deleteConfirmModal').modal('show');

			$('#deleteConfirmModal .user-name').text(recordDesc);

			$('#confirmDeleteBtn').off('click').on('click', function() {
				deleteRecords(recordId);
			});
		});

		function deleteRecords(recordId) {
			$.ajax({
				url: `${API_DELETE_PERFORMANCE}/${recordId}`,
				type: 'DELETE',
				dataType: 'json',
				beforeSend: function() {
					$('#confirmDeleteBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');
				},
				success: function(response) {
					if (response.success) {
						alert('User berhasil dihapus');
						$('#tblKinerja').DataTable().ajax.reload();
					} else {
						alert('Error: ' + (response.message || 'Gagal menghapus user'));
					}
					$('#deleteConfirmModal').modal('hide');
				},
				error: function(xhr) {
					console.error('Error:', xhr);
					let errorMsg = 'Terjadi kesalahan saat menghapus data';
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMsg = xhr.responseJSON.message;
					}
					alert(errorMsg);
					$('#deleteConfirmModal').modal('hide');
				},
				complete: function() {
					$('#confirmDeleteBtn').prop('disabled', false).html('Ya, Hapus');
				}
			});
		}

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

		$('.form-check-input').on('click', function() {
			const menuId = $(this).data('menu');
			const roleId = $(this).data('role');

			$.ajax({
				url: API_CHECK_ACCESS,
				type: 'POST',
				data: {
					menuId: menuId,
					roleId: roleId
				},

				success: function() {
					document.location.href = BASE_ADMIN_ROLE_ACCESS + '/' + roleId;
				}
			})
		});
	});