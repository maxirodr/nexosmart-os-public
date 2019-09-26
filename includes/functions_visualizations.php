<?php
/* @author www.nexosmart.com.ar
 * @mail_support maxirodr@nexosmart.com.ar
 * @title visualizatons
 * @about_doc here are listining the functions to listing elements in the shop
 * 
 * please add here all custom functions/classes to get imported into framework
 * without erase in each update
 */

function generate__item($id_prod,$title,$img,$section,$descripcion) {
	global $url_web;
	//function that scrap the info
	$array_response = generate__item_db($id_prod,$title,$img,$section,$descripcion);
	
	return <<<HTML
	<div class="col-md-3 col-sm-4 col-xs-6">
		<div class="item-home" data-id="{$array_response[id_producto]}">
			<div class="item-photo" style="background: url('$array_response[url_img]');">
				<a href="//$url_web/$section/$array_response[id_producto]" style="display: block; width: 100%; height: 100%;">
					<div class="overlay-diff">{$array_response[descripcion]}</div>
				</a>
				<div class="item-icons">
					{$array_response[buy_button]}
				</div>
			</div>
			<div class="item-info">
				{$array_response[title]}
			</div>
		</div>
	</div>
HTML;
}


function generate_mini_box($cols, $image, $price, $section, $id_producto, $title, $discount) {
	global $url_web;
	
	$array_response = generate_mini_box_db($cols, $image, $price, $section, $id_producto, $title, $discount);
	
	echo "<div class=\"col-md-{$cols} col-sm-4 col-xs-$$array_response[sm_cols]\">
		<div class=\"mini-product\" data-id=\"{$id_producto}\">
			<div class=\"m-pic overlay-effect\" style=\"background: url('$array_response[image]');\">
				<a href=\"//$url_web/producto/$id_producto\"> </a>
			</div>
			<div class=\"descripciones\">
				<div id=\"titulo\">
					<a href=\"//$url_web/producto/$id_producto\">{$array_response[title]}</a>
				</div>

				<div id=\"precio\">
					{$array_response[print_price]}
				</div>

				<div class='row'>
					<div class='col-sm-9'>
					   <span class='small-cuotas'>
					       <span>6</span> cuotas de <span>$$array_response[cuotas_print_price]</span>
				       </span>
				       <span class='small-cft'>
                           CFT: 43.47% - TEA: 33.14%
                       </span>
				    </div>
				    <div class='col-sm-3 tarjeta'>
                       <i class=\"fa fa-cc-visa\" aria-hidden=\"true\"></i>
                    </div>
				</div>

			</div>
		</div>
	</div>";
}

function paginar_resultados_view($part='') {
	if($part==1) {
		$return = "<div style=\"text-align:right;padding:4px;float:left;clear:both;margin-top:5px;margin-bottom:5px;\">Página de los resultados: ";
	}
	if($part==2) {
		global $url,$i;
		$return = '<a href='.$url.'&pagina='.$i.'>'.$i.'</a>';
	}
	if($part==3) {
		$return = "</div><br/>";
	}
	if($part==4) {
		$return = '<div class="col-sm-12 notice_display"><i class="fa fa-file" aria-hidden="true"></i> Aún no hay información suficiente para mostrar resultados</div>';
	}
	
	if( isset($return) ) return $return;
}
 

function show_professional($id, $name, $city, $address, $tel, $time){
return <<<HTML
	<div class="col-sm-3 col-xs-6 professional-data" data-id="{$id}" data-name="{$name}" data-lastname="{$lastname}" data-city="{$city}" data-address="{$address}" data-tel="{$tel}" data-time="{$time}">
		<div class="col-xs-11 professional">
			{$name}
		</div>
		<a class="addlink">+</a>
		<div class="col-xs-12">
			{$city}
		</div>
		<div class="col-xs-12">
			{$address}
		</div>
		<div class="col-xs-12">
			{$tel}
		</div>
		<div class="col-xs-12">
			{$time}
		</div>
		<hr	class="col-xs-12 hrprofessional">
	</div>
HTML;
}

