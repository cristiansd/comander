<?php
require_once ('../includes/GoogleTranslate.php');

$traslator = new GoogleTranslate();
    
    for ($i=0;$i<8;$i++){
        switch ($i){
            case 0:
                $source = 'es';
                $target = 'en';
                $text = 'pasteles';
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);    
                echo $resultado."<br>";
                break;
            case 1:
                $source = 'es';
                $target = 'ca';
                $text = 'pasteles';
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);    
                echo $resultado."<br>";
                break;
            case 2:
                $source = 'es';
                $target = 'fr';
                $text = 'pasteles';
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                
                echo $resultado."<br>";
                break;     
            case 3:
                $source = 'es';
                $target = 'de';
                $text = 'pasteles';
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                
                echo $resultado."<br>";
                break;     
            case 4:
                $source = 'es';
                $target = 'it';
                $text = 'pasteles';
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                
                echo $resultado."<br>";
                break;    
            case 5:
                $source = 'es';
                $target = 'ru';
                $text = 'pasteles';
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                
                echo $resultado."<br>";
                break;     
            case 6:
                $source = 'es';
                $target = 'zh-CN';
                $text = 'pasteles';
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                
                echo $resultado."<br>";
                break;     
            case 7:
                $source = 'es';
                $target = 'ja';
                $text = 'pasteles';
                $result = $traslator->translate($source, $target, $text);
                $resultado = json_encode($result, JSON_UNESCAPED_UNICODE);                
                echo $resultado;
                break;   
        }
    }
    

