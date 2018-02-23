<?php
    $cfg_file = storage_path('app/settings.php');
    return file_exists($cfg_file) ?
        require $cfg_file : [];