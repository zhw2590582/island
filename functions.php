<?php
/**
 * Island 功能和定义
 *
 * @package Island
 * @since island 1.0.0
 */
 
/* 引入在线更新(new)  */
require 'theme_update_check.php';
$MyUpdateChecker = new ThemeUpdateChecker(
    'Island',
    'https://kernl.us/api/v1/theme-updates/569f8a0e7ba9bc01527df762/'
);

/* 引入在线更新(old) 
require_once('wp-updates-theme.php');
new WPUpdatesThemeUpdater_1340( 'http://wp-updates.com/api/2/theme', basename( get_template_directory() ) );
*/

/* 引入后台框架 */
require_once dirname(__FILE__) . '/cs-framework/cs-framework.php'; 
 
/* 加载脚本和样式 */
function island_scripts_styles() {
	
    /* 注册样式 */
    wp_enqueue_style('style', get_template_directory_uri() . "/style.css", array() , '0.9', 'screen');
    wp_enqueue_style('font-awesome-css', get_template_directory_uri() . "/cs-framework/assets/css/font-awesome.css", array() , '0.3', 'screen');
	
    /* 注册脚本 */
    wp_enqueue_script('jquery');
    wp_enqueue_script('plugins-js', get_template_directory_uri() . '/js/plugins.js', false, '0.3', true);
    wp_enqueue_script('comments-ajax', get_template_directory_uri() . '/comments-ajax.js', false, '0.4', true);
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js', false, '2.0', true);
	
	/* 代码高亮 */
    wp_register_script('prettify', get_template_directory_uri() . '/js/prettify.js', false, '0.3', true);
	$prettify = cs_get_option( 'i_code_prettify' ); 
	if ($prettify == true) {
		wp_enqueue_script('prettify');
	}	
	
	/* 二维码 */
    wp_register_script('qrcode', get_template_directory_uri() . '/js/qrcode.js', false, '0.3', true);
	$qrcodes = cs_get_option( 'i_code_qrcodes' ); 
	if ($qrcodes == true && !is_mobile()) {
		wp_enqueue_script('qrcode');
	}
	/* 萤火虫背景 */
	wp_register_script('circle', get_template_directory_uri() . '/js/circle.js', false, '0.3', true);
	$circle = cs_get_option( 'i_circle' );
 	if ( $circle == true && !is_mobile() ) {
		wp_enqueue_script('circle');	
	}
	
	/* Snowfall */
	wp_register_script('snowfall', get_template_directory_uri() . '/js/snowfall.js', false, '0.3', true);
	$snowfall = cs_get_option( 'i_snowfall' );
 	if ( $snowfall == true && !is_mobile() ) {
		wp_enqueue_script('snowfall');	
	}	
	
	/* 自定义皮肤 */
    wp_register_style('switcher', get_template_directory_uri() . "/skin/switcher.php", array() , '0.3', 'screen');
    wp_register_style('skin01', get_template_directory_uri() . "/skin/skin01.css", array() , '0.3', 'screen');
    wp_register_style('skin02', get_template_directory_uri() . "/skin/skin02.css", array() , '0.3', 'screen');
    wp_register_style('skin03', get_template_directory_uri() . "/skin/skin03.css", array() , '0.3', 'screen');
    $skin = cs_get_option('i_skin');
    $switcher = cs_get_option('i_switcher');

    if ($switcher == true) {
        wp_enqueue_style('switcher');
    }else {
		switch ($skin) {
			case "i_skin01":
				wp_enqueue_style('skin01');
				break;

			case "i_skin02":
				wp_enqueue_style('skin02');
				break;	
				
			case "i_skin03":
				wp_enqueue_style('skin03');
				break;					
		}	
	}

	/* Logo字体图标 */	
	wp_register_style('logo', get_template_directory_uri() . "/logo/logo.css", array() , '0.3', 'screen');
	$symbol = cs_get_option( 'i_symbol' );
	if ( $symbol == 'i_font' ) {
		wp_enqueue_style('logo');
	}	
	
}
add_action('wp_enqueue_scripts', 'island_scripts_styles'); 

/* 布局类名 */
function theme_box($classes) {
    $layout = cs_get_option( 'i_layout' );  
	if ( $layout == 'i_width' ) {
        $classes[] = 'wp_width';
    }else {
        $classes[] = 'wp_box';
	}
    return $classes;
}
add_filter('body_class','theme_box');

/* 边栏类名 */
function leftbar_view($classes) {
    $leftbar_view = cs_get_option( 'i_leftbar_view' ); 
	if ( $leftbar_view == true ) {
        $classes[] = 'leftbar_open';
    }else {
        $classes[] = 'leftbar_close';
	}
    return $classes;
}
add_filter('body_class','leftbar_view');

/* 引入密钥验证 */
include ('verify.php');

