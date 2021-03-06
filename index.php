<?php 
require_once('bootstrap.php');

$types_content = get_content_types($connection);


$get_id = get_data_from_params('categories-id');

$posts = get_posts($connection, $get_id, NULL);


$page_content = include_template('main.php', 
    [
     'posts' => $posts, 
     'types_content' => $types_content, 
     'get_id' => $get_id,
     'connection' => $connection
    ]
);

$layout_content = include_template('layout.php', 
    [
     'user_name' => $user_name,
     'is_auth' => $is_auth,
     'content' => $page_content, 
     'title' => 'readme: блог, каким он должен быть',
     'button_close' => ''
    ]
);

print($layout_content);