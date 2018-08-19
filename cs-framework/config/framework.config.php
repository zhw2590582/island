<?php if ( ! defined( 'ABSPATH' ) ) { die; } // 不能直接访问网页.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// Island 主题框架设置
// -----------------------------------------------------------------------------------------------
// ===============================================================================================

$settings      = array(
  'menu_title' => '主题选项',
  'menu_type'  => 'add_menu_page',
  'menu_slug'  => 'cs-framework',
  'ajax_save'  => true, // ajax保存.
);

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// 框架选项
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options        = array();

// ----------------------------------------
// 常规  -
// ----------------------------------------
$options[]      = array(
  'name'        => 'overwiew',
  'title'       => '常规',
  'icon'        => 'fa fa-star',
  'fields'      => array(

 		// 布局设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '布局设置',
		),

		// 布局设置
        array(
          'id'         => 'i_layout',
          'type'       => 'radio',
          'title'      => '布局设置',
          'class'      => 'horizontal',
          'options'    => array(
            'i_width'  => '宽屏',
            'i_box'    => '窄屏',
          ),
          'default'    => 'i_width',
        ),

 		// Favicon和Logo设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => 'Favicon和Logo设置',
		),

		// 自定义收藏站标
        array(
          'id'      => 'i_favicon_icon',
          'type'    => 'upload',
          'title'   => 'Favicon',
		  'add_title' => '添加favicon',
          'default' => get_template_directory_uri()."/images/favicon.ico",
          'help'      => '建议制作一张400x400的png图像, 然后等比缩小到你想转换的ico尺寸,最后通过网上的工具转换成ico图标格式.',
        ),

		// 自定义网站标志
        array(
          'id'         => 'i_symbol',
          'type'       => 'radio',
          'title'      => '网站标志',
          'class'      => 'horizontal',
          'options'    => array(
            'i_logo'   => '显示Logo',
            'i_text'   => '显示网站标题',
            'i_font'   => '显示字体图标',
          ),
          'default'    => 'i_text',
          'help'       => '若没有Logo图像时，默认显示标题',
        ),

		// Logo设置
        array(
          'id'      => 'i_logo_image',
          'type'    => 'upload',
          'title'   => 'Logo设置',
		  'add_title' => '添加Logo',
          'help'      => 'Logo尺寸大小建议不宜超过100px,支持SVG文件',
          'dependency' => array( 'i_symbol_i_logo', '==', 'true' ),
        ),

		// 网站标题渐变动画
        array(
          'id'      => 'i_logo_color',
          'type'    => 'switcher',
          'title'   => '网站标题渐变动画',
          'dependency' => array( 'i_symbol_i_text', '==', 'true' ),
        ),

		// 自定义皮肤
        array(
          'id'        => 'i_skin',
          'type'      => 'select',
          'title'     => '自定义皮肤',
          'options'   => array(
          'i_skin01' => '复古',
          'i_skin02' => '酷黑',
          'i_skin03' => '清新',
          ),
          'default'   => 'i_skin01',
          'help'      => '皮肤随版本更新而增加，另可定制个人专属皮肤',
        ),

		// 开启前端换肤功能
		array(
          'id'    	  => 'i_switcher',
          'type'      => 'switcher',
          'title'     => '开启前端换肤',
          'label'     => '假如此项没开启，换肤小工具会失效；一旦开启，自定义皮肤将失效',
          'help'      => '开启后默认显示第一套皮肤，关于修改默认皮肤请看使用说明',
        ),


		// 分页设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '分页设置',
		),

		// 分页方式
        array(
          'id'         => 'i_pagination',
          'type'       => 'radio',
          'title'      => '分页方式',
          'class'      => 'horizontal',
          'options'    => array(
            'i_ajax'   => 'ajax无限加载',
            'i_next'   => '下一篇/前一篇按钮',
            'i_num'   => '页码',
          ),
          'default'    => 'i_num',
          'help'       => '后续增加页码显示方式',
        ),

			// 无限加载页数
        array(
          'id'         => 'i_ajax_num',
          'type'       => 'number',
          'default'    => '2',
          'title'      => 'ajax无限加载页数',
          'help'       => 'ajax无限加载到第几页出现下一页按钮，默认为2',
          'after'      => ' <i class="cs-text-muted">(页)</i>',
          'dependency' => array( 'i_pagination_i_ajax', '==', 'true' ),
        ),

		// ajax加载条样式
        array(
          'id'         => 'i_ajax_style',
          'type'       => 'radio',
          'title'      => 'ajax加载条样式',
          'class'      => 'horizontal',
          'options'    => array(
            'style1'   => '自定义颜色',
            'style2'   => '彩虹',
            'style3'   => 'IOS7',
          ),
		  'default'    => 'style1',
          'dependency' => array( 'i_pagination_i_ajax', '==', 'true' ),
        ),

		// ajax加载条颜色
        array(
          'id'         => 'i_ajax_color',
          'type'       => 'color_picker',
          'title'      => 'ajax加载条颜色',
		  'default'    => '#60d778',
          'dependency' => array( 'i_ajax_style_style1', '==', 'true' ),
          'help'       => '只有在选择了自定义颜色才生效',
        ),

			// 无限加载中下一页的文字
        array(
          'id'         => 'i_ajax_loading',
          'type'    => 'text',
          'default'    => '加载更多',
          'title'      => 'ajax无限加载中下一页的文字',
          'dependency' => array( 'i_pagination_i_ajax', '==', 'true' ),
        ),

			// 无限加载完结的文字
        array(
          'id'         => 'i_ajax_end',
          'type'       => 'text',
          'default'    => '没有更多文章了',
          'title'      => 'ajax无限加载完结的文字',
          'dependency' => array( 'i_pagination_i_ajax', '==', 'true' ),
        ),

  ),
);

