<?php
class Mapper
{
    private $dbh;
    public function __construct($dbh)
    {
        $this->dbh = $dbh;
    }
    public function getAll(){
        $data = $this->dbh->query("SELECT `id` FROM `books` ORDER BY `title`");
        if($data){
            if($data->rowcount()) {
                $var = array();
                while($row = $data->fetch()) {
                    $var[] = $row['id'];
                }
            }
        }
        $list = array();
        foreach($var as $value){
            $list[] = $this->getSome($value);
        }
        //var_dump($list);
        return $list;
    }
    public function getSome($id)
    {
        $data = $this->dbh->query("SELECT * FROM `books` WHERE `id` = {$id}");
        if($data){
            $data =  $data->fetch(\PDO::FETCH_ASSOC);
        }
        $data1 = $this->dbh->query("SELECT DISTINCT authors.name from `authors`
                                        INNER JOIN `link_book_author` ON authors.id IN
                                        (SELECT link_book_author.author_id FROM link_book_author WHERE link_book_author.book_id={$id})
                                        GROUP BY authors.id");
        if($data1){
            if($data1->rowcount()) {
                $var = array();
                while($row = $data1->fetch()) {
                    $var[] = $row['name'];
                }
            }
        }
        $data['authors'] = $var;
        $data2 = $this->dbh->query("SELECT DISTINCT genres.genrename from `genres`
                                        INNER JOIN `link_book_genre` ON genres.id IN
                                        (SELECT link_book_genre.genre_id FROM link_book_genre WHERE link_book_genre.book_id={$id})
                                        GROUP BY genres.id");
        if($data2){
            if($data2->rowcount()) {
                $var = array();
                while($row = $data2->fetch()) {
                    $var[] = $row['genrename'];
                }
            }
        }
        $data['genres'] = $var;
        return $data;
    }

    public function getComments($id)
    {
        $data = $this->dbh->query("SELECT `comment` FROM `comments` WHERE `book_id` = {$id} ORDER BY `comment`");
        if($data&&($data!=false)){
            $data =  $data->fetch(\PDO::FETCH_ASSOC);
            return $data;
        }
        $data = array();
        return $data;
    }
    public function setComment($id,$comment)
    {
        $this->dbh->query("INSERT INTO comments(`book_id`,`comment`)
                              VALUES ('{$id}', '{$comment}')");
    }
    public function getAuthor($name)
    {
        $data = $this->dbh->query("SELECT * FROM `authors` WHERE `name` = {$name}");
        if($data){
            $data =  $data->fetch(\PDO::FETCH_ASSOC);
            return $data;
        }
    }
}
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 30.06.2015
 * Time: 22:05
 */