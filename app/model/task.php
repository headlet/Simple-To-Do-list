<?php
class task {
    private $id;
    private $title;
    private $status;

private function __construct($id, $title, $status='pending')
{
    $this->id= $id;
    $this->title = $title;
    $this->status = $status;
}

//getter
public function getId(){
    return $this->id;
}
public function getTitle(){
    return $this->title;
}
public function getStatus(){
    return $this->status;
}   

//

}
