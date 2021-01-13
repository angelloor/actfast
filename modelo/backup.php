<?php
    require '../vendor/autoload.php';

    use Ifsnop\Mysqldump as IMysqldump;

    try {
        $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=actfast', 'root', 'sysadmin');
        $dump->start('storage/work/dump.sql');
    } catch (\Exception $e) {
        echo 'mysqldump-php error: ' . $e->getMessage();
    }

?>