<?php

class Ajax extends Controller {

  public function Ajax() {
  
    parent::Controller(); 
  }

  public function reload()
  {
    $this->load->model('MUser', '', TRUE);
    $type = trim($_GET['list']);
    // if the username exists return a 1 indicating true
    if ($this->MUser->username_exists($username)) {
      echo '1';
    }
  }

}

?>