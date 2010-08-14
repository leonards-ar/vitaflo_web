<?
session_start();
include("../models/template.php");

$template = new Template();

$left_xml = $template->get_left();
$right_xml = $template->get_right();

$template->draw_header();
?>
<div class="header bannerE">
    <a href="/" title="Back to home"><img src="../images/vitaflo-logo.gif" alt="Vitaflo Logo"></a>
</div><!-- header -->
<div class="submenu">
  <h2><?= $left_xml->titulo ?></h2>
  <ul>
  	 <? foreach($left_xml->item as $item ):?>
  	 	<li><a href="<?= $template->get_root(); ?>products/<?= $item['id']?>/"><?= $item ?></a></li>
  	 <? endforeach ?>
  </ul>
</div>
<div class="content articles">
	 <h1><?= (string)$right_xml->titulo ?></h1>
  	 <? foreach($right_xml->item as $item ): ?>
	 	<?= $item ?>
  	 <? endforeach ?>
</div><!-- content -->
<?
$template->draw_footer();
?>

