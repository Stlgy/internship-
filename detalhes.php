<?
include_once("includes/start.php");

    $pagina = $PAGINAS->obter($_GET['id']);
    $g = json_decode($pagina['ordem_multimedia'],true);
    //rsort($g['galeria']);
    //krsort($g['galeria']);
    $pieces = array_chunk($g['galeria'],ceil(count($g['galeria']) /5));


    //list($arr1,$arr2) = array_chunk($g['galeria'],ceil(count($g['galeria']) /2 ));

    //var_dump($g);
    //$firstkey =array_key_first($g['galeria']);
    //echo '<pre>';
    //var_dump($g['galeria']);
    //var_dump($pieces);
    //var_dump($firstkey);

    //print_r(array_keys($g['galeria']));
    
    //print_r(array_values($g['galeria']));
    //var_dump($arr1,$arr2);
    //echo'</pre>';

    /* echo '<pre>';
    print_r($pagina);
    echo '<pre>'; */
?>
<!DOCTYPE html>
<html>

<head>

</head>

<body class="">
    <section>
        <div class="">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>
                            <? echo $pagina['titulo'];?>
                        </h1>
                        <div class="">
                            <? echo $pagina["texto"]; ?>

                            <?php
                            $text = [];

                            $parag1 = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam imperdiet ligula leo, sit amet malesuada lacus rutrum ut. Nullam dapibus posuere enim quis facilisis.
                                    Suspendisse et dignissim ante, vel gravida orci. Cras luctus dapibus massa in dignissim. Morbi mollis at elit sed pulvinar. Morbi scelerisque condimentum felis ac facilisis. 
                                    Aenean eget erat molestie, finibus ante eget, fringilla massa.';

                            $parag2 = "Phasellus maximus suscipit nulla. Praesent orci dolor, fermentum nec est ut, volutpat varius mi. 
                                    In bibendum id nisi eget iaculis. Aliquam nec nibh et libero euismod faucibus a a ex. Proin volutpat ultricies luctus. 
                                    Proin suscipit nulla in gravida dignissim. Fusce bibendum euismod quam in finibus. Fusce at blandit nisl.";

                            $parag3 = "Curabitur lacinia tincidunt egestas. Donec consectetur diam non sem volutpat, vitae lobortis felis fermentum. 
                                    Nunc commodo tellus elementum, porta massa eu, condimentum nisi. Phasellus ultricies enim magna, et fermentum augue tempus sed. Duis vel odio tempor, congue massa ac, lacinia eros. 
                                    Vestibulum ac volutpat nunc, in congue elit. Nullam scelerisque nunc in ligula volutpat, nec fermentum eros pellentesque. Nulla dapibus at turpis dapibus eleifend. Nunc fringilla mollis urna, eget fermentum quam mollis sed.";

                            $parag4 = "Sed in scelerisque ante, in pulvinar ante. Suspendisse aliquet mattis consequat. Nullam luctus nisl ac erat dictum posuere. 
                                    Duis magna felis, interdum id feugiat non, sagittis nec leo. Maecenas tellus mauris, porttitor ut consectetur nec, suscipit vitae ipsum. Nam facilisis tellus quam, et finibus erat tristique ac. 
                                    Vivamus mauris risus, lacinia eget lobortis id, porta at nulla. Nullam eros purus, ullamcorper quis sollicitudin at, scelerisque sed magna. Sed sed tempor elit. Duis non egestas lorem. 
                                    Nullam elit odio, pretium eu felis nec, dictum condimentum ipsum. Vestibulum ornare vel mi at consequat. Cras hendrerit, magna eu sagittis pretium, risus purus laoreet ligula, molestie tempus felis augue in nunc.";

                            $parag5 = "Nam vel gravida tellus, quis gravida ipsum. Nunc nec ultricies tellus. Aenean eget metus turpis. Nunc sit amet lacinia augue. 
                                    Quisque vitae nibh dignissim nulla suscipit dictum ut at ipsum. Integer nec augue neque. Nulla eu tortor odio. Duis ultricies pellentesque ex, et vulputate est vulputate non. Aliquam quis mattis enim. Aliquam erat volutpat.";

                            $text = [
                                "parag1" => $parag1,
                                "parag2" => $parag2,
                                "parag3" => $parag3,
                                "parag4" => $parag4,
                                "parag5" => $parag5,
                            ];

                            echo '<p>' . $text["parag1"] . '</p>';
                            echo '<p>' . $text["parag2"] . '</p>';
                            echo '<p>' . $text["parag3"] . '</p>';
                            echo '<p>' . $text["parag4"] . '</p>';
                            echo '<p>' . $text["parag5"] . '</p>';

                            $fullText = $parag1 . $parag2 . $parag3 . $parag4 . $parag5;

                            ?>
                            <ul>
                                <li>
                                    <p><strong>Show first 10 characters in given text.</strong><br><br>Res:
                                        <? echo mb_substr($fullText,0,10)?>
                                    </p>
                                </li>

                                <li>
                                    <p><strong>Count word repeat - Lorem in given text .</strong><br><br>Res: </p>
                                    <?
                                            foreach ($text as $index => $item) {
                                                 echo '<p>'.$index.": ".substr_count(strtoupper($item),strtoupper("Lorem"))."<br>".'</p>';
                                            }
                                        ?>
                                </li>

                                <li>
                                    <p><strong>Show last 30 characters in given text.</strong><br><br>Rsp:
                                        <? echo substr($fullText,-30)?>
                                    </p>
                                </li>

                                <li>
                                    <p><strong>Replace every instance of word fringilla for Yennefer.</strong><br><br>Res: <br>
                                        <? echo str_replace("fringilla", '<strong>'."yennefer".'</strong>',$fullText)?>
                                        <p>
                                </li>

                                <li>
                                    <p><strong>Remove middle paragraph in given text.</strong><br><br>Res: </p>

                                    <? 
                                        $arraySize        = count($text); //retriving array length
                                        $arraySizeDivided = floor($arraySize / 2); //divide given array by 2 and round it down
                                        $arrayKeys        = array_keys($text); //get array key list
                                        $middleKey        = $arrayKeys[$arraySizeDivided]; //get middle key

                                        unset($text[$middleKey]);
                                        $text = array_values($text); //reindex array      
                                     
                                        foreach($text as $key => $value){
                                                echo '<p>'.$value.'</p>';                                             
                                        }
                                    ?>
                            </ul>
                            <h2><br>***Objects***</span></h2>
                            <?
                                    ### OBJECTS
                                    interface Drinks
                                    {
                                        public function drink();
                                    }
                                    class Bottle implements Drinks
                                    {
                                        /* Properties */
                                        public  $objectType;
                                        public  $capacity;
                                        public  $color;
                                        public  $bottleCap;
                                        public  $product;

                                        public function __construct($objectType="", $capacity="", $color="", $bottleCap="", $product="")
                                        {
                                            $this->objectType = $objectType;
                                            $this->capacity = $capacity;
                                            $this->color = $color;
                                            $this->bottleCap = $bottleCap;
                                            $this->product = $product;
                                        }
                                        public function drink(){}
                                       
                                        public function killThirst()
                                        {
                                            echo 'Ahhhh';
                                        }
                                        public function grabBottle()
                                        {
                                            echo "Grab " . $this->objectType;
                                        }
                                        public function liftBottle()
                                        {
                                            echo "Lift " . $this->objectType;
                                        }
                                        public function inclineBottle()
                                        {
                                            echo "Incline " . $this->objectType;
                                        }
                                        public function openBottle()
                                        {
                                            echo "Remove " . $this->bottleCap;
                                        }
                                        public function hasSubstance()
                                        {
                                            echo " I am ".$this->product;
                                        }
                                        
                                        
                                    }
                                    class WaterBottle extends Bottle
                                    {
                                        public function drink()
                                        {
                                            echo "Cold or Room temperature";
                                        }
                                    }
                                    class CocaCola extends Bottle
                                    {
                                        public function drink()
                                        {
                                            echo "Cold ";
                                        }
                                    }
                                    $water = new Bottle("plastic bottle","small","blue", "screwTopLid","water");
                                    $cocacola = new Bottle("glass bottle","small","blue", "screwTopLid","cocacola");
                                    $drinks = array($water,$cocacola);
                                    foreach($drinks as $drink)
                                    {
                                        $drink->drink();
                                        echo'<p>'.$drink->hasSubstance()."in a ".$drink->objectType. '</p>';
                                    }
                                    
                                ?>
                                
                            <?
                                    #### FILES
                                    echo '<h1>'."***Working with files***".'</h1>';
                                    /* 2- Write Hello Word into a .txt */

                                    $myfile = fopen($_SERVER['DOCUMENT_ROOT']."/newfile.txt","w") or die("Unable to open file");
                                    $txt = "Hello World\n";
                                    fwrite($myfile, $txt);
                                    fclose($myfile);  
                                    
                                
                                    /* 3- Read .txt content */

                                    function read($filename){
                                        $myfile = fopen($filename, "r") or die("Unable to open file");
                                        $filecontent = fread($myfile, filesize($filename));
                                        fclose($myfile);
                                        return $filecontent;
                                    }
                                    echo read("newfile.txt");
                                    echo'<br><br>';
                            
                                    /* 4- Processing CSV -method--->memory //// method--->stream*/
                                   
                                    echo'<table boder"1">';
                                
                                    $start_row = 1;
                                    if(($csv_file = fopen("book2.csv","r+"))!==FALSE){
                                        while(($read_data= fgetcsv($csv_file,100, ","))!==FALSE){
                                            $column_count = count($read_data);
                                            echo '<tr>';

                                            $start_row++;
                                            for($c=0; $c<$column_count; $c++){
                                                echo '<td>'.$read_data[$c].'</td>';
                                            }
                                            echo '</tr>';
                                            
                                        }
                                        fclose($csv_file);
                                    }
                                    echo'</table>';
                                  
                                    $csv_files = fopen('book2.csv','a');

                                    $f =['witcher', 'elf', 'rambo'];
                                    fputcsv($csv_files, $f, chr(9));
                                    fclose($csv_files); 
                                    echo'<br><br>';
                                                                       
                                ?>  
                                <?
                                    $names = array("Ana","Maria","Diogo","Ines");
                                    echo json_encode($names,JSON_FORCE_OBJECT);
                                ?>
                                <br>
                                
                                <?
                                 echo'<br><br><br>';
                                $json = '{"Ana":30, "Maria":12, "Diogo":37,"Ines":40}';

                                //var_dump(json_decode($json));
                                $array = json_decode($json,true);
                                echo $array["Ana"];
                                $obj = json_decode($json);
                                echo'<br><br>';
                                echo $obj->Maria;
                                echo'<br><br>';
                                ?>
                                <people>
                                    <person>
                                        <firstName>Maria&nbsp</firstName><lastName>Lima<br></lastName>
                                    </person>
                                    <person>
                                        <firstName>Jaime&nbsp</fistName><lastName>Andrade<br></lastName>
                                    </person>
                                    <person>
                                        <firstName>Luisa&nbsp</firstName><lastName>Silva<br></lastName>
                                    </person>
                                    <person>
                                        <firstName>Vera&nbsp</firstName><lastName>Santos<br></lastName>
                                    </person>
                                    <person>
                                        <firstName>Tatiana&nbsp</firstName><lastName>Ponte<br></lastName>
                                    </person>
                                </people>
                                <? echo'<br><br>';
                                
                                //DOMDocument to modify HTML script
                                $doc = new DOMDocument();
                                $doc->loadHTML("<html><body><h1>***parse html***</h1></body></html>");
                                echo $doc->saveHTML();
                                echo'<br><br>';
                                ?>

                                <?
                                    
                                $xml_doc = new DOMDocument();
                                $xml_doc->load('note.xml');

                                print $xml_doc->saveXML();//saveXML puts internal XML data into a data string
                                echo'<br><br>';


                                $xml_doc = new DOMDocument();
                                $xml_doc->load('note.xml');

                                $j = $xml_doc->documentElement;
                                foreach($j->childNodes AS $item){
                                    
                                   print_r($item->nodeName . " = " . $item->nodeValue.'<br>') ;
                                   
                                }
                                echo'<br><br>';

                                $path = 'controlo/';
                                $files = array_diff(scandir($path),array('.','..'));
                                echo'<pre>';
                                print_r($files);
                                echo'</pre>';

                                $dir = 'controlo/';
                                if(is_dir($dir)){
                                    if($dh = opendir($dir)){
                                        while(($file = readdir($dh)) !== false){
                                            if(is_dir($dir)){
                                                 echo $file . "<br>";
                                            }
                                           
                                        }
                                        closedir($dh);
                                    }

                                } 
                                echo'<br><br>';
                                echo getcwd();//current directory
                                 echo'<br><br>';
                                $slides =$SLIDES->obter();
                                foreach ($slides as $slide){
                                    if($slide['flag_activo']==1){
                                        echo "titulo: ". $slide['titulo']."<br>";
                                        echo "botao_texto: ". $slide['botao_texto']."<br>";
                                        echo "botao_url: ". $slide['botao_url']."<br>";
                                        echo '<img src="downloads/slides/'.$slide['id'].'/imagem1.jpg">';
                                    }
                                }
                              
                                ?>
                                
                            

                        </div>
                        
                    </div>
                    <div class="galeria">
                        <!-- $pagina["ordem_multimedia"]; -->
                        <img src="downloads/paginas/<?= $pagina['id'] ?>/imagem1.jpg">
                        <ul>
                            <?
                                foreach($g['galeria'] as $key => $value){
                                    echo'<li>'.$key.'<img src="downloads/paginas/'.$pagina['id'].'/galeria/'.$value.'"></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
    </section>




</body>

</html>