/* 引入CDN */
$qiniu = cs_get_option('i_qiniu');
$qiniu_link = cs_get_option('i_qiniu_link');
if ($qiniu == true && !empty( $qiniu_link )) {
	include ('qiniu.php');
}

/* 禁用 WordPress 4.4+ 的响应式图片功能 */
add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );

/* 禁用embeds功能 */
function disable_embeds_init() {
	global $wp;
	$wp->public_query_vars = array_diff( $wp->public_query_vars, array( 'embed', ) );
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	add_filter( 'embed_oembed_discover', '__return_false' );
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' ); 
	} 
	add_action( 'init', 'disable_embeds_init', 9999 );
	function disable_embeds_tiny_mce_plugin( $plugins ) {
		return array_diff( $plugins, array( 'wpembed' ) ); 
	}
	function disable_embeds_rewrites( $rules ) {
		foreach ( $rules as $rule => $rewrite ) {
			if ( false !== strpos( $rewrite, 'embed=true' ) ) { unset( $rules[ $rule ] ); } 
		}  return $rules;
	}
	function disable_embeds_remove_rewrite_rules() { 
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
	flush_rewrite_rules(); } 
	register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' ); 
	function disable_embeds_flush_rewrite_rules() { 
		remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' ); flush_rewrite_rules(); 
	} 
	register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );

/* 引入作品模板 */
include("template-portfolio.php");

/* 引入推荐插件 */
$player = cs_get_option('i_player');
if ($player == true) {
	require_once( get_template_directory().'/TGM/plugins.php' );
}

/* 调用ssl 头像链接 */
function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');

/* 自动特色图 */
function autoset_featured() {
          global $post;
          $already_has_thumb = has_post_thumbnail($post->ID);
              if (!$already_has_thumb)  {
              $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
                          if ($attached_image) {
                                foreach ($attached_image as $attachment_id => $attachment) {
                                set_post_thumbnail($post->ID, $attachment_id);
                                }
                           }
                        }
      }  //end function
	  
$auto = cs_get_option( 'i_auto_featured' ); 
if ($auto == true) {
	add_action('the_post', 'autoset_featured');
	add_action('save_post', 'autoset_featured');
	add_action('draft_to_publish', 'autoset_featured');
	add_action('new_to_publish', 'autoset_featured');
	add_action('pending_to_publish', 'autoset_featured');
	add_action('future_to_publish', 'autoset_featured');
}	  

/* 禁用emoji */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );    
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array  Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	return array_diff( $plugins, array( 'wpemoji' ) );
}
function smilies_reset() {
global $wpsmiliestrans;

// don't bother setting up smilies if they are disabled
if ( !get_option( 'use_smilies' ) )
    return;

    $wpsmiliestrans = array(
    ':mrgreen:' => 'icon_mrgreen.gif',
    ':neutral:' => 'icon_neutral.gif',
    ':twisted:' => 'icon_twisted.gif',
      ':arrow:' => 'icon_arrow.gif',
      ':shock:' => 'icon_eek.gif',
      ':smile:' => 'icon_smile.gif',
        ':???:' => 'icon_confused.gif',
       ':cool:' => 'icon_cool.gif',
       ':evil:' => 'icon_evil.gif',
       ':grin:' => 'icon_biggrin.gif',
       ':idea:' => 'icon_idea.gif',
       ':oops:' => 'icon_redface.gif',
       ':razz:' => 'icon_razz.gif',
       ':roll:' => 'icon_rolleyes.gif',
       ':wink:' => 'icon_wink.gif',
        ':cry:' => 'icon_cry.gif',
        ':eek:' => 'icon_surprised.gif',
        ':lol:' => 'icon_lol.gif',
        ':mad:' => 'icon_mad.gif',
        ':sad:' => 'icon_sad.gif',
          '8-)' => 'icon_cool.gif',
          '8-O' => 'icon_eek.gif',
          ':-(' => 'icon_sad.gif',
          ':-)' => 'icon_smile.gif',
          ':-?' => 'icon_confused.gif',
          ':-D' => 'icon_biggrin.gif',
          ':-P' => 'icon_razz.gif',
          ':-o' => 'icon_surprised.gif',
          ':-x' => 'icon_mad.gif',
          ':-|' => 'icon_neutral.gif',
          ';-)' => 'icon_wink.gif',
    // This one transformation breaks regular text with frequency.
    //     '8)' => 'icon_cool.gif',
           '8O' => 'icon_eek.gif',
           ':(' => 'icon_sad.gif',
           ':)' => 'icon_smile.gif',
           ':?' => 'icon_confused.gif',
           ':D' => 'icon_biggrin.gif',
           ':P' => 'icon_razz.gif',
           ':o' => 'icon_surprised.gif',
           ':x' => 'icon_mad.gif',
           ':|' => 'icon_neutral.gif',
           ';)' => 'icon_wink.gif',
          ':!:' => 'icon_exclaim.gif',
          ':?:' => 'icon_question.gif',
    );
}
smilies_reset();

 /* SVG支持 */
