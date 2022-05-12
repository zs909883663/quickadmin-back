/*
将初始化数据导入建好的数据库中
Date: 2022-05-12 23:28:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `qu_example_category`
-- ----------------------------
DROP TABLE IF EXISTS `qu_example_category`;
CREATE TABLE `qu_example_category` (
  `id` bigint(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '分类描述',
  `weigh` int(9) DEFAULT '0' COMMENT '排序',
  `status` int(9) DEFAULT '0' COMMENT '状态值(select):0=禁用,1=正常',
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qu_example_category
-- ----------------------------
INSERT INTO `qu_example_category` VALUES ('1', '测试分类', '1', '0', '0', '这个是标题1');
INSERT INTO `qu_example_category` VALUES ('2', '分类2', '2', '0', '0', '测试标题612');
INSERT INTO `qu_example_category` VALUES ('3', '分类3', '3', '0', '0', '测试标题63');
INSERT INTO `qu_example_category` VALUES ('4', '分类4', '4', '0', '0', '测试标题64');
INSERT INTO `qu_example_category` VALUES ('5', '分类5', '5', '0', '0', '测试标题65');
INSERT INTO `qu_example_category` VALUES ('6', '测试分类6', '1', '0', '0', '测试标题65');
INSERT INTO `qu_example_category` VALUES ('7', '分类7', '2', '0', '0', '测试标题76');
INSERT INTO `qu_example_category` VALUES ('8', '分类8', '6', '0', '0', '测试标题87');
INSERT INTO `qu_example_category` VALUES ('9', '分类9', '7', '0', '0', '测试标题98');
INSERT INTO `qu_example_category` VALUES ('10', '分类10', '8', '0', '0', '测试标题10');
INSERT INTO `qu_example_category` VALUES ('11', '测试分类6', '1', '0', '0', '测试标题11');
INSERT INTO `qu_example_category` VALUES ('12', '分类7', '2', '0', '0', '测试标题12');
INSERT INTO `qu_example_category` VALUES ('13', '分类8', '9', '0', '0', '测试标题13');
INSERT INTO `qu_example_category` VALUES ('14', '分类9', '10', '0', '0', '测试标题14');
INSERT INTO `qu_example_category` VALUES ('15', '分类10', '11', '0', '0', '测试标题150');
INSERT INTO `qu_example_category` VALUES ('16', '测试分类6', '1', '0', '0', '测试标题16');
INSERT INTO `qu_example_category` VALUES ('17', '分类7', '2', '0', '0', '测试标题17');
INSERT INTO `qu_example_category` VALUES ('18', '分类8', '12', '0', '0', '测试标题18');
INSERT INTO `qu_example_category` VALUES ('19', '分类9', '13', '0', '0', '测试标题19');
INSERT INTO `qu_example_category` VALUES ('20', '分类10', '14', '0', '0', '测试标题20');
INSERT INTO `qu_example_category` VALUES ('21', '测试分类6', '1', '0', '0', '测试标题21');
INSERT INTO `qu_example_category` VALUES ('22', '分类7', '2', '0', '0', '测试标题22');
INSERT INTO `qu_example_category` VALUES ('23', '分类8', '15', '0', '0', '测试标题23');
INSERT INTO `qu_example_category` VALUES ('24', '分类9', '16', '0', '0', '测试标题24');
INSERT INTO `qu_example_category` VALUES ('25', '分类10', '17', '0', '0', '测试标题250');

-- ----------------------------
-- Table structure for `qu_example_demo`
-- ----------------------------
DROP TABLE IF EXISTS `qu_example_demo`;
CREATE TABLE `qu_example_demo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `week` int(10) NOT NULL DEFAULT '3' COMMENT '星期(select单选):1=星期一,2=星期二,3=星期三',
  `flag` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标志(select多选):1=热门,2=最新,3=推荐',
  `genderdata` int(10) NOT NULL DEFAULT '3' COMMENT '性别(单选):1=男,2=女,3=未知',
  `actdata` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '活动(多选):1=徒步,2=读书会,3=自驾游',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `keywords` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '关键字',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '描述',
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片',
  `images` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片组',
  `attachfile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '附件',
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '省市',
  `price` float(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `startdate` int(10) DEFAULT NULL COMMENT '开始日期',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `switch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开关1开0：关',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '状态值:0=禁用,1=正常',
  `category_id` int(11) DEFAULT NULL COMMENT '分类',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '111',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='案例表';

-- ----------------------------
-- Records of qu_example_demo
-- ----------------------------
INSERT INTO `qu_example_demo` VALUES ('1', '1', '2,1,3', '1', '', '完整表单案例1', '<p>完整表单案例1</p>', '完整表单案例1', '完整表单案例1', 'http://api.njyyc.cn/storage/system/20211216/bab7ab63cae84166ddc0017feb237bb3.jpg', 'http://api.njyyc.cn/storage/system/20211216/bab7ab63cae84166ddc0017feb237bb3.jpg,http://api.njyyc.cn/storage/system/20211216/8d078cfb52c09039adb301b942e4afa4.png', '', '北京市,市辖区,东城区', '0.70', '1639642410', null, '2022-04-29 16:06:32', '3', '1', '1', '2', '111');
INSERT INTO `qu_example_demo` VALUES ('8', '2', '3', '3', '1,3', '完整表单案例2', '<p>完整表单案例2</p>', '完整表单案例2', '完整表单案例2', 'http://yyc-1301620739.cos.ap-nanjing.myqcloud.com/20220429626b9ccb9d4b2.png', '', 'http://api.njyyc.cn/storage/system/20210908/9e754e13af52a7f41ff98e1002258f5a.txt', '江苏省,南京市,市辖区', '0.10', '1640880000', null, '2022-04-29 16:07:54', '10', '1', '1', '3', '111');
INSERT INTO `qu_example_demo` VALUES ('10', '3', '1,2', '2', '1', '完整表单案例3', '<p>完整表单案例3</p>', '完整表单案例3', '完整表单案例3', 'http://api.njyyc.cn/storage/system/20211217/dec40d71a0b9688210253642d6bf8cb5.png', 'http://api.njyyc.cn/storage/system/20211217/28e99378013949b4b1790b35d9fdddb5.png', '', '山西省,大同市,新荣区', '0.00', '1650643200', null, '2022-05-05 15:48:24', '50', '1', '2', '3', '111');
INSERT INTO `qu_example_demo` VALUES ('14', '4', '3', '1', '1,2', '完整表单案例4', '<p>完整表单案例4</p>', '完整表单案例4', '完整表单案例4', 'http://yyc-1301620739.cos.ap-nanjing.myqcloud.com/20220429626b9d851d9c4.png', '', '', '江苏省,无锡市,锡山区', '0.00', '1643212800', null, '2022-05-02 14:41:52', '0', '0', '1', '4', '111');
INSERT INTO `qu_example_demo` VALUES ('53', '5', null, '3', null, '完整表单案例5', '<p>完整表单案例5</p>', '完整表单案例5', '完整表单案例5', '', '', '', '北京市,市辖区,西城区', '0.20', '1649779200', '2022-02-25 17:30:31', '2022-04-29 16:14:40', '0', '0', '1', '5', '111');
INSERT INTO `qu_example_demo` VALUES ('54', '3', null, '3', null, '234234324', '<p>234234234234234234234</p>', '111233', '', '', '', '', '山西省,阳泉市,城区', '0.00', null, '2022-04-12 11:10:10', '2022-04-29 10:18:57', '0', '0', '1', '6', '111');

-- ----------------------------
-- Table structure for `qu_example_orders`
-- ----------------------------
DROP TABLE IF EXISTS `qu_example_orders`;
CREATE TABLE `qu_example_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '订单号',
  `total` float(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `remark` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单备注',
  `express_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '物流单号',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '状态值(select):1=未付款,2=待发货,3待收货,4=已完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单表';

-- ----------------------------
-- Records of qu_example_orders
-- ----------------------------
INSERT INTO `qu_example_orders` VALUES ('1', 'DD20220329', '500.00', '这是一个测试订单', 'YQ1235', '2022-04-20 12:01:40', '2022-04-29 16:18:55', '3');
INSERT INTO `qu_example_orders` VALUES ('2', 'DD202204121255', '299.00', '这是一个测试的订单', 'SF12345678', '2022-04-20 12:02:33', '2022-04-20 19:16:00', '3');
INSERT INTO `qu_example_orders` VALUES ('3', 'DD20220422', '366.00', '送到物业', '', '2022-04-20 12:03:22', '2022-04-29 16:18:38', '1');
INSERT INTO `qu_example_orders` VALUES ('4', 'DD998888', '58.00', '尽快发货', 'ST0098787', '2022-04-20 12:03:46', '2022-04-29 16:18:25', '3');

-- ----------------------------
-- Table structure for `qu_system_admin`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_admin`;
CREATE TABLE `qu_system_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `phone` varchar(16) DEFAULT NULL COMMENT '联系手机号',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `head_image` varchar(255) DEFAULT NULL COMMENT '头像',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用,)',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `group_ids` varchar(255) DEFAULT NULL COMMENT '权限id(逗号隔开)',
  `nickname` varchar(100) DEFAULT NULL COMMENT '昵称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of qu_system_admin
-- ----------------------------
INSERT INTO `qu_system_admin` VALUES ('1', 'admin', '', 'e10adc3949ba59abbe56e057f20f883e', 'http://yyc-1301620739.cos.ap-nanjing.myqcloud.com/202205056273755e06da7.png', '', '1', null, '2022-05-05 14:58:45', '1,4', 'admin');

-- ----------------------------
-- Table structure for `qu_system_category`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_category`;
CREATE TABLE `qu_system_category` (
  `id` bigint(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '分类描述',
  `weigh` int(9) DEFAULT '0' COMMENT '排序',
  `status` int(9) DEFAULT '0' COMMENT '状态值(select):0=禁用,1=正常',
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qu_system_category
-- ----------------------------
INSERT INTO `qu_system_category` VALUES ('1', '测试分类', '1', '0', '0', '这个是标题1');
INSERT INTO `qu_system_category` VALUES ('2', '分类2', '2', '0', '0', '测试标题612');
INSERT INTO `qu_system_category` VALUES ('3', '分类3', '3', '0', '0', '测试标题63');
INSERT INTO `qu_system_category` VALUES ('4', '分类4', '4', '0', '0', '测试标题64');
INSERT INTO `qu_system_category` VALUES ('5', '分类5', '5', '0', '0', '测试标题65');
INSERT INTO `qu_system_category` VALUES ('6', '测试分类6', '1', '0', '0', '测试标题65');
INSERT INTO `qu_system_category` VALUES ('7', '分类7', '2', '0', '0', '测试标题76');
INSERT INTO `qu_system_category` VALUES ('8', '分类8', '6', '0', '0', '测试标题87');
INSERT INTO `qu_system_category` VALUES ('9', '分类9', '7', '0', '0', '测试标题98');
INSERT INTO `qu_system_category` VALUES ('10', '分类10', '8', '0', '0', '测试标题10');
INSERT INTO `qu_system_category` VALUES ('11', '测试分类6', '1', '0', '0', '测试标题11');
INSERT INTO `qu_system_category` VALUES ('12', '分类7', '2', '0', '0', '测试标题12');
INSERT INTO `qu_system_category` VALUES ('13', '分类8', '9', '0', '0', '测试标题13');
INSERT INTO `qu_system_category` VALUES ('14', '分类9', '10', '0', '0', '测试标题14');
INSERT INTO `qu_system_category` VALUES ('15', '分类10', '11', '0', '0', '测试标题150');
INSERT INTO `qu_system_category` VALUES ('16', '测试分类6', '1', '0', '0', '测试标题16');
INSERT INTO `qu_system_category` VALUES ('17', '分类7', '2', '0', '0', '测试标题17');
INSERT INTO `qu_system_category` VALUES ('18', '分类8', '12', '0', '0', '测试标题18');
INSERT INTO `qu_system_category` VALUES ('19', '分类9', '13', '0', '0', '测试标题19');
INSERT INTO `qu_system_category` VALUES ('20', '分类10', '14', '0', '0', '测试标题20');
INSERT INTO `qu_system_category` VALUES ('21', '测试分类6', '1', '0', '0', '测试标题21');
INSERT INTO `qu_system_category` VALUES ('22', '分类7', '2', '0', '0', '测试标题22');
INSERT INTO `qu_system_category` VALUES ('23', '分类8', '15', '0', '0', '测试标题23');
INSERT INTO `qu_system_category` VALUES ('24', '分类9', '16', '0', '0', '测试标题24');
INSERT INTO `qu_system_category` VALUES ('25', '分类10', '17', '0', '0', '测试标题250');

-- ----------------------------
-- Table structure for `qu_system_config`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_config`;
CREATE TABLE `qu_system_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '变量名',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '变量标题',
  `group` varchar(30) NOT NULL DEFAULT '' COMMENT '分组',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型input,textarea,image,images,switch',
  `value` text COMMENT '变量值',
  `remark` varchar(100) DEFAULT '' COMMENT '备注信息',
  `weigh` int(10) DEFAULT '0',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `group` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统配置表';

-- ----------------------------
-- Records of qu_system_config
-- ----------------------------
INSERT INTO `qu_system_config` VALUES ('1', 'site_logo', '网站logo', 'site', 'image', '', '网站的logo', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('2', 'site_title', '网站标题', 'site', 'input', 'QuickAdmin', '网站的logo', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('3', 'site_copyright', '版权信息', 'site', 'input', '©版权所有 2020-2021 xxx版权所有', '网站的版权', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('4', 'site_beian', '备案信息', 'site', 'input', '苏ICP备xxxxx号', '网站备案信息', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('5', 'upload_ext', '允许后缀', 'upload', '', 'doc,gif,ico,icon,jpg,mp3,mp4,p12,pem,png,rar,jpeg', '上传允许的后缀', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('6', 'upload_url', '图片路径', 'upload', '', 'http://quickadmin-prod.demo.com', '上传文件访问地址', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('7', 'site_switch', '网站开关', 'site', '', '1', '网站是否关闭', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('8', 'site_ip_blacklist', 'ip黑名单', 'site', '', '2223.8.9,127.0.0.1,211.234.98.112', 'ip黑名单用逗号隔开', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('9', 'site_open_time', '网站维护时间', 'site', '', '6,7,5', '网站维护时间', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('10', 'site_isreg', '允许注册', 'site', '', '1', '是否允许注册', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('11', 'upload_type', '上传方式', 'upload', '', 'alioss', '上传方式', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('12', 'site_back_image', '登录页背景图', 'site', 'image', '', '登录页背景', '0', null, null);
INSERT INTO `qu_system_config` VALUES ('13', 'site_icon', 'icon', 'site', 'image', '', '网站小icon', '0', null, null);

-- ----------------------------
-- Table structure for `qu_system_files`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_files`;
CREATE TABLE `qu_system_files` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `upload_type` varchar(20) NOT NULL DEFAULT 'local' COMMENT '存储位置',
  `original_name` varchar(255) DEFAULT NULL COMMENT '文件原名',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '物理路径',
  `image_width` varchar(30) NOT NULL DEFAULT '' COMMENT '宽度',
  `image_height` varchar(30) NOT NULL DEFAULT '' COMMENT '高度',
  `image_frames` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片帧数',
  `mime_type` varchar(100) NOT NULL DEFAULT '' COMMENT 'mime类型',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `file_ext` varchar(100) DEFAULT NULL COMMENT '文件后缀',
  `sha1` varchar(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `create_time` datetime DEFAULT NULL COMMENT '创建日期',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `file_type` varchar(100) DEFAULT NULL COMMENT '文件类型',
  PRIMARY KEY (`id`),
  KEY `upload_type` (`upload_type`),
  KEY `original_name` (`original_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='上传文件表';

-- ----------------------------
-- Records of qu_system_files
-- ----------------------------

-- ----------------------------
-- Table structure for `qu_system_group`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_group`;
CREATE TABLE `qu_system_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `status` int(10) NOT NULL DEFAULT '0' COMMENT '状态',
  `weigh` int(10) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of qu_system_group
-- ----------------------------
INSERT INTO `qu_system_group` VALUES ('1', '超级管理员', null, null, '1', '0');
INSERT INTO `qu_system_group` VALUES ('4', 'web管理员', null, '2022-05-10 16:54:55', '1', '3');

-- ----------------------------
-- Table structure for `qu_system_group_admin`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_group_admin`;
CREATE TABLE `qu_system_group_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '组id',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='用户-组关系表';

-- ----------------------------
-- Records of qu_system_group_admin
-- ----------------------------
INSERT INTO `qu_system_group_admin` VALUES ('27', '1', '1');

-- ----------------------------
-- Table structure for `qu_system_group_menu`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_group_menu`;
CREATE TABLE `qu_system_group_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '组id',
  `menu_id` text NOT NULL COMMENT '菜单id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组菜单表';

-- ----------------------------
-- Records of qu_system_group_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `qu_system_log`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_log`;
CREATE TABLE `qu_system_log` (
  `id` bigint(15) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) unsigned DEFAULT '0' COMMENT '管理员ID',
  `url` varchar(1500) NOT NULL DEFAULT '' COMMENT '操作页面',
  `method` varchar(50) NOT NULL COMMENT '请求方法',
  `title` varchar(100) DEFAULT '' COMMENT '日志标题',
  `content` text NOT NULL COMMENT '内容',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) DEFAULT '' COMMENT 'User-Agent',
  `create_time` datetime DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台操作日志表';

-- ----------------------------
-- Records of qu_system_log
-- ----------------------------

-- ----------------------------
-- Table structure for `qu_system_menu`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_menu`;
CREATE TABLE `qu_system_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '1为目录,2菜单3按钮',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '规则名称',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `path` varchar(50) DEFAULT '' COMMENT '地址名称',
  `component` varchar(255) DEFAULT NULL COMMENT '地址',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `weigh` int(10) DEFAULT '0' COMMENT '权重',
  `status` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1:显示 0：隐藏',
  `permission` varchar(255) DEFAULT NULL COMMENT '后台接口地址',
  `tag_type` varchar(255) DEFAULT NULL,
  `tag_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8 COMMENT='菜单节点表';

-- ----------------------------
-- Records of qu_system_menu
-- ----------------------------
INSERT INTO `qu_system_menu` VALUES ('1', '1', '0', '系统管理', 'system', 'system', 'Layout', null, '2022-04-28 20:11:07', '0', '1', null, '', '');
INSERT INTO `qu_system_menu` VALUES ('2', '2', '1', '菜单管理', 'tree-table', 'menu', 'system/menu/index', null, null, '0', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('3', '3', '2', '列表', 'tree-table', null, null, null, null, '0', '1', '/admin/system.menu/index', null, null);
INSERT INTO `qu_system_menu` VALUES ('4', '3', '2', '添加', 'tree-table', null, null, null, null, '0', '1', '/admin/system.menu/add', null, null);
INSERT INTO `qu_system_menu` VALUES ('5', '3', '2', '查找', 'tree-table', null, null, null, null, '0', '1', '/admin/system.menu/find', null, null);
INSERT INTO `qu_system_menu` VALUES ('6', '3', '2', '修改', 'tree-table', null, null, null, null, '0', '1', '/admin/system.menu/edit', null, null);
INSERT INTO `qu_system_menu` VALUES ('7', '3', '2', '删除', 'tree-table', null, null, null, null, '0', '1', '/admin/system.menu/delete', null, null);
INSERT INTO `qu_system_menu` VALUES ('8', '2', '1', '角色组管理', 'peoples', 'role', 'system/role/index', null, null, '3', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('9', '3', '8', '获取授权', 'tree-table', null, null, null, null, '0', '1', '/admin/system.role/authData', null, null);
INSERT INTO `qu_system_menu` VALUES ('10', '3', '8', '授权', 'tree-table', null, null, null, null, '0', '1', '/admin/system.role/authGroup', null, null);
INSERT INTO `qu_system_menu` VALUES ('11', '3', '8', '列表', 'tree-table', null, null, null, null, '0', '1', '/admin/system.role/index', null, null);
INSERT INTO `qu_system_menu` VALUES ('12', '3', '8', '添加', 'tree-table', null, null, null, null, '0', '1', '/admin/system.role/add', null, null);
INSERT INTO `qu_system_menu` VALUES ('13', '3', '8', '查找', 'tree-table', null, null, null, null, '0', '1', '/admin/system.role/find', null, null);
INSERT INTO `qu_system_menu` VALUES ('14', '3', '8', '修改', 'tree-table', null, null, null, null, '0', '1', '/admin/system.role/edit', null, null);
INSERT INTO `qu_system_menu` VALUES ('15', '3', '8', '删除', 'tree-table', null, null, null, null, '0', '1', '/admin/system.role/delete', null, null);
INSERT INTO `qu_system_menu` VALUES ('16', '2', '1', '系统配置', 'system', 'config', 'system/config/index', null, null, '0', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('17', '3', '16', '配置详情', 'tree-table', null, null, null, null, '0', '1', '/admin/system.config/index', null, null);
INSERT INTO `qu_system_menu` VALUES ('18', '2', '1', '日志管理', 'log', 'log', 'system/log/index', null, null, '0', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('19', '2', '18', '列表', 'log', null, null, null, null, '0', '1', '/admin/system.log/index', null, null);
INSERT INTO `qu_system_menu` VALUES ('20', '2', '18', '删除', 'log', null, null, null, null, '0', '1', '/admin/system.log/delete', null, null);
INSERT INTO `qu_system_menu` VALUES ('21', '1', '0', '系统工具', 'tool', 'tool', 'Layout', null, null, '0', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('22', '2', '170', '表单测试案例', 'table', 'curd', 'example/curd/index', null, '2022-05-02 12:13:44', '0', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('23', '3', '22', '列表', 'tree-table', null, null, null, null, '0', '1', '/admin/example.demo/index', null, null);
INSERT INTO `qu_system_menu` VALUES ('24', '3', '22', '添加', 'tree-table', null, null, null, null, '0', '1', '/admin/example.demo/add', null, null);
INSERT INTO `qu_system_menu` VALUES ('25', '3', '22', '查找', 'tree-table', null, null, null, null, '0', '1', '/admin/example.demo/find', null, null);
INSERT INTO `qu_system_menu` VALUES ('26', '3', '22', '修改', 'tree-table', null, null, null, null, '0', '1', '/admin/example.demo/edit', null, null);
INSERT INTO `qu_system_menu` VALUES ('27', '3', '22', '删除', 'tree-table', null, null, null, null, '0', '1', '/admin/example.demo/delete', null, null);
INSERT INTO `qu_system_menu` VALUES ('28', '3', '22', '导出', 'tree-table', null, null, null, null, '0', '1', '/admin/example.demo/export', null, null);
INSERT INTO `qu_system_menu` VALUES ('29', '2', '1', '管理员管理', 'user', 'staff', 'system/staff/index', null, null, '1', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('30', '3', '29', '列表', 'tree-table', null, null, null, null, '0', '1', '/admin/system.admin/index', null, null);
INSERT INTO `qu_system_menu` VALUES ('31', '3', '29', '添加', 'tree-table', null, null, null, null, '0', '1', '/admin/system.admin/add', null, null);
INSERT INTO `qu_system_menu` VALUES ('32', '3', '29', '查找', 'tree-table', null, null, null, null, '0', '1', '/admin/system.admin/find', null, null);
INSERT INTO `qu_system_menu` VALUES ('33', '3', '29', '修改', 'tree-table', null, null, null, null, '0', '1', '/admin/system.admin/edit', null, null);
INSERT INTO `qu_system_menu` VALUES ('34', '3', '29', '删除', 'tree-table', null, null, null, null, '0', '1', '/admin/system.admin/delete', null, null);
INSERT INTO `qu_system_menu` VALUES ('35', '2', '21', '附件管理', 'zip', 'file', 'tool/file/index', null, null, '0', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('36', '3', '35', '列表', 'tree-table', null, null, null, null, '0', '1', '/admin/system.files/index', null, null);
INSERT INTO `qu_system_menu` VALUES ('37', '3', '35', '删除', 'tree-table', null, null, null, null, '0', '1', '/admin/system.files/delete', null, null);
INSERT INTO `qu_system_menu` VALUES ('38', '2', '171', 'Online表单开发', 'online', 'index', 'online/index', null, '2022-05-02 14:33:07', '1', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('71', '2', '171', '插件市场', 'build', 'plugin', 'plugin/index', null, '2022-04-28 20:22:12', '0', '1', null, 'danger', '');
INSERT INTO `qu_system_menu` VALUES ('127', '1', '0', '官网', 'guide', 'http://www.quickadmin.icu', 'Layout', null, '2022-05-10 09:25:25', '0', '1', null, 'success', '');
INSERT INTO `qu_system_menu` VALUES ('149', '2', '170', 'tab状态检索案例', 'code', 'orders', 'example/orders/index', '2022-04-20 11:53:56', '2022-05-02 12:15:47', '0', '1', null, null, null);
INSERT INTO `qu_system_menu` VALUES ('150', '3', '149', '列表', 'code', '', null, '2022-04-20 11:53:56', '2022-04-20 11:53:56', '0', '1', '/admin/example.orders/index', null, null);
INSERT INTO `qu_system_menu` VALUES ('151', '3', '149', '添加', 'code', '', null, '2022-04-20 11:53:56', '2022-04-20 11:53:56', '0', '1', '/admin/example.orders/add', null, null);
INSERT INTO `qu_system_menu` VALUES ('152', '3', '149', '查看', 'code', '', null, '2022-04-20 11:53:57', '2022-04-20 11:53:57', '0', '1', '/admin/example.orders/find', null, null);
INSERT INTO `qu_system_menu` VALUES ('153', '3', '149', '编辑', 'code', '', null, '2022-04-20 11:53:57', '2022-04-20 11:53:57', '0', '1', '/admin/example.orders/edit', null, null);
INSERT INTO `qu_system_menu` VALUES ('154', '3', '149', '删除', 'code', '', null, '2022-04-20 11:53:57', '2022-04-20 11:53:57', '0', '1', '/admin/example.orders/delete', null, null);
INSERT INTO `qu_system_menu` VALUES ('155', '3', '149', '导出', 'code', '', null, '2022-04-20 11:53:57', '2022-04-20 11:53:57', '0', '1', '/admin/example.orders/export', null, null);
INSERT INTO `qu_system_menu` VALUES ('170', '1', '0', '常用案例', 'example', 'example', 'Layout', '2022-04-28 20:07:30', '2022-04-28 20:07:30', '0', '1', null, 'warning', 'example');
INSERT INTO `qu_system_menu` VALUES ('171', '1', '0', '在线开发', 'form', 'online', 'Layout', '2022-04-28 20:08:25', '2022-04-28 20:08:25', '0', '1', null, 'danger', 'hot');

-- ----------------------------
-- Table structure for `qu_system_onlinecurd`
-- ----------------------------
DROP TABLE IF EXISTS `qu_system_onlinecurd`;
CREATE TABLE `qu_system_onlinecurd` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `table` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `comment` varchar(255) DEFAULT NULL COMMENT '表备注',
  `relation_table` varchar(1000) DEFAULT NULL COMMENT '关联表',
  `filename` text COMMENT '文件夹路径',
  `params` text COMMENT '参数',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(0:失败,1:成功,)',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `version` int(11) DEFAULT '0' COMMENT '版本',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='在线curd';

-- ----------------------------
-- Records of qu_system_onlinecurd
-- ----------------------------

-- ----------------------------
-- Table structure for `qu_test`
-- ----------------------------
DROP TABLE IF EXISTS `qu_test`;
CREATE TABLE `qu_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `week` int(10) NOT NULL DEFAULT '3' COMMENT '星期(select):1=星期一,2=星期二,3=星期三',
  `flag` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标志(selects):1=热门,2=最新,3=推荐',
  `genderdata` int(10) NOT NULL DEFAULT '3' COMMENT '性别(radio):1=男,2=女,3=未知',
  `actdata` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活动(checkbox):1=徒步,2=读书会,3=自驾游',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `keywords` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '关键字',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '描述',
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片',
  `images` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片组',
  `attachfile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '附件',
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '省市',
  `price` float(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `startdate` int(10) DEFAULT NULL COMMENT '开始日期',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `switch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开关(switch)',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '状态值(select):0=禁用,1=正常',
  `category_id` int(11) DEFAULT NULL COMMENT '分类',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '111',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='案例表';

-- ----------------------------
-- Records of qu_test
-- ----------------------------
