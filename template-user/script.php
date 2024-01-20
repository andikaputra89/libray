<script src="../asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../asset/dist/js/adminlte.min.js"></script>
<script src="../asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<!-- Toastr -->
<script src="../asset/plugins/toastr/toastr.min.js"></script>
<script>
  $('#pinjam').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });

  $('#pinjambkpaket').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
  $('#kembalibkpaket').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
 
$(document).ready(function () {
    $('#kembali').DataTable();
});

</script>
<?php if (isset($_SESSION['pinjam'])): ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'top',
      title: '<?php echo $_SESSION['pinjam'] ?>',
      icon: '<?php echo $_SESSION['pinjam_icon'] ?>',
    })
</script>
<?php
  unset($_SESSION['pinjam']);
 endif; ?>

 <?php if(isset($_SESSION['login']) && $_SESSION['login'] !='') : ?>
    <script type="text/javascript">
        $(function() {
        var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

          Toast.fire({
            icon: '<?= $_SESSION['login_icon']; ?>',
            title: '<?= $_SESSION['login']; ?>'
          })
    });
  </script>
<?php 
unset($_SESSION['login']);
endif; ?>
</body>
</html>