// ------------------------------
// 页眉                      -
// ------------------------------

$options[]      = array(
  'name'        => 'header',
  'title'       => '页眉',
  'icon'        => 'fa fa-bookmark',
  'fields'      => array(

 		// 顶部
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '顶部',
		),

		// 隐藏系统工具条
		array(
          'id'    	  => 'i_toolbar',
          'type'      => 'switcher',
          'title'     => '隐藏系统工具条',
          'label'     => '为使页面干净，建议隐藏',
          'default'   => true,
		  'help'      => '因为主题的页尾自带进入后台操作的按钮，建议隐藏;另你也可以进入个人资料禁用工具条',
        ),

		// 前端登录
		array(
          'id'    	  => 'i_login',
          'type'      => 'switcher',
          'title'     => '是否开启前端登录',
          'default'   => true,
        ),

		// 搜索按钮
		array(
          'id'    	  => 'i_search',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '是否显示搜索按钮',
        ),

 		// Banner设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => 'Banner设置',
		),

		// Banner图片
        array(
          'id'      => 'i_banner_image',
          'type'    => 'upload',
          'title'   => 'Banner图片',
          'help'      => '',
          'default' => get_template_directory_uri()."/images/banner.jpg",
		  'help'      => '推荐尺寸为1920X200',
        ),

		// Banner文字
		array(
		  'id'      => 'i_banner_text',
		  'type'    => 'textarea',
		  'title'   => 'Banner文字',
		  'help'    => '',
          'default' => '尚未设置',
		),

  ),
);

// ------------------------------
// 幻灯片                      -
// ------------------------------

$options[]      = array(
  'name'        => 'slider',
  'title'       => '幻灯片',
  'icon'        => 'fa fa-image',
  'fields'      => array(

		// 首页开启灯箱
		array(
          'id'    	  => 'i_slider',
          'type'      => 'switcher',
          'title'     => '首页开启幻灯片',
		  'help'      => '注意：幻灯片只显示在主页',
        ),

			// 自定义灯箱
        array(
          'id'              => 'i_slider_custom',
          'type'            => 'group',
          'title'           => '自定义幻灯片',
          'info'            => '更多详细设置方式可以浏览使用说明',
          'button_title'    => '添加滑块',
          'accordion_title' => '滑块',
          'fields'          => array(

				// 自定义幻灯片--标题
            array(
              'id'          => 'i_slider_title',
			  'type'        => 'text',
              'title'       => '标题',
			  'attributes'    => array(
				'placeholder' => '例如：滑块01'
			  )
            ),

				// 自定义幻灯片--图片
			array(
			  'id'      => 'i_slider_image',
			  'type'    => 'upload',
			  'title'   => '图片',
			),

				// 自定义幻灯片--描述
            array(
              'id'          => 'i_slider_text',
			  'type'        => 'text',
              'title'       => '描述',
			  'attributes'    => array(
				'placeholder' => '输入描述'
			  )
            ),

				// 自定义幻灯片--链接
			array(
			  'id'            => 'i_slider_link',
			  'type'          => 'text',
			  'title'         => '链接',
			  'attributes'    => array(
				'placeholder' => 'http://...'
			  )
			),

				// 自定义幻灯片--新标签
			array(
			  'id'    	  => 'i_slider_newtab',
			  'type'      => 'switcher',
			  'title'     => '新标签打开',
			  'dependency'   => array( 'i_slider_link', '!=', '' ),
			),

          )
        ),

				// 自动播放
			array(
			  'id'    	  => 'i_slider_auto',
			  'type'      => 'switcher',
			  'default'   => true,
			  'title'     => '自动播放',
			),

				// 循环播放
			array(
			  'id'    	  => 'i_slider_loop',
			  'type'      => 'switcher',
			  'default'   => true,
			  'title'     => '循环播放',
			),

				// 自动调整高度
			array(
			  'id'    	  => 'i_slider_height',
			  'type'      => 'switcher',
			  'title'     => '自动调整高度',
			),

  ),
);

// ------------------------------
// 公告栏                      -
// ------------------------------

