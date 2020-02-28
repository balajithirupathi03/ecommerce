<?php


class OrdersController
{
    use Render;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->post = $_POST;
        $this->requestType = $_SERVER['REQUEST_METHOD'];
    }

    public function create()
    {
        echo 'order create';exit;
        if ($this->userModel->insertSellingFormData($this->post)) {
            $status['status code'] = 201;
            $this->responce['status'] = $status;
            echo json_encode($this->responce);
        }
    }

    public function delete()
    {
        echo 'order delete';exit;
    }

    public function update()
    {
        echo 'order delete';exit;
    }

    public function getData()
    {
        echo 'order getData';exit;
    }
}
