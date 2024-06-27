<?php

require_once 'app/view/JSONView.php';
require_once 'app/helpers/AuthHelpers.php';

class Controller {

    protected $authHelper;
    protected $view;   
    private $data;

    public function __construct() {
        $this->authHelper = new AuthHelper();     
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
    }

    function getData() {
        return json_decode($this->data);
    }
}