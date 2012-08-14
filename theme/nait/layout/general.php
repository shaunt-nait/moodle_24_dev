<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
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
<script type="text/javascript">
function GetQuerystringValue( name ){  
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");  
	var regexS = "[\\?&]"+name+"=([^&#]*)";  
	var regex = new RegExp( regexS );  
	var results = regex.exec( window.location.href );  
	if( results == null )    
		return "";  
	else    
			return results[1];
	}
function ViewCourseOutline(){
	//NAIT CHANGE: Change URL When copying to different systems
 	//Old
	//window.open('http://academictools.nait.ca/CourseOutline/GetCourseOutlineForMoodleCourse?id=' + GetQuerystringValue("id") );
	window.open('<?php echo $CFG->courseOutlineUrl?>/CourseOutline/GetCourseOutlineForMoodleCourse?id=' + GetQuerystringValue("id") );
	
	}
</script>
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

		<!--  <div id="headerLeft"></div> -->

        <div class="headermain">

       		<a class="mainlogo" href="<?php echo $CFG->wwwroot.'/' ?>"><img src="<?php echo $OUTPUT->pix_url('logo', 'theme');?>" alt="NAIT" /></a><?php //echo $PAGE->heading ?>

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

        <!--  <div id="headerRight"></div> -->

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

    <div id="page-content">
    	<div id="innerPageContent">
        	<div id="region-main-box">
            	<div id="region-post-box">

                	<div id="region-main-wrap">
                		<div id="region-main-holder">
                    		<div id="region-main">
                        		<div class="region-content">
                            		<?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
                        		</div>
                    		</div>
                    	</div>
                	</div>

                	<?php if ($hassidepre) { ?>
                	<div id="region-pre" class="block-region">
                    	<div class="region-content">
                        	<?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                    	</div>
                	</div>
                	<?php } ?>

                	<?php if ($hassidepost) { ?>
                	<div id="region-post" class="block-region">
                    	<div class="region-content">
                        	<?php echo $OUTPUT->blocks_for_region('side-post') ?>
                    	</div>
                	</div>
               		<?php } ?>
            	</div>
        	</div>
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
<?php if (strpos($PAGE->url, 'https') === false) {?>
<div>
 <img src="http://academictools.nait.ca/Chart/GatherMoodleData?username=<?php echo $USER->username ?>&courseId=<?php echo $COURSE->id ?>&currentURL=<?php echo base64_encode($PAGE->url) ?>&timestamp=<?php echo time() ?>&hostname=<?php echo base64_encode(gethostname()) ?>" />
</div>
<?php }?>
</body>
</html>