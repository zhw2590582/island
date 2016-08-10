<?php
// 获取选项
$keywords = cs_get_option( 'i_seo_keywords' ); 
$description = cs_get_option( 'i_seo_description' );
$favicon = cs_get_option( 'i_favicon_icon' ); 
$page = cs_get_option('i_pagination'); 
$style = cs_get_option('i_ajax_style'); 
$symbol = cs_get_option( 'i_symbol' ); 
$logo = cs_get_option( 'i_logo_image' ); 
$search = cs_get_option( 'i_search' ); 
$fixed = cs_get_option( 'i_menu_fixed' ); 
$scroll = cs_get_option( 'i_menu_scroll' ); 
$login = cs_get_option( 'i_login' ); 
$sliders = cs_get_option( 'i_slider' ); 
$link = cs_get_option( 'i_slider_link' );
$newtab = cs_get_option( 'i_slider_newtab' ); 
$copyright = cs_get_option( 'i_foot_copyright' );  
$leftbar = cs_get_option( 'i_leftbar_show' );  
$rightbar = cs_get_option( 'i_rightbar_show' ); 
$rb = cs_get_option( 'i_rightbar_scroll' ); 
$post_img = cs_get_option( 'i_post_image' ); 
$img_setup = cs_get_option( 'i_post_setup' ); 
$leftmenu = cs_get_option( 'i_menu_skin' ); 
$leftcode = cs_get_option( 'i_menu_code' ); 
$sidebar = cs_get_option( 'i_sidebar_switch' );  
$logo_color = cs_get_option( 'i_logo_color' );  
$sticky = cs_get_option( 'i_post_sticky' ); 
$exclude = cs_get_option( 'i_exclude_sticky' ); 
$sticky_img = cs_get_option( 'i_sticky_image' ); 
$leftbar_view = cs_get_option( 'i_leftbar_view' ); 
$banner_test = cs_get_option( 'i_banner_text' ); 
$switcher = cs_get_option( 'i_switcher' ); 
$qrcodes = cs_get_option( 'i_code_qrcodes' ); 
$qrcodes_img = cs_get_option( 'i_qrcodes_img' ); 
$bulletin = cs_get_option( 'i_bulletin' ); 
$layout = cs_get_option( 'i_layout' );  
?> 

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php if(function_exists('show_wp_title')){show_wp_title();} ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0,minimal-ui">
	<meta name="keywords" content="<?php echo $keywords ?>" />
	<meta name="description" content="<?php echo $description ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" href="<?php echo $favicon; ?>" title="Favicon">	
	<!--[if lte IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" media="screen"/>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/ie-html5.js"></script>
	<![endif]-->
	<script type="text/javascript">document.documentElement.className = 'js';</script>
	<?php wp_head(); ?>
</head>
<?php if ( $page == 'i_ajax' ) { 
 $bar = cs_get_option('i_ajax_style');
	$load_style = '';
	switch ($bar) {
		case "style1":
			$load_style = 'ajax_load loading_style1';
			break;

		case "style2":
			$load_style = 'ajax_load loading_style2';
			break;

		case "style3":
			$load_style = 'ajax_load loading_style3';
			break;
	} 
} ?>
	
<body <?php body_class($load_style); ?>>	
	<?php if (is_mobile()) { ?>
		<div style="display:none;"><?php the_post_thumbnail( 'medium' ); ?></div>
	<?php }?>	

	<header class="header fixed">
		<div class="container clearfix">
			<?php if ( $symbol == 'i_text' ) { ?>
				<hgroup>	
					<span class="logo-text <?php if ( $logo_color == true ) { echo 'in';}?>"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></span>
				</hgroup>
			<?php }elseif( $symbol == 'i_logo' ){ ?>
				<span class="logo-image">
					<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
						<img class="logo" src="<?php echo $logo ;?>" alt="<?php bloginfo('name'); ?>" />
					</a>
				</span> 
			<?php }else{ ?>
				<hgroup>	
					<span class="logo-text <?php if ( $logo_color == true ) { echo 'in';}?>"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><i class="icon-logo"></i></a></span>
				</hgroup>
			<?php } ?>
	    <nav role="navigation" class="header-menu">  	
			<?php wp_nav_menu(array('theme_location' => 'main', 'container' => 'div', 'container_class' => 'header-menu-wrapper arrow-up-right', 'menu_class' => 'header-menu-list', 'walker' => new pinthis_submenu_wrap())); ?>
	    </nav>		
		
	<?php if ($switcher == true && !is_mobile()) { ?>
	<!-- 切换皮肤 -->	
		<div class="skin">皮 肤<ul class="clearfix">
            <li class="skin1"><a href="<?php echo get_template_directory_uri(); ?>/skin/switcher.php?style=skin01.css"><span></span>复古</a></li>
            <li class="skin2"><a href="<?php echo get_template_directory_uri(); ?>/skin/switcher.php?style=skin02.css"><span></span>酷黑</a></li>
            <li class="skin3"><a href="<?php echo get_template_directory_uri(); ?>/skin/switcher.php?style=skin03.css"><span></span>清新</a></li>
			</ul>
		</div>
	<?php }?>	
		
	<?php if ($login == true) { ?>
		
			<div class="member_login">
			<?php $current_user = wp_get_current_user(); ?>
			<?php if ( is_user_logged_in() ) { ?>
			<div class="profile dropel">
				<nav class="member">
					<a href="<?php if(current_user_can('level_10')){ echo admin_url( 'admin.php?page=cs-framework' ) ;}else {echo admin_url( 'index.php' ) ;}  ?>" class="tooltip" title="<?php echo __('后台管理', 'pinthis'); ?>">
						<span class="avatar">
							<?php if (strlen(get_avatar($current_user->ID, 40)) > 0) { ?>
								<?php echo get_avatar($current_user->ID, 40); ?>
							<?php } else { ?>
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/default-avatar.png" alt="<?php echo $current_user->display_name; ?>">
							<?php } ?>
						</span>
					</a>	
				</nav>
				<div class="dropdown">
					<div class="dropdown-wrapper arrow-up-left">
						<ul class="sub-menu">
							<li class="name">
								<a href="<?php if(current_user_can('level_10')){ echo admin_url( 'admin.php?page=cs-framework' ) ;}else {echo admin_url( 'index.php' ) ;}  ?>"><i class="fa fa-tachometer"></i><?php echo $current_user->display_name; ?></a>
							</li>
							<li class="edit-post">
								<a href="<?php echo admin_url( 'post-new.php' ) ; ?>"><i class="fa fa-edit"></i><?php echo __('发文章', 'pinthis'); ?></a>
							</li>							
							<li class="log-out">
								<a href="<?php echo wp_logout_url(home_url()); ?>" class="icon-login out tooltip"><i class="fa fa-sign-out"></i><?php echo __('登出', 'pinthis'); ?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php } else { ?>
				<div class="log-in-out dropel">
					<a href="#" onclick="return false;" title="<?php echo __('登录', 'pinthis'); ?>" class="login-toggle icon-login tooltip"><i class="fa fa-user"></i></a>
					<div class="login_bg">
						<div class="dropdown-wrapper arrow-up-left">
							<?php 
								$login_form_args = array (
									'form_id' => 'login-form',
									'label_log_in' => __('登录', 'pinthis'),
									'remember' => false,
									'value_remember' => false
								); 
							?> 
							<?php wp_login_form($login_form_args); ?>
							<p class="login-links clearfix">
								<span class="alignleft">
									<a href="<?php echo htmlspecialchars(wp_lostpassword_url(get_permalink()), ENT_QUOTES); ?>"><?php echo __('忘记密码', 'pinthis'); ?></a>
								</span>
								<?php if (get_option('users_can_register')) { ?>
									<span class="alignright"><?php wp_register('', ''); ?></span>
								<?php } ?>
							</p>
						</div>
					</div>
				</div>
			<?php } ?>	
		</div>		
		
	<?php } ?>	
	
	<?php if ($search == true && !is_mobile()) { ?>
	<!-- 搜索栏 -->	
		<div id="searchbox">
			<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
				<input type="text" class="search-text" name="s" value="<?php _e( '搜索...' , 'tie' ) ?>" onfocus="if (this.value == '<?php _e( '搜索...' , 'tie' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( '搜索...' , 'tie' ) ?>';}"  />
				<i class="fa fa-search"></i>
			</form>
		</div>
	<?php }?>		
	
	<a id="menu-toggle" href="javascript:void(0)" class="menu-toggle"></a>
	<div class="clearfix"></div>
	</div>
	</header>
	
	<nav role="navigation" class="mobile-nav">  	
		<?php wp_nav_menu(array('theme_location' => 'main', 'menu_class' => 'mobile-menu')); ?>
	</nav>		
	
	<?php if (!is_mobile() && $layout == 'i_box') { ?>
		<div id="banner" class="with-tooltip"  data-tooltip="<?php echo $banner_test ?>"></div>
		<div class="banner_bg"></div>
	<?php } ?>    
    
    <div id="wp_box" class="container">    
    
	<?php if ($leftbar_view == true) { ?>
	<!-- 左侧边栏 -->	
		<div class="leftbar_bg"></div>
		<div class="leftbar<?php if ($leftmenu == 'menu_skin_1') {echo ' leftopen';} ?>">
			<!-- 左菜单 -->
			<div class="left_menu">
				<?php 
				    $i_width=$layout=='i_width'?'right':'left';                                      
					$my_menus = cs_get_option( 'i_menu' );
					echo '<ul class="menu_link">';
					if( ! empty( $my_menus ) ) {
					  foreach ( $my_menus as $menu ) {
						$iconstyle = $menu['i_menu_style']; 
						echo '<li>';
						if( ! empty( $menu['i_menu_link'] ) ){echo '<a href="'. $menu['i_menu_link'] .'" class="simptip-position-'.$i_width.' simptip-smooth simptip-movable" data-tooltip="'. $menu['i_menu_title'] .'"';}else{echo '<a href="javascript:void(0)"  class="simptip-position-'.$i_width.' simptip-smooth simptip-movable" data-tooltip="'. $menu['i_menu_title'] .'" ';}
						if ( $menu['i_menu_newtab'] == true) { echo 'target="_black"';}
						if ($iconstyle == 'i_icon') {echo '><i class="'. $menu['i_menu_icon'] .'"></i>';} else {echo '><img src="'. $menu['i_menu_image'] .'">';}			
						echo '<span>'. $menu['i_menu_title'] .'</span><div class="clearfix"></div></a>';
						echo '</li>';
					  }
					}		
					echo '</ul>';
				?>
			</div>
		</div>
	<?php } ?>		
			
	<?php if (!is_mobile() && $layout == 'i_box') { ?>
        <div class="wrapper_bg"></div>
	<?php } ?>          
        
	<div id="wrapper" <?php if ($rightbar != true){echo 'class="toggle-wrapper"';}?>>
		<div id="main">
		
	<?php if(is_home() && !is_paged()) { ?> 
		<!-- 调用幻灯片 -->
		<?php if ( $sliders == true || $sticky == true ) { ?> <div id="header_slider" 	<?php if (!is_mobile()) { ?> class=" fadeInDown animated <?php }?>"> <?php } ?>	
		<?php if ($sliders == true) { ?>
		<div class="slider">
			<?php	
				$my_sliders = cs_get_option( 'i_slider_custom' );
				echo '<ul class="lightSlider">';
				if( ! empty( $my_sliders ) ) {
				  foreach ( $my_sliders as $slider ) {
					echo '<li>';
				    if( ! empty( $slider['i_slider_link'] ) ){ echo '<a href="'. $slider['i_slider_link'] .'"';}
					if ( ! empty( $slider['i_slider_link'] ) && $slider['i_slider_newtab'] == true) { echo 'target="_black">';}else{ if ( ! empty( $slider['i_slider_link'] )){ echo '>';}}
					echo '<img class=" " src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-echo="'. $slider['i_slider_image'] .'"/><p>'. $slider['i_slider_text'] .'</p>';
				    if( ! empty( $slider['i_slider_link'] ) ){ echo '</a>';}				    
					echo '</li>';
				  }
				}		
				echo '</ul>';
			?>	
		</div>
		<?php } ?>
		
		<?php if ($sticky == true) {?>
			<!-- 调用置顶文章 -->
			<div class="sticky_slider">
			<?php query_posts(array('post__in'=>get_option('sticky_posts'))); ?>
			<ul id="sticky">
				<?php while (have_posts()) : the_post(); ?>
					<li>
						<?php if ( has_post_thumbnail()) { ?>
							<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
						<?php }else{?>
							<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $sticky_img ?>"></a>
						<?php } ?>
						<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>				
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_query(); ?>
			</div>
		<?php }	?>	
		<?php if ( $sliders == true || $sticky == true ) { ?> </div><?php } ?>
	<?php } ?>	
	
	<?php if(is_home() && !is_paged() && !is_mobile()) { ?> 
		<?php if ($bulletin == true) {?>
		<div id="bulletin_box">
			<i class="fa fa-bell-o"></i>
			<div id="bulletin">
				<?php	
					$my_bulletins = cs_get_option( 'i_bulletin_custom' );
					echo '<ul class="bulletin_list">';
					if( ! empty( $my_bulletins ) ) {
					  foreach ( $my_bulletins as $bulletin ) {
						echo '<li>';
						if( ! empty( $bulletin['i_bulletin_link'] ) ){ echo '<a href="'. $bulletin['i_bulletin_link'] .'"';}
						if ( ! empty( $bulletin['i_bulletin_link'] ) && $bulletin['i_bulletin_newtab'] == true) { echo 'target="_black">';}else{ if ( ! empty( $bulletin['i_bulletin_link'] )){ echo '>';}}
						echo ''. $bulletin['i_bulletin_text'] .'';
						if( ! empty( $bulletin['i_bulletin_link'] ) ){ echo '</a>';}				    
						echo '</li>';
					  }
					}		
					echo '</ul>';
				?>	
			</div>
			<a href="#" class="bulletin_remove"><i class="fa fa-close"></i></a>
		</div>
		<?php }	?>	
	<?php } ?>		