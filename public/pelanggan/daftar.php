<?php
include __DIR__ . "/../../src/containers/header.php";
include __DIR__ . "/../../src/containers/sidebar.php";
?>

<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="page-header" id="top">
			<h2 class="pageheader-title">Pelanggan </h2>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-sm-10">
						<h5 class="mb-0">Daftar Pelanggan</h5>
					</div>
					<div class="col-sm-2">
						<ul class="ml-auto mb-0">
							<form method="post" action="<?php echo url('pelanggan/form.php'); ?>">
								<input type="hidden" name="submit" value="new">
								<button id="btn-new" class="btn btn-success">Tambah Pelanggan</button>
							</form>
						</ul>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="data-table" class="table table-striped table-bordered first">
						<thead>
							<tr>
								<th>Nama Pelanggan</th>
								<th>Alamat</th>
								<th>No Telepon</th>
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

<?php include __DIR__ . "/../../src/containers/script.php"; ?>

<script>
	$(document).ready(function() {
		$('#data-table').DataTable({
			ajax: { 
				type:"POST", 
				url: "<?php echo url('action/pelanggan.php'); ?>", 
				data: {'submit': 'list'} 
			},
			columns: [
				{ "data": "NamaPelanggan" },
				{ "data": "AlamatPelanggan" },
				{ "data": "NoTelepon" },
				{ 
					"data": null,
					"render": function(data, type, full) {
						return `
							<form action="<?php echo url('pelanggan/form.php'); ?>" method="post">
								<button class="btn btn-primary btn-xs text-white btn-view" value="${full['IdPelanggan']}">View</button>
								<input type="hidden" name="idpelanggan" value="${full['IdPelanggan']}">
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