function generate__item_db($id_prod,$title,$img,$section,$descripcion){
	global $url_web;
	if(!isset($section)) $section = "producto";
	
	//if(!in_array($section,array("mascotas","producto"))) $section="producto";

	if($section=="producto") {
		$img_aleatoria=array(
			"auto",
			"moto",
			"camisa"
		);
		$id_prod="";

		$img_aleatoria=$img_aleatoria[mt_rand(0,2)];

		$num_rand=mt_rand(1,3);

		$url_img="//$url_web/uploads/img/articulos/$img_aleatoria-$num_rand.jpg";
		
		$title=$img_aleatoria;
	}
	
	$buy_button="<a href=\"//$url_web/loquieroya/$id_prod\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Comprar\"><i class=\"fa fa-shopping-cart\" aria-hidden=\"true\"></i></a>";
	
	//check si el producto está agregado en favs para el user
	/*if(is_numeric($id_prod)) {
		unset($id_prod_fv,$id_user_fv,$query,$resultado,$row,$fav_alredy);
		// traemos una categoria
		$id_prod_fv=secure_input($id_prod);
		global $_SESSION;
		global $dbConn;
		$id_user_fv=secure_input($_SESSION['id']);
		$query = "SELECT id_articulo,id_user FROM `favoritos` WHERE id_user = '$id_user_fv' AND id_articulo = '$id_prod_fv' AND section='$section' LIMIT 1";
		$resultado = mysqli_query($dbConn, $query);
		$row = mysqli_fetch_assoc($resultado);

		if($row['id_articulo']==$id_prod_fv && $row['id_user']==$id_user_fv) $fav_alredy=" added";
		else $fav_alredy="";
	} else $fav_alredy="";*/
	//end favs
	
	if($section=="mascotas"){ 
		$img=explode(";",$img);
		$buy_button="";
	}
	if(empty($section)) $section="articulos";
	
	if( strpos($img, ";") !== FALSE ) { 
        $imagen = explode(";",$img);
        $count_rand = count($imagen);
        $imagen_link = $imagen[0];
        if( empty($imagen_link) ) $imagen_link = $imagen[1];
    } else $imagen_link = $img;


	if(!isset($url_img)) $url_img="//$url_web/$imagen_link"; //después de migrar esto cambia a URL WEB y no el link dierctamente, error atrós
	
	$title=ucfirst($title);
	
	if(strlen($title)>20) {
		$title=substr($ttle,0,18);
		$title=$title."...";
	}
	
	if(strlen($descripcion)>50) {
		$descripcion=substr($descripcion,0,47);
		$descripcion=$descripcion."...";
	}

	$id_prod=$id_producto."_$section";
	
	$array_response=[
		'id_producto' => $id_prod,
		'url_img' => $url_img,
		'descripcion' => $descripcion,
		'buy_button' => $buy_button,
		'title' => $title
	];
	
	return $array_response;
}



function generate__product($data){
	/*
		Seteo los elementos del array a variables para mejor manejo de código
		$data tiene la siguiente forma

		[
			'name' 		=>	'Nombre del producto',
			'price' 	=>	'123.45',
			'category'	=>	'ID categoria (int)',

		]
	*/

	$name = $data['name'];
	$price = $data['price'];
	$category = $data['category'];
	
}

function product_generate_testimonial($active, $name, $city, $photo, $stars, $testimonial){
	// Set empty string to avoid isset($) false when trying to add a string to these variables.
	$st = '';
	$si = '';
	$add = '';

	// Check if this is the active item from carousel
	if ($active) $add = 'active';

	$has_halfstar = ($stars-floor($stars)) > 0;
	$has_photo = $photo != '';

	// Check if there is a half star, then add it
	if ($has_halfstar)
		$half_star = '<i class="fa fa-star-half-o selected" aria-hidden="true"></i>';
	// Generate the other stars
	for ($i=1;$i<=5;$i++){
		if ($i<=$stars){
			$st .= '<i class="fa fa-star selected" aria-hidden="true"></i>';
		}
		else {
			if ($has_halfstar){
				$st .= $half_star;
				$has_halfstar = false;
			}
			else {
				$st .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
			}
		}
	}

	// Check if there is an image, then add it
	if ($has_photo)
		$si .= '<img src="'.$photo.'" alt="" class="img-responsive br-circle">';


		return <<<HTML
		<div class="item {$add}">
			<div class="row">
				<div class="col-sm-2 hidden-xs">
					<div class="tes-photo br-circle">{$si}</div>
				</div>
				<div class="col-sm-10 col-xs-12">
					<div class="tes-name xs-center"><span>{$name}</span>, {$city}</div>
					<div class="tes-text xs-center br-5">{$testimonial}</div>
					<div class="tes-star xs-center">{$st}</div>
				</div>
			</div>
		</div>
HTML;

}

