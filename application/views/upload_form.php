
<!--<?php echo $error;?>-->

<?php echo form_open_multipart('upload/do_upload');?>
Upload a file: 
<input type="file" name="userfile" size="20" />
				<?php $id = $this->session->userdata('m_id');
						$id = $id[0]->$m_id;
						echo $id; ?>

<?php echo  " and ". $id; ?>
<br /><br />

<input type="submit" value="upload" />

</form>

