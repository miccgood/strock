
    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo base_url('assets/bootstrap-sb-admin-2/js/jquery-1.11.0.js') ?>"></script>


<?php foreach ($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
    
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap-sb-admin-2/js/bootstrap.min.js') ?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap-sb-admin-2/js/plugins/metisMenu/metisMenu.min.js') ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap-sb-admin-2/js/sb-admin-2.js') ?>"></script>
</body>

</html>