$options[]      = array(
  'name'        => 'bulletin',
  'title'       => '公告栏',
  'icon'        => 'fa fa-bell',
  'fields'      => array(

		// 首页开启公告栏
		array(
          'id'    	  => 'i_bulletin',
          'type'      => 'switcher',
          'title'     => '首页开启公告栏',
		  'help'      => '注意：公告栏只显示在主页',
        ),

			// 自定义公告栏
        array(
          'id'              => 'i_bulletin_custom',
          'type'            => 'group',
          'title'           => '自定义公告栏',
          'info'            => '更多详细设置方式可以浏览使用说明',
          'button_title'    => '添加滑块',
          'accordion_title' => '滑块',
          'fields'          => array(

				// 自定义公告栏--标题
            array(
              'id'          => 'i_bulletin_title',
			  'type'        => 'text',
              'title'       => '标题',
			  'attributes'    => array(
				'placeholder' => '例如：公告栏01'
			  )
            ),

				// 自定义公告栏--描述
            array(
              'id'          => 'i_bulletin_text',
			  'type'        => 'textarea',
              'title'       => '描述',
			  'attributes'    => array(
				'placeholder' => '输入描述'
			  )
            ),

				// 自定义公告栏--链接
			array(
			  'id'            => 'i_bulletin_link',
			  'type'          => 'text',
			  'title'         => '链接',
			  'attributes'    => array(
				'placeholder' => 'http://...'
			  )
			),

				// 自定义公告栏--新标签
			array(
			  'id'    	  => 'i_bulletin_newtab',
			  'type'      => 'switcher',
			  'title'     => '新标签打开',
			  'dependency'   => array( 'i_bulletin_link', '!=', '' ),
			),

          )
        ),


  ),
);


// ------------------------------
// 文章                       -
// ------------------------------

$options[]      = array(
  'name'        => 'post',
  'title'       => '文章',
  'icon'        => 'fa fa-book',
  'fields'      => array(

 		// 常规设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '常规设置',
		),

  		// 移除修订版本
		array(
          'id'    	  => 'i_post_autosave',
          'type'      => 'switcher',
          'title'     => '移除修订版本',
        ),

  		// 移除自动保存
		array(
          'id'    	  => 'i_post_revision',
          'type'      => 'switcher',
          'title'     => '移除自动保存',
        ),

  		// 自动特色图
		array(
          'id'    	  => 'i_auto_featured',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '自动特色图',
        ),

  		// 内页特色图
		array(
          'id'    	  => 'i_post_featured',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '内页特色图',
        ),

  		// 启用浏览数目
		array(
          'id'    	  => 'i_post_view',
          'type'      => 'switcher',
          'title'     => '启用浏览数目',
        ),

   		// 启用作者名字
		array(
          'id'    	  => 'i_post_author',
          'type'      => 'switcher',
          'title'     => '启用作者名字',
        ),

 		// 启用喜欢按钮
		array(
          'id'    	  => 'i_post_like',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '启用喜欢按钮',
        ),

		// 喜欢按钮类型
        array(
          'id'         => 'i_like_style',
          'type'       => 'radio',
          'title'      => '喜欢按钮类型',
          'class'      => 'horizontal',
          'options'    => array(
            'i_like'   => '喜欢按钮',
            'i_zancai'   => '赞/踩按钮',
          ),
          'default'    => 'i_like',
		  'dependency'   => array( 'i_post_like', '==', 'true' ),
        ),

 		// 开启转载链接信息
		array(
          'id'    	  => 'i_post_link',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '开启转载链接信息',
        ),

 		// 阅读更多设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '阅读更多设置',
		),

 		// 开启自定义阅读更多
		array(
          'id'    	  => 'i_post_readmore',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '开启自定义阅读更多',
        ),

 		// 不过滤html标签
		array(
          'id'    	  => 'i_post_html',
          'type'      => 'switcher',
          'title'     => '不过滤html标签',
          'help'    => '支持截取支持中英文并且不过滤html标签，但对html标签支持不好，截取时会把标签截断而导致显示不全，所以建议配合文章的more标签一起使用',
		  'dependency'   => array( 'i_post_readmore', '==', 'true' ),
        ),

 		// 自定义主页文章摘录长度
        array(
          'id'      => 'i_post_excerpt',
          'type'    => 'number',
          'title'   => '自定义主页文章摘录长度',
          'after'   => ' <i class="cs-text-muted">(字)</i>',
          'default' => '80',
		  'dependency'   => array( 'i_post_readmore', '==', 'true' ),
		),

		// 自定义阅读更多的文字
        array(
          'id'         => 'i_post_more',
          'type'    => 'text',
          'default'    => '阅读更多',
          'title'      => '自定义阅读更多的文字',
		  'dependency'   => array( 'i_post_readmore', '==', 'true' ),
        ),

 		// 文章相关链接设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '文章相关链接设置',
		),

 		// 开启文章的上一篇和下一篇链接
		array(
          'id'    	  => 'i_post_next',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '开启文章的上一篇和下一篇链接',
        ),

 		// 开启相关文章
		array(
          'id'    	  => 'i_post_related',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '开启相关文章',
        ),

		// 设置默认相关文章预览图
        array(
          'id'        => 'i_related_image',
          'type'      => 'upload',
          'title'     => '设置默认相关文章预览图',
          'default' => get_template_directory_uri()."/images/post_thumb.png",
		  'dependency'   => array( 'i_post_related', '==', 'true' ),
        ),

 		// 文章图片设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '文章图片设置',
		),

		// 启用图片特效
		array(
          'id'    	  => 'i_post_image',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '启用图片特效',
        ),

		// Lazyload或者Lightbox
        array(
          'id'         => 'i_post_setup',
          'type'       => 'radio',
          'title'      => '图片特效',
          'class'      => 'horizontal',
          'options'    => array(
            'i_lazyload'   => '以Lazyload加载图片',
            'i_lightbox'   => '以Lightbox显示图片',
          ),
          'default'    => 'i_lazyload',
          'dependency'   => array( 'i_post_image', '==', 'true' ),
          'help'       => '这是两个插件的兼容问题，目前尚未找到解决方法，暂时只能选择其一',
        ),

  ),
);

