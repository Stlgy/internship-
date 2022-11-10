<?php
    class icones extends sys_utils {
        public $tabela = "_icones";

        public function __construct() {
			parent::__construct();
			if (!file_exists(PASTA.ltrim($this->tabela,'_'))) mkdir(PASTA.ltrim($this->tabela,'_'),0777);
		}

        /**
         * Areas
         * */
        public function gravar() {
            $titulo = array();
            $texto = array();

            foreach(IDIOMAS as $codigo => $idioma) {
                $titulo["$codigo"] = isset($_POST["titulo_".$codigo]) ? filter_var($_POST["titulo_".$codigo],FILTER_SANITIZE_STRING) : '';
                $texto["$codigo"] = isset($_POST["texto_".$codigo]) ? $this->st_clean_html($_POST["texto_".$codigo]) : '';
            }
            $flag_activo = (int)$_POST["flag_activo"];
            $icone = isset($_POST["icone"]) ? filter_var($_POST["icone"],FILTER_SANITIZE_STRING) : '';

            if (isset($_GET["id"])) {
                $modo = "edit";
                $query = "UPDATE ".BDPX.$this->tabela." SET flag_activo=$flag_activo, titulo='".json_encode($titulo,JSON_UNESCAPED_UNICODE)."', texto='".json_encode($texto,JSON_UNESCAPED_UNICODE)."', icone='$icone' WHERE id='".(int)$_GET["id"]."'";
            } else {
                $modo = "ins";
                $ordem = $this->db_max_ordem($this->tabela);
                $query = "INSERT INTO ".BDPX.$this->tabela." VALUES ('','$flag_activo','".json_encode($titulo,JSON_UNESCAPED_UNICODE)."','".json_encode($texto,JSON_UNESCAPED_UNICODE)."', '$icone', '$ordem','".json_encode(array(),JSON_UNESCAPED_UNICODE)."')";
            }
            $res = SQL::run($query);
            $ID = isset($_GET["id"]) ? (int)$_GET["id"] : $ID = isset($_GET["id"]) ? (int)$_GET["id"] : SQL::$insert_id;;

            $this->handleSingleUpload($this->tabela,$ID);

            $this->db_last_op($res,$modo);
            //$this->handleSEO($this->tabela,$ID);
        }
        public function obter($id=0,$oneLang=true) {

            $resultados = array();
            $where = "";
            if (!CONTROLO) $where = " WHERE flag_activo = '1' ";
            if($id == 0) $query = "SELECT * FROM ".BDPX.$this->tabela."$where ORDER BY ordem";
			else $query = "SELECT * FROM ".BDPX.$this->tabela." WHERE id = '$id'";
			$res = SQL::run($query);
			if ($res && $res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
				    if ($oneLang) $row["titulo"] = $this->st_parse_idioma($row["titulo"],IDIOMA);
				    else $row["titulo"] = json_decode($row["titulo"],true);
				    if ($oneLang) $row["texto"] = $this->st_parse_texto($this->st_parse_idioma($row["texto"],IDIOMA));
				    else $row["texto"] = json_decode($row["texto"],true);

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
            if ($contexto == "NOTUSED") $tabela = "";

            $sucesso = false;
            if(is_array($ids) && !empty($ids)) {
                $sucesso = true;
                foreach ($ids as $id) {
                    $tempRes = SQL::run("DELETE from ".BDPX."$tabela where id='".(int)$id."'");
                    if (file_exists(PASTA.ltrim($tabela,'_').'/'.$id)) $this->fs_deltree(PASTA.ltrim($tabela,'_').'/'.$id);
                    if(!$tempRes && $sucesso) $sucesso = false;
                }
            }
            return $sucesso;
        }
        public function toggle($id,$estado,$contexto='') {
            $tabela = $this->tabela;
            if ($contexto == "NOTUSED") $tabela = "";

            $ide = filter_var($id, FILTER_SANITIZE_STRING);
            $state = filter_var($estado, FILTER_SANITIZE_STRING);
            $result = SQL::run("UPDATE ".BDPX."$tabela set flag_activo = '$state' where id='$ide'");
            return $result;
        }
        public function reordenar($ids,$contexto='') {
            //é importante colocar o _ antes do nome da tabela
            $tabela = $this->tabela;
            if ($contexto == "NOTUSED") $tabela = "";

            $sucesso = false;
            if(is_array($ids) && !empty($ids)) {
                $sucesso = true;
                foreach ($ids as $ind => $id) {
                    $ordem = $ind + 1;
                    $tempRes = SQL::run("UPDATE ".BDPX."$tabela SET ordem = ".(int)$ordem." WHERE id='".(int)$id."'");
                    if(!$tempRes && $sucesso) $sucesso = false;
                }
            }
            return $sucesso;
        }
    }

?>
