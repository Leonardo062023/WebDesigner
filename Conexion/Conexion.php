<?php
$_SESSION['conexion']=1;
$_SESSION['BD']="PRUEBA";

class ConexionPDO
{


	public $db_serv = "localhost";
	public $db_nomb = "PRUEBA";
	public $db_usua ="root"; //Usuario base de datos
	public $db_clav ="";

	// public $db_serv = "sql107.infinityfree.com";
	// public $db_nomb = "if0_35558914_prueba";
	// public $db_usua ="si0_35558914"; //Usuario base de datos
	// public $db_clav ="NEVnNGdBPJUySW5";

	public $obj_resu; //Objeto que contiene el resultado
	/**********************************************
	 Inicializacion de variable de la base de datos
	***********************************************/
	public function MET_CONEXION(){
		try
		{
			//$this->obj_resu = new PDO($this->db_serv, $this->db_usua, $this->db_clav);
			$this->obj_resu = new PDO('mysql:host='.$this->db_serv.';dbname='.$this->db_nomb.';', $this->db_usua, $this->db_clav, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
			$this->obj_resu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);      
			// $this->obj_resu->exec("SET NAMES utf8 ");
		}
		catch(Exception $e)
		{
			$this->obj_resu = $e->getMessage();
			die($e->getMessage());
		}
		return $this->obj_resu;
	}
	/**********************************************
	 METODO DE LISTAR
	***********************************************/
	public function Listar($arg_cons){
		$loc_cone = null; //Conexion
		$loc_coma = null; //Comandos
		$loc_rows = null; //Filas de la consulta
		$loc_resu = null; //Resultado

		try{
			$loc_cone = $this->MET_CONEXION();
			$loc_coma = $loc_cone->prepare($arg_cons);
			$loc_coma->execute();

			while ($loc_rows = $loc_coma->fetch()) {
				$loc_resu[] = $loc_rows; 
			}
		}
		catch(Exception $e)
		{
			$this->obj_resu = null;
			$this->obj_resu = $e->getMessage();
		}
		return $loc_resu;
	}
	/**********************************************
	 METODO DE INSERTAR, ACTUALIZAR Y ELIMINAR
	***********************************************/	
	public function InAcEl($arg_cons, $arg_data){
		$obj_resu ="";

		$loc_cone = null; //Conexion
		$loc_coma = null; //Comandos
		try {

			$loc_cone = $this->MET_CONEXION();
			$loc_coma = $loc_cone->prepare($arg_cons);
			
			for($i=0;$i<count($arg_data);$i++) {
				$loc_coma->bindParam($arg_data[$i][0],$arg_data[$i][1]);	
			}
			if (!$loc_coma) {
				$this->obj_resu ="Error al crear el registro";
			}else{
				$loc_coma->execute();
			}

		} catch (Exception $e) {
			$obj_resu = $e->getMessage();
		}

		return $obj_resu;
	}

}
 ?>