function my_upload_mimes($mimes = array()) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'my_upload_mimes');

/*
 * 首页忽略置顶文章
 */
function island_alter_main_loop($query){
    if (!$query->is_home() || !$query->is_main_query())
        return;
    $query->set('ignore_sticky_posts', 1);
}
$sticky = cs_get_option( 'i_post_sticky' ); 
if ($sticky == true) {
	add_action('pre_get_posts', 'island_alter_main_loop'); 	
}

/* Lazyload 功能,默认移动设备不开启，默认特色图不开启 */
function add_image_placeholders($content) {
    if (is_feed() || is_preview() || (function_exists('is_mobile') && is_mobile())) return $content;
    if (false !== strpos($content, 'data-original')) return $content;
    $placeholder_image = apply_filters('lazyload_images_placeholder_image', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
    $content = preg_replace('#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf('<img${1}src="%s" data-echo="${2}"${3}>', $placeholder_image) , $content);
    return $content;
}
$post_img = cs_get_option('i_post_image');
$img_setup = cs_get_option('i_post_setup');
$avatar_img = cs_get_option('i_comment_avatar');
if ($post_img == true && $img_setup == 'i_lazyload') {
    add_filter('the_content', 'add_image_placeholders', 99);
}
if (!is_admin() && $avatar_img == true) {
    add_filter('get_avatar', 'add_image_placeholders', 11);
}
// add_filter( 'post_thumbnail_html', 'add_image_placeholders', 11 );

/* 引入喜欢属性 */
$like = cs_get_option( 'i_post_like' );
if ($like == true) {
 	include_once ('post-like.php');
} 

/* 激活后跳转到密钥或设置页 */
 
add_action('after_switch_theme', 'Init_theme');
function Init_theme($oldthemename) {
	global $pagenow;
	if ('themes.php' == $pagenow && isset($_GET['activated'])) {
		global $verify;
		$key = cs_get_customize_option( 'lazycat_key' ); 
		$verify = get_option('Island_license_key');
		if (!empty($verify) || $key == '' ) {
			wp_redirect(admin_url('admin.php?page=cs-framework'));
			exit;
		} else {
			wp_redirect(admin_url('options-general.php?page=' . get_stylesheet_directory() . '/verify.php'));
			exit;
		}
	}
}


/* 统一标签尺寸 */
function custom_tag_cloud_widget($args) {
  $args['largest'] = 13; 
  $args['smallest'] = 13; 
  $args['unit'] = 'px'; 
  $args['number'] = '50'; 
  $args['orderby'] = 'count'; 
  $args['order'] = 'DESC'; 
  return $args;
}
add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );

/* 修改时间格式 */
function timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return '刚刚';     
    $interval = array (         
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

/**
 * 管理员类名
 */
function add_admin_body_class( $classes ) {
    return "$classes zhw_admin";
}
$theme_url = wp_get_theme()->display('ThemeURI');
$wp_url = home_url('/');
if ($theme_url == $wp_url) {
  add_filter( 'admin_body_class', 'add_admin_body_class' );
}

/* 版本类名 */
function theme_pro( $classes ) {
  global $verify;
  $key = cs_get_customize_option( 'lazycat_key' ); 
    $verify = get_option('Island_license_key');
    if (!empty($verify) || $key == 'zhw2590582') {
      return "$classes theme_pro";
    } else {
      return "$classes theme_free";
    }
}
add_action('admin_body_class', 'theme_pro');

/* 启用后台引导 */
add_action('admin_enqueue_scripts', 'my_admin_enqueue_scripts');
function my_admin_enqueue_scripts() {
    wp_enqueue_style('wp-pointer');
    wp_enqueue_script('wp-pointer');
    add_action('admin_print_footer_scripts', 'my_admin_print_footer_scripts');
}
function my_admin_print_footer_scripts() {
    $dismissed = explode(',', (string)get_user_meta(get_current_user_id() , 'dismissed_wp_pointers', true));
    if (!in_array('my_pointer', $dismissed)):
        $pointer_content = '<h3>你好！验证 Island 主题成功</h3>';
        $pointer_content.= '<p>主题设置从这里进入，使用中若有疑问，可以联系老赵</p>';
?>
        <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready( function($) {
            $('#toplevel_page_cs-framework').pointer({
                content: '<?php
        echo $pointer_content; ?>',
				position:		{
									edge:	'left', 
									align:	'center' 
								},
				pointerWidth:	350,
                close  : function() {
                    jQuery.post( '<?php
        bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php', {
                        pointer: 'my_pointer',
                        action: 'dismiss-wp-pointer'
                    });
                }
            }).pointer('open');
        });
        //]]>
        </script>
        <?php
    endif;
}

/* 添加选项按钮到工具栏 */
function tie_admin_bar() {
    global $wp_admin_bar;
    global $verify;
	$key = cs_get_customize_option( 'lazycat_key' ); 
    $verify = get_option('Island_license_key');
    if (!empty($verify) || $key == 'zhw2590582') {
        if (current_user_can('switch_themes')) {
            $wp_admin_bar->add_menu(array(
                'parent' => 0,
                'id' => 'mpanel_page',
                'title' => 'Island 主题选项',
                'href' => admin_url('admin.php?page=cs-framework')
            ));
        }
    } else {
        if (current_user_can('switch_themes')) {
            $wp_admin_bar->add_menu(array(
                'parent' => 0,
                'id' => 'mpanel_verify',
                'title' => '主题未验证',
                'href' => admin_url('options-general.php?page=' . get_stylesheet_directory() . '/verify.php')
            ));
        }
    }
}
add_action('wp_before_admin_bar_render', 'tie_admin_bar');

if (!isset($content_width)) $content_width = 690; /* 像素 */
if (!function_exists('island_setup')):
    /**
     * 设置默认的主题，并注册为WordPress的各种功能的支持.
     * @since island 1.0.0
     */
    function island_setup() {
        /* 添加默认的文章和评论的RSS */
        add_theme_support('automatic-feed-links');
        /* 启用缩略图的支持 */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(200, 200, true); // 默认缩略图
        add_image_size('large-image', 9999, 9999, false);
		
        /* 启用文章形式的支持*/
        add_theme_support('post-formats', array(
            'aside',
            'status'
        )); 
		
        /* 启用自定义菜单 */
        register_nav_menus(array(
            'main' => __('Main Menu', 'island') ,
        ));
        /* 启动主题可利用的语言 */
        load_theme_textdomain('island', get_template_directory() . '/languages');
    }
endif;
add_action('after_setup_theme', 'island_setup');

/* 隐藏系统工具栏 */
$toolbar = cs_get_option('i_toolbar');
function hide_admin_bar($flag) {
    return false;
}
if ($toolbar == true) {
    add_filter('show_admin_bar', 'hide_admin_bar');
}

/* 页码分页 */
function pagination($query_string){   
	global $posts_per_page, $paged;   
	$my_query = new WP_Query($query_string ."&posts_per_page=-1");   
	$total_posts = $my_query->post_count;   
	if(empty($paged))$paged = 1;   
	$prev = $paged - 1;   
	$next = $paged + 1;   
	$range = 2; // only edit this if you want to show more page-links   
	$showitems = ($range * 2)+1;   
  
$pages = ceil($total_posts/$posts_per_page);   
	if(1 != $pages){   
		echo "<div class='pagination'>";   
		echo ($paged > 2 && $paged+$range+1 > $pages && $showitems < $pages)? "<a href='".get_pagenum_link(1)."'>最前</a>":"";   
		echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."'>上一页</a>":"";   
		for ($i=1; $i <= $pages; $i++){   
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){   
				echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";   
			}   
		}   
		echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."'>下一页</a>" :"";   
		echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."'>最后</a>":"";   
		echo "</div>\n";   
	}   
}  

