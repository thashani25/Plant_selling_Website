
<?php

if (isset($success_meg)) {
    foreach ($success_meg as $success_meg) {
       echo '<script>swal("'.$success_meg.'", "", "success");</script>';
        }
}

if (isset($warning_meg)) {
    foreach ($warnings_meg as $warning_meg) {
       echo '<script>swal("'.$warning_meg.'", "", "success");</script>';
        }
}

if (isset($info_meg)) {
    foreach ($info_meg as $info_meg) {
       echo '<script>swal("'.$info_meg.'", "", "success");</script>';
        }
}

if (isset($error_meg)) {
    foreach ($error_meg as $error_meg) {
       echo '<script>swal("'.$error_meg.'", "", "success");</script>';
        }
}


?>