// ------------------------------
// 评论                       -
// ------------------------------

$options[]      = array(
  'name'        => 'comment',
  'title'       => '评论',
  'icon'        => 'fa fa-comments',
  'fields'      => array(

 		// SMPT设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => 'SMPT设置',
		),

 		// 启用SMPT功能
		array(
          'id'    	  => 'i_comment_smpt',
          'title'     => '启用SMPT功能',
          'type'      => 'switcher',
        ),

		// 发件人的名称
        array(
          'id'         => 'i_smpt_name',
          'type'    => 'text',
          'default'    => 'Admin',
          'title'      => '发件人的名称',
          'dependency' => array( 'i_comment_smpt', '==', 'true' ),
        ),

		// SMTP服务器
        array(
          'id'         => 'i_smpt_server',
          'type'    => 'text',
          'default'    => 'smtp.qq.com',
          'title'      => 'SMTP服务器',
          'dependency' => array( 'i_comment_smpt', '==', 'true' ),
        ),

		// SMTP端口
        array(
          'id'         => 'i_smpt_port',
          'type'    => 'text',
          'default'    => '25',
          'title'      => 'SMTP端口',
          'dependency' => array( 'i_comment_smpt', '==', 'true' ),
        ),

		// 邮箱账号
        array(
          'id'         => 'i_smpt_email',
          'type'    => 'text',
          'title'      => '邮箱账号',
          'dependency' => array( 'i_comment_smpt', '==', 'true' ),
        ),

		// 邮箱密码
        array(
          'id'         => 'i_smpt_password',
          'type'    => 'text',
          'title'      => '邮箱密码',
          'dependency' => array( 'i_comment_smpt', '==', 'true' ),
        ),

 		// 提醒设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '提醒设置',
		),

 		// 启用邮件提醒
		array(
          'id'    	  => 'i_comment_mail',
          'title'     => '启用邮件提醒',
          'type'      => 'switcher',
          'default' => true,
        ),

		// 评论审核通过通知用户
        array(
          'id'         => 'i_mail_approve',
          'type'    => 'switcher',
          'title'      => '评论审核通过通知用户',
          'default' => true,
          'dependency' => array( 'i_comment_mail', '==', 'true' ),
        ),

		// 评论回复通知用户
        array(
          'id'         => 'i_mail_reply',
          'type'    => 'switcher',
          'title'      => '评论回复通知用户',
          'default' => true,
          'dependency' => array( 'i_comment_mail', '==', 'true' ),
        ),

		// 网站后台登录失败通知管理员
        array(
          'id'         => 'i_mail_login',
          'type'    => 'switcher',
          'title'      => '网站后台登录失败通知管理员',
          'dependency' => array( 'i_comment_mail', '==', 'true' ),
        ),

		// 注册用户资料信息更新通知用户
        array(
          'id'         => 'i_mail_update',
          'type'    => 'switcher',
          'title'      => '注册用户资料信息更新通知用户',
          'dependency' => array( 'i_comment_mail', '==', 'true' ),
        ),

		// 注册用户账户被管理员删除通知用户
        array(
          'id'         => 'i_mail_delete',
          'type'    => 'switcher',
          'title'      => '注册用户账户被管理员删除通知用户',
          'dependency' => array( 'i_comment_mail', '==', 'true' ),
        ),

		// 网站发布新文章通知用户
        array(
          'id'         => 'i_mail_newpost',
          'type'    => 'switcher',
          'title'      => '网站发布新文章通知用户',
          'dependency' => array( 'i_comment_mail', '==', 'true' ),
        ),

 		// 常规设置
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '常规设置',
		),

		// 启用头像Lazyload功能
		array(
          'id'    	  => 'i_comment_avatar',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '启用头像Lazyload功能',
        ),

		// 启用滑动验证
		array(
          'id'    	  => 'i_comment_unlock',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '启用滑动验证',
        ),

		// 启用读者墙
		array(
          'id'    	  => 'i_comment_wall',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '启用读者墙',
        ),

		// 读者墙头像数目
		array(
          'id'    	  => 'i_comment_num',
          'type'      => 'number',
          'default'    => '20',
          'title'     => '读者墙头像数目',
        ),

  ),
);

// ------------------------------
// 作品                       -
// ------------------------------

$options[]      = array(
  'name'        => 'works',
  'title'       => '作品',
  'icon'        => 'fa fa-cube',
  'fields'      => array(

 		// 每页显示作品数目
		array(
          'id'    	  => 'i_works_num',
          'title'     => '每页显示作品数目',
          'default'    => '20',
          'type'      => 'number',
        ),

		// 全局关闭评论
		array(
          'id'    	  => 'i_works_comment',
          'type'      => 'switcher',
          'title'     => '全局关闭评论',
        ),

  ),
);

// ------------------------------
// 下载                       -
// ------------------------------

$options[]      = array(
  'name'        => 'download',
  'title'       => '下载',
  'icon'        => 'fa fa-download',
  'fields'      => array(

    // 评论回复可见
    array(
      'id'    	  => 'i_download_view',
      'type'      => 'switcher',
      'title'     => '评论回复可见',
    ),

    // 解压密码
    array(
      'id'    => 'i_download_jieya',
      'type'  => 'text',
      'title' => '解压密码',
      'after' => '<p class="cs-text-muted">留空即无</p>',
    ),

    // 下载声明
    array(
      'id'    => 'i_download_shengming',
      'type'  => 'textarea',
      'title' => '下载声明',
    ),

  ),
);

