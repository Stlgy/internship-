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
         
         if ($res->num_rows > 0)
         {
            $i = 0;
             
            while($row = $res->fetch_assoc())
            {
            ?>
                   // <tr class="<?php $i % 2 == 0 ? echo 'even' : echo 'odd' ?> ">
                  <tr class="<?php $i % 2 == 0 ? even : odd">
                    <td>$row['id_produto']</td>
                    <td>$row['id_cliente']</td>
                    <td>$row['referencia']</td>
                    <td>$row['codigo_barras']</td>
                    <td>$row['nome']</td>
                    <td>$row['descricao']</td>
                    <td>$row['link']</td>
                    <td>$row['link_imagem']</td>
                    <td>$row['disponibilidade']</td>
                    <td>$row['preco']</td>
                    <td>$row['preco_promocao']</td>
                    <td>$row['marca']</td>
                    <td>$row['marca_vendedor']</td>
                    <td>$row['categoria']</td>
                    <td>$row['stock']</td>
                    <td>$row['preco_portes_normal']</td>
                    <td>$row['prazo_entrega_normal']</td>
                    <td>$row['prazo_entrega-min']</td>
                    <td>$row['prazo_entrega_max']</td>
                    <td>$row['prazo_preparacao_min']</td>
                    <td>$row['prazo_preparacao_max']</td>
                    <td>$row['tamanho']</td>
                    <td>$row['condicao']</td>
                    <td>$row['cor']</td>
                    <td>$row['faixa_etaria']</td>
                    <td>$row['genero']</td>
                  </tr>
             <?php
             $i++
            }
            ?>
    </table>
</body>

</html>
