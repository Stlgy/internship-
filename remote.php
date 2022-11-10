<?
    include("base.php");

    //use Gettext\Translations;


    $quality = 72;

        //para a criação do ficheiro de tradução
    function isInString($string,$array) {
        foreach ($array as $ptrn) {
            if (strstr($string, $ptrn)) return true;
        }
        return false;
    }

    if(!empty($_SERVER["HTTP_REFERER"])) if(strstr($_SERVER["HTTP_REFERER"], $_SERVER["HTTP_HOST"])) {

        $cmd = isset($_REQUEST["cmd"]) ? filter_var($_REQUEST["cmd"]) : '';

        if ($cmd == 'vrfSeoUrl') {
            $urles = array();
            $resultado = 'false';
            $url = filter_var($_POST["seo_url"],FILTER_SANITIZE_STRING);
            $id = (int)$_POST["id"];
            $tabela = filter_var($_POST["tabela"],FILTER_SANITIZE_STRING);
            $res = SQL::run("SELECT url from ".BDPX."_seo_urls WHERE id_tabela != $id AND tabela != $tabela");
            if ($res && $res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $c = json_decode($row["url"],true);
                    foreach ($c as $u) {
                        $urles[] = $u;
                    }
                }
            }
            if (!in_array($url,$urles)) $resultado = 'true';
            echo $resultado;
        }

        if ($cmd === 'getJStrans') {
        	//procedimento para obter as traduções em javascript
        	$trans = array(
        	    "i18n_1" => _("Aviso"),
        		"i18n_2" => _("Endereços válidos começam por http:// ou https://"),
        		"i18n_3" => _("Sucesso"),
        		    /** imagens **/
        		"i18n_4" => _("A imagem que está a tentar colocar não tem as dimensões pretendidas.<br>Por favor envie uma imagem com {W}{H}."),
        		"i18n_5" => _("de largura"),
        		"i18n_6" => _("de altura"),
        		"i18n_7" => _("e"),
        		"i18n_8" => _("A imagem que está a tentar colocar não tem as dimensões pretendidas.<br>Por favor envie uma imagem com pelo menos {W}{H}.<br><br>A sua imagem tem <b>{W2}{H2}</b>."),
        		"i18n_9" => _("Atingiu o limite máximo de {X} imagens."),
        		"i18n_10" => _("Não tem uma imagem gravada."),
        		"i18n_11" => _("Tem a certeza?"),
        		"i18n_12" => _("A imagem será apagada definitivamente."),
        		"i18n_13" => _("Sim, apagar!"),
        		"i18n_14" => _("Imagem apagada com sucesso."),
        		"i18n_15" => _("Houve um erro ao apagar a imagem."),
        		"i18n_16" => _("Cancelar"),
        		"i18n_17" => _("O ficheiro será apagado definitivamente."),
        		"i18n_18" => _("Houve um erro ao apagar o ficheiro."),
        		"i18n_19" => _("Ficheiro apagado com sucesso."),
                "i18n_20" => _("Não preencheu todos os campos obrigatórios!"),
                "i18n_21" => _("Se apagar estes registos não os poderá recuperar."),
                "i18n_22" => _("Apagados!"),
                "i18n_23" => _("Os seus registos foram apagados."),
        	);
        	echo json_encode($trans);
        }

        if ($cmd === 'getJuice') { echo UNIQ; }

        if ($cmd === 'login') {
            //print_r($_POST);
        	$user = filter_var($_POST["user"],FILTER_SANITIZE_STRING);
        	$pass = filter_var($_POST["pass"],FILTER_SANITIZE_STRING);
        	$resolution = filter_var($_POST["resolution"],FILTER_SANITIZE_STRING);
        	$q = filter_var($_POST["q"],FILTER_SANITIZE_STRING);
        	if($q == UNIQ) {
        	    echo $usr->doLogin($user, $pass, $resolution);
        	} else {
        	    echo 0;
        	}
        }

        if($cmd === 'acceptTerms') {
            $resultado = 0;

            $resultado = $usr->acceptTerms();

            echo $resultado;
        }

        if ($cmd == 'legendar') {
            $imagem = filter_var($_POST["file"],FILTER_SANITIZE_STRING);

            $legenda = array();
			//verificar se existem legendas
			foreach(IDIOMAS as $codigo => $idioma) {
				//echo "imagem_legenda_".$codigo."_".($numero-1)."<br>";
				$campo = 'imagem_legenda_'.$codigo;
				if (isset($_POST["$campo"])) {
					$legenda["$codigo"] = filter_var($_POST["$campo"],FILTER_SANITIZE_STRING);
				}
			}

			if (!strstr($imagem,"temp/")) {
			    $imagem = "../".$imagem;
			}
		    if (file_exists($imagem) && count($legenda) > 0) {
		        $IMG = new sys_imagens($imagem);
				$IMG->setLegenda(json_encode($legenda));
				unset($IMG);
                echo 1;
		    }
		    else {
		        echo 0;
		    }
        }

        if ($cmd == 'apagarpasta') {
            $pasta = filter_var($_POST["pasta"],FILTER_SANITIZE_STRING);
            if (!strstr($pasta,"temp/")) {
			    $tipo = filter_var($_POST["tipo"],FILTER_SANITIZE_STRING);
                $pasta = PASTA.$pasta."/".$tipo;
			}

			$files = $sys->fs_dir($pasta);
            if (count($files) > 0) {
                foreach($files as $file) {
                    unlink($file["file"]);
                }
            }
        }

        if ($cmd == 'apagarfile') {
            $file = filter_var($_POST["file"],FILTER_SANITIZE_STRING);

            if (!strstr($file,"temp/")) $file = "../".$file;

            if (file_exists($file)) unlink($file);

            $ext = pathinfo($file,PATHINFO_EXTENSION);
            $original = str_replace(".".$ext, "_original.".$ext, $file);
            if (file_exists($original)) unlink($original);

            echo 1;
        }

        if ($cmd == 'apagarficheiro') {
            $file = filter_var($_POST["file"],FILTER_SANITIZE_STRING);

            if (strstr($file,"downloads/")) {
			    $file = "../..".$file;
			}
			else{
			    $file = "temp/".$file;
			}

            if (file_exists($file)) {
                unlink($file);
                echo 1;
            }
            else{
                echo 0;
            }
        }

        if ($cmd == 'updateOrdemM') {
            $pasta = filter_var($_POST["pasta"],FILTER_SANITIZE_STRING);
            $tabela = filter_var($_POST["tabela"],FILTER_SANITIZE_STRING);
            $tipo = filter_var($_POST["tipo"],FILTER_SANITIZE_STRING);
            $id = filter_var($_POST["id"],FILTER_SANITIZE_STRING);

            $res = SQL::run("SELECT ordem_multimedia from ".BDPX.$tabela." WHERE id = '$id'");
            if ($res && $res->num_rows > 0) {
                $registo = $res->fetch_assoc();
                $ordem_actual = json_decode($registo["ordem_multimedia"],true);

                $ficheiros = glob(str_replace("//","/",$pasta."/*.*"));
                if (count($ordem_actual) == 0) {
                    foreach($ficheiros as $ficheiro) {
                        $ordem_actual["$tipo"][] = basename($ficheiro);
                    }
                }
                else {

                    //limpar o array de ficheiros inexistentes
                    $nova_ordem_actual = [];
                    foreach($ordem_actual["$tipo"] as $ficheiro) {
                        if (file_exists(str_replace("//","/",$pasta."/".$ficheiro))) {
                            $nova_ordem_actual[] = $ficheiro;
                        }
                    }
                    $ordem_actual["$tipo"] = $nova_ordem_actual;

                    $add = [];
                    foreach($ficheiros as $ficheiro) {
                        $f = basename($ficheiro);
                        if (!in_array($f,$ordem_actual)) {
                            $add[] = $f;
                        }
                    }
                    if (count($add) > 0) {
                        foreach($add as $f) {
                            $ordem_actual["$tipo"][] = $f;
                        }
                    }
                }

                $ordem_actual["$tipo"] = array_unique($ordem_actual["$tipo"]);

                SQL::run("UPDATE ".BDPX.$tabela." SET ordem_multimedia='".json_encode($ordem_actual,JSON_UNESCAPED_UNICODE)."' WHERE id = '$id'");
            }
        }

        if ($cmd === 'verpasta') {
            $pasta = filter_var($_POST["pasta"],FILTER_SANITIZE_STRING);

            $ordem = array();

            if (!strstr($pasta,"temp")) {
                $tipo = filter_var($_POST["tipo"],FILTER_SANITIZE_STRING);
                    //inferir o ID e a tabela de onde vamos ler a ordem
                $ID = preg_replace('/[^0-9]/',"",$pasta);
				$TABELA = preg_replace('/[^a-z|_]/',"",$pasta);

				    //obter a ordem multimedia
                $res = SQL::run("SELECT ordem_multimedia from ".BDPX."_".$TABELA." WHERE id = '$ID'");
				if ($res && $res->num_rows > 0) {

					$c = $res->fetch_assoc();
					$c = json_decode($c["ordem_multimedia"],true);
					if (count($c) > 0) {
					    $ordem = $c[$tipo];
					}
				}
                $pasta = PASTA."/".$pasta."/".$tipo;
            }

            $pasta_info = array(
                "ficheiros" => array(),
                "tamanho" => 0
            );

            if (file_exists($pasta)) {
                $opts = array("legenda","bytes","data");
                $pasta_info["ficheiros"] = $sys->fs_dir($pasta,$opts,$ordem);

                if (!strstr($pasta,"temp")) {
                    //fix dos caminhos
                    $new_ficheiros = array();
                    foreach($pasta_info["ficheiros"] as $ficheiro) {
                            //shitty hack
                        $ficheiro["file"] = str_replace("./","",$sys->fs_getRelativePath(dirname(PASTA),$ficheiro["file"]));
                        $new_ficheiros[] = $ficheiro;
                    }
                    $pasta_info["ficheiros"] = $new_ficheiros;
                }

                if (count($pasta_info["ficheiros"]) > 0) {
                    foreach($pasta_info["ficheiros"] as $f) {
                        $pasta_info["tamanho"] += $f["bytes"];
                    }
                }
            }
            echo json_encode($pasta_info);
        }

        if ($cmd === 'copiaficheiro') {
            $ficheiros = explode("@",urldecode(filter_var($_POST["ficheiros"],FILTER_SANITIZE_STRING)));
                //não existe pasta defaulta para o temp
                    //em galerias a pasta ir´á sempre existir
            $pasta = isset($_POST["pasta"]) ? filter_var($_POST["pasta"],FILTER_SANITIZE_STRING) : 'temp/';
            $dim = explode(",",filter_var($_POST["dim"],FILTER_SANITIZE_STRING));
            $low_image = (int)filter_var($_POST["low_image"],FILTER_SANITIZE_STRING);
            $fileType = filter_var($_POST["fileType"],FILTER_SANITIZE_STRING);
            $tipo = filter_var($_POST["tipo"],FILTER_SANITIZE_STRING);

            if (!file_exists("temp/")) {
                mkdir("temp/",0777);
            }
            if (strstr($pasta,"temp/")) {
                if (!file_exists($pasta)) {
                    mkdir($pasta,0777);
                }
            }
            else {
                    //isto no cloudif funciona, mas remotamente não funciona
                //$pasta = dirname($ficheiro,2)."/".$pasta."/".$tipo;
                    //funciona no remote.
                if ($tipo != "single") {
                    $pasta = PASTA.$pasta."/".$tipo;
                }
                else {
                    $pasta = "temp";
                }
            }
            $manager = new Intervention\Image\ImageManager(array('driver' => 'imagick'));

            foreach($ficheiros as $ficheiro) {
                $ficheiro = "../".$ficheiro;
                if (file_exists($ficheiro)) {
                    $dest = str_replace("//","/",$pasta."/".$sys->st_clean_filename(basename($ficheiro)));
                    //die($dest);
                    $im = pathinfo($dest);
                    if (copy($ficheiro,$dest)) {

                        $imm = $manager->make($dest);
    					$mime = $imm->mime();
    					    //copiado do SingleUpload do class_utils
    					if ($mime !== 'image/png' && $fileType == 'png') {
    						//gravar como png
    						$novo_nome = str_replace(".".strtolower($im["extension"]),".png",$dest);
    						if ($imm->save($novo_nome)) {
    							unlink($dest);
    							$dest = $novo_nome;
    						}
    						$imm->destroy();
    						$imm = $manager->make($dest);
    					}
    					if ($mime !== 'image/jpeg' && $mime !== 'image/pjpeg' && $fileType == 'jpg') {
    						//gravar como png
    						$novo_nome = str_replace(".".strtolower($im["extension"]),".jpg",$dest);
    						if ($imm->save($novo_nome)) {
    							unlink($dest);
    							$dest = $novo_nome;
    						}
    						$imm->destroy();
    						$imm = $manager->make($dest);
    					}

                        if ($dim[0] == '0' || $dim[1] == '0') {
                            $fdim = $dim;

                            $fdim[0] = $dim[0] == '0' ? null : $dim[0];
    						$fdim[1] = $dim[1] == '0' ? null : $dim[1];

                                //calcular o aspect ratio da imagem pedida contra as dimensões pedidas.
                            if (is_null($fdim[0])) $fdim[0] = (int)$sys->math_ratio_calc('x',$dim[1],$imm->width(),$imm->height());
    						if (is_null($fdim[1])) $fdim[1] = (int)$sys->math_ratio_calc($dim[0],'x',$imm->width(),$imm->height());

                            if ($low_image == 1) {

    									//($par_a1,$par_a2,$par_b1,$par_b2) {
    							$imm->resize($fdim[0], $fdim[1], function ($constraint) {
    							    $constraint->aspectRatio();
    							    $constraint->upsize();
    							})->resizeCanvas($fdim[0], $fdim[1], 'center')->save();
    						}
    						else {
    							$imm->resize($fdim[0], $fdim[1], function ($constraint) {
    								//Constraint the current aspect-ratio if the image. As a shortcut to proportional resizing you can use widen() or heighten().
    							    $constraint->aspectRatio();
    							    //Keep image from being upsized.
    							    $constraint->upsize();
    							})->save();
    						}
                        }
                        $imm->destroy();
                        $IMG = new sys_imagens($dest);
    					$v = $IMG->comprimir($dest);
    					unset($IMG);
                    }
                }
                else {
                    echo "no exists";
                }
            }
            if ($tipo == 'galeria') {
                echo $pasta;
            }
            else {
                echo $dest;
            }
        }

        if ($cmd === 'cortaficheiro') {
            $pasta = isset($_POST["pasta"]) ? filter_var($_POST["pasta"],FILTER_SANITIZE_STRING) : 'temp/';
            $ficheiro = "../".urldecode(filter_var($_POST["ficheiro"],FILTER_SANITIZE_STRING));
            $crop_dim = $_POST["crop"];
            $dim = explode(",",filter_var($_POST["dim"],FILTER_SANITIZE_STRING));
            $tipo = filter_var($_POST["tipo"],FILTER_SANITIZE_STRING);
            $fileType = filter_var($_POST["fileType"],FILTER_SANITIZE_STRING);
            if (!file_exists("temp/")) {
                mkdir("temp/",0777);
            }
            if (!strstr($pasta,"temp/")) {
                    //isto no cloudif funciona, mas remotamente não funciona
                //$pasta = dirname($ficheiro,2)."/".$pasta."/".$tipo;
                    //funciona no remote.

                $pasta = PASTA.$pasta."/".$tipo;
            }
            else {
                if (!file_exists($pasta)) {
                    mkdir($pasta,0777);
                }
            }



            if (file_exists($ficheiro)) {
                //garantir que o $ficheiro está dentro do tipo de pedido
                $finfo = pathinfo($ficheiro);

                if ($tipo == 'galeria') {
                    $dest = $pasta."/".str_replace(".".$finfo["extension"],".".$fileType,$sys->st_clean_filename(basename($ficheiro)));
                    //$dest = str_replace("//","/",$pasta."/".$sys->st_clean_filename(basename($ficheiro)));
                }
                if ($tipo == 'single') {
                    //manda pro temp
                    //$dest = "temp/".str_replace(".".$finfo["extension"],".".$fileType,basename($ficheiro));
                    $dest = "temp/".str_replace(".".$finfo["extension"],".".$fileType,$sys->st_clean_filename(basename($ficheiro)));
                }

                $manager = new Intervention\Image\ImageManager(array('driver' => 'imagick'));

                $imm = $manager->make($ficheiro);
                if (isset($crop_dim["paths"]) && count($crop_dim["paths"]) > 0) {
					foreach($crop_dim["paths"] as $path) {
						$op = array_keys($path);
						$va = array_values($path);
						$operacao = $op[0];
						$valor = (int)$va[0]*-1;

						if ($operacao == "rotate") {
							$imm->rotate($valor);
						}
						if ($operacao == 'scaleX') {
							$imm->flip('h');
						}
						if ($operacao == 'scaleY') {
							$imm->flip('v');
						}
					}
				}
				$imm->crop(round($crop_dim["width"],0),round($crop_dim["height"],0), round($crop_dim["x"],0), round($crop_dim["y"],0));
			    if (round($crop_dim["width"],0) >= $dim[0] && round($crop_dim["height"],0) >= $dim[1]) {
				    $imm->resize($dim[0], $dim[1], function($constraint) {
            		    $constraint->aspectRatio();
            			$constraint->upsize();
        			})->save($dest,100);

        			$IMG = new sys_imagens($dest);
					$v = $IMG->comprimir($dest);
					unset($IMG);
        		    //nunca vai acontecer o caso para este porque teoricamente o crop trata disto
        		    //->resizeCanvas($dim[0], $dim[1], 'center', false, [0, 0, 0, 0]);
				}

				if ($tipo == 'galeria') {
                    echo $pasta;
                }
                else {
                    echo $dest."?i=".uniqid();
                }
				$imm->destroy();
            }
        }

        if ($cmd == 'verficheiro') {
            //analisar as dimensões da imagems
            $ficheiro = filter_var(urldecode($_POST["ficheiro"]),FILTER_SANITIZE_STRING);
            $manager = new Intervention\Image\ImageManager(array('driver' => 'imagick'));
            if (file_exists("../".$ficheiro)) {
                $imm = $manager->make("../".$ficheiro);
                echo json_encode(array("width" => $imm->width(),"height" => $imm->height()));
                $imm->destroy();
            }
            else {
                echo -1;
            }
        }

        if ($cmd == 'getLogs') {
            echo json_encode($usr->getLogs());
        }

        if ($cmd == 'updateLog') {
            $usr->updateLogOut();
        }
        if ($cmd == 'gerarPassword') {
            function generateStrongPassword($length = 15, $add_dashes = false, $available_sets = 'luds') {
        		$sets = array();
        		if(strpos($available_sets, 'l') !== false)
        			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
        		if(strpos($available_sets, 'u') !== false)
        			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        		if(strpos($available_sets, 'd') !== false)
        			$sets[] = '23456789';
        		if(strpos($available_sets, 's') !== false)
        			$sets[] = '!@#$%&*?';
        		$all = '';
        		$password = '';
        		foreach($sets as $set)
        		{
        			$password .= $set[tweak_array_rand(str_split($set))];
        			$all .= $set;
        		}
        		$all = str_split($all);
        		for($i = 0; $i < $length - count($sets); $i++)
        			$password .= $all[tweak_array_rand($all)];
        		$password = str_shuffle($password);
        		if(!$add_dashes)
        			return $password;
        		$dash_len = floor(sqrt($length));
        		$dash_str = '';
        		while(strlen($password) > $dash_len)
        		{
        			$dash_str .= substr($password, 0, $dash_len) . '-';
        			$password = substr($password, $dash_len);
        		}
        		$dash_str .= $password;
        		return $dash_str;
        	}

        	$pass = generateStrongPassword();
        	echo $pass;
        }

        if ($cmd == 'criarPotSite') {

            if(!file_exists(dirname(CT)."/locale/"."site.pot")){
                $fileSite = fopen(dirname(CT)."/locale/"."site.pot","w");
                fclose($fileSite);
                chmod(dirname(CT)."/locale/"."site.pot",0777);
            }

            $idioma_base = filter_var($_POST["base"],FILTER_SANITIZE_STRING);
            //faz o mesmo que o worker.php faz para as traduções
            $folder = dirname(CT);
            $dontInclude = ['/.c9/','/classes/','/controlo/','/css/','/downloads/','/fonts/',
            '/js/','/locale/','/assets/','/templates/','/myadmin/',
            '/img/','/images/','/revolution/','/src/',
            'poeditor.sh','config.json','browserconfig.xml','humans.txt',
            'robots.txt','sizer.php','ver_session.php','.htaccess','sitemap.xml','error_log'
            ];
            $object = new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($object,RecursiveIteratorIterator::CHILD_FIRST);
            $linhas = [];

            foreach ($files as $filename) {
                if (!isInString($filename,$dontInclude) && !$filename->isDir()) {
                    $cont = file_get_contents($filename);

                    preg_match_all('/_\([\s]*[\'|\"]([^_\(\)]*)[\'|\"][\s]*\)/',$cont,$estas);
                    $linhas = array_merge($linhas,$estas[1]);
                }
            }
            /*#. TRANSLATORS: First letter in 'Scope'
#. TRANSLATORS: South*/

            $linhasf = array_unique($linhas);
                //inicializar o ficheiro pot
            $po_template = 'msgid ""
msgstr ""
"Project-Id-Version: \\n"
"Report-Msgid-Bugs-To: \\n"
"POT-Creation-Date: \\n"
"PO-Revision-Date: \\n"
"Last-Translator: \\n"
"Language: '.$idioma_base.'\\n"
"Language-Team: Ideias Frescas, design e multimédia\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
"Plural-Forms: nplurals=2; plural=n == 1 ? 0 : 1;\\n"
"MIME-Version: 1.0\\n"

';

            //colocar as linnhas dentro do ficheiro
            foreach($linhasf as $linhaf) {
                $po_template .= 'msgid "'.$linhaf.'"
msgstr ""

';
            }

            $resultado = file_put_contents($folder."/locale/site.pot",$po_template);
            if($resultado) echo 1;
        }

        if ($cmd == 'criarPotBackoffice') {

            if(!file_exists(dirname(CT)."/locale/"."backoffice.pot")){
                $fileBackoffice = fopen(dirname(CT)."/locale/"."backoffice.pot","w");
                fclose($fileBackoffice);
                chmod(dirname(CT)."/locale/"."backoffice.pot",0777);
            }

            $idioma_base = filter_var($_POST["base"],FILTER_SANITIZE_STRING);
            //faz o mesmo que o worker.php faz para as traduções
            $folder = dirname(CT);
            $dontInclude = ['/includes/','/css_antigo/','/css/','/data/','/vendor/',
            'js_antigo/'.'js/','/locale/','filemanager/','/fonts/','/mail/',
            '/src/','/temp/','/thumbs/','/src/',
            'base.php','compify.phar','composer.json','.htaccess','remote_anexos.php'
            ];
            $object = new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($object,RecursiveIteratorIterator::CHILD_FIRST);
            $linhas = [];

            foreach ($files as $filename) {
                if (!isInString($filename,$dontInclude) && !$filename->isDir()) {
                    $cont = file_get_contents($filename);                    
                    preg_match_all('/(_\(\s*"(.*?)"\s*\)|_\(\s*\'(.*?)\'\s*\))/m',$cont,$estas);
                    $linhas = array_merge($linhas,$estas[1]);
                }
            }
            /*#. TRANSLATORS: First letter in 'Scope'
#. TRANSLATORS: South*/

            $linhasf = array_unique($linhas);
                //inicializar o ficheiro pot
            $po_template = 'msgid ""
msgstr ""
"Project-Id-Version: \\n"
"Report-Msgid-Bugs-To: \\n"
"POT-Creation-Date: \\n"
"PO-Revision-Date: \\n"
"Last-Translator: \\n"
"Language: '.$idioma_base.'\\n"
"Language-Team: Ideias Frescas, design e multimédia\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
"Plural-Forms: nplurals=2; plural=n == 1 ? 0 : 1;\\n"
"MIME-Version: 1.0\\n"

';

            //colocar as linnhas dentro do ficheiro
            foreach($linhasf as $linhaf) {
                $po_template .= 'msgid "'.$linhaf.'"
msgstr ""

';
            }

            $resultado = file_put_contents($folder."/locale/backoffice.pot",$po_template);
            if($resultado) echo 1;
        }

        if ($cmd == 'gravarTraducao') {
            $origem = filter_var($_POST["origem"],FILTER_SANITIZE_STRING);
            $locale = filter_var($_POST["locale"],FILTER_SANITIZE_STRING);

            $original = filter_var($_POST["original"],FILTER_SANITIZE_STRING);
            $traducao = filter_var($_POST["traducao"],FILTER_SANITIZE_STRING);
            $comentario = filter_var($_POST["comentario"],FILTER_SANITIZE_STRING);

            $folder = $origem == "site" ? dirname(CT)."/locale/" : CT."locale/";
            $filePot = $origem == "site" ? dirname(CT)."/locale/site." : dirname(CT)."locale/backoffice.";

            $translations = Gettext\Translations::fromPoFile($folder.$locale."/LC_MESSAGES/messages.po");

            //$translation = $translations->find($original, $original);
            $translation = $translations->find(null, $original) ? : $translations->insert(null, $original);
            if ($translation) {
	            $translation->setTranslation($traducao);
                if (!empty($comentario)) {
                    $translation->addComment($comentario); //experimental
                }
                else {
                    $translation->addComment('');
                }
                echo 1;

                Gettext\Generators\Po::toFile($translations, $folder.$locale."/LC_MESSAGES/messages.po");

                //abrir de novo o ficheiro po e fazer fix à linguagem que vai com os porcos
                $temp = file_get_contents($folder.$locale."/LC_MESSAGES/messages.po");
                $tp_locale = explode(".",$locale);

                $temp = str_replace('"Language: \n"','"Language: '.$tp_locale[0].'\n"',$temp);
                file_put_contents($folder.$locale."/LC_MESSAGES/messages.po",$temp);

                /*$moLines = MoGenerator::generate($translations);
                file_put_contents($folder.$locale."/LC_MESSAGES/messages.po", $moLines);*/
                $translations = Gettext\Translations::fromPoFile($folder.$locale."/LC_MESSAGES/messages.po");
                $translations->toMoFile($folder.$locale."/LC_MESSAGES/messages.mo");
            }
        }

        if ($cmd == 'listarTraducoes') {
            $origem = filter_var($_GET["origem"],FILTER_SANITIZE_STRING);
            $locale = filter_var($_GET["locale"],FILTER_SANITIZE_STRING);

            $folder = $origem == "site" ? dirname(CT)."/locale/" : CT."locale/";
            $filePot = $origem == "site" ? dirname(CT)."/locale/site." : dirname(CT)."/locale/backoffice.";

            $translations = Gettext\Translations::fromPoFile($folder.$locale."/LC_MESSAGES/messages.po");
            $t_actuais = [];
            $t_comments = [];

            $translations2 = Gettext\Translations::fromPoFile($filePot."pot");
            $t_originais = [];


            //construir a lista de traduções actuais
            foreach($translations as $translation) {
                $k = $translation->getOriginal();
                $t_actuais[$k] = $translation->getTranslation();
                $t_comments[$k] = $translation->getComments();
            }
            //construir a lista de traduções originais ( do pot )
            foreach($translations2 as $translation) {
                $k = $translation->getOriginal();
                $t_originais[] = ["original" => $k,"traducao" => isset($t_actuais[$k]) ? $t_actuais[$k] : '',"comentario" => isset($t_comments[$k]) ? $t_comments[$k] : ''];
            }
            //var_dump($t_actuais);
            $out = [];
            foreach($t_originais as $chave => $t_original) {
                $out[] = ["original" => $t_original["original"],"traducao" => $t_original["traducao"],"comentario" => $t_original["comentario"]];
            }
            echo json_encode($out,JSON_UNESCAPED_UNICODE);
        }



    } else {
        echo "Nothing to see here! Move along!";
    } else {
        echo "Nothing to see here! Move along!";
    }
?>
