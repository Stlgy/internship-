<?php
    class paginas extends sys_utils {
        public $tabela = "_paginas";

        public function __construct() {
			parent::__construct();
			if (!file_exists(PASTA.ltrim($this->tabela,'_'))) mkdir(PASTA.ltrim($this->tabela,'_'),0777);
		}
        /**
         * Só para Páginas
         * */
        public function gravar(){

            $titulo = array();
            $texto = array();
         
            
            foreach(IDIOMAS as $codigo =>$idioma){
                $titulo["$codigo"] = isset($_POST["titulo_".$codigo]) ? filter_var($_POST["titulo_".$codigo],FILTER_SANITIZE_STRING) : '';
                $texto["$codigo"]  = isset($_POST["texto_".$codigo])  ? $this->st_clean_html($_POST["texto_".$codigo]) : '';
            }
            if(isset($_GET["id"])){
                $modo   = "edit";
                $query = "UPDATE ".BDPX.$this->tabela." set flag_activo='1',texto='".json_encode($texto,JSON_UNESCAPED_UNICODE)."',titulo='".json_encode($titulo,JSON_UNESCAPED_UNICODE)."' where id='".(int)$_GET["id"]."'";
                
            }else{
                $modo = "ins";
                $ordem = $this->db_max_ordem($this->tabela);
                $query = "INSERT INTO ".BDPX.$this->tabela." VALUES ('','1','".json_encode($titulo,JSON_UNESCAPED_UNICODE)."','".json_encode($texto,JSON_UNESCAPED_UNICODE)."','$ordem','".json_encode(array(),JSON_UNESCAPED_UNICODE)."')";
                
                
                
            }
            $res = SQL::run($query);
            //echo SQL::$error;
           
            
            $ID =isset($_GET["id"]) ? (int)$_GET["id"] : $ID = isset($_GET["id"]) ? (int)$_GET["id"] : SQL::$insert_id;
            
            $this->handleSingleUpload($this->tabela,$ID);
            $this->handlePastaUpload($this->tabela,$ID);
            $this->db_last_op($res,$modo);
            SEO::gravar($ID,$this->tabela);
            
        }
        public function obter($id=0,$oneLang=true) {

            //Se o id não for numerico, procura o url definido no _seo_urls
            $id = SEO::identRegisto($id,$this->tabela);

            $resultados = array();
            if($id == 0) $query = "SELECT * FROM ".BDPX.$this->tabela." ORDER BY ordem";
			else $query = "SELECT * FROM ".BDPX.$this->tabela." WHERE id = '$id'";
			$res = SQL::run($query);
			if ($res && $res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
				    if ($oneLang) $row["titulo"] = $this->st_parse_idioma($row["titulo"],IDIOMA);
				    else $row["titulo"] = json_decode($row["titulo"],true);
				    if ($oneLang) $row["texto"] = $this->st_parse_texto($this->st_parse_idioma($row["texto"],IDIOMA));
				    else $row["texto"] = json_decode($row["texto"],true);

				    //Faz set ao $row[_url] se houver seo_url
				    $row["_url"] = SEO::identURL($row["id"],$this->tabela);

                    if($id == 0) $resultados[] = $row;
                    else $resultados = $row;
				}
			}
			return($resultados);
        }
        /**
         * Genéricas
         * */
        public function apagar($ids,$contexto='') {
            //é importante colocar o _ antes do nome da tabela
            $tabela = $this->tabela;
            if ($contexto == "cat") $tabela = "_blogs_categorias";

            $sucesso = false;
            if(is_array($ids) && !empty($ids)) {
                $sucesso = true;
                foreach ($ids as $id) {
                    $tempRes = SQL::run("DELETE from ".BDPX."$tabela where id='".(int)$id."'");
                    //$tempRes2 = SQL::run("DELETE from ".BDPX."_seo_urls WHERE id_tabela='".(int)$id."' AND tabela='$tabela'");
                    if (file_exists(PASTA.ltrim($tabela,'_').'/'.$id)) $this->fs_deltree(PASTA.ltrim($tabela,'_').'/'.$id);
                    if(!$tempRes && $sucesso) $sucesso = false;
                    SEO::apagar($id,$tabela);
                }
            }
            return $sucesso;
        }
        public function toggle($id,$estado,$contexto='') {
            $tabela = $this->tabela;
            if ($contexto == "NOTUSED") $tabela .= "";

            $id = filter_var($id, FILTER_SANITIZE_STRING);
            $state = filter_var($estado, FILTER_SANITIZE_STRING);
            $result = SQL::run("UPDATE ".BDPX."$tabela set flag_activo = '$state' where id='$id'");
            return $result;
        }
		public function mod_SEO($id,$tabela) {
        	$modulo = ['seo_title'=>'','seo_description'=>'','seo_keywords'=>'','og_title'=>'','og_description'=>'','twit_title'=>'','twit_description'=>'',"seo_extra_tags" => []];

            if ($this->tabela == $tabela) {
        	    $registo = $this->obter($id);
            }


            $modulo["seo_title"] = $this->st_crop_sentence($registo["titulo"],65,"");
            $modulo["seo_description"] = $this->st_crop_sentence(strip_tags($registo["texto"]),170,"");
            $modulo["og_title"] = $modulo["seo_title"];
            $modulo["og_description"] = $modulo["seo_description"];
            $modulo["twit_title"] = $modulo["seo_title"];
            $modulo["twit_description"] = $modulo["seo_description"];

        	return $modulo;
        }
    }

?>
