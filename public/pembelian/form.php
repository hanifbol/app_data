<?php
include __DIR__ . "/../../src/containers/header.php";
include __DIR__ . "/../../src/containers/sidebar.php";
?>

<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="page-header" id="top">
			<h2 class="pageheader-title">Pembelian </h2>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-8 col-sm-12">
		<div class="card">
			<form id="pembelian-form">
				<h5 class="card-header">Form Pembelian</h5>
				<div class="card-body">
					<input id="idpembelian" name="idpembelian" type="hidden">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="pemasok" class="col-form-label">Nama Pemasok</label>
								<input id="pemasok" type="text" class="form-control">
								<input id="idpemasok" type="hidden" name="idpemasok">
								<div id="data-pemasok" class="card position-absolute" style="display: none; z-index: 1000; width: 90%;">
									<div class="card-body p-0">
										<div class="list-group list-group-flush">
											<!-- Suppliers list goes here -->
										</div>
									</div>
								</div>
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="barang" class="col-form-label">Nama Barang</label>
								<input id="barang" type="text" class="form-control">
								<input id="idbarang" type="hidden" name="idbarang">
								<div id="data-barang" class="card position-absolute" style="display: none; z-index: 1000; width: 90%;">
									<div class="card-body p-0">
										<div class="list-group list-group-flush">
											<!-- Items list goes here -->
										</div>
									</div>
								</div>
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="jumlah" class="col-form-label">Jumlah Pembelian</label>
								<input id="jumlah" name="jumlah" type="text" class="form-control">
							</div>	
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="harga" class="col-form-label">Harga Satuan</label>
								<input id="harga" name="harga" type="text" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="total-harga" class="col-form-label">Total Harga</label>
								<input id="total-harga" type="text" class="form-control" disabled>
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
								<button id="btn-delete" class="btn btn-danger" data-toggle="modal" data-target="#confirmation-modal">Hapus Pembelian</button>
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
				Apakah Anda yakin untuk menghapus pembelian ini?
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
				url: "<?php echo url('action/pembelian.php'); ?>",
				data: {'IdPembelian': <?php echo $_POST['idpembelian']; ?>, 'submit': 'find'},
				dataType: 'json',
				success: function(response) {
					fillForm(response)
				}
			})
		<?php } ?>
	});

	$('#pembelian-form').on('submit', function(e) {
		e.preventDefault()

		var values = $(this).serializeArray()
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/pembelian.php'); ?>",
			data: values,
			success: function() {
				window.location.href = "<?php echo url('pembelian/daftar.php'); ?>"
			},
			error: function(a, b, c) {
				console.log(c)
			}
		})
	});

	// Search supplier
	$('#pemasok').on('input', function() {
		var search = this.value
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/pemasok.php') ?>",
			data: {'search': search, 'submit': 'search'},
			dataType: 'json',
			success: function(responses) {
				$('#data-pemasok div.list-group').html("");
				$('#data-pemasok').show();
				responses.forEach(response => {
					$('#data-pemasok div.list-group').append(`
						<a href="#" class="list-group-item list-group-item-action" value="${response.IdPemasok}">${response.NamaPemasok}</a>
					`)
				});
			},
			error: function(a, b, c) {
				console.log(c)
			}
		})
	})

	$('#data-pemasok div.list-group').on('click', 'a', function(e) {
		e.preventDefault();
		var name = $(this).html()
		var id = $(this).attr('value')
		$('#pemasok').val(name)
		$('#idpemasok').val(id)
	})

	// Search item
	$('#barang').on('input', function() {
		var search = this.value
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/barang.php') ?>",
			data: {'search': search, 'submit': 'search'},
			dataType: 'json',
			success: function(responses) {
				$('#data-barang div.list-group').html("");
				$('#data-barang').show();
				responses.forEach(response => {
					$('#data-barang div.list-group').append(`
						<a href="#" class="list-group-item list-group-item-action" value="${response.IdBarang}">${response.NamaBarang}</a>
					`)
				});
			},
			error: function(a, b, c) {
				console.log(c)
			}
		})
	})

	$('#data-barang div.list-group').on('click', 'a', function(e) {
		e.preventDefault();
		var name = $(this).html()
		var id = $(this).attr('value')
		$('#barang').val(name)
		$('#idbarang').val(id)
	})

	$(window).on('click', function(e) {
		$('#data-pemasok').hide();
		$('#data-pemasok div.list-group').html("");

		$('#data-barang').hide();
		$('#data-barang div.list-group').html("");
	})

	// Calculate price
	$('#harga').on('change', function() {
		var harga = this.value
		var jumlah = $('#jumlah').val()
		$('#total-harga').val(harga * jumlah)
	})

	$('#jumlah').on('change', function() {
		var harga = $('#harga').val()
		var jumlah = this.value
		$('#total-harga').val(harga * jumlah)
	})

	<?php if ($_POST['submit'] == 'update') { ?>
		$('#btn-delete').on('click', function(e) {
			e.preventDefault();
		})

		$('#confirm-delete').on('click', function(e) {
			e.preventDefault();
			
			$.ajax({
				type: 'POST',
				url: "<?php echo url('action/pembelian.php'); ?>",
				data: {'idpembelian': <?php echo $_POST['idpembelian']; ?>, 'submit': 'delete'},
				success: function() {
					window.location.href = "<?php echo url('pembelian/daftar.php'); ?>"
				}
			})
		})
	<?php } ?>

	function fillForm(values) {
		$('#idpembelian').val(values.IdPembelian)
		$('#pemasok').val(values.Pemasok.NamaPemasok)
		$('#barang').val(values.Barang.NamaBarang)
		$('#jumlah').val(values.JumlahPembelian)
		$('#harga').val(values.HargaBeli)
		$('#total-harga').val(values.JumlahPembelian * values.HargaBeli)
	}
</script>

<?php include __DIR__ . "/../../src/containers/closing.php"; ?>