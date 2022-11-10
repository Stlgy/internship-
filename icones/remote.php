<?
    include("../../base.php");
    $IDIOMAS = json_decode($sys->cfg_ler("_configs","idiomas"),true);
    require_once("classe.php");
    $caminho = explode('/',__DIR__);
	$pasta = array_pop($caminho);
	$obj = new $pasta;
    $op = filter_var($_REQUEST["op"],FILTER_SANITIZE_STRING);

    if ($op == 'listar') {
        $resultados = array();
        $registos = $obj->obter();
        foreach($registos as $registo) {
            $resultados[] = $registo;
        }
        echo json_encode($registos);
    }
    if ($op == 'apagar') {
        $ids = $_REQUEST["ids"];
        if ($obj->apagar($ids,"")) echo 1;
        else echo 0;
    }
    if($op == 'toggle') {
        $id = $_REQUEST["id"];
        $estado = $_REQUEST["estado"];
        if($obj->toggle($id, $estado)) echo 1;
        else echo 0;
    }
    if ($op == 'reorder') {
        $ids = $_REQUEST["ids"];
        if ($obj->reordenar($ids,"")) echo 1;
        else echo 0;
    }

?>
