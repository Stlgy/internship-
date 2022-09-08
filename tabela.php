<?
set_time_limit(0);
   define('BDS','localhost');
   define('BDN','ifreshhost15_estagio');
   define('BDU','ifreshhost15_estagio');
   define('BDP','agosto2022#');
   define('BDPX','exportador');
   define('IDIOMA',"pt");

   require '../vendor/autoload.php';

   include("../includes/class_utils.php");

?>
<!doctype html>
<html lang="en">

<head>
   <title>Products Table</title>
   
</head>

<body>
    <table>
        <tr>
            <th>id_produto</th>
            <th>id_cliente</th>
            <th>referencia</th>
            <th>codigo_barras</th>
            <th>nome</th>
            <th>descricao</th>
            <th>link</th>
            <th>link_imagem</th>
            <th>disponibilidade</th>
            <th>preco</th>
            <th>preco_promocao</th>
            <th>marca</th>
            <th>marca_vendedor</th>
            <th>categoria</th>
            <th>stock</th>
            <th>preco_portes_normal</th>
            <th>prazo_entrega_normal</th>
            <th>prazo_entrega-min</th>
            <th>prazo_entrega_max</th>
            <th>prazo_preparacao_min</th>
            <th>prazo_preparacao_max</th>
            <th>tamanho</th>
            <th>condicao</th>
            <th>cor</th>
            <th>faixa_etaria</th>
            <th>genero</th>
        </tr>
         <?php
         $res = SQL::run("SELECT * FROM ".BDPX."_produtos");
            if ($res->num_rows >0){
                $i = 0;
                while($row = $res->fetch_assoc()){
                    if($i %2 == 0){
                        
                        echo <tr class ="even"><td><?php $row['id_produto'] ?> </td></tr >
                    }else{
                        ?>
                        <tr class="odd"><td><?php $row['id_produto'] ?>
                        </td></tr >
                        
                 }
                 $i++;
                }
                
            }
            ?>
    </table>
</body>

</html>
