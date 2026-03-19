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



}
