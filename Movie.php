<?php

class Movie
{
    protected $pdo;

    //Call the connection function
    public function __construct()
    {
        $this->connection();
    }

    //Do database connection
    private function connection()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=projek', 'root', '');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            die("Problem with database...");
        }
    }

    /**
     * Get title, year, genre, director, actors, rating based on id
     */
    public function get($id)
    {
        $sql = "SELECT `title`,`year`,`genre`,`director`,`actors`,`rating` FROM movie WHERE ID = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        foreach ($res as $key => $val) {
            echo "[$key] => $val" . PHP_EOL;
        }
    }

    /**
     * Get all column fron database
     */
    public function getAll()
    {
        $sql = "SELECT * FROM movie";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $movie) {
            echo "------------\n" . PHP_EOL;
            echo "ID: {$movie['ID']}" . PHP_EOL;
            echo "title: {$movie['title']}" . PHP_EOL;
            echo "year: {$movie['year']}" . PHP_EOL;
            echo "genre: {$movie['genre']}" . PHP_EOL;
            echo "director: {$movie['director']}" . PHP_EOL;
            echo "actors: {$movie['actors']}" . PHP_EOL;
            echo "rating: {$movie['rating']}" . PHP_EOL;
            echo "-----------" . PHP_EOL;
        }
    }


    /**
     * Insert title, year, genre, director, actors, rating based on id
     */
    public function insert(string $title, int $year, string $genre, string $director, string $actors, float $rating)
    {
        $sql = "INSERT INTO movie(`title`,`year`,`genre`,`director`,`actors`,`rating`) VALUE (?,?,?,?,?,?)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$title, $year, $genre, $director, $actors, $rating]);
            $this->getAll();
        } catch (\PDOException $e) {
            echo "[Insert failed]\t" . $e->getMessage();
        } catch (\Exception $e) {
            echo "[Unexpected error]\t" . $e->getMessage();
        }
    }

    /**
     * Update title, year, genre, director, actors, rating based on id
     */
    public function update(int $id, string $col, $val)
    {
        $sql = "UPDATE movie SET `$col` = ? WHERE ID = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$val, $id]);
            $this->get($id);
        } catch (\PDOException $e) {
            echo "[Update failed]\t" . $e->getMessage();
        } catch (\Exception $e) {
            echo "[Unexpected error]\t" . $e->getMessage();
        }
    }

    /**
     * Delete title, year, genre, director, actors, rating based on id
     */
    public function delete(int $id)
    {
        $sql = "DELETE FROM movie WHERE ID = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $this->getAll();
        } catch (\PDOException $e) {
            echo "[Delete failed]\t" . $e->getMessage();
        } catch (\Exception $e) {
            echo "[Unexpected error]\t" . $e->getMessage();
        }
    }

}

class MovieList extends Movie
{
    //Fetch all movie
    /**
     * Get all column fron database
     */
    public function getAll()
    {
        $sql = "SELECT * FROM movie";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function getBy($order = "default")
    {
        if ($order == "default") {
            $sql = "SELECT * FROM movie";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            shuffle($res);
            return $res;
        } elseif ($order == 'title') {
            $sql = "SELECT * FROM movie ORDER BY title";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } elseif ($order == 'year') {
            $sql = "SELECT * FROM movie ORDER BY year DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }   elseif ($order == 'rating') {
            $sql = "SELECT * FROM movie ORDER BY rating DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } else {
            echo "Nothing here";
        }
    }

    //Fetch all movie order by alphabet
    //Fetch all movie order by year
    //Fetch all movie order by rating
    //Fetch movie data from database, filtered by title
    //Fetch movie data from database, filtered by year, either with range or not
    //Fetch movie data from database, filtered by genre, might be with multiple genre
    //Fetch movie data from database, filtered by director
    //Fetch movie data from database, filtered by actor
    //Fetch movie data from database, filtered by rating, probably with range
}
?>