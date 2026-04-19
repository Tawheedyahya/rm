<?php

if (!function_exists('pr')) {
    function pr($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
}
if(!function_exists('fstatus')){
    function fstatus(&$data){
    $status = $data['status'] ?? 200;
    unset($data['status']);
    return $status;
}
}