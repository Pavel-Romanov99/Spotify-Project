<?php
    class songPost {
        // DB Stuff
        private $conn;

        // Post Properties
        public $song_id;
        public $cover_id;
        public $name;
        public $author;
        public $uploader;
        public $user;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Create Post 
        public function create() {
            // Create Query
            $query = 'INSERT INTO songs (song_id, cover_id, name, author, uploader, user) VALUES (?, ?, ?, ?, ?, ?)';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind Data
            $stmt->bindParam(1, $this->song_id);
            $stmt->bindParam(2, $this->cover_id);
            $stmt->bindParam(3, $this->name);
            $stmt->bindParam(4, $this->author);
            $stmt->bindParam(5, $this->uploader);
            $stmt->bindParam(6, $this->user);

            // Execute Query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }
    }