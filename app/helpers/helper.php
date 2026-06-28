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
if(!function_exists('paginate_extractor')){
    function paginate_extractor($data){
        return [
            'current_page'   => $data->currentPage()??null,
            'next_page_url'  => $data->nextPageUrl()??null,
            'prev_page_url'  => $data->previousPageUrl()??null,
            'per_page'       => $data->perPage()??null,
            'last_page'      => $data->lastPage()??null,
            'last_page_url'  => $data->url($data->lastPage())??null,
        ];
        
    }
};