<?php

class UserController
{
    use Render;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->request = $_REQUEST;
        $this->requestType = $_SERVER['REQUEST_METHOD'];
    }

    public function login()
    {
        
        $userData = $this->model->checkMailIdIsAvailaple($this->request['loginMailId']);
        $passwordStatus = $this->model->matchPassword($userData['id'], $this->request['loginPassword'], $userData['schema']);
        if ($userData && $passwordStatus) {
            $this->model->setSesstionData($userData);
            $status['status code'] = 200;
            $status['message'] = 'Login successFully';
            $this->response['status'] = $status;
        } else {
            $status['status code'] = 500;
            $status['message'] = 'Mail Id and password do not match';
            $this->response['status'] = $status;
        }
        echo json_encode($this->response);
    }

    public function viewLoginPage()
    {
        $this->render('UserLoginForm', '');
    }

    public function viewUserRegistrationForm()
    {
        $this->render('UserRegisterationForm', '');
    }

    public function viewHomePage()
    {
        if ($_SESSION["role"] === 'b') {
            $this->render('buyerPage', '');
        } else {
            $this->render('sellerPage', '');
        }
    }

    public function create($param)
    {
        if ($param[1] === 'products') {
            if ($param[2]) {
                if ($this->model->addToCart($param[2])) {
                    $status['status code'] = 201;
                    $status['message'] = 'product Added to cart successfully';
                    $this->response['status'] = $status;
                } else {
                    $status['status code'] = 400;
                    $status['message'] = 'Faild Add to cart';
                    $this->response['status'] = $status;
                }
                echo json_encode($this->response);
                exit;
            }
            echo 'Api Not Available';
            exit;
        } else {
            $this->createAccount();
        }
    }

    public function getData($param)
    {
        if ($param[1]) {
            if ($param[2]) {
                $this->response['data'] = $this->model->getCartProduct($param[2]);
            } else {
                $this->response['data'] = $this->model->getCartProduct();
            }
        } else {
            if ($param[0]) {
                $this->response['data'] = $this->model->getData(['id' => $param[0]]);
            } else {
                $this->response['data'] = $this->model->getAllData();
            }
            echo json_encode($this->response);
        }
    }

    public function update($param)
    {
        if ($param[0]) {
            if($this->model->updateAllData($this->request, ['id' => $param[0]])){
                $status['status code'] = 200;
            $status['message'] = 'update successfully';
            $this->response['status'] = $status;
            }
        } else {
            if($this->model->updateAllData($this->request)){
                $status['status code'] = 200;
            $status['message'] = 'update successfully';
            $this->response['status'] = $status;
            }
        }
        echo json_encode($this->response);
    }

    public function delete($param)
    {
        if ($param[1] === 'products') {
            if ($param[2]) {
                $queryResult = $this->response['data']['Affected Rows'] = $this->model->removeCartProduct($param[0], $param[2]);
            } else {
                $queryResult = $this->response['data']['Affected Rows'] = $this->model->removeCartProduct($param[0]);
            }
            if ($queryResult) {
                $status['status code'] = 204;
                $status['message'] = 'successfully Remove from cart';
            } else {
                $status['status code'] = 400;
                $status['message'] = 'No records availaple for remove';
            }
        } else if ($param[0]) {
            if ($this->model->remove(['id' => $param[0]])) {
                $status['status code'] = 204;
                $status['message'] = 'The Account deleted successfully';
                $this->response['status'] = $status;
            } else {
                echo 'xxx';
            }
        } else {
            echo 'Dont Use It';
            exit;
            if ($this->model->remove()) {
                $status['status code'] = 204;
                $status['message'] = 'All the accounts deleted successfully';
            } else {
                echo 'xxx';
            }
        }
        $this->response['status'] = $status;
        echo (json_encode($this->response));
    }

    private function createAccount()
    {
        if ($this->model->checkMailIdIsAvailaple($this->request['mailid'])) {
            $status['status code'] = 409;
            $status['message'] = 'Account already exists';
            $this->response['status'] = $status;
            echo json_encode($this->response);
        } else {
            $this->model->insertDetails($this->request);
            $status['status code'] = 201;
            $status['message'] = 'Account created succcessfully';
            $this->response['status'] = $status;
            echo json_encode($this->response);
        }
    }
}
