<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if (!$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php echo $PAGE->bodyid ?>" class="<?php echo $PAGE->bodyclasses.' '.join(' ', $bodyclasses) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<div id="page">
<div id="innerPage">

<?php if ($hasheading) { ?>

	<?php if ($hascustommenu) { ?>
        	<div id="custommenu"><?php echo $custommenu; ?></div>
        <?php } else { ?>
        	<!--  <div id="custommenu"></div> -->
    <?php }?>

    <div id="page-header">

        <!-- <div id="headerLeft"></div>-->

        <div class="headermain">
        	<a class="mainlogo" href="<?php echo $CFG->wwwroot.'/' ?>"><img src="<?php echo $OUTPUT->pix_url('logo', 'theme');?>" alt="NAIT" /></a><?php //echo $PAGE->heading ?>

        	<!-- menu / login -->
        	<div class="headermenu"><?php
            	if ($haslogininfo) {
                	echo $OUTPUT->login_info();
            	}
            	if (!empty($PAGE->layout_options['langmenu'])) {
               	 echo $OUTPUT->lang_menu();
            	}
            	echo $PAGE->headingmenu;
         	?></div>

        </div>

        <!-- <div id="headerRight"></div>-->

    </div>

     <!-- Displays the heading for the section -->

    <div id="headingName">
    	<?php echo $PAGE->heading ?>
    </div>

    <?php if ($hasnavbar) { ?>
    	<div class="navbar clearfix">
        	<div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
            <div class="navbutton"> <?php echo $PAGE->button; ?></div>
        </div>
       <?php } else {?>

       	<!-- added the nav bar as an element -->
    	<div class="navbar clearfix">
    	</div>

       <?php }?>


<?php } ?>
<!-- END OF HEADER -->

    <div id="page-content" class="clearfix">
    <div id="innerPageContent">
        <div id="report-main-content">
            <div class="region-content">
                <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
            </div>
        </div>
        <?php if ($hassidepre) { ?>
        <div id="report-region-wrap">
            <div id="report-region-pre" class="block-region">
                <div class="region-content">
                    <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    </div>

<!-- START OF FOOTER -->
    <?php if ($hasfooter) { ?>
    <div id="page-footer" class="clearfix">
     <div id="innerFooter">
        <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
        <?php
        echo $OUTPUT->login_info();
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
    </div>
    <?php } ?>
</div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>