// ------------------------------
// 边栏                       -
// ------------------------------

$options[]      = array(
  'name'        => 'sidebar',
  'title'       => '边栏',
  'icon'        => 'fa fa-tasks',
  'fields'      => array(

 		// 左侧边栏
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '左侧边栏',
		),

			// 启用左侧边栏
		array(
          'id'    	  => 'i_leftbar_view',
          'type'      => 'switcher',
          'title'     => '启用左侧边栏',
          'default'   => true,
        ),

			// 自定义菜单
        array(
          'id'              => 'i_menu',
          'type'            => 'group',
          'title'           => '自定义菜单',
          'info'            => '更多详细设置方式可以浏览使用说明',
          'button_title'    => '添加菜单项',
          'accordion_title' => '菜单项',
          'fields'          => array(

				// 自定义菜单--标题
            array(
              'id'          => 'i_menu_title',
			  'type'        => 'text',
              'title'       => '菜单标题',
			  'attributes'    => array(
				'placeholder' => '例如：心情、音乐、视频...'
			  )
            ),

				// 自定义图标类型
			array(
			  'id'         => 'i_menu_style',
			  'type'       => 'radio',
			  'title'      => '图标类型',
			  'class'      => 'horizontal',
			  'options'    => array(
				'i_icon'   => '字体图标',
				'i_image'  => '自定义图片',
			  ),
			  'default'    => 'i_icon',
			),

				// 自定义菜单--字体图标
			array(
			  'id'      => 'i_menu_icon',
			  'type'    => 'icon',
			  'title'   => '字体图标',
			  'dependency' => array( 'i_menu_style_i_icon', '==', 'true' ),
			),

				// 自定义菜单--自定义图片
			array(
			  'id'      => 'i_menu_image',
			  'type'    => 'upload',
			  'title'   => '自定义图片',
			  'dependency' => array( 'i_menu_style_i_image', '==', 'true' ),
			  'help'      => '自定义图片大小建议不宜超过100px',
			),

				// 自定义菜单--链接
			array(
			  'id'            => 'i_menu_link',
			  'type'          => 'text',
			  'title'         => '菜单链接',
			  'attributes'    => array(
				'placeholder' => 'http://...'
			  )
			),

				// 自定义菜单--新标签
			array(
			  'id'    	  => 'i_menu_newtab',
			  'type'      => 'switcher',
			  'title'     => '新标签打开',
			  'dependency'   => array( 'i_menu_link', '!=', '' ),
			),

          )
        ),


 		// 底边栏
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '底边栏',
		),

		// 启用底边栏
		array(
          'id'    	  => 'i_topbar_show',
          'type'      => 'switcher',
          'title'     => '启用底边栏',
		  'help'      => '至少存在一个小工具才会生效',
          'default'   => true,
        ),

		// 顶侧底边栏
        array(
          'id'         => 'i_topbar_col',
          'type'       => 'radio',
          'title'      => '分栏方式',
          'class'      => 'horizontal',
          'options'    => array(
            'col_1'   => '一栏',
            'col_2'   => '两栏',
            'col_3'   => '三栏',
            'col_4'   => '四栏',
          ),
          'default'    => 'col_1',
        ),

    ),
);

// ------------------------------
// 页脚                       -
// ------------------------------

$options[]      = array(
  'name'        => 'footer',
  'title'       => '页脚',
  'icon'        => 'fa fa-sliders',
  'fields'      => array(

 		// 显示回到顶部按钮
		array(
          'id'    	  => 'i_gotop',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '显示回到顶部按钮',
        ),

 		// 开启分享按钮
		array(
          'id'    	  => 'i_share',
          'type'      => 'switcher',
          'title'     => '开启分享按钮',
          'default'   => true,
          'help'       => '实际上是插入百度分享代码，更多设置可以参考百度官方网站',
        ),

 		// 图片分享功能
		array(
          'id'    	  => 'i_share_img',
          'type'      => 'switcher',
          'title'     => '图片分享功能',
          'dependency'   => array( 'i_share', '==', 'true' ),
        ),

 		// 划词分享功能
		array(
          'id'    	  => 'i_share_word',
          'type'      => 'switcher',
          'title'     => '划词分享功能',
          'dependency'   => array( 'i_share', '==', 'true' ),
        ),

 		// 显示评论按钮
		array(
          'id'    	  => 'i_comment_switch',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '显示评论按钮',
        ),


 		// 显示二维码
		array(
          'id'    	  => 'i_qrcode',
          'type'      => 'switcher',
          'title'     => '显示二维码',
        ),

		// 插入二维码
        array(
          'id'      => 'i_qrcode_image',
          'type'    => 'upload',
          'title'   => '插入二维码',
          'default' => get_template_directory_uri()."/images/qrcode.png",
          'help'      => '建议二维码尺寸不超过250px',
		  'dependency'   => array( 'i_qrcode', '==', 'true' ),
        ),

		// 版权信息
        array(
          'id'    => 'i_foot_copyright',
          'type'  => 'textarea',
          'title' => '版权信息',
          'attributes'    => array(
            'placeholder' => '© '.date("Y").' All Rights Reserved.'
          ),
          'help'  	  => '当右侧边栏隐藏，版权信息将显示在页面底部',
        ),

  ),
);

