<?php
include __DIR__ . "/../../src/containers/header.php";
include __DIR__ . "/../../src/containers/sidebar.php";
?>

<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="page-header" id="top">
			<h2 class="pageheader-title">Barang </h2>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-8 col-sm-12">
		<div class="card">
			<form id="barang-form">
				<h5 class="card-header">Form Barang</h5>
				<div class="card-body">
					<input id="idbarang" name="idbarang" type="hidden">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="barang" class="col-form-label">Nama Barang</label>
								<input id="barang" name="barang" type="text" class="form-control">
							</div>	
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="keterangan" class="col-form-label">Keterangan</label>
								<textarea id="keterangan" name="keterangan" class="form-control"></textarea>
							</div>	
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="satuan" class="col-form-label">Satuan</label>
								<input id="satuan" name="satuan" type="text" class="form-control">
							</div>	
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-12">
							<input type="hidden" name="submit" value="<?php echo $_POST['submit']; ?>">
							<button class="btn btn-primary" type="submit">Simpan</button>
							<?php if ($_SESSION['submit'] == 'update') { ?>
								<button id="btn-delete" class="btn btn-danger" data-toggle="modal" data-target="#confirmation-modal">Hapus Barang</button>
							<?php } ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php if ($_SESSION['submit'] == 'update') { ?>
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
				Apakah Anda yakin untuk menghapus barang ini?
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
				url: "<?php echo url('action/barang.php'); ?>",
				data: {'IdBarang': <?php echo $_POST['idbarang']; ?>, 'submit': 'find'},
				dataType: 'json',
				success: function(response) {
					fillForm(response)
				}
			})
		<?php } ?>
	});

	$('#barang-form').on('submit', function(e) {
		e.preventDefault()

		var values = $(this).serializeArray()
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/barang.php'); ?>",
			data: values,
			success: function() {
				window.location.href = "<?php echo url('barang/daftar.php'); ?>"
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
				url: "<?php echo url('action/barang.php'); ?>",
				data: {'idbarang': <?php echo $_POST['idbarang']; ?>, 'submit': 'delete'},
				success: function() {
					window.location.href = "<?php echo url('barang/daftar.php'); ?>"
				}
			})
		})
	<?php } ?>

	function fillForm(values) {
		$('#idbarang').val(values.IdBarang)
		$('#barang').val(values.NamaBarang)
		$('#keterangan').val(values.Keterangan)
		$('#satuan').val(values.Satuan)
	}
</script>

<?php include __DIR__ . "/../../src/containers/closing.php"; ?>