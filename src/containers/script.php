				</div>
			</div>
		</div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
	<!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="<?php echo url('assets/vendor/jquery/jquery-3.3.1.min.js')?>"></script>
    <!-- bootstap bundle js -->
    <script src="<?php echo url('assets/vendor/bootstrap/js/bootstrap.bundle.js')?>"></script>
    <!-- slimscroll js -->
    <script src="<?php echo url('assets/vendor/slimscroll/jquery.slimscroll.js')?>"></script>
    <!-- main js -->
    <script src="<?php echo url('assets/libs/js/main-js.js')?>"></script>
    <!-- datatable js -->
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo url('assets/vendor/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo url('assets/vendor/datatables/js/buttons.bootstrap4.min.js')?>"></script>
	<script src="<?php echo url('assets/vendor/datatables/js/data-table.js')?>"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
	<script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
	<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
	<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
	<!-- custom script -->
	<script>
		$("#logout").on("click", function(e) {
			e.preventDefault()

			$.ajax({
				type: 'POST',
				url: "<?php echo url('logout.php');?>",
				success: function() {
					window.location.href = "<?php echo url('login.php'); ?>"
				}
			})
		})
	</script>