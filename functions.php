<?php
    declare(strict_types=1);

    const API_URL = "https://dev.whenisthenextmcufilm.com/api";

    function render_template(string $template, array $data = []){
        extract($data);
        require "templates/$template.php";
    }

    function get_data(string $url) : array{
        $result = file_get_contents($url);
        $data = json_decode($result, true);
        return $data;
    } 
?>