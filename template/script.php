<script src="../asset/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../asset/dist/js/adminlte.min.js"></script>
<script src="../asset/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../asset/js/datatable.js"></script>
<script src="../asset/js/script.js"></script>

<script>
$('.alert_notif').on('click',function(){
    var getLink = $(this).attr('href');
    Swal.fire({
        position: 'top',
        title: "Yakin ingin menghapus data?",            
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonColor: '#3085d6',
        cancelButtonText: "Batal"
    
    }).then(result => {
        if(result.isConfirmed){
            window.location.href = getLink
        }
    })
    return false;
});        
</script>
<?php if (isset($_SESSION['failed'])): ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'top',
      title: '<?php echo $_SESSION['failed'] ?>',
      icon: '<?php echo $_SESSION['failed_icon'] ?>',
    })
</script>
<?php
  unset($_SESSION['failed']);
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