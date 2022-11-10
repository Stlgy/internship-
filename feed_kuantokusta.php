<?
include("includes/start.php");

function marca($id) {
        GLOBAL $sys;
        $resultados = array();
        $res = SQL::run("SELECT id,nome from rocha_loja_produtos_marcas where id='$id' and flag_activo='1'");
        while ($row = $res->fetch_assoc()) {
            $row["nome"] = $sys->st_parse_idioma($row["nome"],IDIOMA);
            $resultados = $row;
        }
        return $resultados;
       }

function obterPrecos($id) {
$precos = array();
$res = SQL::run("SELECT preco from rocha_loja_produtos where id='$id'");
if ($res && $res->num_rows > 0) {
    $p = $res->fetch_assoc();
    if ($p["preco"] > 0.00) $precos[] = (float)$p["preco"];

    $res = SQL::run("SELECT preco from rocha_aux_produtos_modificadores where id_produto='$id' and stock > 0");
    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            if ($row["preco"] > 0.00) $precos[] = (float)$row["preco"];
        }
    }
}
sort($precos,SORT_NUMERIC);
return $precos;
}

function st_parse_idioma($valor,$idioma) {
      //echo $valor;
      $temp = @unserialize($valor);
      //echo str_replace("\r\n","",$temp[$idioma]);
      return($temp[$idioma]);
    }

$res = SQL::run("SELECT t1.id_categoria,
                        t3.nome as categoria_nome,
                        t3.id_cat_feed_facebook,
                        t2.id,
                        t2.nome,
                        t2.texto,
                        t2.stock_actual-t2.stock_reserve as stock_total,
                        t2.marca,t2.referencia 
                            FROM rocha_aux_categorias_produtos as t1 
                            LEFT JOIN rocha_loja_produtos as t2 ON t1.id_produto = t2.id 
                            LEFT JOIN rocha_loja_produtos_categorias as t3 ON t1.id_categoria = t3.id 
                            WHERE t2.flag_activo = 1 GROUP BY t1.id_produto");
    
   
$xml = '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
<channel>
<title>Rocha Surf Shop - Online Store Portugal - Portimão - Algarve</title>
<link>https://rochasurfshop.com/</link>
<description>Your favorite products like Surf Wear, Wetsuits, Accessories, Surf Gear, Surf &amp; SUP boards, Watches, Skates. Surf &amp; SUP lessons. Rentals. 
We have what you need.</description>';


if ($res && $res->num_rows > 0) {   
    while ($produto = $res->fetch_assoc()) { 

        $clink="";//categoria link
        if(!empty($produto["categoria_nome"])){
            $clink .= $sys->st_clean_link(st_parse_idioma($produto["categoria_nome"],"en"))."/";
        }
        $url =  "https://".$_SERVER["HTTP_HOST"]."/product/".$clink.$sys->st_clean_link(st_parse_idioma($produto["nome"],"en"))."/".$produto["id"];

        $fotos = [];

        if(file_exists("downloads/produtos/".$produto["id"]."/imagem.jpg")) $fotos[] = "downloads/produtos/".$produto["id"]."/imagem.jpg";
            $galeria = $sys->fs_dir("downloads/produtos/".$produto["id"]."/galeria");
            //fs_dir devolde o conteudo da directoria
            $mainFoto = "";
            $mainFoto = array_shift($fotos);
            if(!empty($fotos)) $mainFoto = array_shift($fotos);

            $total = $produto["stock_total"] > 0 ? 'in stock' : 'out of stock';



            $M = marca($produto["marca"]);
            $marca = empty($M["nome"]) ? 'Rocha Surf Shop' : $M["nome"];
            $marca = html_entity_decode($marca,ENT_QUOTES,"UTF-8"); 

            $M = [];

            $precos = obterPrecos($produto["id"]);                
            //st_parse_idioma devolve um array serializado o texto na lingua correcta.
            $nome = html_entity_decode(st_parse_idioma($produto["nome"],"en"),ENT_QUOTES,"UTF-8");
            $nome = ucfirst(mb_strtolower($nome,"UTF-8"));
            $nome = str_replace(["\n","\r","\r\n","  "],['','','','  '],trim($nome)); 

            $texto = st_parse_idioma($produto["texto"],"en");
            $texto = strip_tags(html_entity_decode($texto,ENT_QUOTES,"UTF-8"));
            $texto = preg_replace_callback("/(&#[0-9]+;)/", function($m) { 
                return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $texto);
            $texto = str_replace(["\n","\r","\r\n","  "],['','','','  '],$texto);

            $xml .= 
                '<item>
                    <designation><![CDATA['.$nome.']]></designation>
                    <product_url>'.$url.'</product_url>
                    <description><![CDATA['.$texto.']]></description>
                    <g:image_url>https://'.$_SERVER["HTTP_HOST"].dirname($_SERVER['PHP_SELF'])."/".$mainFoto.'</g:image_url>
                    <g:regular_price>'.$precos[0].'</g:regular_price>
                    <g:current_price>preco promocional do produto com IVA Incluido</g:current_price>
                    <g:brand><![CDATA['.$marca.']]></g:brand>
                    <g:upc_ean>codigo barras/EAN/GTIN</g:upc_ean>
                    <g:category>categoria/familia do produto</g:category>
                    <g:availability>'.$total.'</g:availability>
                    <g:stock>unidades disponiveis</g:stock>
                    <g:norma_shipping_cost>envio normal com tracking e IVA Incluido</g:norma_shipping_cost>
                    <g:min_delivery_time>tempo min dias para entrega, correio normal</g:min_delivery_time>
                    <g:max_delivery_time>tempo max dias para entrega, correio normal</g:max_delivery_time>
                    <g:min_preparation_time>tempo min dias para preparar encomenda</g:min_preparation_time>
                    <g:max_preparation_time>tempo max dias para preparar encomenda</g:max_preparation_time>
                    <g:size>tamanho</g:size>
                </item>';
        }
    }
         /*   .= Concatenation assignment*/
            $xml .= '   
</channel>
</rss>';    
    file_put_contents("feed_kuantokusta.xml",$xml);
    echo $xml;
?>
