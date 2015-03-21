
<!-- /.row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery Version 1.11.0 -->


<script src="<?php echo base_url('assets/bootstrap-sb-admin/js/jquery-1.11.0.js') ?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url('assets/bootstrap-sb-admin/js/bootstrap.min.js') ?>"></script>




<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url('assets/bootstrap-sb-admin/js/plugins/morris/raphael.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-sb-admin/js/plugins/morris/morris.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-sb-admin/js/plugins/morris/morris-data.js') ?>"></script>

<?php foreach ($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</body>

<script type="text/javascript">
//    $(function() {
//        $(window).resize(function() {
//
//            $("form").each(function() {
//                var $formWidth = $(this).width();
//
//                $(this).find("input, textarea").each(function() {
//
//                    var $width = $(this).width();
//
//                    if ($width > $formWidth) {
//                        $(this).width($formWidth - 20);
//                    }
//                });
//            });
//        });
//    });
</script>
</html>
