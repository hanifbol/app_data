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
	<div class="col-xl-8 col-sm-12">
		<div class="card">
			<form id="pelanggan-form">
				<h5 class="card-header">Form Pelanggan</h5>
				<div class="card-body">
					<input id="idpelanggan" name="idpelanggan" type="hidden">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="pelanggan" class="col-form-label">Nama Pelanggan</label>
								<input id="pelanggan" name="pelanggan" type="text" class="form-control">
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="alamat" class="col-form-label">Alamat</label>
								<textarea id="alamat" name="alamat" class="form-control"></textarea>
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="telepon" class="col-form-label">No Telepon</label>
								<input id="telepon" name="telepon" type="text" class="form-control">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="email" class="col-form-label">Email</label>
								<input id="email" name="email" type="text" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-12">
							<input type="hidden" name="submit" value="<?php echo $_POST['submit']; ?>">
							<button class="btn btn-primary" type="submit">Simpan</button>
							<?php if ($_POST['submit'] == 'update') { ?>
								<button id="btn-delete" class="btn btn-danger" data-toggle="modal" data-target="#confirmation-modal">Hapus Pelanggan</button>
							<?php } ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php if ($_POST['submit'] == 'update') { ?>
	<!-- Delete Confirmation Modal -->
	<div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<div class="modal-body">
				Apakah Anda yakin untuk menghapus pelanggan ini?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
				<button id="confirm-delete" type="button" class="btn btn-danger">Hapus</button>
			</div>
		</div>
	</div>
<?php } ?>

<?php include __DIR__ . "/../../src/containers/script.php"; ?>

<script>
	$(document).ready(function() {
		<?php if ($_POST['submit'] == 'update') { ?>
			$.ajax({
				type: 'POST',
				url: "<?php echo url('action/pelanggan.php'); ?>",
				data: {'IdPelanggan': <?php echo $_POST['idpelanggan']; ?>, 'submit': 'find'},
				dataType: 'json',
				success: function(response) {
					fillForm(response)
				}
			})
		<?php } ?>
	});

	$('#pelanggan-form').on('submit', function(e) {
		e.preventDefault()

		var values = $(this).serializeArray()
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/pelanggan.php'); ?>",
			data: values,
			success: function() {
				window.location.href = "<?php echo url('pelanggan/daftar.php'); ?>"
			},
			error: function(a, b, c) {
				console.log(c)
			}
		})
	});

	<?php if ($_POST['submit'] == 'update') { ?>
		$('#btn-delete').on('click', function(e) {
			e.preventDefault();
		})

		$('#confirm-delete').on('click', function(e) {
			e.preventDefault();
			
			$.ajax({
				type: 'POST',
				url: "<?php echo url('action/pelanggan.php'); ?>",
				data: {'idpelanggan': <?php echo $_POST['idpelanggan']; ?>, 'submit': 'delete'},
				success: function() {
					window.location.href = "<?php echo url('pelanggan/daftar.php'); ?>"
				}
			})
		})
	<?php } ?>

	function fillForm(values) {
		$('#idpelanggan').val(values.IdPelanggan)
		$('#pelanggan').val(values.NamaPelanggan)
		$('#alamat').val(values.AlamatPelanggan)
		$('#telepon').val(values.NoTelepon)
		$('#email').val(values.Email)
	}
</script>

<?php include __DIR__ . "/../../src/containers/closing.php"; ?>