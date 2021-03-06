<?php
class categorias_model{

  private $db;
  private $categorias;


  private $id;
  private $name;
  private $parentcategory;



  public function __construct(){
    $this->db=Conectar::conexion();
    $this->categorias=array();
  }

  /* GETTERS & SETTERS */

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }


  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getParentcategory() {
    return $this->parentcategory;
  }

  public function setParentcategory($parentcategory) {
    $this->parentcategory = $parentcategory;
  }

  //Obtiene las categorias padre
  public function get_categoriasPadre(){

    $consulta=$this->db->query("SELECT * from CATEGORY WHERE PARENTCATEGORY IS NULL;");
    while($filas=$consulta->fetch_assoc()){
      $this->categorias[]=$filas;
    }

    return $this->categorias;

  }

  //Obtiene las categorias hijas
  public function get_categoriasHijas(){

    $consulta=$this->db->query("select * from CATEGORY where PARENTCATEGORY  =  {$this->name};");
    while($filas=$consulta->fetch_assoc()){
      $this->categorias[]=$filas;
    }
    return $this->categorias;
  }

  //Categorias para el header
  public function get_categoriasHeaderView(){
    //  $consulta=$this->db->query("select * from CATEGORY ");
    $consulta=$this->db->query("select I1.NAME,I2.ID,I2.NAME as SUBCATEGORIA from CATEGORY I1  JOIN CATEGORY I2 WHERE I1.ID = I2.PARENTCATEGORY ORDER BY I1.NAME");
    while($filas=$consulta->fetch_assoc()){
      $this->categorias[]=$filas;
    }

    return $this->categorias;

  }

  //Insertar categorias
  public function insertar_categorias() {

    if ($this->parentcategory == "NULL") {
      $sql = "INSERT INTO CATEGORY (NAME) VALUES ('{$this->name}')";
    }else {
      $sql = "INSERT INTO CATEGORY (PARENTCATEGORY ,NAME) VALUES ('{$this->parentcategory}','{$this->name}')";
    }

    $result = $this->db->query($sql);



    if ($this->db->error)
    return "$sql<br>{$this->db->error}";
    else {
      return false;
    }
  }

}
?>
