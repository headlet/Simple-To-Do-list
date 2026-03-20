<?php
class task
{

    private $id;
    private $title;
    private $status;

    public function __construct(int $id, string $title, string $status)
    {
        $this->id = $id;
        $this->setTitle($title);
        $this->setStatus($status);
    }

    //setter
    public function setId() {}

    public function setTitle($title)
    {
        $cleanTitle = trim($title);
        if ($cleanTitle === '') {
            throw new Exception('Title is empty. Please add title');
        }

        $this->title = htmlspecialchars($cleanTitle);
    }

    public function setStatus($status)
    {
        if (!in_array($status, ['pending', 'complete'])) {
            throw new Exception("Status is invalid. Please select the valid status");
        }
        $this->status = $status;
    }

    //getter
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
        ];
    }
}
