<?php
include __DIR__ . "/../../src/containers/header.php";
include __DIR__ . "/../../src/containers/sidebar.php";
?>

<div class="col-xl-12">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="page-header" id="top">
				<h2 class="pageheader-title">Account Management </h2>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-10">
							<h5 class="mb-0">Daftar Pengguna</h5>
						</div>
						<div class="col-sm-2">
							<ul class="ml-auto mb-0">
								<form method="post" action="<?php echo url('pengguna/form.php'); ?>">
									<input type="hidden" name="submit" value="new">
									<button id="btn-new" class="btn btn-success">Tambah User</button>
								</form>
							</ul>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="users-table" class="table table-striped table-bordered first">
							<thead>
								<tr>
									<th style="display: hidden;">ID</th>
									<th>Nama Pengguna</th>
									<th>Nama</th>
									<th>No HP</th>
									<th>Hak Akses</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include __DIR__ . "/../../src/containers/script.php"; ?>

<script>
	$(document).ready(function() {
		$('#users-table').DataTable({
			ajax: { 
				type:"POST", 
				url: "<?php echo url('action/pengguna.php'); ?>", 
				data: {'submit': 'list'} 
			},
			columns: [
				{ 
					"data": "IdPengguna",
					"visible": false 
				},
				{ "data": "NamaPengguna" },
				{
					"data": null,
					"render": function(data, type, full) {
						return full['NamaDepan'] + ' ' + full['NamaBelakang']
					}
				},
				{ "data": "NoHp" },
				{ "data": "HakAkses.NamaAkses" },
				{ 
					"data": null,
					"render": function(data, type, full) {
						return `
							<form action="<?php echo url('pengguna/form.php'); ?>" method="post">
								<button class="btn btn-primary btn-xs text-white btn-view" value="${full['IdPengguna']}">View</button>
								<input type="hidden" name="userid" value="${full['IdPengguna']}">
								<input type="hidden" name="submit" value="update">
								<button type="submit" class="btn btn-success btn-xs text-white btn-edit">Edit</button>
							</form>
						`
					},
				}
			],
		})
	})
</script>

<?php include __DIR__ . "/../../src/containers/closing.php"; ?>