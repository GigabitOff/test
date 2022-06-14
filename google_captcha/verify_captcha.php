<?php

 

    // URL куда отправлять токин и секретный ключ
    $url = 'https://localhost/web/api/deactivateurok';
    
    
    
    // Делаем запрос
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Отправляем запрос 
    $response = curl_exec($ch);
    
    // Возвращаем массив полученных данных
    return json_decode($response, true);


