<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">

<title>
    <?php
    global $page, $paged;
    wp_title( '|', true, 'right' );
    bloginfo( 'name' );
    $site_description = get_bloginfo( 'description', 'display' );
    
    if ( $site_description && ( is_home() || is_front_page() ) ){
        echo " | $site_description";
    }
    
    if ( $paged >= 2 || $page >= 2 ){
        echo ' | ' . sprintf( __( 'Page %s', 'wpestate' ), max( $paged, $page ) );
    }
    ?>
</title>



<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 
<?php 
$favicon        =   esc_html( get_option('wp_estate_favicon_image','') );
if ( $favicon!='' ){
    echo '<link rel="shortcut icon" href="'.$favicon.'" type="image/x-icon" />';
} else {
    echo '<link rel="shortcut icon" href="'.get_template_directory_uri().'/img/favicon.gif" type="image/x-icon" />';
}


wp_head();


if( is_tax() ) {
    echo '<meta name="description" content="'.strip_tags( term_description('', get_query_var( 'taxonomy' ) )).'" >';
}

if (get_post_type()== 'estate_property'){
    $image_id       =   get_post_thumbnail_id();
    $share_img= wp_get_attachment_image_src( $image_id, 'full'); 
    ?>
    <meta property="og:image" content="<?php echo $share_img[0]; ?>"/>
    <meta property="og:image:secure_url" content="<?php echo $share_img[0]; ?>" />
<?php 
} 
?>
</head>



<?php 

$wide_class      =   '';
$wide_status     =   esc_html(get_option('wp_estate_wide_status',''));
if($wide_status==1){
    $wide_class=" wide ";
}

if( isset($post->ID) && wpestate_half_map_conditions ($post->ID) ){
    $wide_class="wide fixed_header ";
}


$halfmap_body_class='';
if( isset($post->ID) && wpestate_half_map_conditions ($post->ID) ){
    $halfmap_body_class=" half_map_body ";
}

if(esc_html ( get_option('wp_estate_show_top_bar_user_menu','') )=="yes"){
    $halfmap_body_class.=" has_top_bar ";
}

$logo_header_type    =   get_option('wp_estate_logo_header_type','');
$header_transparent_class   =   '';

$header_transparent         =   get_option('wp_estate_header_transparent','');


//  $header_transparent_class=' header_transparent '; 

if(isset($post->ID) && !is_tax() && !is_category() ){
        $header_transparent_page    =   get_post_meta ( $post->ID, 'header_transparent', true);
        if($header_transparent_page=="global" || $header_transparent_page==""){
            if ($header_transparent=='yes'){
                $header_transparent_class=' header_transparent ';
            }
        }else if($header_transparent_page=="yes"){
            $header_transparent_class=' header_transparent ';
        }
}else{
    if ($header_transparent=='yes'){
            $header_transparent_class=' header_transparent ';
    }
}

$logo           =   get_option('wp_estate_logo_image','');   
$logo_margin    =   intval( get_option('wp_estate_logo_margin','') );
?>




<body <?php body_class($halfmap_body_class); ?>>  
   

<?php   get_template_part('templates/mobile_menu' ); ?> 
    
<div class="website-wrapper" id="all_wrapper" >
<div class="container main_wrapper <?php print $wide_class; print 'has_header_'.$logo_header_type.' '.$header_transparent_class; ?> ">

    <div class="master_header <?php print $wide_class.' '.$header_transparent_class; ?>">
        
        <?php   
            if(esc_html ( get_option('wp_estate_show_top_bar_user_menu','') )=="yes"){
                get_template_part( 'templates/top_bar' ); 
            } 
            get_template_part('templates/mobile_menu_header' );
        ?>
       
        
        <div class="header_wrapper <?php echo 'header_'.$logo_header_type;?> ">
            <div class="header_wrapper_inside">
                
                <div class="logo" >
                    <a href="<?php echo home_url('','login');?>">
                        <?php  
                        if ( $logo!='' ){
                           print '<img style="margin-top:'.$logo_margin.'px;" src="'.$logo.'" class="img-responsive retina_ready" alt="logo"/>';	
                        } else {
                           print '<img class="img-responsive retina_ready" src="'. get_template_directory_uri().'/img/logo.png" alt="logo"/>';
                        }
                        ?>
                    </a>
                </div>   

              
                <?php 
                if(esc_html ( get_option('wp_estate_show_top_bar_user_login','') )=="yes"){
                   get_template_part('templates/top_user_menu');  
                }
                ?>    
                <nav id="access">
                    <?php 
                    wp_nav_menu( array( 'theme_location' => 'primary' ) );
                    ?>
                </nav><!-- #access -->
            </div>
        </div>

     </div> 
    
<?php 
$show_adv_search_status     =   get_option('wp_estate_show_adv_search','');
$global_header_type         =   get_option('wp_estate_header_type','');
$adv_search_type            =   get_option('wp_estate_adv_search_type','');
$hideclass                  =   get_field('hide_advance_search');
if($hideclass =='no'): $cls = 'hide-advance-search-form'; else: $cls = ''; endif;
?>
<div class="header_media with_search_<?php echo $adv_search_type;?>  <?php echo $cls;?>">
<?php
	// vars
	$queried_object = get_queried_object(); 
	$taxonomy = $queried_object->taxonomy;
	$term_id = $queried_object->term_id;  
	// load thumbnail for this taxonomy term (term object)
	$thumbnail = get_field('category_banner', $queried_object);
	// load thumbnail for this taxonomy term (term string)
	$thumbnail = get_field('category_banner', $taxonomy . '_' . $term_id);

	if(is_blog()){
	   if($thumbnail!=''):
	       print '<img src="'.$thumbnail.'"  class="img-responsive category-banner-image" alt="header_image"/>';
	   else:
		   print '<img src="'.get_bloginfo('url').'/wp-content/uploads/2016/02/page_header_iamge.jpg"  class="img-responsive" alt="header_image"/>';
	   endif;
	}
?>
</div> 
    
  <div class="container content_wrapper">