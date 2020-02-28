<?php


class productsController
{
    use Render;

    public function __construct()
    {
        $this->model = new ProductsModel();
        $this->request = $_REQUEST;/*  */
    }

    public function create($param)
    {
        if (!$param[0]) {
            if ($this->productsModel->insertDetails($this->request)) {
                $status['status code'] = 200;
                $status['message'] = 'Insert successfully';
                $this->response['status'] = $status;
            } else {
                $status['status code'] = 200;
                $status['message'] = 'Fails to insert';
                $this->response['status'] = $status;
            }
        } else {
            echo 'xxx';
        }
        echo json_encode($this->response);
    }

    public function delete($param)
    {
        if ($param[0]) {
            $queryResult = $this->response['data']['Affected Rows'] =$this->model->remove($param[0]);
            
        } else {
            $queryResult = $this->response['data']['Affected Rows'] =$this->model->remove();
        }
        if ($queryResult) {
            $status['status code'] = 204;
            $status['message'] = 'successfully Remove';
        } else {
            $status['status code'] = 400;
            $status['message'] = 'No records availaple for remove';
        }
        $this->response['status'] = $status;
        echo (json_encode($this->response));
    }

    public function update($param)
    {
        if($param[0]){
            $affectedRows=$this->model->updateData($this->request,$param[0]);
        }
        else{
            $affectedRows=$this->model->updateData($this->request);
        }
        if($affectedRows){
            $status['status code'] = 200;
            $status['message'] = 'Update products Successfully';
           $this->response['status']=$status;
           $this->response['data']['Affected rows']=$affectedRows;
        }
        else{
            $status['status code'] = 200;
            $status['message'] = 'Update products Successfully';
           $this->response['status']=$status;
           $this->response['data']['Affected rows']=$affectedRows;
        }
        echo json_encode($this->response);
    }

    public function getData($param)
    {
       if($param[0]){
            $data=$this->model->getData($param[0]);
       }
       else{
           $data=$this->model->getData();
       }
       if($data){
        $status['status code'] = 200;
        $status['message'] = 'Get prducts Successfully';
           $this->response['status']=$status;
           $this->response['data']=$data;
       }
       else{
        $status['status code'] = 404;
        $status['message'] = 'There is no data availpale for fetch';
           $this->response['status']=$status;
       }
       echo json_encode($this->response);
    }


    public function viewSellerForm()
    {
        $this->render('ProductSellForm', '');
    }


    public function getDatas()
    {
        $sellerPageData = $this->userModel->getSellerPageData();
        while ($dbdata = pg_fetch_assoc($sellerPageData)) {
            unset($dbdata['sellerid']);
            $dataArray[] = $dbdata;
        }
        $status['status code'] = 200;
        $data['roll'] = 's';
        $data['dataArray'] = $dataArray;
        $this->responce['status'] = $status;
        $this->responce['data'] = $data;
        echo (json_encode($this->responce));
    }
}