// 禁用谷歌字体
class Disable_Google_Fonts {
        public function __construct() {
                add_filter( 'gettext_with_context', array( $this, 'disable_open_sans' ), 888, 4 );
	}
	public function disable_open_sans( $translations, $text, $context, $domain ) {
		if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
		        $translations = 'off';
		}
		return $translations;
	}
}
$disable_google_fonts = new Disable_Google_Fonts;

/* 启用浏览数目 */
// function to display number of posts.
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.'';
}

// function to count views.
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if (is_singular()) {
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
    
}


//后台添加显示
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('浏览');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
	if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}

/* 后台更新提醒 */	

//服务器端
function createFolder($path){
	if (!file_exists($path)){
	   createFolder(dirname($path));
	   mkdir($path, 0777);
}}
$data = array();
$data['version'] = ''.cs_get_option('i_update_version').'';
$data['notice'] = ''.cs_get_option('i_update_notice').'';
foreach ( $data as $key => $value ) {  
	$data[$key] = urlencode ( $value );  
} 	
$json_string = urldecode ( json_encode ( $data ) ); 
$i_update = cs_get_option('i_update');
if ($i_update == true) {
	createFolder('updates');
	file_put_contents('updates/update.json', $json_string);	
}	

//客户端
function my_admin_notice() {
	$url = wp_get_theme()->display('ThemeURI');
	$name = wp_get_theme()->display('Name');
	$nowversion = wp_get_theme()->display('Version');
	$json_string = wp_remote_retrieve_body( wp_remote_get(''.$url.'updates/update.json',array('timeout' => 120)));
	$obj=json_decode($json_string);
	$newversion=$obj->version;
	$notice=$obj->notice;
	if (strcmp($newversion,$nowversion)>0) {
		echo '<div class="update-nag">您的'.$name.'当前版本为:'.$nowversion.'，可更新到:'.$newversion.'！<a href='.admin_url( 'update-core.php' ).'>请现在升级</a>。遇到问题请加QQ群：284093657。</br>'.$notice.'</div>';
	}		
}
$push = cs_get_option('i_push');
if ($push == true) {
  add_action( 'admin_notices', 'my_admin_notice' );
}


