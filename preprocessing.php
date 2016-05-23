<?php
if(!isset($_SESSION))
{
    session_start();
}

require_once('constants.php');

function finish_if(&$text_body, &$i, &$output, &$substituition_map, $switch){
    while(++$i<count($text_body)){
        $text_body[$i] = trim($text_body[$i]);
        if($switch){
            $match = array();
            if(preg_match("/^#define (.*) (.*)$/", $text_body[$i], $match)){
                $substituition_map[$match[1]] = $match[2];
                continue;
            } else if(preg_match("/^#error (.*)$/", $text_body[$i], $match)){
                echo "Error" . $match[1];
                exit(0);
            } else if(preg_match("/^#undef (.*)$/", $text_body[$i], $match)){
                unset($substituition_map[$match[1]]);
                continue;
            } else if(preg_match("/^#ifdef (.*)$/", $text_body[$i], $match)){
                finish_if($text_body, $i, $output, $substituition_map, $substituition_map[$match[1]]);
                continue;
            } else if(preg_match("/^#ifndef (.*)$/", $text_body[$i], $match)){
                finish_if($text_body, $i, $output, $substituition_map, !$substituition_map[$match[1]]);
                continue;
            } else if(preg_match("/^#elif (.*)$/", $text_body[$i], $match)){
                finish_if($text_body, $i, $output, $substituition_map, eval("return " . $match[1] . ";"));
                continue;
            } else if(preg_match("/^#endif$/", $text_body[$i], $match)){
                return;
            } else if(preg_match("/^#else$/", $text_body[$i], $match)){
                $switch = 0;
                continue;
            }

            foreach($substituition_map as $key => $value){
                $text_body[$i] = preg_replace("/".preg_quote($key)."/", $value, $text_body[$i]);
            }

            if(preg_match("/^#if (.*)$/", $text_body[$i], $match)){
                finish_if($text_body, $i, $output, $substituition_map, eval("return " . $match[1] . ";"));
            } else{
                $output = $output . $text_body[$i] . "\n";
            }
        } else if(preg_match("/^#else$/", $text_body[$i], $match)){
            $switch = 1;
        } else if(preg_match("/^#elif (.*)$/", $text_body[$i], $match)){
            finish_if($text_body, $i, $output, $substituition_map, eval("return " . $match[1] . ";"));
        } else if(preg_match("/^#endif$/", $text_body[$i], $match)){
            return;
        }
    }
}

function get_preprocessed_text($file_name, $user_variables_text='') {
    $text_body = explode("\n", $user_variables_text.file_get_contents($file_name));
    $substituition_map = array();
    $output = "";
    $count = count($text_body);
    for($i=0; $i < $count; ++$i){
        $text_body[$i] = trim($text_body[$i]);
        $match = array();
        if(preg_match("/^#define (.*) (.*)$/", $text_body[$i], $match)){
            $substituition_map[$match[1]] = $match[2];
            continue;
        } else if(preg_match("/^#error (.*)$/", $text_body[$i], $match)){
            echo "Error: " . $match[1];
            exit(0);
        } else if(preg_match("/^#undef (.*)$/", $text_body[$i], $match)){
            unset($substituition_map[$match[1]]);
            continue;
        } else if(preg_match("/^#ifdef (.*)$/", $text_body[$i], $match)){
            if(key_exists($match[1],$substituition_map)){
                finish_if($text_body, $i, $output, $substituition_map, 1);
            } else{
                finish_if($text_body, $i, $output, $substituition_map, 0);
            }
            continue;
        } else if(preg_match("/^#ifndef (.*)$/", $text_body[$i], $match)){
            if(key_exists($match[1],$substituition_map)){
                finish_if($text_body, $i, $output, $substituition_map, 0);
            } else{
                finish_if($text_body, $i, $output, $substituition_map, 1);
            }
            continue;
        } else if(preg_match("/^#el(.*)$/", $text_body[$i], $match)){
            echo "Parse error\n";
            break;
        }

        foreach($substituition_map as $key => $value){
            $text_body[$i] = preg_replace("/".preg_quote($key)."/", $value, $text_body[$i]);
        }

        if(preg_match("/^#if (.*)$/", $text_body[$i], $match)){
            finish_if($text_body, $i, $output, $substituition_map, eval("return " . $match[1] . ";"));
        }
        else{
            $output = $output . $text_body[$i] . "\n";
        }
    }

    return $output;
}

function get_website_path($path) {
    return _WEBSITE_DIRECTORY.DIRECTORY_SEPARATOR.substr($path, _BASE_DIRECTORY_COUNT);
}

function create_dir_safe($path) {
    if(!is_dir($path)) {
        mkdir($path);
    }
}

function create_website_recursive($dir, $user_variables_text = ''){
    $files = scandir($dir);
    foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $finfo = finfo_open(FILEINFO_MIME);
            $is_text_file = substr(finfo_file($finfo, $path), 0, 4) == 'text';
            if($is_text_file) {
                file_put_contents(get_website_path($path), get_preprocessed_text($path, $user_variables_text));
            } else {
                copy($path, get_website_path($path));
            }
        } else if($value != "." && $value != "..") {
            create_dir_safe(get_website_path($path));
            create_website_recursive($path, $user_variables_text);
        }
    }
}

function create_website() {
    create_dir_safe(_WEBSITE_DIRECTORY);
    $user_variables_text = '';
    if (isset($_SESSION['user-id'])) {
        require('base/db_communication/data.php');
        if (isset($variables)) {
            foreach ($variables as $index => $var_arr) {
                $user_variables_text .= '#define '.$var_arr['var_key'].' '.$var_arr['var_value']."\n";
            }
        }
    }

    create_website_recursive(_BASE_DIRECTORY, $user_variables_text);
}

?>