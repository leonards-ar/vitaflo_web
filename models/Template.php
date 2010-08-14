<?
class Template
	{
    var $tag_actual;
    var $idioma_actual;
    var $idiomas;
    var $xml_error="<?xml version='1.0' encoding='utf-8'?><error><titulo><![CDATA[<h1>Sector en Desarroyo</h1><h2>Disculpe las Molestias</h2>]]></titulo></error>";

  	/*------------------------------------------------------------------------*/
	/* Metodo Contructor de la clase
  	/*------------------------------------------------------------------------*/
    function Template()
 		{
        /*-----------------------*/
      	define("CADENA_A_BUSCAR","vitaflo/");//direccion terminada en "/", Unica,  correspondiente al comienzo el sitio
       	$posicion_comienzo = strpos ($_SERVER["REQUEST_URI"],CADENA_A_BUSCAR) + strlen(CADENA_A_BUSCAR);//busca ultima aparicion de "vitaflo/"
       	$posicion_fin = strpos (substr($_SERVER["REQUEST_URI"],$posicion_comienzo),"/");//busca la primer aparicion de "/"
       	$actual=substr($_SERVER["REQUEST_URI"],$posicion_comienzo, $posicion_fin);
        $this->tag_actual = $actual;

      	/*-----------------------*/
        $this->levanta_setup();

        /*-----------------------*/
        $_idioma = "esp"; # IDIOMA POR DEFECTO

        # si esta en la session lo cargo
        if (isset($_SESSION["idioma"]))
            $_idioma = $_SESSION["idioma"];

        # si esta en el GET lo cargo
        if (isset($_GET["idioma"]))
            $_idioma = $_GET["idioma"];

        # seteo el idioma que corresponda
        $this->set_idioma($_idioma);
        /*-----------------------*/
    	}

  	/*------------------------------------------------------------------------*/
	/* Metodo Que devuelve si el $_tag pasado es el actual o no
  	/*------------------------------------------------------------------------*/
    function set_idioma($_idioma)
        {
        $encontrado = false;
        foreach($this->idiomas as $idioma)
        	{
            if ($idioma["prefijo"] == $_idioma)
            	{                $encontrado = true;
                $this->idioma_actual = $idioma;
                $_SESSION["idioma"]=$idioma["prefijo"];            	}        	}

        # si no encontro el idioma setea el por defecto
        if (!$encontrado)
         	$this->set_idioma("esp");
        }

  	/*------------------------------------------------------------------------*/
	/* Metodo Que devuelve si el $_tag pasado es el actual o no
  	/*------------------------------------------------------------------------*/
    function is_current_tag($_tag)
        {
        return($_tag == $this->tag_actual);
        }

  	/*------------------------------------------------------------------------*/
	/* Metodo Que accede al XML de configuracion del Template
  	/*------------------------------------------------------------------------*/
    function levanta_setup()
        {
        $template_config_url = $this->get_root().'template.xml';
        if (file_exists($template_config_url))
        	{
            $xml = simplexml_load_file($template_config_url);
            $this->idiomas = array();
            foreach($xml->idioma as $idioma )
                {
                $idioma_acum = array();
                $idioma_acum["nombre"] = (string)$idioma->nombre;
                $idioma_acum["prefijo"] = (string)$idioma->prefijo;
                $idioma_acum["terminos"] = (string)$idioma->terminos;
                foreach($idioma->pestana as $pestana)
                    {
                    $idioma_acum["pestanas"][] = (string)$pestana;
                    }
                $this->idiomas[] = $idioma_acum;
                }
            }
        else
        	{
            exit('Error al abrir la Cofiguracion del Template.');
        	}
        }

  	/*------------------------------------------------------------------------*/
	/* Metodo que devueñve el XML del Lado Izquierdo deacuerdo al Idioma actual
  	/*------------------------------------------------------------------------*/
    function get_left($_url="")
    	{
    	$url = $_url."left_".$this->idioma_actual["prefijo"].".xml";
        if (is_file($url))
        	{
	        return(simplexml_load_file($url));
	        }
		else
			{	    	return(simplexml_load_string($this->xml_error));			}
    	}

  	/*------------------------------------------------------------------------*/
	/* Metodo que devueñve el XML del Lado Derecho deacuerdo al Idioma actual
  	/*------------------------------------------------------------------------*/
    function get_right($_url="")
    	{
    	$url = $_url."right_".$this->idioma_actual["prefijo"].".xml";
        if (is_file($url))
        	{
	        return(simplexml_load_file($url));
	        }
	    else
	    	{
	    	return(simplexml_load_string($this->xml_error));	    	}
	   	}

  	/*------------------------------------------------------------------------*/
	/* Metodo que devueñve la cadena necesaria para posicionarse ne la Raiz del sitio
  	/*------------------------------------------------------------------------*/
    function get_root()
    	{    	$niveles_abajo = "";        while(!is_dir($niveles_abajo."models"))
        	{        	$niveles_abajo .= "../";        	}
        return $niveles_abajo;    	}

  	/*------------------------------------------------------------------------*/
  	/* Metodo que dibuja el Cabezal de la pagina
  	/*------------------------------------------------------------------------*/
 	function draw_header()
 		{
        header ('Content-type: text/html; charset=utf-8');
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset= utf-8" />
        <title>Vitaflo - Innovation in Nutrition -  Home Page</title>
		<style type="text/css">
		<!--
		@import url("<?= $this->get_root(); ?>stylesheets/master.css");
		-->
		</style>
        <link href="<?= $this->get_root(); ?>stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
        <link href="<?= $this->get_root(); ?>stylesheets/master.css" media="master" rel="stylesheet" type="text/css" />
        </head>
        <body>
        	<div class="container">
        		<div class="menu">
        			<ul>
        				<li><a href="<?= $this->get_root(); ?>home/" <? if ($this->is_current_tag("home")) echo "class='selected'" ?>><?= $this->idioma_actual["pestanas"][0] ?></a></li>
        				<li><a href="<?= $this->get_root(); ?>about/" <? if ($this->is_current_tag("about")) echo "class='selected'" ?>><?= $this->idioma_actual["pestanas"][1] ?></a></li>
        				<li><a href="<?= $this->get_root(); ?>disorders/" <? if ($this->is_current_tag("disorders")) echo "class='selected'" ?>><?= $this->idioma_actual["pestanas"][2] ?></a></li>
        				<li><a href="<?= $this->get_root(); ?>products/" <? if ($this->is_current_tag("products")) echo "class='selected'" ?>><?= $this->idioma_actual["pestanas"][3] ?></a></li>
        				<li><a href="<?= $this->get_root(); ?>news/" <? if ($this->is_current_tag("news")) echo "class='selected'" ?>><?= $this->idioma_actual["pestanas"][4] ?></a></li>
        				<li><a href="<?= $this->get_root(); ?>how_to_order/" <? if ($this->is_current_tag("how_to_order")) echo "class='selected'" ?>><?= $this->idioma_actual["pestanas"][5] ?></a></li>
        				<li><a href="<?= $this->get_root(); ?>contact_us/" <? if ($this->is_current_tag("contact_us")) echo "class='selected'" ?>><?= $this->idioma_actual["pestanas"][6] ?></a></li>
        			</ul>
        		</div>
        	<div class="containerB">
   		<?php
 		}

 	/*------------------------------------------------------------------------*/
  	/* Metodo que dibuja el Pie de la pagina
 	/*------------------------------------------------------------------------*/
	function draw_footer()
		{
		?>
            </div><!-- container B -->
        		<div class="footer">
        			<ul>
        			<li><a href="<?= $this->get_root() ?>home/teminos_condiciones.php"><?= $this->idioma_actual["terminos"] ?></a></li>
        			<? foreach($this->idiomas as $idioma): ?>
	        			<li><a href="?idioma=<?= $idioma['prefijo']?>" title="<?= $idioma['nombre']?>"><?= $idioma['nombre']?></a></li>
        			<? endforeach ?>
        			</ul>
        		</div><!-- footer-->
            </div><!-- container -->
        </body>
        </html>
		<?php
		}
	}
?>
