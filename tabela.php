<?php
set_time_limit(0);
ini_set("display_errors", "On"); //faz com que o PHP emita todos os erros que existam durante a execução do script
ini_set("display_startup_errors", "On"); //faz com que o PHP emita todos os erros que estejam a impedir a execução do script
error_reporting(E_ALL); //ativar a emissão de todo o tipo de mensagens de aviso e erros.
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
   <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
            
        }
          
        th, td {
            text-align: left;
            padding: 8px;
            text-align:center;
            border:1px solid currentcolor;
        }
        tr:nth-child(even) {background-color: lightgrey;}
      
   
   </style>
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
         
            if ($res && $res->num_rows > 0){
                $i = 0;
                while($row = $res->fetch_assoc()){
                    
        ?>
            <tr class = " <?php $i % 2 == 0 ? 'even' :  'odd' ?> ">
                        <?php
                        echo "<td>" . $row['id_produto']."</td>";
                        echo "<td>" . $row['id_cliente']."</td>";
                        echo "<td>" . $row['referencia']."</td>";
                        echo "<td>" . $row['codigo_barras']."</td>";
                        echo "<td>" . $row['nome']."</td>";
                        echo "<td>" . $row['descricao']."</td>";
                        echo "<td>" . $row['link']."</td>";
                        echo "<td>" . $row['link_imagem']."</td>";
                        echo "<td>" . $row['disponibilidade']."</td>";
                        echo "<td>" . $row['preco']."</td>";
                        echo "<td>" . $row['preco_promocao']."</td>";
                        echo "<td>" . $row['marca']."</td>";
                        echo "<td>" . $row['marca_vendedor']."</td>";
                        echo "<td>" . $row['categoria']."</td>";
                        echo "<td>" . $row['stock']."</td>";
                        echo "<td>" . $row['preco_portes_normal']."</td>";
                        echo "<td>" . $row['prazo_entrega_min']."</td>"; 
                        echo "<td>" . $row['prazo_entrega_max']."</td>";
                        echo "<td>" . $row['prazo_preparacao_min']."</td>";
                        echo "<td>" . $row['prazo_preparacao_max']."</td>";
                        echo "<td>" . $row['tamanho']."</td>";
                        echo "<td>" . $row['condicao']."</td>";
                        echo "<td>" . $row['cor']."</td>";
                        echo "<td>" . $row['faixa_etaria']."</td>";
                        echo "<td>" . $row['genero']."</td>";
            echo"</tr>";
            
                $i++;
                }
            }
            ?>
    </table>
</body>
</html>
