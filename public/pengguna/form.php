<?php
include __DIR__ . "/../../src/containers/header.php";
include __DIR__ . "/../../src/containers/sidebar.php";

if ($_POST['submit'] == 'new') {
	$type = 'new';
} else {
	$type = 'update';
	if (isset($_POST['userid'])) {
		$userid = $_POST['userid'];
	} else {
		$userid = $_SESSION['IdPengguna'];
	}
}
?>

<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="page-header" id="top">
			<h2 class="pageheader-title">Account Management </h2>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-8 col-sm-12">
		<div class="card">
			<form id="user-form">
				<h5 class="card-header">Form Pengguna</h5>
				<div class="card-body">
					<input id="userid" name="userid" type="hidden">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="username" class="col-form-label">Nama Pengguna</label>
								<input id="username" name="username" type="text" class="form-control" disabled>
							</div>		
						</div>	
						<div class="col-lg-6">
							<div class="form-group">
								<label for="access" class="col-form-label">Hak Akses</label>
								<select id="access" class="form-control" disabled></select>
								<input id="accessid" type="hidden" name="accessid" value="1">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="password" class="col-form-label">Password</label>
								<input id="password" type="password" name="password" class="form-control" placeholder="password">
								<p id="msg-password">Kosongkan bila tidak ingin mengubah password.</p>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="confirm" class="col-form-label">&nbsp;</label>
								<input id="confirm" type="password" class="form-control" placeholder="konfirmasi password">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="firstname" class="col-form-label">Nama</label>
								<input id="firstname" type="text" name="firstname" class="form-control" required>
								<p>Nama depan</p>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="lastname" class="col-form-label">&nbsp;</label>
								<input id="lastname" type="text" name="lastname" class="form-control">
								<p>Nama belakang</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="phone" class="col-form-label">No Handphone</label>
								<input id="phone" type="text" name="phone" class="form-control" >
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="address" class="col-form-label">Alamat</label>
								<textarea id="address" name="address" class="form-control"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-12">
							<input type="hidden" name="submit" value="<?php echo $type; ?>">
							<button class="btn btn-primary" type="submit">Simpan</button>
							<?php if (($type == 'update') && ($userid != $_SESSION['IdPengguna'])) { ?>
								<button id="btn-delete" class="btn btn-danger" data-toggle="modal" data-target="#confirmation-modal">Hapus User</button>
							<?php } ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php if (($type == 'update') && ($userid != $_SESSION['IdPengguna'])) { ?>
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
				Apakah Anda yakin untuk menghapus user ini?
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
		// Get access references
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/akses.php'); ?>",
			data: {'submit': 'list'},
			dataType: 'json',
			success: function(responses) {
				// Fill access dropdown
				responses.forEach(response => {
					$('#access').append(`<option value="${response.IdAkses}">${response.NamaAkses}</option>`)
				});

				<?php if ($type == 'update') { ?>
					getUser(<?php echo $userid; ?>)
				<?php } else { ?>
					$('#username').prop('disabled', false)
					$('#access').prop('disabled', false)
					$('#msg-password').html("")
				<?php } ?>
			}
		})
	});

	$('#user-form').on('submit', function(e) {
		e.preventDefault()

		var values = $(this).serializeArray()
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/pengguna.php'); ?>",
			data: values,
			dataType: 'json',
			success: function() {
				window.location.href = "<?php echo url('pengguna/daftar.php'); ?>"
			}
		})
	});

	$('#access').on('change', function() {
		var id_akses = this.value
		$('#accessid').val(id_akses)
	})

	<?php if ($type == 'update') { ?>
		$('#btn-delete').on('click', function(e) {
			e.preventDefault();
		})

		$('#confirm-delete').on('click', function(e) {
			e.preventDefault();
			
			$.ajax({
				type: 'POST',
				url: "<?php echo url('action/pengguna.php'); ?>",
				data: {'userid': <?php echo $userid; ?>, 'submit': 'delete'},
				success: function() {
					window.location.href = "<?php echo url('pengguna/daftar.php'); ?>"
				}
			})
		})
	<?php } ?>

	function getUser(id) {
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/pengguna.php'); ?>",
			data: {'IdPengguna': id, 'submit': 'find'},
			dataType: 'json',
			success: function(response) {
				fillForm(response)
			}
		})
	}

	function fillForm(values) {
		$('#userid').val(values.IdPengguna)
		$('#username').val(values.NamaPengguna)
		$('#access').val(values.HakAkses.IdAkses).change()
		$('#firstname').val(values.NamaDepan)
		$('#lastname').val(values.NamaBelakang)
		$('#phone').val(values.NoHp)
		$('#address').val(values.Alamat)
	}
</script>

<?php include __DIR__ . "/../../src/containers/closing.php"; ?>