/* 边栏评论 */	
	function h_comments($outer,$limit){
		global $wpdb;
		$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, SUBSTRING(comment_content,1,22) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND user_id='0' AND comment_author != '$outer' ORDER BY comment_date_gmt DESC LIMIT $limit";
		$comments = $wpdb->get_results($sql);
		foreach ($comments as $comment) {
			$output .= '<li>'.get_avatar( $comment, 32,"",$comment->comment_author).' <p class="s_r"><a class="with-tooltip" href="'. get_permalink($comment->ID) .'#comment-' . $comment->comment_ID . '" data-tooltip="《'.$comment->post_title . '》上的评论"><span class="s_name">'.strip_tags($comment->comment_author).':</span><span class="s_desc">'. strip_tags($comment->com_excerpt).'</span></a></p></li>';
		}
		$output = convert_smilies($output);
		echo $output;
	}

/* 启用文章摘录 */
function improved_trim_excerpt($text) {
    global $post;
    if ('' == $text) {
        $text = get_the_content('');
        $text = apply_filters('the_content', $text);
        $text = str_replace('\]\]\>', ']]&gt;', $text);
        $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		/* 可自定义不过滤html标签 */
        $text = strip_tags($text, '<span><pre><code><script><style><br><em><i><ul><ol><li><a><p><img><video><audio><strong><em><blockquote>');
        $text = mb_substr($text, 0, cs_get_option('i_post_excerpt') , 'utf-8') . '...<div class="read_more"><a href="' . get_permalink($post->ID) . '">' . cs_get_option('i_post_more') . '</a></div>';
        $excerpt_length = cs_get_option('i_post_excerpt');
        $words = explode(' ', $text, $excerpt_length + 1);
        if (count($words) > $excerpt_length) {
            array_pop($words);
            array_push($words, '...<div class="read_more"><a " href="' . get_permalink($post->ID) . '">' . cs_get_option('i_post_more') . '</a></div>');
            $text = implode(' ', $words);
        }
    }
    return $text;
}
function custom_excerpt_length($length) {
    return cs_get_option('i_post_excerpt');
}
function new_excerpt_more($more) {
    global $post;
    return '...<div class="read_more"><a href="' . get_permalink($post->ID) . '">' . cs_get_option('i_post_more') . '</a></div>';
}
$excerpt = cs_get_option('i_post_readmore');
$html = cs_get_option('i_post_html');
if ($excerpt == true) {
    if ($html == true) {
        remove_filter('get_the_excerpt', 'wp_trim_excerpt');
        add_filter('get_the_excerpt', 'improved_trim_excerpt');
    } else {
        add_filter('excerpt_length', 'custom_excerpt_length', 999);
        add_filter('excerpt_more', 'new_excerpt_more');
    }
}

/* 启用标题 */
function show_wp_title(){
    global $page, $paged;
    wp_title( '-', true, 'right' );
    // 添加网站标题.
    bloginfo( 'name' );
    // 为首页添加网站描述.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
    echo ' - ' . $site_description;
    // 如果有必要，在标题上显示一个页面数.
    if ( $paged >= 2 || $page >= 2 )
    echo ' - ' . sprintf( '第%s页', max( $paged, $page ) );
}

/* 启用相关文章 */
if (function_exists('add_theme_support')) add_theme_support('post-thumbnails');
function post_thumbnail_src() {
    global $post;
    if ($values = get_post_custom_values("thumb")) {
        $values = get_post_custom_values("thumb");
        $post_thumbnail_src = $values[0];
    } elseif (has_post_thumbnail()) {
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID) , 'thumbnail');
        $post_thumbnail_src = $thumbnail_src[0];
    } else {
        $post_thumbnail_src = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $post_thumbnail_src = $matches[1][0];
        if (empty($post_thumbnail_src)) {
            $random = mt_rand(1, 10);
            echo cs_get_option('i_related_image');
        }
    };
    echo $post_thumbnail_src;
}

/* SMPT设置 */
$stmp = cs_get_option('i_comment_smpt');
if ($stmp == true) {
	add_action('phpmailer_init', 'mail_smtp');
}

function mail_smtp( $phpmailer ) {
$phpmailer->FromName = cs_get_option('i_smpt_name'); 
$phpmailer->Host = cs_get_option('i_smpt_server');
$phpmailer->Port = cs_get_option('i_smpt_port');
$phpmailer->Username = cs_get_option('i_smpt_email'); 
$phpmailer->Password = cs_get_option('i_smpt_password'); 
$phpmailer->From = cs_get_option('i_smpt_email');
$phpmailer->SMTPAuth = true;
$phpmailer->SMTPSecure = ''; 
$phpmailer->IsSMTP();
}

