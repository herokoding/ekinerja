$(function () {
	$('#tblMenu').DataTable({
		"processing": true,
		"ajax": {
			"url": "<?= base_url('api/getMenu') ?>",
			"type": 'GET',
			"dataSrc": 'data',
		},

		"columns": [
			{ data: 'menu_id' },
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
});