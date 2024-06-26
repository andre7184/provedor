<?php
include "_conf.php";
class login{
	// class variables
	private $dbConn;
	private $page = "index.php";
	// the constructor
	public function __construct(){
		$this->$dbConn = new Connection();
	}
	function escape($value){
		return trim(strip_tags(mysqli_real_escape_string($this->$dbConn,$value)));
	}
  	function loginUser($user, $pass,$remenber,$page){
  		$this->page=$page;
  		echo 'ok1';
    	$user = $this->escape($user);
    	echo 'ok2';
    	$this->checkFields($user, $pass);
    	echo 'ok3';
    	$iduser =$this->checkUserExists($user);
    	echo 'ok4';
    	$this->verifyPassword($iduser, $pass, $remenber);
  	}
  	function checkFields($user, $pass){
    	if(!$user | !$pass){
    		$this->closeConn();
     	 	$_SESSION['process_result'] = '<div class="notify-error">Please complete all fields before continuing.</div>';
	      	header("Location: " . $_SERVER['HTTP_REFERER'].'?page='.$this->page);
	    }else{
	      	return true;
	    }
  	}
  	function checkUserExists($user){
  		$iduser = false;
  		$stmt = mysqli_stmt_init($this->dbConn) or die($this->error);
  		$sql = "SELECT id_userfc FROM fc_user WHERE login_userfc = ?";
  		// prepare an SQL statement for execution
  		if(mysqli_stmt_prepare($stmt, $sql)) {
  			// bind parameters for markers
  			mysqli_stmt_bind_param($stmt, 's', $user);  // where 's' is the string type
  		
  			// execute previously prepared statement
  			if(mysqli_stmt_execute($stmt)) {    // returns true on success or false on failure
  				// gets a result set from a prepared statement
  				$result = mysqli_stmt_get_result($stmt);
  				if($result) {
  					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  						echo $row['id_userfc'];
  						if($row['id_userfc'] && $row['id_userfc'] > 0 ){
  							$iduser = $row['id_userfc'];
  						}
  					}
  					// free memory associated with the result
  					mysqli_free_result($result);
  				}
  			}
  		}
  		// close the statement
  		mysqli_stmt_close($stmt);
  		if(!$iduser){
  			$this->closeConn();
  			$_SESSION['process_result'] = '<div class="notify-error">Username/Password is incorrect.</div>';
  			header("Location: " . $_SERVER['HTTP_REFERER'].'?page='.$this->page);
  		}
  		return $iduser;
  	}
	function verifyPassword($iduser, $pass, $remenber){
		//
		$stmt = mysqli_stmt_init($this->dbConn) or die($this->error);
		$sql = "SELECT login_userfc,email_userfc,admin_userfc,grupo_userfc,id_provedor,senhar_userfc FROM fc_user WHERE id_userfc = ?";
		// prepare an SQL statement for execution
		if(mysqli_stmt_prepare($stmt, $sql)) {
			// bind parameters for markers
			mysqli_stmt_bind_param($stmt, 's', $iduser);  // where 's' is the string type
		
			// execute previously prepared statement
			if(mysqli_stmt_execute($stmt)) {    // returns true on success or false on failure
				// gets a result set from a prepared statement
				$result = mysqli_stmt_get_result($stmt);
				if($result) {
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
						if(md5($pass) == md5($row['senhar_userfc'])){
							$_SESSION['id_userfc']=$iduser;
							$_SESSION['login_userfc']=$row['login_userfc'];
							$_SESSION['email_userfc']=$row['email_userfc'];
							$_SESSION['admin_userfc']=$row['admin_userfc'];
							$_SESSION['grupo_userfc']=$row['grupo_userfc'];
							$_SESSION['grupo']=$row['grupo_userfc'];
							$_SESSION['id_provedor']=$row['id_provedor'];
						}else{
							$this->closeConn();
							$_SESSION['process_result'] = '<div class="notify-error">Username/Password is incorrect.</div>';
							header("Location: " . $_SERVER['HTTP_REFERER'].'?page='.$this->page);
						}
					}
					// free memory associated with the result
					mysqli_free_result($result);
				}
			}
		}
		$this->closeConn();
	}
}
?>