// ------------------------------
// SEO                       -
// ------------------------------

$options[]      = array(
  'name'        => 'seo',
  'title'       => 'SEO',
  'icon'        => 'fa fa-bug',
  'fields'      => array(

 		// 百度主动推送
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '百度主动推送',
		),

 		// 百度主动推送
		array(
          'id'    	  => 'i_baidu_submit',
          'type'      => 'switcher',
          'title'     => '百度主动推送',
        ),

		// 验证站点域名
		array(
		  'id'            => 'i_baidu_link',
		  'type'          => 'text',
		  'title'         => '验证站点域名',
		  'after'  		  => '<p class="cs-text-muted">在站长平台验证的站点，比如www.example.com</p>',
          'dependency' => array( 'i_baidu_submit', '==', 'true' ),
		),

		// 站点准入密钥
		array(
		  'id'            => 'i_baidu_key',
		  'type'          => 'text',
		  'title'         => '站点准入密钥',
		  'after'  		  => '<p class="cs-text-muted">在站长平台申请的推送用的准入token值,点击<a href="http://zhanzhang.baidu.com/linksubmit/" target="_blank">这里</a>获取</p>',
          'dependency' => array( 'i_baidu_submit', '==', 'true' ),
		),

 		// 百度手动推送
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '百度手动推送',
		),

 		// 百度手动推送
		array(
          'id'    	  => 'i_baidu_manual',
          'type'      => 'switcher',
          'title'     => '百度手动推送',
          'label'     => '推送按钮显示在文章上，管理员可见',
        ),

 		// Sitemap.xml
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => 'Sitemap.xml',
		),

 		// 生成sitemap.xml
		array(
          'id'    	  => 'i_seo_sitemap',
          'type'      => 'switcher',
          'title'     => '生成sitemap.xml',
        ),

		array(
		  'type'    => 'notice',
		  'class'   => 'warning',
		  'content' => "当前Sitemap地址为： ".home_url()."/sitemap.xml",
          'dependency' => array( 'i_seo_sitemap', '==', 'true' ),
		),

 		//基本信息
		 array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '基本信息',
		),

		// 关键词
		array(
		  'id'      => 'i_seo_keywords',
		  'type'    => 'textarea',
		  'title'   => '关键字',
		  'help'    => '标识页面是关于什么的关键词，通常在搜索引擎中使用',
		),


		// 描述
		array(
		  'id'      => 'i_seo_description',
		  'type'    => 'textarea',
		  'title'   => '描述',
		  'help'    => '页面的简短描述',
		),

  ),
);

// ------------------------------
// 简介                      -
// ------------------------------

$options[]      = array(
  'name'        => 'social',
  'title'       => '简介',
  'icon'        => 'fa fa-globe',
  'fields'      => array(

 		// 显示简介
		array(
          'id'    	  => 'i_me_switch',
          'type'      => 'switcher',
          'default'   => true,
          'title'     => '显示简介',
        ),

 		// 背景
        array(
          'id'      => 'i_avatar_bg',
          'type'    => 'upload',
          'title'   => '背景	',
          'default' => get_template_directory_uri()."/images/me-bg.jpg",
        ),

 		// 头像
        array(
          'id'      => 'i_avatar_image',
          'type'    => 'upload',
          'title'   => '头像	',
          'default' => get_template_directory_uri()."/images/default-avatar.png",
        ),

 		// 昵称
        array(
          'id'      => 'i_avatar_name',
          'type'    => 'text',
          'title'   => '昵称',
          'default' => '你的名字',
        ),

 		// 简介
        array(
          'id'      => 'i_avatar_content',
          'type'    => 'textarea',
          'title'   => '简介',
          'default' => '你的简介',
        ),

		// 自定义社交链接
        array(
          'id'              => 'i_social',
          'type'            => 'group',
          'title'           => '自定义社交链接',
          'info'            => '更多详细设置方式可以浏览使用说明',
          'button_title'    => '添加链接项',
          'accordion_title' => '链接项',
		  'help'            => '社交链接显示在关于我小工具里面',
          'fields'          => array(

				// 自定义社交链接--标题
            array(
              'id'          => 'i_social_title',
			  'type'        => 'text',
              'title'       => '菜单标题',
			  'attributes'    => array(
				'placeholder' => '例如：我的微博'
			  )
            ),

				// 自定义图标类型
			array(
			  'id'         => 'i_icon_style',
			  'type'       => 'radio',
			  'title'      => '图标类型',
			  'class'      => 'horizontal',
			  'options'    => array(
				'i_icon'   => '字体图标',
				'i_image'  => '自定义图片',
			  ),
			  'default'    => 'i_icon',
			),

				// 自定义社交链接--字体图标
			array(
			  'id'      => 'i_social_icon',
			  'type'    => 'icon',
			  'title'   => '字体图标',
			  'dependency' => array( 'i_icon_style_i_icon', '==', 'true' ),
			),

				// 自定义社交链接--自定义图片
			array(
			  'id'      => 'i_social_image',
			  'type'    => 'upload',
			  'title'   => '自定义图片',
			  'dependency' => array( 'i_icon_style_i_image', '==', 'true' ),
			  'help'      => '自定义图片大小建议不宜超过100px',
			),


				// 自定义社交链接--链接
			array(
			  'id'            => 'i_social_link',
			  'type'          => 'text',
			  'title'         => '菜单链接',
			  'attributes'    => array(
				'placeholder' => 'http://...'
			  )
			),

				// 自定义社交链接--新标签
			array(
			  'id'    	  => 'i_social_newtab',
			  'type'      => 'switcher',
			  'title'     => '新标签打开',
			  'dependency'   => array( 'i_social_link', '!=', '' ),
			),

          )
        ),

  ),
);


