<?php 
$config = require 'config.php';

require_once('functions/db.php');
require_once('functions/template.php');
require_once('functions/request.php');
require_once('functions/date.php');
require_once('functions/validation.php');
require_once('functions/actions.php');

$user_name = 'Иван Тестов';

$is_auth = rand(0, 1);

$connection = db_connect($config["db"]["host"], $config["db"]["user"], $config["db"]["password"], $config["db"]["name"]);

$types_content = get_content_types($connection);

$get_id = get_data_from_params('categories-id');

$get_type_name = get_type_from_id($types_content, $get_id);


if($_POST) {
    
    $filter_form_data = array_map($no_html, $_POST);

    $form_errors = check_filled_value($filter_form_data, $get_type_name);

    $tags_arr = get_tags_form($filter_form_data, $get_type_name);

    switch($get_type_name) {

        case "photo" :

            $error_file_or_link = check_photo_form($_FILES, $filter_form_data);
            $form_errors += $error_file_or_link;
    
            if(!$_FILES["file-photo"]["error"] && !$form_errors) {
             
                $filter_form_data += upload_files($_FILES);
            }
            elseif(!$form_errors) {
    
                $filter_form_data += download_out_files($filter_form_data["photo-url"]);
            };
        break;

        case "video" :
 
            $error_link_video = check_video_form($filter_form_data);
            $form_errors += $error_link_video;
        break;

        case "link" :

            $error_link = check_link($filter_form_data['post-link'], 'post-link');
            $form_errors += $error_link; 
        break;

        case "quote" : 

            $error_quote_text = check_length_str($filter_form_data["post-quote"], 70);

            if(isset($error_quote_text)){
    
                $form_errors +=  ["post-quote" => "Цитата. {$error_quote_text}"];
            };
        break; 
    };


    if(!$form_errors){
        
        $post_id = $get_last_id($connection, "posts") + 1;

        add_new_tags_db($connection, $tags_arr, $add_tag_db, $get_last_id, $get_tags_id);
     
        add_post_db($connection, $filter_form_data, $get_type_name, $post_id);

        add_relation_arr_db($connection, $post_id, $tags_arr, $get_tags_id, $get_last_id, $add_relatios_db);

        header("Location: post.php?post-id={$post_id}");

        exit();
    }; 
};


$add_post_form = include_template("add-post-form-{$get_type_name}.php",
    [
        'get_id' => $get_id,
        'filter_form_data' => $filter_form_data,
        'filling_errors' => $filling_errors,
        'form_errors' => $form_errors
    ]
);


$add_post = include_template('adding-post.php',
    [
     'types_content' => $types_content,
     'get_id' => $get_id,
     'add_post_form' => $add_post_form
    ]
);

$layout_content = include_template('layout.php', 
    [
     'user_name' => $user_name,
     'is_auth' => $is_auth,
     'content' => $add_post,
     'title' => 'Добавить публикацию',
     'button_close' => 'закрыть'
    ]
);

print($layout_content);