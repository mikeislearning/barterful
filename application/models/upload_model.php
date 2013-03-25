<?php
class upload_model extends CI_Model{
  var $original_path;
  var $resized_path;
  var $thumbs_path;
 
  //initialize the path where you want to save your images
  function __construct(){
    parent::__construct();
    //return the full path of the directory
    //make sure these directories have read and write permessions
    $this->original_path = realpath(APPPATH.'../uploads/original');
    $this->resized_path = realpath(APPPATH.'../uploads/resized');
    $this->thumbs_path = realpath(APPPATH.'../uploads/thumbs');
  }
  
 /* function do_upload_profile(){
	 

    $this->load->library('image_lib');
    $config = array(
    'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
    'max_size'          => 2048, //2MB max
    'upload_path'       => $this->original_path, //upload directory
    'id' => $id
    );
    
    //get the time for the current update
    $time =  date('Y-m-d H:i:s');


		//get the id value from the first pair in the array
		$id = $id[0]->m_id;
		//getting the username from the post array storing it in username and getting the data ready to insert
		$username = $this->input->post('username');
	
		
		$update_profile_insert_data = array (
		'p_img'=> 'upload_data',
		
		'p_last_updated' => $time		
				);
		//doing our update
		
//gets the id and updates the profile according to the m_id foreign key
$this->db->where('m_id', $id);
$this->db->update('profiles', $update_profile_insert_data); 
	}
    /*
 
 ////////////////////////*original*/ ///////////////////// /////////////////////
  function do_upload(){
    $this->load->library('image_lib');
    $config = array(
    'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
    'max_size'          => 2048, //2MB max
    'upload_path'       => $this->original_path, //upload directory
    'id' => $id;
    
    
  );
  
 
  
    //your desired config for the resize() function
  /*  $config = array(
    'file_name' =>  $id.$img_data['file_name'];
    'source_image'      => $image_data['full_path'], //path to the uploaded image
    'new_image'         => $this->resized_path, //path to
    'maintain_ratio'    => true,
    'width'             => 128,
    'height'            => 128
    );
 */
 
    //this is the magic line that enables you generate multiple thumbnails
    //you have to call the initialize() function each time you call the resize()
    //otherwise it will not work and only generate one thumbnail
    /*$this->image_lib->initialize($config);
    $this->image_lib->resize();
 
    $config = array(
    'source_image'      => $image_data['full_path'],
    'new_image'         => $this->thumbs_path,
    'maintain_ratio'    => true,
    'width'             => 36,
    'height'            => 36
    );*/
    //here is the second thumbnail, notice the call for the initialize() function again
    $this->image_lib->initialize($config);
    $this->image_lib->resize();
  }
}

?>