// ------------------------------
// 代码                      -
// ------------------------------

$options[]      = array(
  'name'        => 'code',
  'title'       => '代码',
  'icon'        => 'fa fa-code',
  'fields'      => array(

			// 自定义CSS
			array(
			  'id'     => 'i_css',
			  'type'   => 'textarea',
			  'before' => '<h4>自定义CSS</h4>',
			  'after'  => '<p class="cs-text-muted">注意：无需写入<strong>&lt;style></strong>标签。</p>',
			),

			// 自定义javascript
			array(
			  'id'     => 'i_js',
			  'type'   => 'textarea',
			  'before' => '<h4>自定义javascript</h4>',
			  'after'  => '<p class="cs-text-muted">注意：无需写入<strong>&lt;script></strong>标签。</p>',
			),

			// 统计代码
			array(
			  'id'     => 'i_js_tongji',
			  'type'   => 'textarea',
			  'before' => '<h4>统计代码</h4>',
			  'after'  => '<p class="cs-text-muted">注意：无需写入<strong>&lt;script></strong>标签。',
			),

  ),
);

// ------------------------------
// 扩展                      -
// ------------------------------
$options[]   = array(
  'name'     => 'extension',
  'title'    => '扩展',
  'icon'     => 'fa fa-cubes',
  'fields'   => array(

    array(
      'type'    => 'notice',
      'class'   => 'warning',
      'content' => '后续版本按用户需求添加各种扩展功能，每个扩展都会额外加载js或css，可按需开启',
    ),

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => '代码高亮',
    ),

 		// 代码高亮
		array(
          'id'    	  => 'i_code_prettify',
          'type'      => 'switcher',
          'title'     => '代码高亮',
		  'label'     => '使用pre标签把你的高亮代码包括起来',
        ),

		array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '音乐播放器',
		),

 		// 音乐播放器
		array(
          'id'    	  => 'i_player',
          'type'      => 'switcher',
          'title'     => '开启音乐播放器',
		  'help'    => '首次开启后，刷新页面，按提示安装cue音乐插件',
        ),

		// 歌单ID
        array(
          'id'         => 'i_player_id',
          'type'       => 'number',
          'title'      => '歌单ID',
          'dependency' => array( 'i_player', '==', 'true' ),
        ),

		// 播放器背景颜色
        array(
          'id'         => 'i_player_bg',
          'type'       => 'color_picker',
          'title'      => '播放器背景颜色',
		  'default'    => '#000000',
		  'rgba'    => false,
          'dependency' => array( 'i_player', '==', 'true' ),
        ),

		// 播放器按钮颜色
        array(
          'id'         => 'i_player_btn',
          'type'       => 'color_picker',
          'title'      => '播放器按钮颜色',
		  'default'    => '#ffffff',
		  'rgba'    => false,
          'dependency' => array( 'i_player', '==', 'true' ),
        ),

		// 手机端是否显示
		array(
          'id'    	  => 'i_player_mobi',
          'type'      => 'switcher',
          'title'     => '手机端是否关闭',
        ),

		array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '萤火虫背景',
		),

 		// 萤火虫背景
		array(
          'id'    	  => 'i_circle',
          'type'      => 'switcher',
          'title'     => '开启萤火虫背景',
        ),

		array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '下雪特效',
		),

 		// 下雪特效
		array(
          'id'    	  => 'i_snowfall',
          'type'      => 'switcher',
          'title'     => '下雪特效',
        ),

  )
);

// ------------------------------
// CDN                       -
// ------------------------------
$options[]   = array(
  'name'     => 'qiniu',
  'title'    => 'CDN',
  'icon'     => 'fa fa-cloud-upload',
  'fields'   => array(

    array(
      'type'    => 'notice',
      'class'   => 'warning',
      'content' => '开启CDN加速你的网站，其中需手动修改comments-ajax.js文件，详情请关注老赵博客',
    ),

		// 开启加速
		array(
          'id'    	  => 'i_qiniu',
          'type'      => 'switcher',
          'title'     => '开启加速',
        ),

		// CDN域名
		array(
		  'id'            => 'i_qiniu_link',
		  'type'          => 'text',
		  'title'         => 'CDN域名',
		  'after'  		  => '<p class="cs-text-muted">注意：开头需写入http://，结尾不需写入/</p>',
		  'attributes'    => array(
			'placeholder' => 'http://'
		  )
		),

		// 包含目录
		array(
		  'id'            => 'i_qiniu_dir',
		  'type'          => 'text',
		  'title'         => '包含目录',
		  'default'       => 'wp-content,wp-includes',
		),

		// 排除文件
		array(
		  'id'            => 'i_qiniu_exc',
		  'type'          => 'text',
		  'title'         => '排除文件',
		  'default'       => '.php|.xml|.html|.po|.mo',
		),

  )
);