function product_generate_question($question, $answer){
	$has_answer = !(empty($answer));
	$answer_string = '';
	$si = '';

	if (isset($question['deleted'])){
		$deleted = 'deleted';
	}
	else {
		$deleted = '';
	}

	if ($has_answer){
		$answer_string .= '<div class="tes-answer br-5">';
		$answer_string .= '<div class="tes-ans-name xs-center"><span class="name">'.$answer['name'].'</span> <span class="isg br-5">'.$answer['range'].'</span> ─ '.$answer['time'].'</div>';
		$answer_string .= '<div class="tes-text tes-text-ans">'.$answer['answer'].'</div>';
		$answer_string .= '</div>';
	}

	$has_photo = $question['photo'] != '';

	if ($has_photo)
		$si .= '<img src="'.$question['photo'].'" alt="" class="img-responsive br-circle">';

	$name = $question['name'];
	$city = $question['city'];
	$time = $question['time'];
	$question = $question['question'];

	return <<<HTML
	<div class="question {$deleted}">
		<div class="col-sm-1 hidden-xs np">
			<div class="tes-photo br-circle">{$si}</div>
		</div>
		<div class="col-sm-11 col-xs-12">
			<div class="text-question-panel">
				<div class="tes-name xs-center"><span>{$name}</span>, {$city} ─ {$time}</div>
				<div class="tes-text">{$question}</div>
				{$answer_string}
			</div>
		</div>
		<div style="clear:both"></div>
	</div>
HTML;

}

function generate_stars($stars){
	$st = '';
	$add = '';

	$has_halfstar = ($stars-floor($stars)) > 0;

	// Check if there is a half star, then add it
	if ($has_halfstar)
		$half_star = '<i class="fa fa-star-half-o selected" aria-hidden="true"></i>';
	// Generate the other stars
	for ($i=1;$i<=5;$i++){
		if ($i<=$stars){
			$st .= '<i class="fa fa-star selected" aria-hidden="true"></i>';
		}
		else {
			if ($has_halfstar){
				$st .= $half_star;
				$has_halfstar = false;
			}
			else {
				$st .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
			}
		}
	}

	return $st;
}

function generate_mini_box_db($cols, $image, $price, $section, $id_producto, $title, $discount){
	global $url_web;
	global $_SESSION;

	//arreglo para MP precio
	$price = get_product_price($price);

	$decimal = 0.5;
	if (rand(0,99) >= 50) { $decimal = 0.99; }

	//if ($price == 0) $price = rand(50,999)+$decimal;
	//$print_price = parse__price($price);
	
	$img_aleatoria=array(
	"auto",
	"moto",
	"camisa"
	);
	
	$img_aleatoria=$img_aleatoria[mt_rand(0,2)];
	
	$num_rand=mt_rand(1,3);

	if ($image=='') $image = "//$url_web/uploads/img/articulos/$img_aleatoria-$num_rand.jpg";
	elseif( strpos($image, ";") !== FALSE ) {
		$image_array = explode(";", $image);
		$image = "//$url_web".$image_array[0];

		if( empty($image) ) $image = "//$url_web".$image_array[1];
	} else $image = "//$url_web".$image;
	
	if(empty($id_producto)) $id_producto=1;
	
	/*if($section=="slider") $sm_cols=12;
	else $sm_cols=6;*/
	$sm_cols=12;
	
	if(strlen($title)>23) {
		$title=substr($title,0,21);
		$title=$title."...";
	}
	
	//check si el producto está agregado en favs para el user
	/*if(is_numeric($id_producto)) {
		unset($id_prod_fv,$id_user_fv,$query,$resultado,$row,$fav_alredy);
		// traemos una categoria
		$id_prod_fv=secure_input($id_producto);
		global $_SESSION;
		global $dbConn;
		$id_user_fv=secure_input($_SESSION['id']);
		$query = "SELECT id_articulo,id_user FROM `favoritos` WHERE id_user = '$id_user_fv' AND id_articulo = '$id_prod_fv' AND section='articulos' LIMIT 1";
		$resultado = mysqli_query($dbConn, $query);
		$row = mysqli_fetch_assoc($resultado);

		if($row['id_articulo']==$id_prod_fv && $row['id_user']==$id_user_fv) $fav_alredy=" added";
		else $fav_alredy="";
	} else $fav_alredy="";*/
	//end favs
	
	
	$id_prod=$id_producto."_articulos";

	//tratamiento del precio
	if( $discount!=0 && !empty($discount) ) {
	    $precio_discount = $discount*$price/100;
        
		$precio_new = $price-$precio_discount;
		
		$print_price = parse__price($precio_new);
		
		$print_price = "<span style='text-decoration: line-through;font-size: 16px;color: #757980; font-weight: normal;clear: both;display: block;'>$price</span> $print_price";
	} else $print_price = parse__price($price);
    
    if( !empty($precio_new) ) $cuotas_print_price = round($precio_new/6,2);
    else $cuotas_print_price = round($price/6,2);
    
    $array_response=[
		'sm_cols' => $sm_cols,
		'image' => $image,
		'print_price' => $print_price,
		'cuotas_print_price' => $cuotas_print_price,
		'title' => $title
	];
	
	return $array_response;
	
	
}


