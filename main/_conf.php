<?php
//
header('Content-Type: text/html; charset=utf-8');
$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 'home.php';
$nomeSession='authAdmin';
session_name($nomeSession);
session_start($nomeSession);
// BOLETO FÁCIL
$token_acesso_boleto_facil='632249530ccce95c6ea3d8602a4cf64d';
$token_boletofacil='FCE0C3413FA30667A09E4FDE6395FA65B38031C010172E0B0336926431D5DDA9';
//$token_boletofacil='CCA0BCEA656E91A7C9D5A531CCF7635AFA5F26180F44C4AC'; // TESTES
$url_boletofacil_gerar='https://www.boletobancario.com/boletofacil/integration/api/v1/issue-charge';
//$url_boletofacil_gerar='https://sandbox.boletobancario.com/boletofacil/integration/api/v1/issue-charge'; // TESTES
$url_boletofacil_verificar='https://www.boletobancario.com/boletofacil/integration/api/v1/fetch-payment-details';
//$url_boletofacil_verificar='https://sandbox.boletobancario.com/boletofacil/integration/api/v1/fetch-payment-details'; //TESTES
$url_boletofacil_consultar='https://www.boletobancario.com/boletofacil/integration/api/v1/list-charges';
//$url_boletofacil_consultar='https://sandbox.boletobancario.com/boletofacil/integration/api/v1/list-charges'; //TESTES
$url_boletofacil_saldo='https://www.boletobancario.com/boletofacil/integration/api/v1/fetch-balance';
$url_boletofacil_transferir='https://www.boletobancario.com/boletofacil/integration/api/v1/request-transfer';
$url_boletofacil_cancelar='https://www.boletobancario.com/boletofacil/integration/api/v1/cancel-charge';
//
$textAtua = array("-", "(", ")", ".", ",", "/");
$textNew   = array("", "", "", "", "", "");
include("_funcoes.php");
//
class PDO_instruction{

	/** @var object $stmt Represents a prepared statement. */
	protected $stmt;
	/** @var object $pdo PDO connection. */
	private $pdo;
	/** @var array $resp This is associated result of statement. */
	protected $resp;

