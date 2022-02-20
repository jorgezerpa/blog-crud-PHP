<?php
    //headers
    header('Access-Control-Allow-Origin: *'); //give access by anybody
    header('Content-Type: application/json');

    include_once '../../config/DataBase.php';
    include_once '../../models/Post.php';

    //Instantiate DB & connect
    $database = new DataBase();
    $db = $database->connect();

    //Instantiate blog post object
    $post = new Post($db);

    //blog post query
    $result = $post->read();
    //Get row count
    $num = $result->rowCount();

    //Check if any post
    if($num>0){
        // Post Array
        $posts_arr = array();
        $posts_arr['data'] = array();

                            //fetch => PDO method
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $post_item = array(
                        //this values comes from the query response
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body), //usually in a blog the body is allow to have some HTML
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            //Push to the data
            array_push($posts_arr['data'], $post_item);
        }

        //turn to JSON & output
        echo json_encode($posts_arr);

    } else {
        //else => if num === 0 => NO POSTS
        echo json_encode(
            array('message'=>'No Post Found')
        );
    }
