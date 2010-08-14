<?
session_start();
include("../models/template.php");

$template = new Template();

$left_xml = $template->get_left();
$rigth_xml = $template->get_right();

$template->draw_header();
?>
<script type="text/javascript" src="../javascripts/ufo.js"></script>
<script type="text/javascript">
var FO = { movie:"../images/flash/banner.swf", width:"462", height:"124", majorversion:"6", build:"0", xi:"true" };
UFO.create(FO, "flash");
</script>
<div class="header">
    <a title="Back to home" href="/"><img alt="Vitaflo Logo" src="..//images/vitaflo-logo.gif"/></a>
    <div class="bannerA" id="flash" style="visibility: visible;">
        <embed width="462" height="124" pluginspage="http://www.macromedia.com/go/getflashplayer" src="../images/flash/banner.swf" type="application/x-shockwave-flash"/>
    </div>
</div>
<div class="home">
	 <? foreach($left_xml->item as $item ):?>
  	 	<?= (string)$item ?>
  	 <? endforeach ?>
</div>
<div class="rigth">
	 <? foreach($rigth_xml->item as $item ):?>
  	 	<?= (string)$item ?>
  	 <? endforeach ?>
</div>
<?
$template->draw_footer();
?>

