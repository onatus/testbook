<?php
class Controller
{
    public static function d2o(array $data = array())                                  //функция гидрации "data to object"
    {
        $obj = new Book();
        $obj->setId(isset($data['id']) ? $data['id'] : null);
        $obj->setTitle(isset($data['title']) ? $data['title'] : null);
        $obj->setDescription(isset($data['description']) ? $data['description'] : null);
        $obj->setCover(isset($data['cover']) ? $data['cover'] : null);
        $obj->setNofpages(isset($data['numberofpages']) ? $data['numberofpages'] : null);
        $authors = $data['authors'];
        $obj->setAuthors($authors);
        $genres = $data['genres'];
        $obj->setGenres($genres);

        return $obj;
    }

    public function showBook($book, $mapper)
    {
        $book = (is_null($book) ? null : $this->d2o($book));
        $authors = '';
        $aut = $book->getAuthors();
        foreach ($aut as $values) {
            $authors .= "{$values}, ";
        }
        $authors = substr($authors, 0, (strlen($authors) - 2));
        $genres = '';
        $gen = $book->getGenres();
        foreach ($gen as $values) {
            $genres .= "{$values}, ";
        }
        $genres = substr($genres, 0, (strlen($genres) - 2));
        $comments = $this->showComments($mapper->getComments($book->getId()));
        $accordion = 'accordion'.$book->getId();
        $collapse = 'collapse'.$book->getId();
        $formId = 'comment'.$book->getId();
        $textId = 'text'.$book->getId();
        $commentBox = 'commentBox'.$book->getId();
        echo "
                <div class='row'>
                    <div class='col-xs-5'><img src='cover/{$book->getCover()}'></div>
                    <div class='col-xs-7'>
                            <hgroup>
                            <h2>{$book->getTitle()}</h2><br>
                            <h3>Authors: {$authors}</h3><br><br><br>
                            <h4>
                                Genre: {$genres}<br>
                                Number of pages: {$book->getNofpages()}<br>
                            </h4>
                            </hgroup>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-xs-12'>
                        <p>
                            {$book->getDescription()}
                        </p>
                        <div class='accordion' id='{$accordion}' data-toggle='collapse'>
                            <div class='accordion-group'>
                                <div class='accordion-heading'>
                                    <a class='accordion-toggle' data-toggle='collapse' data-parent='#{$accordion}' href='#$collapse'>
                                        <h5>Show comments</h5>
                                    </a>
                                </div>
                                <div id='$collapse' class='accordion-body collapse'>
                                    <div class='accordion-inner form-group comment-content' id='$commentBox'>
                                        {$comments}
                                        <form role='form' class='form-horizontal' id='{$formId}'>
                                            <textarea class='form-control' maxlength='1000' id='{$textId}'></textarea>
                                            <input type='submit' class='btn btn-info addComment' data-id='{$book->getId()}' value='Add your comment'>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                </div>
            ";
    }
    public function showAll(array $list, $mapper)
    {
        foreach($list as $value){
            $this->showBook($value, $mapper);
        }
    }
    public function showComments($comments)
    {
        foreach ($comments as $value) {
            $data = '';
            $data .= "
                <p>
                    <hr/>
                    {$value}
                    <hr/>
                </p>
            ";
        }
        return $data;
    }
}
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 30.06.2015
 * Time: 22:05
 */