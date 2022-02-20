<?php
    class Post {
        //DB stuff
        private $conn;
        private $table = 'posts';
    
        //Post Properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        //constructor
        public function __construct($db){
            $this->conn = $db;
        }

                        //METHODS
        //Get Posts
        public function read(){
            // post as p and categories as c (sql multitable query)
            $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM 
                '. $this->table .' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY 
                p.created_at DESC';

        //Prepare statment
        $stnt = $this->conn->prepare($query);   //prepare are a PDO METHOD

        //Execute query
        $stnt->execute();

        return $stnt;
        }
 



        
        //get single post
        public function read_single(){
            //create query
            $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM 
                '. $this->table .' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE 
                p.id = ?
            LIMIT 0,1';

        //Prepare statment
        $stnt = $this->conn->prepare($query);   //prepare are a PDO METHOD

        //bind ID
        $stnt->bindParam(1, $this->id);

        //Execute query
        $stnt->execute();

        $row = $stnt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
        }



        //create post
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . $this->table .'
                SET 
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';

        //Prepare statement
        $stnt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //Bind data
        $stnt->bindParam('title', $this->title);
        $stnt->bindParam('body', $this->body);
        $stnt->bindParam('author', $this->author);
        $stnt->bindParam('category_id', $this->category_id);

        //Eecute query
        if($stnt->execute()){
            return true;
        }
        
        //Print error if something goes wrong
        printf('error: %s.\n', $stnt->error);

        return false;
        }



        //update post
        public function update(){
            //Create query
            $query = 'UPDATE ' . $this->table .'
                SET 
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
                WHERE 
                    id = :id';

        //Prepare statement
        $stnt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
        

        //Bind data
        $stnt->bindParam('title', $this->title);
        $stnt->bindParam('body', $this->body);
        $stnt->bindParam('author', $this->author);
        $stnt->bindParam('category_id', $this->category_id);
        $stnt->bindParam('id', $this->id);

        //Eecute query
        if($stnt->execute()){
            return true;
        }
        
        //Print error if something goes wrong
        printf('error: %s.\n', $stnt->error);

        return false;
        }



         // Delete Post
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
          return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
  }


    }