<?php
    //headers
    header('Access-Control-Allow-Origin: *'); //give access by anybody
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, x-Requested-with');
    

    include_once '../../config/DataBase.php';
    include_once '../../models/Post.php';

    //Instantiate DB & connect
    $database = new DataBase();
    $db = $database->connect();

    //Instantiate blog post object
    $post = new Post($db);

    //Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $post->id = $data->id;

    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    //Update post
    if($post->update()){
        echo json_encode(
            array('message'=> 'Post updated' )
        );
    } else {
        echo json_encode(
            array('message'=> 'Post not updated' )
        );
      }
    