/* 启用邮件提醒 */
$mail = cs_get_option('i_comment_mail');
if ($mail == true) {
	include_once('notify.php');
}

/* 启用二级菜单 */
class pinthis_submenu_wrap extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output.= "\n$indent<div class=\"dropdown\"><div class=\"dropdown-wrapper arrow-up-left\"><ul class=\"sub-menu\">\n";
    }
    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output.= "$indent</ul></div></div>\n";
    }
}

/* 分页条件 */
function island_page_has_nav() {
    global $wp_query;
    return ($wp_query->max_num_pages > 1);
}

/* 图集和画廊支持 */
function island_theme_setup() {
    add_theme_support('island_themes_gallery_support');
}
add_action('after_setup_theme', 'island_theme_setup');
add_filter('island_themes_portfolio_items_support', '__return_true');
add_filter('pre_option_link_manager_enabled', '__return_true');

/* 注册小工具 */
if (function_exists('register_sidebars')) register_sidebar(array(
    'name' => __('Main Sidebar', 'dw-minion') ,
    'id' => 'sidebar-1',
    'description' => __('显示在页面右边', 'island') ,	
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '<div class="clearfix"></div></aside>',
    'before_title' => '<h3 class="widget-title"><span>',
    'after_title' => '</span></h3>',
));
register_sidebar(array(
    'name' => __('Drawer', 'island') ,
    'description' => __('显示在页面顶部，可自定义分栏数目', 'island') ,
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>'
));

/* 引入小工具 */
require get_template_directory() . '/widgets.php';

/* 短代码 */
function cs_accordion($atts,$content=null)
{
    extract(shortcode_atts(array("title" => '0'), $atts));
    $return = '<aside class="accordion">';
    $return .= do_shortcode($content);	
    $return .= '</aside>';
    return $return;
}
add_shortcode("accordion",'cs_accordion');

function cs_accordion_sub($atts,$content=null)
{
    extract(shortcode_atts(array("title" => '0'), $atts));
    $return = '<h1 class="question"><i class="fa fa-plus"></i>'.$title.'</h1>';
    $return .= '<div class="answer">';	
    $return .= $content;
    $return .= '</div>';
    return $return;
}
add_shortcode("accordion_sub",'cs_accordion_sub');


/* 判断移动设备 */
function is_mobile() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$mobile_browser = Array(
		"mqqbrowser","opera mobi","juc","iuc","fennec","ios","applewebKit/420","applewebkit/525","applewebkit/532","ipad","iphone","ipaq","ipod","iemobile", "windows ce","240x320","480x640","acer","android","anywhereyougo.com","asus","audio","blackberry","blazer","coolpad" ,"dopod", "etouch", "hitachi","htc","huawei", "jbrowser", "lenovo","lg","lg-","lge-","lge", "mobi","moto","nokia","phone","samsung","sony","symbian","tablet","tianyu","wap","xda","xde","zte"
	);
	$is_mobile = false;
	foreach ($mobile_browser as $device) {
		if (stristr($user_agent, $device)) {
			$is_mobile = true;
			break;
		}
	}
	return $is_mobile;
}
if (is_mobile()) {
} else {
}

/* 判断微信浏览器 */
function is_weixin()
{ 
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }  
        return false;
}
if (is_weixin()) {
} else {
}

/* 维护模式 */
function wp_maintenance_mode(){
    if(!current_user_can('edit_themes') || !is_user_logged_in()){
        wp_die(''.cs_get_option('i_maintenance_notice').'', ''.cs_get_option('i_maintenance_title').'', array('response' =>'503'));
    }
}

$maintenance = cs_get_option('i_maintenance');
if ($maintenance == true) {
	add_action('get_header', 'wp_maintenance_mode');
}

//保护后台登录
function login_protection(){  
    if($_GET[''.cs_get_option('i_login_prefix').''] != ''.cs_get_option('i_login_suffix').'')header('Location: '.cs_get_option('i_login_link').'');  
}

$protection = cs_get_option('i_login_protection');
if ($protection == true) {
	add_action('login_enqueue_scripts','login_protection');  
}

