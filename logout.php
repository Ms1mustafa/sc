<?php 
    setcookie('email', '', -1, '/');
    // الانتقال الى الصفحة الاخرى
    echo'<meta http-equiv="refresh" content="0, url=login.php" />';
    // التوقف عن قراءة الاوامر البرمجية القادمة
    exit();
?>