	/**
	 * PDO Connection.
	 * @access public
	 * @param string|null $database Set DBMS
	 * @return bool
	 */
	function con_pdo($database='mysql'){
		$host_sql = "localhost";
		$user_sql = "provedor_facil";
		$pass_sql = "amb8484";
		$bd_sql = "provedor_facil";

		try{
			$this->pdo = new PDO($database.':host='.$host_sql.';dbname='.$bd_sql, $user_sql, $pass_sql, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		}
		catch(PDOException $e){
			echo 'Error!: '.$e->getMessage().'<br>';
			return false; die();
		}
		return true;
	}

	/**
	 * Close PDO Connection.
	 * @access public
	 * @return void
	 */
	function end_con_pdo(){
		$this->stmt = null;
		$this->pdo = null;
	}

	/**
	 * SELECT functions (DBMS), this function prepare and execute statements, return array of SELECT results.
	 * @access public
	 * @param string $query Query of DBMS. Setin bind params use '?', example <http://php.net/manual/pt_BR/pdostatement.bindparam.php>
	 * @param array|null $params Params bind query | null if don't have any param.
	 * @return false|array
	 */
	function select_pdo($query='', $params=[]){
		$this->resp = array();

		$this->stmt = $this->pdo->prepare($query);
		/* http://php.net/manual/pt_BR/pdostatement.bindparam.php */
		$this->stmt->execute($params);

		$error = $this->stmt->errorInfo();
		if($error[0] != 0)
			echo 'Error Query: ('.$this->stmt->errorCode().') '.$error[2].'<br>';

		while($result = $this->stmt->fetch(PDO::FETCH_ASSOC)){
			$this->resp[] = $result;
		}

		if(!$this->resp) return false;
		else return $this->resp;
	}

	/**
	 * Another functions (DBMS), like: DELETE, UPDATE, CREATE (TABLE) and DROP (TABLE).
	 * @access public
	 * @param string $query Query of DBMS. Setin bind params use '?', example <http://php.net/manual/pt_BR/pdostatement.bindparam.php>
	 * @param array|null $params Params bind query | null if don't have any param.
	 * @return bool
	 */
	function sql_pdo($nomeTable='',$nomeId='',$idTable=false,$var=[]){
		$this->resp = false;
		$this->insert = false;
		if($idTable && $idTable!=''){
			$this->result = $this->select_pdo("SELECT * FROM $nomeTable WHERE $nomeId= ?", array($idTable))[0];
			if(count($this->result)>0){
				$this->sql="UPDATE $nomeTable SET ";
				$this->params=array();
				foreach ($this->result as $col=>$value){
					if(isset($var[$col]) && $var[$col]!=$value){
						$this->sql.="`$col`=:$col,";
						if (strpos($col, "data_") !== false && $var[$col]!='') {
							$var[$col]=converterDataSimples($var[$col]);
						}
						if (strpos($col, "valor_") !== false OR strpos($col, "porcentagem_") !== false) {
							$var[$col]=str_replace(',', '.',$var[$col]);
						}
						if (!(strpos($col, "datatime_") !== false) && !(strpos($col, "data_") !== false)) {
							$var[$col] = str_replace($chars, "", $var[$col]);
						}
						$this->params[":$col"]=$var[$col];
					}
				}
				if(count($this->params)>0){
					$this->params[":$nomeId"]=$idTable;
					$this->sql=substr($this->sql,0,-1);
					$this->sql.=" WHERE `$nomeId`=:$nomeId";
					//EXECUTE UPDATE
					$this->stmt = $this->pdo->prepare($this->sql);
					$this->resp = $this->stmt->execute($this->params);
					//
					$error = $this->stmt->errorInfo();
					if($this->resp) 
						$this->resp=array(true,'Alterado com Sucesso',$idTable,false);
					else
						$this->resp=array(false,'Error Update Query: ('.$this->stmt->errorCode().') '.$error[2].'<br>');
				}else{
					$this->resp=array(true,'Nada para alterar');
				}
			}else{
				$this->insert=true;
			}
		}else{
			$this->insert=true;
		}
		if($this->insert){
			$var['id_provedor']=$_SESSION['id_provedor'];
			$var['grupo_parceria']=$_SESSION['grupo'];
			$this->result = $this->get_fields_pdo($nomeTable);
			if(count($this->result)>0){
				$this->sql="INSERT $nomeTable SET "; 
				$this->params=array();
				foreach ($this->result as $id){
					$this->sql.="$id=:$id,";
					if (strpos($id, "datatime_") !== false) {
						if($var[$id]==""){
							$var[$id]=date('Y-m-d H:i:s');
						}
					}
					if (strpos($id, "data_") !== false) {
						$var[$id]=converterDataSimples($var[$id]);
					}
					if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
						$var[$id]=str_replace(',', '.',$var[$id]);
					}
					if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
						$var[$id] = str_replace($chars, "", $var[$id]);
					}
					$this->params[":$id"]=$var[$id];
				} 
				if(count($this->params)>0){
					$this->sql=substr($this->sql,0,-1);
					//echo "sql:".$this->sql;
					//print_r($this->params);
					//EXECUTE INSERT
					$this->stmt = $this->pdo->prepare($this->sql);
					$this->stmt->execute($this->params);
					$error = $this->stmt->errorInfo();
					if($error[0] != 0)
						$this->resp=array(false,'Error Insert Query: ('.$this->stmt->errorCode().') '.$error[2].'<br>');
					else
						$this->resp=array(true,'Cadastrado com Sucesso id:'.$this->pdo->lastInsertId(),$this->pdo->lastInsertId(),true);
				}else{
					$this->resp=array(false,'Error Insert Query: (Nada para inserir)');
				}
			}
		}
		return $this->resp;
	}
	//
	//
	function get_fields_pdo($table){
		$this->resp = array();
		$this->stmt = $this->pdo->prepare("DESCRIBE $table");
		/* http://php.net/manual/pt_BR/pdostatement.bindparam.php */
		$this->stmt->execute();
		//
		$this->resp = $this->stmt->fetchAll(PDO::FETCH_COLUMN);
		//
		if(!$this->resp) return false;
		else return $this->resp;
	}
	//
	//
	function del_pdo($query='', $params=[]){
		$this->resp = array();
		//EXECUTE DELETE
		//print_r($params);
		$this->stmt = $this->pdo->prepare($query);
		$this->stmt->execute($params);
		$error = $this->stmt->errorInfo();
		//echo $this->pdo->lastInsertId();
		if($error[0] != 0){
			$this->resp=array(false,'Error delete Query: ('.$this->stmt->errorCode().') '.$error[2].'<br>');
			//print_r($this->resp);
		}else
			$this->resp=array(true,'Deletado com Sucesso',$this->pdo->lastInsertId());
		//
		if(!$this->resp) return false;
		else return $this->resp;
	}
}
/* Example (PDO_instruction) *
 $pdo = new PDO_instruction();
 $pdo->con_pdo();
 $resp = $pdo->select_pdo('SELECT * FROM tabela WHERE id_tabela < ?', array('10'));
 var_dump($resp);
 $pdo->end_con_pdo();
 //*/
?>