// 增加额外登录验证
function wlp_basic_auth() {
  if( !isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW']) )
    wlp_unauthorized(__('No credentials have been provided.', 'memberpress'));
  else {
    $user = wp_authenticate($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']);

    if(is_wp_error($user))
      wlp_unauthorized( $user->get_error_message() );
  }
}
function wlp_unauthorized($message) {
  header('WWW-Authenticate: Basic realm="' . get_option('blogname') . '"');
  header('HTTP/1.0 401 Unauthorized');
  die(sprintf(__('UNAUTHORIZED: %s', 'memberpress'),$message));
}

$auth = cs_get_option('i_login_auth');
if ($auth == true) {
	add_action('login_init','wlp_basic_auth');
}

//过滤HTTP 1.0的登录POST请求
function wlp_filter_http() {
  if(preg_match('/1\.0/',$_SERVER['SERVER_PROTOCOL'])) { wlp_forbidden(); }
}
$http = cs_get_option('i_login_http');
if ($http == true) {
	add_action('login_init','wlp_filter_http');
}

// POST Cookie 保护
//这将设置一个cookie的初始值，如果cookie不存在POST请求，登录会被阻止
function wlp_set_login_protection_cookie() {
  if( strtoupper($_SERVER['REQUEST_METHOD'])=='GET' and
      !isset($_COOKIE['wlp_post_protection']) ) {
    setcookie('wlp_post_protection','1',time()+60*60*24);
    $_COOKIE['wlp_post_protection'] = '1';
  }
}

function wlp_post_protection() {
  if( strtoupper($_SERVER['REQUEST_METHOD'])=='POST' and
      !isset($_COOKIE['wlp_post_protection']) ) {
    wlp_forbidden();
  }
}
$cookie = cs_get_option('i_login_cookie');
if ($cookie == true) {
	add_action('init','wlp_set_login_protection_cookie');
	add_action('login_init','wlp_post_protection'); 

}

// 登录错误，返回403状态
function wlp_forbidden() {
  header("HTTP/1.0 403 Forbidden");
  exit;
}

// 返回网站中未审核留言数
function get_not_audit_comments(){
    if(is_home() && current_user_can('level_10')){    //只有在首页，并且管理员登录是才执行
        $awaiting_mod = wp_count_comments();
        $awaiting_mod = $awaiting_mod->moderated;
        if($awaiting_mod){
            //当存在未审核留言
            echo "<div id=\"awaiting_comments\"><a href=".admin_url( 'edit-comments.php' ).'><i class=\'fa fa-comments\'></i>你有'.$awaiting_mod.'条新回复</a></div>';
         }
    }
}
add_filter('wp_footer','get_not_audit_comments');

/* 插件css */
add_action('wp_head', 'plugin_css', 99);
function plugin_css() {
	$ajaxbar = cs_get_option( 'i_ajax_color' ); 
	$player_bg = cs_get_option( 'i_player_bg' );
	$player_btn = cs_get_option( 'i_player_btn' );
	$progress = cs_get_option( 'i_loadingbar_color' );
	$width = cs_get_option( 'i_menu_width' ); 
	$banner = cs_get_option( 'i_banner_image' ); 
    echo '<!-- 插件参数css --><style>
	.loading_style1 .loading-bar{
	  background:'. $ajaxbar.';
	}

	#banner{
			background-image: url('. $banner.');
            background-position: top center;
            background-repeat:no-repeat;
	}
	
	.cue-playlist, .cue-playlist .cue-skin-cuebar.mejs-container .mejs-controls .mejs-volume-button .mejs-volume-slider{
		background-color:'. $player_bg.';
	}

	.cue-skin-cuebar.mejs-container .mejs-layers , .cue-skin-cuebar.mejs-container .mejs-controls .mejs-time span , .mejs-previous button:before , .mejs-next button:before , .mejs-play button:before , .mejs-pause button:before , .mejs-mute button:before , .mejs-unmute button:before , .is-closed button:before , .is-open button:before{
		color:'. $player_btn.';
	}

	.cue-skin-cuebar.mejs-container .mejs-controls {
		border-right-color: '. $player_bg.';
		border-left-color: '. $player_bg.';
	}	
	
	</style>';
}

if ( ! function_exists( '_wp_render_title_tag' ) ) :
   function theme_slug_render_title() {
      ?>
      <title><?php wp_title( '-', true, 'right' ); ?></title> 
      <?php
   }
   add_action( 'wp_head', 'theme_slug_render_title' );
endif;

/* 自定义css */
add_action('wp_head', 'add_css', 99);
function add_css() {
    echo '<!-- 自定义css --><style>' . cs_get_option('i_css') . '</style>';
}

/* 自定义js */
add_action('wp_footer', 'add_js', 99);
function add_js() {
	
    echo '<!-- 自定义js --><script>' . cs_get_option('i_js') . '</script>';
}

/* 评论表情包 */
function add_my_smiley() {
	echo '<div id="wp-smiley">';
	include(TEMPLATEPATH . '/smiley.php');
	echo '</div>';
}
if ( ! is_user_logged_in() ) { 
  add_filter('comment_form_top', 'add_my_smiley');
}
add_filter('comment_form_logged_in_after', 'add_my_smiley');
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src ($img_src, $img, $siteurl){
return get_bloginfo('template_directory').'/images/smilies/'.$img;
}


/* 评论高亮作者 */
function comment_admin_title($email = '')
{
    if(empty($email))return;
    $handsome=array(
    '1'=>' ',); 
    $adminEmail = get_option('admin_email');
    if($email==$adminEmail)
    echo "<span class='author'>(管理员)</span>";
    elseif(in_array($email,$handsome))
    echo "<span class='author'>(管理员)</span>";
}

/* 引入Sitemap.xml */
if (cs_get_option('i_seo_sitemap') == true) {
	include ('sitemap.php');
}

/* 引入百度主动推送 */
if (cs_get_option('i_baidu_submit') == true) {
	include ('baidu_submit.php');
}

/* 百度手动推送 */
if (cs_get_option('i_baidu_manual') == true) {
	function island($url){
		$url='http://www.baidu.com/s?wd='.$url;
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$rs=curl_exec($curl);
		curl_close($curl);
		if(!strpos($rs,'没有找到')){
			return 1;
		}else{
			return 0;
		}
	}
	add_filter( 'the_content',  'baidu_submit' );
	function baidu_submit( $content ) {
		if( is_single() && current_user_can( 'manage_options') )
			if(island(get_permalink()) == 1) 
				$content="<p class='baidu_submit'><i class='fa fa-paw'></i>百度已收录</p>".$content; 
			else 
				$content="<p class='baidu_submit'><a target=_blank href=http://zhanzhang.baidu.com/sitesubmit/index?sitename=".get_permalink()."><i class='fa fa-paw'></i>百度未收录</a></p>".$content;  
			return $content;
	}
}

//移除自动保存
if (cs_get_option('i_post_autosave') == true) {
	wp_deregister_script('autosave');
}

//移除修订版本
if (cs_get_option('i_post_revision') == true) {
	remove_action('post_updated','wp_save_post_revision' );
}

/* 自定义评论输出 */
function island_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
	global $commentcount, $page;
	if ( (int) get_option('page_comments') === 1 && (int) get_option('thread_comments') === 1 ) { //开启嵌套评论和分页才启用
		if(!$commentcount) { //初始化楼层计数器
			$page = ( !empty($in_comment_loop) ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args ); //获取当前评论列表页码
			$cpp = get_option('comments_per_page'); //获取每页评论显示数量
			 if ( !$post_id ) $post_id = get_the_ID();
			 if ( get_option('comment_order') === 'desc' ) { //倒序
				$cnt = get_comments( array('status' => 'approve','parent' => '0','post_id' => $post_id,'count' => true) );
				if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) $commentcount = $cnt + 1;
				else $commentcount = $cpp * $page + 1;
			} else {
				$commentcount = $cpp * ($page - 1);
			}
		}
		if ( !$parent_id = $comment->comment_parent ) {
			$commentcountText = '';
			if ( get_option('comment_order') === 'desc' ) { //倒序
				$commentcountText .= --$commentcount . '楼';
			} else {
				$commentcountText .= ++$commentcount . '楼';
			}
		}
	}
	?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">
	<span class="commentcount"><?php echo $commentcountText; ?></span>
		<div class="comment-block" id="comment-<?php comment_ID(); ?>">
			<div class="author-img"><?php echo get_avatar($comment->comment_author_email, 50); ?></div>
			<div class="comment-body">
				<div class="comment-name"><?php printf(__('<cite class="fn">%s</cite>', 'island') , get_comment_author_link()) ?><?php comment_admin_title($comment->comment_author_email); ?></div>
				<div class="comment-text">
					<?php comment_text() ?>			
				</div>
				<div class="comment-info">
					<span class="comment-date">
							<a class="comment-time" href="<?php echo esc_url(get_comment_link($comment->comment_ID)) ?>">
							<?php printf(__('%1$s - %2$s', 'island') , get_comment_date('m/d/Y') , get_comment_time()) ?></a>
					</span>
					<span class="comment-reply">
						<?php comment_reply_link(array_merge($args, array(
							'depth' => $depth,
							'max_depth' => $args['max_depth']
						))) ?>
					</span>		
					<span class="comment-edit">
						<?php edit_comment_link(__('(Edit)', 'island') , '  ', '') ?>
					</span>	
					<div class="clearfix"></div>
				</div>
				
				<?php if ($comment->comment_approved == '0'): ?>
					<em class="comment-awaiting-moderation">
					<?php _e('Your comment is awaiting moderation.', 'island') ?></em>
				<?php endif; ?> 
				<div class="clearfix"></div>
			</div>
		</div>
<?php
}
function island_cancel_comment_reply_button($html, $link, $text) {
    $style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
    $button = '<div id="cancel-comment-reply-link"' . $style . '>';
    return $button . '<i class="icon-remove-sign"></i> </div>';
}
add_action('cancel_comment_reply_link', 'island_cancel_comment_reply_button', 10, 3);