function BBcode($texto){
	 //$texto = htmlentities($texto);
	 $texto_READ = strlen($texto);
	 if($texto_READ <= 45000) {
	 $texto = strip_tags($texto);
	 $a = array(
			"/\[i\](.*?)\[\/i\]/is",
			"/\[b\](.*?)\[\/b\]/is",
			"/\[u\](.*?)\[\/u\]/is",
			"/\[title\](.*?)\[\/title\]/is",
			"/\[center\](.*?)\[\/center\]/is",
		"/\[left\](.*?)\[\/left\]/is",
		"/\[right\](.*?)\[\/right\]/is",
			"/\[img\](.*?)\[\/img\]/is",
			"/\[url=(.*?)\](.*?)\[\/url\]/is",
			"/\[url](.*?)\[\/url\]/is",
			"/\[quote=(.*?)\](.*?)\[\/quote\]/is",
		"/\[quote](.*?)\[\/quote\]/is",
		"/\[sangria\](.*?)\[\/sangria\]/is",
		"/\[interlineado=(.*?)\](.*?)\[\/interlineado\]/is",
		"/\[youtube](.*?)\[\/youtube\]/is",
		"/\[vimeo](.*?)\[\/vimeo\]/is",
		"/\<php(.*?)\?>/is",
		"/\<javascript>(.*?)\<\/javascript\>/is"
	 );
	 $b = array(
			"<i>$1</i>",
			"<b>$1</b>",
			"<u>$1</u>",
			"<h5 class=\"heading-pink\">$1</h5>",
		"<center>$1</center>",
		"<left>$1</left>",
		"<right>$1</right>",
		'"<img src=\"\\1\" style=\"max-width:550px;max-height:550px;\" width=\"" . img_size("\\1", "width") . "\" height=\"" . img_size("\\1", "height") . "\"/>"',
			"<a href=\"$1\">$2</a>",
			"<a href=\"$1\">$1</a>",
		"<div class=\"quote\">Cita:<br/> <div class=\"bgquote\">Empezado por: <b>$1</b><br/> <font style=\"font-size:10px;\"><i>$2</i></font></div></div>",
		"<div class=\"quote\">Cita:<br/> <div class=\"bgquote\">Empezado por alguién:<br/> <font style=\"font-size:10px;\"><i>$1</i></font></div></div>",
		"<p style=\"text-indent:2cm;\">$1</p>",
		"<p style=\"line-height:$1;\">$2</p>",
		"<iframe style=\"min-width:768px;min-height:512px;\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>",
		"<object style=\"height: 300px; width: 400px\">
<param name=\"movie\" value=\"http://player.vimeo.com/video/$1\">
<param name=\"allowFullScreen\" value=\"true\">
<param name=\"allowScriptAccess\" value=\"always\">
<embed src=\"http://player.vimeo.com/video/$1\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" allowScriptAccess=\"always\" width=\"400\" height=\"300\"></object>",
		"",
		""

	 );
        $texto = nl2br($texto);
        $texto = preg_replace($a, $b, $texto);
        $texto = parse_links($texto);

	 return $texto;
	 } else {
	 exit(); 
	 }
} 

