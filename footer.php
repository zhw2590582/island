<?php
 // 获取选项
$copyright = cs_get_option( 'i_foot_copyright' );  
$topbar = cs_get_option( 'i_topbar_show' );  
$gotop = cs_get_option( 'i_gotop' );  
$page = cs_get_option('i_pagination'); 
$qrcode = cs_get_option( 'i_qrcode' );  
$qrcodeimg = cs_get_option( 'i_qrcode_image' );  
$sidebar = cs_get_option( 'i_sidebar_switch' );  
$loadmore = cs_get_option( 'i_ajax_loading' );  
$loadend = cs_get_option( 'i_ajax_end' ); 
$loadnum = cs_get_option( 'i_ajax_num' ); 
$play = cs_get_option( 'i_slider_play' ); 
$auto = cs_get_option( 'i_slider_auto' ); 
$loop = cs_get_option( 'i_slider_loop' );
$height = cs_get_option( 'i_slider_height' );
$rightbar = cs_get_option( 'i_rightbar_show' ); 
$post_img = cs_get_option('i_post_image');
$img_setup = cs_get_option('i_post_setup');
$pagination = cs_get_option('i_pagination'); 	
$qrcodes = cs_get_option( 'i_code_qrcodes' ); 
$qrcodes_color = cs_get_option( 'i_qrcodes_color' ); 
$comment = cs_get_option( 'i_comment_switch' ); 
$player_id = cs_get_option( 'i_player_id' ); 
$player = cs_get_option('i_player');
$player_mobi = cs_get_option('i_player_mobi');
$rb = cs_get_option( 'i_rightbar_scroll' ); 
$avatar_bg = cs_get_option( 'i_avatar_bg' ); 
$avatar_image = cs_get_option( 'i_avatar_image' ); 
$avatar_name = cs_get_option( 'i_avatar_name' ); 
$avatar_content = cs_get_option( 'i_avatar_content' ); 
$me = cs_get_option( 'i_me_switch' ); 
$unlock = cs_get_option( 'i_comment_unlock' ); 
$share = cs_get_option( 'i_share' ); 
$share_img = cs_get_option( 'i_share_img' ); 
$share_word = cs_get_option( 'i_share_word' ); 
$tongji = cs_get_option( 'i_js_tongji' );
$circle = cs_get_option( 'i_circle' ); 
$snowfall = cs_get_option( 'i_snowfall' ); 
$modal = cs_get_option( 'i_modal' ); 
$modal_title = cs_get_option( 'i_modal_title' ); 
$modal_main = cs_get_option( 'i_modal_main' ); 
$shengming = cs_get_option( 'i_download_shengming' ); 
$meta_data = get_post_meta( get_the_ID(), 'aside_options', true );
$download = $meta_data['i_download'];
$layout = cs_get_option( 'i_layout' ); 
?> 
	
	</div><!-- main -->
	<?php if (!is_mobile()) { ?>
	<!-- 右侧边栏 -->
		<div class="rightbar">
		<?php if ($me == true) {?>
			<div class="about_me">
                
           <?php if ( $layout == 'i_width' ) { ?>
                
				<div class="me_img">
					<div class="me_bg">
						<img src="<?php echo $avatar_bg; ?>">
						</div>
					<div class="me_avatar">
						<img src="<?php echo $avatar_image; ?>">
					</div>
				</div>
                
            <?php }else { ?>
				<div class="me_img">
					<div class="me_avatar">
						<img src="<?php echo $avatar_image; ?>">
					</div>
				</div>
				<span class="me_name">
					<?php echo $avatar_name; ?>
				</span>
            <?php }?>        
                
				<p class="me_content">
					<?php echo $avatar_content; ?>
				</p>
				<div class="social">
					<?php 
						$my_socials = cs_get_option( 'i_social' );
						echo '<ul class="social_link">';
						if( ! empty( $my_socials ) ) {
						  foreach ( $my_socials as $social ) {
							$iconstyle = $social['i_icon_style']; 
							echo '<li>';
							if( ! empty( $social['i_social_link'] ) ){echo '<a href="'. $social['i_social_link'] .'" class="simptip-position-bottom simptip-smooth simptip-movable" data-tooltip="'. $social['i_social_title'] .'"';}else{echo '<a href="javascript:void(0)" class="simptip-position-bottom simptip-smooth simptip-movable" data-tooltip="'. $social['i_social_title'] .'" ';}
							if ( $social['i_social_newtab'] == true) { echo 'target="_black"';}
							if ($iconstyle == 'i_icon') {echo '><i class="'. $social['i_social_icon'] .'"></i>';} else {echo '><img src="'. $social['i_social_image'] .'">';}			
							echo '</a>';
							echo '</li>';
						  }
						}		
						echo '</ul>';
					?>
				</div>			
			</div>
			<?php } ?>
			
			<div class="sidebar-contentWrapper">
			<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Main Sidebar') ) : else : ?>	
			<?php endif; ?>
			</div>
			
		</div>	
	<?php }?>	
	</div><!-- wrapper -->
	<div class="clearfix"></div>
    </div><!-- wp_box -->
	<?php if (!is_mobile()) { ?>
		<div class="foot_btn">
			<ul>
				<?php if ($gotop == true) {
					echo '<li class="mate-gotop">
							<a href="#totop" class="scrolltotop" title="回到顶部"><i class="fa fa-chevron-up"></i></a>
						</li>';
				}?>
	
				<?php if ($share == true) {
					echo '<li class="baidu_share">
							<a href="javascript:void(0)" class="share_icon" title="分享">
								<i class="fa fa-share"></i>
							</a>								
								<div class="share_show" style="display: none;">
									<div class="bdsharebuttonbox">
										<a href="#" class="bds_mshare" data-cmd="mshare" title="一键分享">一键分享</a>
										<a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a>
										<a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a>
										<a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a>
										<a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a>
										<a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣">豆瓣</a>
										<a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a>									
										<a href="#" class="bds_twi" data-cmd="twi" title="分享到 Twitter">Twitter</a>
										<a href="#" class="bds_fbook" data-cmd="fbook" title="分享到 Facebook">Facebook</a>
									</div>
									<div class="clear"></div>
								</div>
						<script>
							window._bd_share_config = {
								"common": {
									"bdSnsKey": {},
									"bdText": "",
									"bdMini": "2",
									"bdPic": "",
									"bdStyle": "0",
									"bdSize": "16"
								},
								"share": {},';
				}?>	
				<?php if ($share == true && $share_img == true) {	
						echo '				
								"image": {
									"viewList": ["qzone", "tsina", "tqq", "renren", "weixin"],
									"viewText": "分享到：",
									"viewSize": "16"
								},';
				}?>	
				<?php if ($share == true && $share_word == true) {	
						echo '
								"selectShare": {
									"bdContainerClass": null,
									"bdSelectMiniList": ["qzone", "tsina", "tqq", "renren", "weixin"]
								}';
				}?>		
				<?php if ($share == true) {
					echo '	
							};
							with(document) 0[(getElementsByTagName("head")[0] || body).appendChild(createElement("script")).src = "http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=" + ~ (-new Date() / 36e5)];
						</script>				
					</li>';
				}?>		
				
				<?php if ($comment == true && is_single ()) {
					echo '<li class="mate-com">
							<a href="#comment-jump" class="comment_btn" title="评论"><i class="fa fa-comment-o"></i></a>
						  </li>';
				}?>								
				
				<?php if ($qrcode == true) {
					echo '<li class="mate-qrcode">
							<a style="" title="二维码" href="javascript:void(0)" id="r-wx">
							<i class="fa fa-qrcode"></i>
								<div id="fi-wx-show" style="display: none;">
									<img src="'. $qrcodeimg .'">
								</div>
							</a>
						</li>';
				}?>	

			</ul>
		</div>
	<?php }?>	
	<footer id="footer">
		<?php if ( $topbar == true && is_active_sidebar(2) && !is_mobile()) { ?>
		<?php 
			$column = cs_get_option( 'i_topbar_col' );  
			$column_style = '';
			switch ($column) {
				case "col_1":
					$column_style = 'columns1';
					break;

				case "col_2":
					$column_style = 'columns2';
					break;

				case "col_3":
					$column_style = 'columns3';
					break;
					
				case "col_4":
					$column_style = 'columns4';
					break;				
			} 
		 ?>	
		
		<section id="drawer">
			<div id="drawer-inside" class="container clearfix <?php echo $column_style; ?>">
				<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Drawer') ) : else : ?>		
				<?php endif; ?>		
			</div>
		</section>
		<?php } ?>
		<div id="copyright">
			<div class="copyright">
			<!-- 版权信息 -->			
			<?php if( ! empty( $copyright ) ){ echo ''.$copyright.'';}else{
				echo'&copy; '.date("Y").' All Rights Reserved.';
			} ?>	
	
			<!-- 你忍心删除我？ -->
			<a href="http://zhw-island.com/" target="_blank"> Theme by Island</a>
		
			<!-- 统计代码 -->			
			<?php if( ! empty( $tongji ) ){ echo '<script>'.$tongji.'</script>';}else{
				echo' ';
			} ?>			
			</div>
		</div>
	</footer>
	<?php if ($player_mobi == true && is_mobile() ) { }else{ ?>
		<?php if ($player == true && ! empty( $player_id ) && function_exists('cue_playlist') ) {?>
			<!-- 音乐播放器 -->
				<?php cue_playlist( $player_id ); ?>
		<?php }	 ?>
	<?php }	 ?>
	
	<?php if ($unlock == true && is_singular()) {?>
		<script>	
		jQuery(document).ready(function($) {	
			$(".form-submit").before('<div class="unlock"><input type="range" value="0" class="pullee" /><i class="fa fa-lock"></i></div>');
		});	
		</script>	
	<?php }	?>		

	<?php if ($modal == true && !is_mobile() ) {?>		
		<?php
		setcookie('modal','show',time()+3600);
		if(isset($_COOKIE["modal"])){
		}else{?>	
			<div class="modal-bg">
				<div class="modal-body">
					<div class="modal-head clearfix">
						<div class="modal-title"><?php echo $modal_title ?></div>
						<div class="modal-close"><a href="javascript:void(0)"><i class="fa fa-times"></i></a></div>
					</div>
					<div class="modal-main"><?php echo $modal_main ?></div>
				</div>
			</div>
		<?php }	?>	
	<?php }	?>	

	<?php if ( is_single() && $download && !is_mobile() ) {?>		
        <div class="download-bg modal-bg hide">
            <div class="modal-body">
                <div class="modal-head clearfix">
                    <div class="modal-title"><i class="fa fa-download"></i>资源下载</div>
                    <div class="modal-close"><a href="javascript:void(0)"><i class="fa fa-times"></i></a></div>
                </div>
                <div class="modal-main">
                    <div class="dl-btn"><a href="javascript:void(0)" target="_black"><i class="fa fa-download"></i>点击下载</a></div>
                    <div class="dl-tqcode">提取码：<span></span></div>
                </div>
                <div class="modal-bottom">
                    <span>下载声明：<?php echo $shengming ?></span>
                </div>
            </div>
        </div> 
	<?php }	?>		

	<!-- 引入插件js -->
	<?php wp_footer(); ?>
	<!-- 插件参数js -->
	<script>	
		
	
	jQuery(document).ready(function($) {	
	
	<?php if ( $snowfall == true && !is_mobile()  ) { ?>
		$(document).snowfall({flakeCount : 200});
	<?php }?>	
	
	<?php if ($qrcodes == true && is_single () && !is_mobile()) {?>
		jQuery("#qrcode").qrcode({
			size: 100,
			ecLevel: 'L',
			fill: "<?php echo $qrcodes_color ?>",
			radius: 0,
			mode: 4,
			minVersion: 8,
			image: jQuery('#qrcode_img')[0],
			mSize: 0.2,
			text: "<?php the_permalink(); ?>"
		});		
	<?php }	?>
	
	<?php if ($post_img == true && $img_setup == 'i_lightbox' && !is_mobile() ) {?>
	$(".post-content a").fluidbox();
	<?php }	?>		
	
	$('.lightSlider').lightSlider({
		mode: "fade",
		auto: <?php if ($auto == true) { echo 'true';}else{echo 'false';} ?>,
		loop: <?php if ($loop == true) { echo 'true';}else{echo 'false';} ?>,
		item:1,
		pause: 4000,
		slideMargin:0,
		currentPagerPosition:'left',
		adaptiveHeight:<?php if ($height == true) { echo 'true';}else{echo 'false';} ?>,
	});  

	<?php if ( $pagination == 'i_ajax' && is_home() || $pagination == 'i_ajax' && is_archive()) { ?>
		// ajax加载			
		var ias = $.ias({
			container: ".posts",
			item: ".post",
			pagination: ".post-nav-inside",
			next: ".post-nav-right a",
		});

		ias.extension(new IASTriggerExtension({
			textPrev: ' ',
			text: '<?php echo $loadmore ?>',
			offset: <?php echo $loadnum ?>,
		}));
		ias.extension(new IASNoneLeftExtension({
			text: '<?php echo $loadend ?>',
		}));
		ias.extension(new IASSpinnerExtension());
		ias.extension(new IASPagingExtension());
		ias.extension(new IASHistoryExtension({
			prev: '.post-nav-right a',
		}));

		// ajax函数	
		ias.on('rendered', function(items) {
			echo.init({
				offset: 100,
				throttle: 250,
				unload: false,
			});
			$(".post-content a").fluidbox();
			
			if($(".audio-wrapper audio").length>0){
				$('.audio-wrapper audio').mediaelementplayer();
			}
			
			if($(".zancai").length>0){	
				$(".zancai .jm-post-like .fa-heart").addClass("fa-thumbs-up").removeClass("fa-heart");
				$(".zancai .jm-post-like .fa-heart-o").addClass("fa-thumbs-o-up").removeClass("fa-heart-o");
			};				
			
		});	
	<?php } ?>		
	});
	</script>
	<?php if ( $circle == true && !is_mobile()  ) { ?>
		<canvas id="pixie"></canvas>
	<?php }?>		
	
</body>
</html>