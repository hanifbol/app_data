<?php
include __DIR__ . "/../src/containers/header.php";
include __DIR__ . "/../src/containers/sidebar.php";
?>

<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="page-header" id="top">
			<h2 class="pageheader-title">Dashboard </h2>
		</div>
	</div>
</div>

<!-- Cards total -->
<div class="row">
	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
		<div class="card border-3 border-top border-top-primary">
			<div class="card-body">
				<h5 class="text-muted">Jumlah Pembelian</h5>
				<div class="metric-value d-inline-block">
					<h1 id="total-pembelian" class="mb-1"></h1>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
		<div class="card border-3 border-top border-top-primary">
			<div class="card-body">
				<h5 class="text-muted">Total Nilai Pembelian</h5>
				<div class="metric-value d-inline-block">
					<h1 id="total-harga-beli" class="mb-1"></h1>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
		<div class="card border-3 border-top border-top-primary">
			<div class="card-body">
				<h5 class="text-muted">Jumlah Penjualan</h5>
				<div class="metric-value d-inline-block">
					<h1 id="total-penjualan" class="mb-1"></h1>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
		<div class="card border-3 border-top border-top-primary">
			<div class="card-body">
				<h5 class="text-muted">Total Nilai Penjualan</h5>
				<div class="metric-value d-inline-block">
					<h1 id="total-harga-jual" class="mb-1"></h1>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Tabel -->
<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<h5 class="card-header">Laporan Laba Rugi</h5>
			<div class="card-body">
				<div class="table-responsive">
					<table id="data-table" class="table table-striped table-bordered first">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Barang</th>
								<th>Total Pembelian</th>
								<th>Total Harga Beli</th>
								<th>Total Penjualan</th>
								<th>Total Harga Jual</th>
								<th>Stok</th>
								<th>Laba/Rugi</th>
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

<?php include __DIR__ . "/../src/containers/script.php"; ?>

<script>
	$(document).ready(function() {
		// Get total of purchase
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/pembelian.php'); ?>", 
			data: {'submit': 'total'},
			dataType: 'json',
			success: function(data) {
				$('#total-pembelian').html(data.JumlahTransaksi)
				$('#total-harga-beli').html(data.TotalNilai)
			}
		})

		// Get total of sale
		$.ajax({
			type: 'POST',
			url: "<?php echo url('action/penjualan.php'); ?>", 
			data: {'submit': 'total'},
			dataType: 'json',
			success: function(data) {
				$('#total-penjualan').html(data.JumlahTransaksi)
				$('#total-harga-jual').html(data.TotalNilai)
			}
		})
		
		// Get data for datatable
		$('#data-table').DataTable({
			ajax: {
				type: "POST",
				url: "<?php echo url('action/barang.php'); ?>", 
				data: {'submit': 'dashboard'} 
			},
			columns: [
				{
					"data": null,
					"render": function(data, type, full, meta) {
						return meta.row + 1
					}
				},
				{ "data": "NamaBarang" },
				{ "data": "TotalPembelian" },
				{ "data": "TotalHargaBeli" },
				{ "data": "TotalPenjualan" },
				{ "data": "TotalHargaJual" },
				{ "data": "Stok" },
				{ "data": "Laba" },
			]
		})
	})
</script>

<?php include __DIR__ . "/../src/containers/closing.php"; ?>