function unBBcode($texto){
	 $texto = html_entity_decode($texto);
	 $a = array(
			"/\<i\>(.*?)\<\/i\>/is",
			"/\<b\>(.*?)\<\/b\>/is",
			"/\<u\>(.*?)\<\/u\>/is",
			"/\<h5 class=\"heading-pink\"\>(.*?)\<\/h5\>/is",
			"/\<center\>(.*?)\<\/center\>/is",
		"/\<left\>(.*?)\<\/left\>/is",
		"/\<right\>(.*?)\<\/right\>/is",
			"/\<img src=\"(.*?)\" style=\"(.*?)\" width=\"(.*?)\" height=\"(.*?)\"\/>/is",
			"/\<a href=\"(.*?)\"\>(.*?)\<\/a\>/is",
			"/\<a href=\"(.*?)\"\>(.*?)\<\/url\>/is",
			"/\<div class=\"quote\">Cita:<br \/> <div class=\"bgquote\">Empezado por: <b\>(.*?)\<\/b><br \/> <font style=\"font-size:10px;\"><i\>(.*?)\<\/i\><\/font\><\/div\><\/div\>/is",
		"/\<div class=\"quote\">Cita:<br \/> <div class=\"bgquote\">Empezado por alguién:<br \/> <font style=\"font-size:10px;\"><i>(.*?)\<\/i\><\/font\><\/div\><\/div\>/is",
		"/\<p style=\"text-indent:2cm;\"\>(.*?)\<\/p\>/is",
		"/\<p style=\"line-height:(.*?);\"\>(.*?)\<\/p\>/is",
		"/<br\s*\/>/is",
		"/<iframe style=\"min-width:768px;min-height:512px;\" src=\"https:\/\/www.youtube.com\/embed\/(.*?)\" frameborder=\"0\" allowfullscreen\><\/iframe\>/is",
		"/<object style=\"height: 300px; width: 400px\"\>
<param name=\"movie\" value=\"http:\/\/player.vimeo.com\/video\/(.*?)\"\>
<param name=\"allowFullScreen\" value=\"true\"\>
<param name=\"allowScriptAccess\" value=\"always\"\>
<embed src=\"http:\/\/player.vimeo.com\/video\/(.*?)\" type=\"application\/x-shockwave-flash\" allowfullscreen=\"true\" allowScriptAccess=\"always\" width=\"400\" height=\"300\"\><\/object\>/is"
	 );
	 $b = array(
			"[i]$1[/i]",
			"[b]$1[/b]",
			"[u]$1[/u]",
			"[title]$1[/title]",
		"[center]$1[/center]",
		"[left]$1[/left]",
		"[right]$1[/right]",
			"[img]$1[/img]",
			"[url=$1]$2[/url]",
			"[url=$1]$1[/url]",
		"[quote=$1]$2[/quote]",
		"[quote]$1[/quote]",
		"[sangria]$1[sangria]",
		"[interlineado=$1]$2[/interlineado]",
		"",
		"[youtube]$1[/youtube]",
		"[vimeo]$1[/vimeo]"
	 );
	 $texto = preg_replace($a, $b, $texto);
			//$texto = nl2br($texto);
	 return $texto;
} 