// ------------------------------
// 备份                       -
// ------------------------------
$options[]   = array(
  'name'     => 'advanced',
  'title'    => '备份',
  'icon'     => 'fa fa-shield',
  'fields'   => array(

    array(
      'type'    => 'notice',
      'class'   => 'warning',
      'content' => '您可以保存当前的选项，下载一个备份和导入.',
    ),

	// 备份
    array(
      'type'    => 'backup',
    ),

  )
);

// ------------------------------
// 管理                       -
// ------------------------------
$options[]   = array(
  'name'     => 'admin',
  'title'    => '管理',
  'icon'     => 'fa fa-gears',
  'fields'   => array(

		array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '推送通知',
		),

 		// 更新推送
		array(
          'id'    	  => 'i_push',
          'type'      => 'switcher',
          'default'   => true,
          'label'     => '开启可及时得到最新主题更新消息',
          'title'     => '推送通知',
        ),

		array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '维护模式',
		),

 		// 维护模式
		array(
          'id'    	  => 'i_maintenance',
          'type'      => 'switcher',
          'title'     => '维护模式',
        ),

		// 标题
        array(
          'id'         => 'i_maintenance_title',
          'type'       => 'text',
          'title'      => '标题',
          'default'    => '维护中...',
          'dependency' => array( 'i_maintenance', '==', 'true' ),
        ),

		// 通知
        array(
          'id'         => 'i_maintenance_notice',
          'type'       => 'textarea',
          'title'      => '通知',
          'default'    => '网站升级维护中...',
          'dependency' => array( 'i_maintenance', '==', 'true' ),
        ),

		array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => '保护后台登录',
		),

 		// 保护登录地址
		array(
          'id'    	  => 'i_login_protection',
          'type'      => 'switcher',
          'title'     => '保护登录地址',
        ),

		// 前缀
        array(
          'id'         => 'i_login_prefix',
          'type'       => 'text',
          'title'      => '前缀',
          'default'    => 'admin',
          'dependency' => array( 'i_login_protection', '==', 'true' ),
        ),

		// 后缀
        array(
          'id'         => 'i_login_suffix',
          'type'       => 'text',
          'title'      => '后缀',
          'default'    => 'true',
          'dependency' => array( 'i_login_protection', '==', 'true' ),
        ),

		// 非法登录跳转
        array(
          'id'         => 'i_login_link',
          'type'       => 'text',
          'title'      => '非法登录跳转',
          'default'    => home_url(),
          'dependency' => array( 'i_login_protection', '==', 'true' ),
        ),

		array(
		  'type'    => 'notice',
		  'class'   => 'warning',
		  'content' => "当前登录地址为： ".home_url()."/wp-login.php?".cs_get_option('i_login_prefix')."=".cs_get_option('i_login_suffix'),
          'dependency' => array( 'i_login_protection', '==', 'true' ),
		),

 		// 过滤HTTP 1.0的登录POST请求
		array(
          'id'    	  => 'i_login_http',
          'type'      => 'switcher',
          'title'     => '过滤HTTP 1.0',
        ),

 		// POST Cookie 保护
		array(
          'id'    	  => 'i_login_cookie',
          'type'      => 'switcher',
          'title'     => 'POST Cookie 保护',
        ),

 		// 增加额外登录验证
		array(
          'id'    	  => 'i_login_auth',
          'type'      => 'switcher',
          'title'     => '增加额外登录验证',
        ),

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => '弹窗控件',
    ),

      // 弹窗控件
    array(
          'id'        => 'i_modal',
          'type'      => 'switcher',
          'title'     => '弹窗控件',
          'label'     => 'cookie效果的弹窗',
        ),

    // 标题
    array(
      'id'      => 'i_modal_title',
      'type'    => 'text',
      'title'   => '标题',
      'dependency' => array( 'i_modal', '==', 'true' ),
    ),

    // 内容
    array(
      'id'      => 'i_modal_main',
      'type'    => 'textarea',
      'title'   => '内容',
      'dependency' => array( 'i_modal', '==', 'true' ),
    ),

  )
);

// ------------------------------
// 关于                       -
// ------------------------------
$options[]   = array(
  'name'     => 'about',
  'title'    => '关于',
  'icon'     => 'fa fa-info-circle',
  'fields' => array(

		// 关于主题
        array(
          'type'    => 'content',
          'content' => '<iframe src="http://7xigsj.com1.z0.glb.clouddn.com/index.html" style="width:100%;height:900px;"></iframe>',
		),

  ),
);

// ------------------------------
// 权限                       -
// ------------------------------
$options[]   = array(
  'name'     => 'authority',
  'title'    => '权限',
  'icon'     => 'fa fa-user-secret',
  'fields'   => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => '更新推送',
    ),

    // 更新推送
    array(
          'id'        => 'i_update',
          'type'      => 'switcher',
          'title'     => '更新推送',
        ),

    // 版本号
        array(
          'id'         => 'i_update_version',
          'type'       => 'text',
          'title'      => '版本号',
          'dependency' => array( 'i_update', '==', 'true' ),
        ),

    // 通知
        array(
          'id'         => 'i_update_notice',
          'type'       => 'textarea',
          'title'      => '通知',
          'dependency' => array( 'i_update', '==', 'true' ),
        ),

  )
);

CSFramework::instance( $settings, $options );
