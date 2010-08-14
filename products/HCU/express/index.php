<?
session_start();
include("../../../models/template.php");

$template = new Template();

$left_xml = $template->get_left("../../");
$right_xml = $template->get_right();

$template->draw_header();
?>
<div class="header bannerC">
    <a href="/" title="Back to home"><img src="../../../images/vitaflo-logo.gif" alt="Vitaflo Logo"></a>
</div><!-- header -->
<div class="submenu">
  <h2><?= $left_xml->titulo ?></h2>
  <ul>
  	 <? foreach($left_xml->item as $item ):?>
  	 	<li><a href="<?= $template->get_root(); ?>products/<?= $item['id']?>/"><?= $item ?></a></li>
  	 <? endforeach ?>
  </ul>
</div>
<div class="content detail">

	<img id="ProductContainer_ProductDetail_ImageHolder" alt="PKU Gel Sachet" src="../../../Images/products/hcu-express.jpg"/>

	 <h1><?= (string)$right_xml->titulo ?></h1>
	 <p>
  	 <? foreach($right_xml->item as $item ): ?>
	 	<?= $item ?>
  	 <? endforeach ?>
	 </p>
</div><!-- content -->
<?
$template->draw_footer();
?>