function remove_BBcode($texto){
	 //$texto = html_entity_decode($texto);
	 $texto = strip_tags($texto);
	 /*$a = array(
			"/\<i\>(.*?)\<\/i\>/is",
			"/\<b\>(.*?)\<\/b\>/is",
			"/\<u\>(.*?)\<\/u\>/is",
			"/\<h5 class=\"heading-pink\"\>(.*?)\<\/h5\>/is",
			"/\<center\>(.*?)\<\/center\>/is",
		"/\<left\>(.*?)\<\/left\>/is",
		"/\<right\>(.*?)\<\/right\>/is",
			"/\<img src=\"(.*?)\" style=\"(.*?)\" width=\"(.*?)\" height=\"(.*?)\"\/>/is",
			"/\<a href=\"(.*?)\"\>(.*?)\<\/a\>/is",
			"/\<a href=\"(.*?)\"\>(.*?)\<\/url\>/is",
			"/\<div class=\"quote\">Cita:<br \/> <div class=\"bgquote\">Empezado por: <b\>(.*?)\<\/b><br \/> <font style=\"font-size:10px;\"><i\>(.*?)\<\/i\><\/font\><\/div\><\/div\>/is",
		"/\<div class=\"quote\">Cita:<br \/> <div class=\"bgquote\">Empezado por alguién:<br \/> <font style=\"font-size:10px;\"><i>(.*?)\<\/i\><\/font\><\/div\><\/div\>/is",
		"/\<p style=\"text-indent:2cm;\"\>(.*?)\<\/p\>/is",
		"/\<p style=\"line-height:(.*?);\"\>(.*?)\<\/p\>/is",
		"/<br\s*\/>/is",
		"/<iframe (.*?)\><\/iframe\>/is",
		"/<object style=\"height: 300px; width: 400px\"\>
<param name=\"movie\" value=\"http:\/\/player.vimeo.com\/video\/(.*?)\"\>
<param name=\"allowFullScreen\" value=\"true\"\>
<param name=\"allowScriptAccess\" value=\"always\"\>
<embed src=\"http:\/\/player.vimeo.com\/video\/(.*?)\" type=\"application\/x-shockwave-flash\" allowfullscreen=\"true\" allowScriptAccess=\"always\" width=\"400\" height=\"300\"\><\/object\>/is",
		"/\<p\>(.*?)\<\/p>/is",
		"/\<p (.*?)\>(.*?)\<\/p\>/is",
	 );
	 $b = array(
			"$1",
			"$1",
			"$1",
			"$1",
			"$1",
			"$1",
			"$1",
			"$1",
			"$2",
			"$1",
			"$2",
			"$1",
			"$1",
			"$2",
			"",
			"",
			"",
			"$1",
			"$2"
	 );
	 $texto = preg_replace($a, $b, $texto);
			//$texto = nl2br($texto);*/
	 $texto = str_replace("<br>", " ", $texto);
	 return $texto;
} 


function get_product_price($price,$id_prod="",$method="") {
	//el id del producto el día de mañana por si tiene algo especial en el precio?? habrá que ver
	if(!empty($method)) $price *= 1.0889;
	
	return round($price,2,PHP_ROUND_HALF_DOWN);
}



function parse__price($price){
	//$price = number_format((float)$price, 2, '.', ''); //nuevo esto, siempre quiero 2 decimales

	$int = floor($price);
	$red = round(($price-$int)*100,0);
	
	if($red==0) $red="00";

	/*if ($red == 0){
		return <<<HTML
		<span>{$int}</span>
HTML;
	}
	else {*/
	return <<<HTML
		<span>{$int},<sup>{$red}</sup></span>
HTML;
//}

/* <span style="display:none">{$int},<sup>00</sup></span> */
}


function paginar_resultados($pagina="") {
	global $dbConn;
	global $query;
	global $_GET;

	//Limito la busqueda
	if($_GET['cat']=="admin") $TAMANO_PAGINA = 250;
	if(isset($_GET['search_query'])) $TAMANO_PAGINA = 12;
	//if($_GET['search_query']=="moto") $TAMANO_PAGINA = 12;
	else {
		$TAMANO_PAGINA = 24;
	}
	
	
	//examino la página a mostrar y el inicio del registro a mostrar
	if (empty($pagina) or $pagina==0) $pagina=1;
	
	$rs = mysqli_query($dbConn, $query);
	$num_total_registros = mysqli_num_rows($rs);
	//calculo el total de páginas
	$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

	$url = getUrl();	

	$text_output = paginar_resultados_view(1);

	//muestro los distintos índices de las páginas, si es que hay varias páginas
	
		for ($i = 1; $i <= $total_paginas; ++$i){
			if($i!=1) $text_output .= " | ";
			if ($pagina == $i) {
				$text_output .= $pagina;
			}
			else {
				$text_output .= paginar_resultados_view(2);
			}
			}
	
	$text_output .= paginar_resultados_view(3);
	
	$TAMANO_PAGINA--;
	
	$limit_start=$TAMANO_PAGINA*($pagina-1);
	
	$query = "$query LIMIT $limit_start,$TAMANO_PAGINA";

	//si no hay resultados:
	if(empty($num_total_registros) or empty($rs) or $num_total_registros==0) {
		$text_output = paginar_resultados_view(4);
	}

	return array("text" => $text_output,"query" => $query);
}


 
?>