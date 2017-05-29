-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-12-25 09:27:55
-- 服务器版本： 5.6.21-log
-- PHP Version: 5.5.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lion_site`
--

-- --------------------------------------------------------

--
-- 表的结构 `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `sort` int(11) DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `photo_num` int(11) DEFAULT '0',
  `recommend` smallint(6) DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `ext` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `attachment`
--

INSERT INTO `attachment` (`id`, `author_id`, `title`, `path`, `name`, `sort`, `desc`, `ext`, `created_at`, `status`) VALUES
(1, 1, '宝宝出生.jpeg', '/upload/image/20161216', '1481863203713.jpeg', NULL, NULL, 'jpeg', 1481863203, 1),
(2, 1, '宝宝出生.jpeg', '/upload/image/20161216', '1481863303840.jpeg', NULL, NULL, 'jpeg', 1481863303, 1),
(3, 1, '宝宝出生', '/upload/image/20161216', '1481882289725.jpeg', NULL, NULL, 'jpeg', 1481882290, 1),
(4, 1, '税', '/upload/image/20161216', '1481882291288.jpeg', NULL, NULL, 'jpeg', 1481882291, 1),
(5, 1, '税.jpeg', '/upload/image/20161216', '1481883239227.jpeg', NULL, NULL, 'jpeg', 1481883240, 1),
(6, 1, '宝宝出生.jpeg', '/upload/image/20161216', '1481883241573.jpeg', NULL, NULL, 'jpeg', 1481883242, 1),
(7, 1, '宝宝出生.jpeg', '/upload/image/20161216', '1481897520281.jpeg', NULL, NULL, 'jpeg', 1481897521, 1),
(8, 1, '宝宝出生.jpeg', '/upload/image/20161216', '1481897646257.jpeg', NULL, NULL, 'jpeg', 1481897646, 1),
(9, 1, '宝宝出生.jpeg', '/upload/image/20161216', '1481897703678.jpeg', NULL, NULL, 'jpeg', 1481897703, 1),
(10, 1, '宝宝出生.jpeg', '/upload/image/20161217', '1481949371323.jpeg', NULL, NULL, 'jpeg', 1481949372, 1),
(11, 1, '宝宝出生.jpeg', '/upload/image/20161217', '1481949711528.jpeg', NULL, NULL, 'jpeg', 1481949712, 1),
(12, 1, '税.jpeg', '/upload/image/20161217', '1481974085937.jpeg', NULL, NULL, 'jpeg', 1481974086, 1),
(13, 1, '税.jpeg', '/upload/image/201612', '1482248214402.jpeg', NULL, NULL, 'jpeg', 1482248214, 1);

-- --------------------------------------------------------

--
-- 表的结构 `attachment_rel`
--

CREATE TABLE IF NOT EXISTS `attachment_rel` (
  `res_id` int(11) DEFAULT NULL,
  `res_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attach_id` int(11) DEFAULT NULL,
  `use` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `attachment_rel`
--

INSERT INTO `attachment_rel` (`res_id`, `res_name`, `attach_id`, `use`) VALUES
(1, 'goods', 3, NULL),
(1, 'goods', 4, NULL),
(3, 'goods', 5, NULL),
(3, 'goods', 6, NULL),
(NULL, 'goods', 7, NULL),
(4, 'goods', 8, NULL),
(5, 'goods', 9, NULL),
(NULL, 'goods', 10, NULL),
(NULL, 'goods', 11, NULL),
(4, 'goods', 12, NULL),
(NULL, 'post20', 13, 'ue');

-- --------------------------------------------------------

--
-- 表的结构 `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('chaojiguanliyuan_585a784f9cd1a', '1', 1482324120);

-- --------------------------------------------------------

--
-- 表的结构 `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `real_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_menu` smallint(1) DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `real_title`, `is_menu`, `level`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('chaojiguanliyuan_585a784f9cd1a', 1, '', '超级管理员', 0, 8, NULL, NULL, 1482324047, 1482324047),
('chaojiguanlizu_585a7860759fd', 1, '', '超级管理组', 0, 7, NULL, NULL, 1482324064, 1482324064),
('cms', 2, '', NULL, 0, 1, NULL, NULL, 1481861847, 1481861847),
('cms/album', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('cms/album/create', 2, '添加图集', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/album/create-cate', 2, '添加图集分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/album/delete', 2, '删除图集', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/album/delete-cate', 2, '删除分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/album/drop', 2, '删除图集', NULL, 0, 3, NULL, NULL, 1482074567, 1482074567),
('cms/album/index', 2, '图集管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/album/move', 2, '修改图集分类', NULL, 0, 3, NULL, NULL, 1482074567, 1482074567),
('cms/album/update', 2, '修改图集', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/album/update-cate', 2, '修改图集分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/album/view', 2, '图集详细', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/contact', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('cms/contact/create', 2, '添加联系', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/contact/delete', 2, '删除联系', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/contact/index', 2, '联系管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/contact/update', 2, '修改联系', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/contact/view', 2, '联系详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/default', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('cms/default/index', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('cms/post-category', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('cms/post-category/create', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post-category/delete', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post-category/index', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post-category/update', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post-category/view', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post/create', 2, '添加文章', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post/create-cate', 2, '添加分类', NULL, 0, 3, NULL, NULL, 1482074567, 1482074567),
('cms/post/delete', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post/delete-cate', 2, '删除分类', NULL, 0, 3, NULL, NULL, 1482074567, 1482074567),
('cms/post/index', 2, '文章列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post/update', 2, '编辑文章', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('cms/post/update-cate', 2, '修改分类', NULL, 0, 3, NULL, NULL, 1482074567, 1482074567),
('cms/post/view', 2, '文章详细内容', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('mod', 2, '', NULL, 0, 1, NULL, NULL, 1481861847, 1481861847),
('mod/default', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('mod/default/create', 2, '添加模块', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('mod/default/create-field', 2, '添加字段', NULL, 0, 3, NULL, NULL, 1482324024, 1482324024),
('mod/default/delete', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('mod/default/delete-field', 2, '删除字段', NULL, 0, 3, NULL, NULL, 1482324024, 1482324024),
('mod/default/field', 2, '字段管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('mod/default/field-view', 2, '字段详情', NULL, 0, 3, NULL, NULL, 1482324024, 1482324024),
('mod/default/index', 2, '模块管理列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('mod/default/update', 2, '修改模块', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('mod/default/update-field', 2, '修改字段', NULL, 0, 3, NULL, NULL, 1482324024, 1482324024),
('mod/default/view', 2, '模块详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop', 2, '', NULL, 0, 1, NULL, NULL, 1481861847, 1481861847),
('shop/attr', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/attr-val', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/attr-val/create', 2, '添加属性值', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr-val/delete', 2, '删除属性值', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr-val/index', 2, '属性值管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr-val/update', 2, '修改属性值', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr-val/view', 2, '属性值详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr/create', 2, '添加属性', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr/create-val', 2, '添加属性值', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr/delete', 2, '删除属性', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr/delete-val', 2, '删除属性值', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr/index', 2, '属性管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr/update', 2, '修改属性', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr/update-val', 2, '修改属性值', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/attr/view', 2, '属性详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/av-rel', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/av-rel/create', 2, '添加', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/av-rel/delete', 2, '删除', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/av-rel/index', 2, '商品属性', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/av-rel/update', 2, '修改', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/av-rel/view', 2, '商品属性详细', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/cart', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/cart/create', 2, '添加', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/cart/delete', 2, '删除', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/cart/index', 2, '购物车', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/cart/update', 2, '修改', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/cart/view', 2, '购物车详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/category', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/category/create', 2, '添加分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/category/delete', 2, '删除分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/category/index', 2, '分类列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/category/update', 2, '修改分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/category/view', 2, '分类详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/default', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/default/index', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/goods', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/goods/create', 2, '添加商品', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/goods/delete', 2, '删除产品', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/goods/index', 2, '产品管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/goods/test', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/goods/update', 2, '修改产品详细', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/goods/view', 2, '产品详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/meal', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/meal/cover', 2, '上传图片', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/meal/create', 2, '添加菜品', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/meal/delete', 2, '删除菜品', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/meal/index', 2, '餐饮管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/meal/method', 2, '制作方法', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/meal/recommend', 2, '推荐菜品', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/meal/un-recommend', 2, '取消推荐', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/meal/update', 2, '修改', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/meal/view', 2, '详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/mix-cate', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/mix-cate/create', 2, '添加源材料分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix-cate/delete', 2, '删除源材料分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix-cate/index', 2, '原材料分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix-cate/update', 2, '修改源材料分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix-cate/view', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix-rel', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/mix-rel/create', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix-rel/delete', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix-rel/index', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix-rel/update', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix-rel/view', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix/add', 2, '添加原材料分类', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix/create', 2, '添加源材料', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix/del', 2, 'ajax方式删除', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix/delete', 2, '删除源材料', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix/edit', 2, '编辑', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix/index', 2, '源材料管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix/update', 2, '修改源材料', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/mix/view', 2, '源材料详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/order-rel', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/order-rel/create', 2, '添加订单明细', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order-rel/delete', 2, '删除订单明细', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order-rel/index', 2, '订单明细', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order-rel/update', 2, '修改订单明细', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order-rel/view', 2, '订单明细详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order/create', 2, '添加订单', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order/delete', 2, '删除订单', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order/index', 2, '订单列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order/update', 2, '修改订单', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/order/view', 2, '订单详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/refund', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/refund/create', 2, '添加', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/refund/delete', 2, '删除', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/refund/index', 2, '订单退款', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/refund/update', 2, '修改', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/refund/view', 2, '退款详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/spec', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/spec/create', 2, '添加规格', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/spec/create-val', 2, '添加规格值', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/spec/delete', 2, '删除', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/spec/delete-val', 2, '删除规格值', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/spec/index', 2, '规格管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/spec/update', 2, '修改规格', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/spec/update-val', 2, '修改规格值', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/spec/view', 2, '规格详细', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/test', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/test/create', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/test/index', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/test/pay', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/test/pay-create', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/type', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('shop/type/create', 2, '添加类型', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/type/delete', 2, '删除', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/type/index', 2, '类型列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/type/update', 2, '更新', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('shop/type/view', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys', 2, '', NULL, 0, 1, NULL, NULL, 1481861847, 1481861847),
('sys/auth-group', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('sys/auth-group/create', 2, '添加权限组', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-group/delete', 2, '删除权限组', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-group/index', 2, '权限组列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-group/permission', 2, '化分权限', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-group/toggle-permission', 2, '添加删除权限', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-group/update', 2, '编辑权限组', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-permission', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('sys/auth-permission/index', 2, '权限主页面', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-permission/sync', 2, '权限项入库', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-permission/title', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-role', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('sys/auth-role/create', 2, '创建角色', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-role/delete', 2, '删除角色', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-role/index', 2, '角色列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-role/permission', 2, '角色分配权限组', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-role/toggle-permission', 2, '添加删除权限', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-role/toggle-user', 2, '角色分配', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-role/update', 2, '修改角色', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/auth-role/user', 2, '角色用户分配列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/default', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('sys/default/index', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/info', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('sys/info/db', 2, '数据库信息', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/info/f', 2, '公共方法', NULL, 0, 3, NULL, NULL, 1482074567, 1482074567),
('sys/info/php', 2, 'PHP信息', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/menu', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('sys/menu/create', 2, '添加菜单', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/menu/delete', 2, '删除菜单', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/menu/index', 2, '菜单列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/menu/items', 2, '获取方法', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/menu/update', 2, '修改菜单', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/setting', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('sys/setting/create', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/setting/delete', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/setting/index', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/setting/update', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('sys/setting/view', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('test', 2, '', NULL, 0, 1, NULL, NULL, 1481861847, 1481861847),
('test/default', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('test/default/index', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('user', 2, '', NULL, 0, 1, NULL, NULL, 1481861847, 1481861847),
('user/default', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('user/default/create', 2, '添加新用户', NULL, 0, 3, NULL, NULL, 1482324024, 1482324024),
('user/default/delete', 2, '删除用户', NULL, 0, 3, NULL, NULL, 1482324024, 1482324024),
('user/default/index', 2, '用户管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('user/default/update', 2, '修改用户信息', NULL, 0, 3, NULL, NULL, 1482324024, 1482324024),
('user/default/view', 2, '用户详情', NULL, 0, 3, NULL, NULL, 1482324024, 1482324024),
('user/field', 2, '', NULL, 0, 2, NULL, NULL, 1482360324, 1482360324),
('user/field/create', 2, '添加字段', NULL, 0, 3, NULL, NULL, 1482360324, 1482360324),
('user/field/delete', 2, '删除字段', NULL, 0, 3, NULL, NULL, 1482360324, 1482360324),
('user/field/index', 2, '用户字段列表', NULL, 0, 3, NULL, NULL, 1482360324, 1482360324),
('user/field/update', 2, '修改字段信息', NULL, 0, 3, NULL, NULL, 1482360324, 1482360324),
('user/field/view', 2, '用户字段详情', NULL, 0, 3, NULL, NULL, 1482360324, 1482360324),
('wechat', 2, '', NULL, 0, 1, NULL, NULL, 1481861847, 1481861847),
('wechat/default', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('wechat/default/index', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/group', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('wechat/group/create', 2, '添加用户组', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/group/delete', 2, '删除用户组', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/group/index', 2, '用户组管理', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/group/update', 2, '修改用户组', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/group/view', 2, '', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/menu', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('wechat/menu/create', 2, '添加', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/menu/delete', 2, '删除菜单', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/menu/index', 2, '微信菜单', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/menu/sync', 2, '同步到微信服务', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/menu/update', 2, '修改', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/user', 2, '', NULL, 0, 2, NULL, NULL, 1481861847, 1481861847),
('wechat/user/create', 2, '添加', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/user/delete', 2, '删除', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/user/index', 2, '微信用户列表', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/user/update', 2, '修改', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847),
('wechat/user/view', 2, '微信用户详情', NULL, 0, 3, NULL, NULL, 1481861847, 1481861847);

-- --------------------------------------------------------

--
-- 表的结构 `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('chaojiguanliyuan_585a784f9cd1a', 'chaojiguanlizu_585a7860759fd'),
('chaojiguanlizu_585a7860759fd', 'cms/album/create'),
('chaojiguanlizu_585a7860759fd', 'cms/album/create-cate'),
('chaojiguanlizu_585a7860759fd', 'cms/album/delete'),
('chaojiguanlizu_585a7860759fd', 'cms/album/delete-cate'),
('chaojiguanlizu_585a7860759fd', 'cms/album/drop'),
('chaojiguanlizu_585a7860759fd', 'cms/album/index'),
('chaojiguanlizu_585a7860759fd', 'cms/album/move'),
('chaojiguanlizu_585a7860759fd', 'cms/album/update'),
('chaojiguanlizu_585a7860759fd', 'cms/album/update-cate'),
('chaojiguanlizu_585a7860759fd', 'cms/album/view'),
('chaojiguanlizu_585a7860759fd', 'cms/contact/create'),
('chaojiguanlizu_585a7860759fd', 'cms/contact/delete'),
('chaojiguanlizu_585a7860759fd', 'cms/contact/index'),
('chaojiguanlizu_585a7860759fd', 'cms/contact/update'),
('chaojiguanlizu_585a7860759fd', 'cms/contact/view'),
('chaojiguanlizu_585a7860759fd', 'cms/default/index'),
('chaojiguanlizu_585a7860759fd', 'cms/post-category/create'),
('chaojiguanlizu_585a7860759fd', 'cms/post-category/delete'),
('chaojiguanlizu_585a7860759fd', 'cms/post-category/index'),
('chaojiguanlizu_585a7860759fd', 'cms/post-category/update'),
('chaojiguanlizu_585a7860759fd', 'cms/post-category/view'),
('chaojiguanlizu_585a7860759fd', 'cms/post/create'),
('chaojiguanlizu_585a7860759fd', 'cms/post/create-cate'),
('chaojiguanlizu_585a7860759fd', 'cms/post/delete'),
('chaojiguanlizu_585a7860759fd', 'cms/post/delete-cate'),
('chaojiguanlizu_585a7860759fd', 'cms/post/index'),
('chaojiguanlizu_585a7860759fd', 'cms/post/update'),
('chaojiguanlizu_585a7860759fd', 'cms/post/update-cate'),
('chaojiguanlizu_585a7860759fd', 'cms/post/view'),
('chaojiguanlizu_585a7860759fd', 'mod/default/create'),
('chaojiguanlizu_585a7860759fd', 'mod/default/create-field'),
('chaojiguanlizu_585a7860759fd', 'mod/default/delete'),
('chaojiguanlizu_585a7860759fd', 'mod/default/delete-field'),
('chaojiguanlizu_585a7860759fd', 'mod/default/field'),
('chaojiguanlizu_585a7860759fd', 'mod/default/field-view'),
('chaojiguanlizu_585a7860759fd', 'mod/default/index'),
('chaojiguanlizu_585a7860759fd', 'mod/default/update'),
('chaojiguanlizu_585a7860759fd', 'mod/default/update-field'),
('chaojiguanlizu_585a7860759fd', 'mod/default/view'),
('chaojiguanlizu_585a7860759fd', 'shop/attr-val/create'),
('chaojiguanlizu_585a7860759fd', 'shop/attr-val/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/attr-val/index'),
('chaojiguanlizu_585a7860759fd', 'shop/attr-val/update'),
('chaojiguanlizu_585a7860759fd', 'shop/attr-val/view'),
('chaojiguanlizu_585a7860759fd', 'shop/attr/create'),
('chaojiguanlizu_585a7860759fd', 'shop/attr/create-val'),
('chaojiguanlizu_585a7860759fd', 'shop/attr/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/attr/delete-val'),
('chaojiguanlizu_585a7860759fd', 'shop/attr/index'),
('chaojiguanlizu_585a7860759fd', 'shop/attr/update'),
('chaojiguanlizu_585a7860759fd', 'shop/attr/update-val'),
('chaojiguanlizu_585a7860759fd', 'shop/attr/view'),
('chaojiguanlizu_585a7860759fd', 'shop/av-rel/create'),
('chaojiguanlizu_585a7860759fd', 'shop/av-rel/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/av-rel/index'),
('chaojiguanlizu_585a7860759fd', 'shop/av-rel/update'),
('chaojiguanlizu_585a7860759fd', 'shop/av-rel/view'),
('chaojiguanlizu_585a7860759fd', 'shop/cart/create'),
('chaojiguanlizu_585a7860759fd', 'shop/cart/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/cart/index'),
('chaojiguanlizu_585a7860759fd', 'shop/cart/update'),
('chaojiguanlizu_585a7860759fd', 'shop/cart/view'),
('chaojiguanlizu_585a7860759fd', 'shop/category/create'),
('chaojiguanlizu_585a7860759fd', 'shop/category/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/category/index'),
('chaojiguanlizu_585a7860759fd', 'shop/category/update'),
('chaojiguanlizu_585a7860759fd', 'shop/category/view'),
('chaojiguanlizu_585a7860759fd', 'shop/default/index'),
('chaojiguanlizu_585a7860759fd', 'shop/goods/create'),
('chaojiguanlizu_585a7860759fd', 'shop/goods/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/goods/index'),
('chaojiguanlizu_585a7860759fd', 'shop/goods/test'),
('chaojiguanlizu_585a7860759fd', 'shop/goods/update'),
('chaojiguanlizu_585a7860759fd', 'shop/goods/view'),
('chaojiguanlizu_585a7860759fd', 'shop/meal/cover'),
('chaojiguanlizu_585a7860759fd', 'shop/meal/create'),
('chaojiguanlizu_585a7860759fd', 'shop/meal/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/meal/index'),
('chaojiguanlizu_585a7860759fd', 'shop/meal/method'),
('chaojiguanlizu_585a7860759fd', 'shop/meal/recommend'),
('chaojiguanlizu_585a7860759fd', 'shop/meal/un-recommend'),
('chaojiguanlizu_585a7860759fd', 'shop/meal/update'),
('chaojiguanlizu_585a7860759fd', 'shop/meal/view'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-cate/create'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-cate/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-cate/index'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-cate/update'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-cate/view'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-rel/create'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-rel/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-rel/index'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-rel/update'),
('chaojiguanlizu_585a7860759fd', 'shop/mix-rel/view'),
('chaojiguanlizu_585a7860759fd', 'shop/mix/add'),
('chaojiguanlizu_585a7860759fd', 'shop/mix/create'),
('chaojiguanlizu_585a7860759fd', 'shop/mix/del'),
('chaojiguanlizu_585a7860759fd', 'shop/mix/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/mix/edit'),
('chaojiguanlizu_585a7860759fd', 'shop/mix/index'),
('chaojiguanlizu_585a7860759fd', 'shop/mix/update'),
('chaojiguanlizu_585a7860759fd', 'shop/mix/view'),
('chaojiguanlizu_585a7860759fd', 'shop/order-rel/create'),
('chaojiguanlizu_585a7860759fd', 'shop/order-rel/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/order-rel/index'),
('chaojiguanlizu_585a7860759fd', 'shop/order-rel/update'),
('chaojiguanlizu_585a7860759fd', 'shop/order-rel/view'),
('chaojiguanlizu_585a7860759fd', 'shop/order/create'),
('chaojiguanlizu_585a7860759fd', 'shop/order/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/order/index'),
('chaojiguanlizu_585a7860759fd', 'shop/order/update'),
('chaojiguanlizu_585a7860759fd', 'shop/order/view'),
('chaojiguanlizu_585a7860759fd', 'shop/refund/create'),
('chaojiguanlizu_585a7860759fd', 'shop/refund/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/refund/index'),
('chaojiguanlizu_585a7860759fd', 'shop/refund/update'),
('chaojiguanlizu_585a7860759fd', 'shop/refund/view'),
('chaojiguanlizu_585a7860759fd', 'shop/spec/create'),
('chaojiguanlizu_585a7860759fd', 'shop/spec/create-val'),
('chaojiguanlizu_585a7860759fd', 'shop/spec/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/spec/delete-val'),
('chaojiguanlizu_585a7860759fd', 'shop/spec/index'),
('chaojiguanlizu_585a7860759fd', 'shop/spec/update'),
('chaojiguanlizu_585a7860759fd', 'shop/spec/update-val'),
('chaojiguanlizu_585a7860759fd', 'shop/spec/view'),
('chaojiguanlizu_585a7860759fd', 'shop/type/create'),
('chaojiguanlizu_585a7860759fd', 'shop/type/delete'),
('chaojiguanlizu_585a7860759fd', 'shop/type/index'),
('chaojiguanlizu_585a7860759fd', 'shop/type/update'),
('chaojiguanlizu_585a7860759fd', 'shop/type/view'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-group/create'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-group/delete'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-group/index'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-group/permission'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-group/toggle-permission'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-group/update'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-permission/index'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-permission/sync'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-permission/title'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-role/create'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-role/delete'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-role/index'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-role/permission'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-role/toggle-permission'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-role/toggle-user'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-role/update'),
('chaojiguanlizu_585a7860759fd', 'sys/auth-role/user'),
('chaojiguanlizu_585a7860759fd', 'sys/default/index'),
('chaojiguanlizu_585a7860759fd', 'sys/info/db'),
('chaojiguanlizu_585a7860759fd', 'sys/info/f'),
('chaojiguanlizu_585a7860759fd', 'sys/info/php'),
('chaojiguanlizu_585a7860759fd', 'sys/menu/create'),
('chaojiguanlizu_585a7860759fd', 'sys/menu/delete'),
('chaojiguanlizu_585a7860759fd', 'sys/menu/index'),
('chaojiguanlizu_585a7860759fd', 'sys/menu/items'),
('chaojiguanlizu_585a7860759fd', 'sys/menu/update'),
('chaojiguanlizu_585a7860759fd', 'sys/setting/create'),
('chaojiguanlizu_585a7860759fd', 'sys/setting/delete'),
('chaojiguanlizu_585a7860759fd', 'sys/setting/index'),
('chaojiguanlizu_585a7860759fd', 'sys/setting/update'),
('chaojiguanlizu_585a7860759fd', 'sys/setting/view'),
('chaojiguanlizu_585a7860759fd', 'test/default/index'),
('chaojiguanlizu_585a7860759fd', 'user/default/create'),
('chaojiguanlizu_585a7860759fd', 'user/default/delete'),
('chaojiguanlizu_585a7860759fd', 'user/default/index'),
('chaojiguanlizu_585a7860759fd', 'user/default/update'),
('chaojiguanlizu_585a7860759fd', 'user/default/view'),
('chaojiguanlizu_585a7860759fd', 'wechat/default/index'),
('chaojiguanlizu_585a7860759fd', 'wechat/group/create'),
('chaojiguanlizu_585a7860759fd', 'wechat/group/delete'),
('chaojiguanlizu_585a7860759fd', 'wechat/group/index'),
('chaojiguanlizu_585a7860759fd', 'wechat/group/update'),
('chaojiguanlizu_585a7860759fd', 'wechat/group/view'),
('chaojiguanlizu_585a7860759fd', 'wechat/menu/create'),
('chaojiguanlizu_585a7860759fd', 'wechat/menu/delete'),
('chaojiguanlizu_585a7860759fd', 'wechat/menu/index'),
('chaojiguanlizu_585a7860759fd', 'wechat/menu/sync'),
('chaojiguanlizu_585a7860759fd', 'wechat/menu/update'),
('chaojiguanlizu_585a7860759fd', 'wechat/user/create'),
('chaojiguanlizu_585a7860759fd', 'wechat/user/delete'),
('chaojiguanlizu_585a7860759fd', 'wechat/user/index'),
('chaojiguanlizu_585a7860759fd', 'wechat/user/update'),
('chaojiguanlizu_585a7860759fd', 'wechat/user/view');

-- --------------------------------------------------------

--
-- 表的结构 `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `cms_category`
--

CREATE TABLE IF NOT EXISTS `cms_category` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `res_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(1) DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `cms_category`
--

INSERT INTO `cms_category` (`id`, `pid`, `res_name`, `level`, `code`, `name`, `cover`, `body`, `sort`, `is_leaf`, `seo_title`, `seo_keywords`, `seo_description`, `created_at`, `status`) VALUES
(1, 0, 'album2', 1, '1', '分类一', NULL, '', 0, 0, NULL, NULL, NULL, 1481976458, 1),
(2, 1, 'album2', 2, '1.2', '子分类', NULL, '', 0, 1, NULL, NULL, NULL, 1481976472, 1),
(3, 1, 'album2', 2, '1.3', '子分类二', NULL, '', 0, 1, NULL, NULL, NULL, 1481980101, 1),
(18, 0, 'post9', 1, '18', '分类一', NULL, '', 0, 0, NULL, NULL, NULL, 1482073669, 1),
(19, 18, 'post9', 2, '18.19', '分类二', NULL, '', 0, 1, NULL, NULL, NULL, 1482073677, 1),
(20, 0, 'post9', 1, '20', '分类三', NULL, '', 0, 1, NULL, NULL, NULL, 1482222971, 1),
(21, 0, 'post16', 1, '21', '顶一', NULL, '', 0, 1, NULL, NULL, NULL, 1482237058, 1),
(22, 0, 'post17', 1, '22', '分类一', NULL, '', 0, 1, NULL, NULL, NULL, 1482237131, 1),
(23, 0, 'post18', 1, '23', '新粉类', NULL, '', 0, 1, NULL, NULL, NULL, 1482239304, 1),
(24, 0, 'post19', 1, '24', '分类一', NULL, '', 0, 1, NULL, NULL, NULL, 1482241771, 1),
(25, 0, 'post20', 1, '25', '新分类', NULL, '', 0, 0, NULL, NULL, NULL, 1482245764, 1),
(26, 25, 'post20', 2, '25.26', '下一级的分类', NULL, '', 0, 1, NULL, NULL, NULL, 1482246381, 1);

-- --------------------------------------------------------

--
-- 表的结构 `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `grave`
--

CREATE TABLE IF NOT EXISTS `grave` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `area_totle` float DEFAULT NULL,
  `area_use` float DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `user_id` int(11) DEFAULT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(6) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `grave_tomb`
--

CREATE TABLE IF NOT EXISTS `grave_tomb` (
  `id` int(11) NOT NULL,
  `grave_id` int(11) DEFAULT NULL,
  `row` int(11) DEFAULT NULL,
  `col` int(11) DEFAULT NULL,
  `special` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tomb_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hole` smallint(6) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `area_total` float DEFAULT NULL,
  `area_use` float DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `guide_id` int(11) DEFAULT NULL,
  `sale_time` datetime DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `thumb` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1481861806),
('m130524_201442_init', 1481861809),
('m151114_073647_rbac', 1481861810),
('m151118_143810_sys_menu', 1481861811),
('m160104_045557_sys_settings', 1481861811),
('m160110_012843_post', 1481861812),
('m160116_042049_attachment', 1481861813),
('m160414_005721_wechat', 1481861814),
('m160513_044426_note', 1481861814),
('m161006_120844_shop_order', 1481861815),
('m161006_121900_shop', 1481861816),
('m161006_122017_shop_attr', 1481861817),
('m161006_125017_shop_foods', 1481861818),
('m161006_125024_tag', 1481861819),
('m161006_141200_module', 1481861819),
('m161129_121955_album', 1481861819),
('m161129_134658_cms_category', 1481861820),
('m161210_101717_contact', 1481861820),
('m161217_134034_grave', 1482334342),
('m161222_010844_user_addition', 1482368990);

-- --------------------------------------------------------

--
-- 表的结构 `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` smallint(4) DEFAULT NULL,
  `show` smallint(1) DEFAULT '1',
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `module_field`
--

CREATE TABLE IF NOT EXISTS `module_field` (
  `id` int(11) NOT NULL,
  `table` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pop_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `option` text COLLATE utf8_unicode_ci,
  `default` text COLLATE utf8_unicode_ci,
  `is_show` smallint(1) DEFAULT '1',
  `order` smallint(1) DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `module_field`
--

INSERT INTO `module_field` (`id`, `table`, `name`, `title`, `pop_note`, `html`, `option`, `default`, `is_show`, `order`, `created_at`) VALUES
(1, 'post_attach_10', 'author1', '作者一', '第二个作者', 'text', '', '', 1, NULL, 1482151891),
(2, 'post_attach_10', 'author1', '作者一', '第二个作者', 'text', '', '', 1, NULL, 1482151931),
(3, 'post_attach_10', 'abc', '测试', '测试一', 'text', '122', '', 1, NULL, 1482152255),
(4, 'post', 'author1', '附加作者', '附加的作者', 'input', '', '', 1, NULL, 1482154033),
(5, 'post', 'author1', '附加作者', '附加的作者', 'input', '', '', 1, NULL, 1482154142),
(7, 'post_9', 'addr', '地址', '详细地址', 'textarea', '', '', 1, NULL, 1482154831),
(8, 'post_9', 'intro1', '简介', '简介', 'fulltext', '', '', 1, NULL, 1482155551),
(9, 'post_9', 'au1', '作者一', '提示消息', 'input', '', '', 1, NULL, 1482221571),
(10, 'post_17', 'au1', '作者一', '作者一一一一', 'input', '', '', 1, NULL, 1482237184),
(11, 'post_18', 'new', '新字段', '新字段', 'input', '', '', 1, NULL, 1482239222),
(12, 'post_18', 'old', '老字段', '老字段提示', 'textarea', '', '', 1, NULL, 1482239292),
(13, 'post_19', 'ABC', 'abc', 'abce', 'input', '', '', 1, NULL, 1482245464),
(14, 'post_20', 'new', '新加的', '新新新', 'input', '', '', 1, NULL, 1482246257),
(15, 'album_21', 'new', '新字段', '新字段', 'input', '', '', 1, NULL, 1482285829),
(16, 'album_31', 'old', '老字段', '老字体', 'input', '', '', 1, NULL, 1482289608);

-- --------------------------------------------------------

--
-- 表的结构 `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(11) NOT NULL,
  `res_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `thumb` int(11) DEFAULT NULL,
  `ip` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `view_all` int(11) DEFAULT '0',
  `com_all` int(11) DEFAULT '0',
  `recommend` smallint(6) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `post_attach`
--

CREATE TABLE IF NOT EXISTS `post_attach` (
  `id` int(11) NOT NULL,
  `res_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `ext` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `post_category`
--

CREATE TABLE IF NOT EXISTS `post_category` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(1) DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `post_data`
--

CREATE TABLE IF NOT EXISTS `post_data` (
  `post_id` int(11) NOT NULL DEFAULT '0',
  `body` text COLLATE utf8_unicode_ci,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `post_data`
--

INSERT INTO `post_data` (`post_id`, `body`, `status`) VALUES
(6, '1111', 1),
(7, '<p>5</p>', 1),
(8, '<p>e</p>', 1),
(9, '<p>e</p>', 1);

-- --------------------------------------------------------

--
-- 表的结构 `shop_attach`
--

CREATE TABLE IF NOT EXISTS `shop_attach` (
  `id` int(11) NOT NULL,
  `res_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `ext` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_attr`
--

CREATE TABLE IF NOT EXISTS `shop_attr` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_multi` smallint(6) DEFAULT '0',
  `is_spec` smallint(6) DEFAULT '0',
  `body` text COLLATE utf8_unicode_ci,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `shop_attr`
--

INSERT INTO `shop_attr` (`id`, `type_id`, `name`, `is_multi`, `is_spec`, `body`, `status`) VALUES
(1, 1, '颜色', 0, 0, '', 1),
(2, 1, '尺码', 0, 0, '', 1),
(3, 2, '颜色', 0, 0, '', 1),
(4, 2, '内存', 0, 1, '', 1),
(5, 2, 'cpu', 0, 1, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `shop_av`
--

CREATE TABLE IF NOT EXISTS `shop_av` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `attr_id` int(11) DEFAULT NULL,
  `val` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `shop_av`
--

INSERT INTO `shop_av` (`id`, `type_id`, `attr_id`, `val`, `thumb`, `status`) VALUES
(1, 2, 4, '8G', '', 1),
(2, 2, 4, '16G', '', 1),
(3, 1, 1, '红色', '', 1),
(4, 1, 1, '绿色', '', 1),
(5, 1, 1, '黄色', '', 1),
(6, 2, 5, 'i3', '', 1),
(7, 2, 5, 'i5', '', 1),
(8, 2, 5, 'i7', '', 1),
(9, 2, 3, '黑色', '', 1),
(10, 2, 3, '白色', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `shop_av_rel`
--

CREATE TABLE IF NOT EXISTS `shop_av_rel` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `attr_id` int(11) DEFAULT NULL,
  `av_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `shop_av_rel`
--

INSERT INTO `shop_av_rel` (`id`, `type_id`, `category_id`, `goods_id`, `attr_id`, `av_id`, `num`, `price`, `status`) VALUES
(1, NULL, 2, 3, 4, 1, NULL, NULL, 1),
(2, NULL, 2, 3, 4, 2, NULL, NULL, 1),
(3, NULL, 2, 4, 4, 1, NULL, NULL, 1),
(4, NULL, 2, 4, 4, 2, NULL, NULL, 1),
(5, NULL, 2, 4, 5, 6, NULL, NULL, 1),
(6, NULL, 2, 5, 4, 1, NULL, NULL, 1),
(7, NULL, 2, 5, 4, 2, NULL, NULL, 1),
(8, NULL, 2, 5, 5, 6, NULL, NULL, 1),
(9, NULL, 2, 1, 4, 1, NULL, NULL, 1),
(10, NULL, 2, 1, 5, 6, NULL, NULL, 1),
(11, NULL, 2, 1, 5, 7, NULL, NULL, 1),
(12, NULL, 2, 1, 3, 9, NULL, NULL, 1),
(13, NULL, 2, 1, 4, 1, NULL, NULL, 1),
(14, NULL, 2, 1, 5, 6, NULL, NULL, 1),
(15, NULL, 2, 1, 5, 7, NULL, NULL, 1),
(16, NULL, 2, 3, 4, 1, NULL, NULL, 1),
(17, NULL, 2, 3, 4, 2, NULL, NULL, 1),
(18, NULL, 2, 3, 5, 6, NULL, NULL, 1),
(19, NULL, 2, 4, 3, 9, NULL, NULL, 1),
(20, NULL, 2, 4, 4, 1, NULL, NULL, 1),
(21, NULL, 2, 4, 4, 2, NULL, NULL, 1),
(22, NULL, 2, 4, 5, 6, NULL, NULL, 1),
(23, NULL, 2, 4, 3, 9, NULL, NULL, 1),
(24, NULL, 2, 4, 4, 1, NULL, NULL, 1),
(25, NULL, 2, 4, 4, 2, NULL, NULL, 1),
(26, NULL, 2, 4, 5, 6, NULL, NULL, 1),
(27, NULL, 2, 4, 3, 9, NULL, NULL, 1),
(28, NULL, 2, 4, 4, 1, NULL, NULL, 1),
(29, NULL, 2, 4, 4, 2, NULL, NULL, 1),
(30, NULL, 2, 4, 5, 6, NULL, NULL, 1),
(31, NULL, 2, 1, 3, 9, NULL, NULL, 1),
(32, NULL, 2, 1, 4, 1, NULL, NULL, 1),
(33, NULL, 2, 1, 5, 6, NULL, NULL, 1),
(34, NULL, 2, 1, 5, 7, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `shop_cart`
--

CREATE TABLE IF NOT EXISTS `shop_cart` (
  `id` int(11) NOT NULL,
  `wechat_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) DEFAULT '1',
  `goods_id` int(11) DEFAULT NULL,
  `sku_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_category`
--

CREATE TABLE IF NOT EXISTS `shop_category` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(6) NOT NULL DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `shop_category`
--

INSERT INTO `shop_category` (`id`, `pid`, `type_id`, `level`, `code`, `name`, `thumb`, `body`, `sort`, `is_leaf`, `seo_title`, `seo_keywords`, `seo_description`, `created_at`, `status`) VALUES
(1, 0, 1, 1, '1', '大衣', NULL, NULL, 0, 1, NULL, NULL, NULL, 1481862497, 1),
(2, 0, 2, 1, '2', '手机', NULL, NULL, 0, 1, NULL, NULL, NULL, 1481862528, 1),
(3, 0, 3, 1, '3', '整理箱', NULL, NULL, 0, 0, NULL, NULL, NULL, 1481862548, 1),
(4, 3, 3, 2, '3.4', '衣服整理箱', NULL, NULL, 0, 1, NULL, NULL, NULL, 1481864536, 1),
(5, 3, 3, 2, '3.5', '电子产品整理箱', NULL, NULL, 0, 1, NULL, NULL, NULL, 1481864560, 1);

-- --------------------------------------------------------

--
-- 表的结构 `shop_goods`
--

CREATE TABLE IF NOT EXISTS `shop_goods` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `skill` text COLLATE utf8_unicode_ci,
  `unit` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `is_recommend` smallint(6) DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `shop_goods`
--

INSERT INTO `shop_goods` (`id`, `category_id`, `name`, `thumb`, `intro`, `skill`, `unit`, `price`, `num`, `is_recommend`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'iphone 6s', 3, '<p><span style="color: rgb(51, 51, 51); font-family: &#39;Helvetica Neue&#39;, Helvetica, &#39;Microsoft Yahei&#39;, &#39;Hiragino Sans GB&#39;, &#39;WenQuanYi Micro Hei&#39;, sans-serif; line-height: 28px; background-color: rgb(255, 255, 255);">在模态框中嵌入 YouTube 视频需要增加一些额外的 JavaScript 代码1</span></p>', NULL, '台', '5280.00', NULL, 0, 1, 1481882313, 1482156792),
(2, 2, '手机产品', NULL, '<p>category</p>', NULL, '台', '5380.00', NULL, 0, 1, 1481883253, 1481883253),
(3, 2, '手机产品', 6, '<p>category</p>', NULL, '台', '5380.00', NULL, 0, 1, 1481883282, 1481900239),
(4, 2, '图书文件', 12, '<p>12221</p>', NULL, '份', '12.00', NULL, 0, 1, 1481897657, 1481974091),
(5, 2, '酸菜', 9, '<p>12</p>', NULL, '件', '122.00', NULL, 0, 1, 1481897859, 1481897860);

-- --------------------------------------------------------

--
-- 表的结构 `shop_history`
--

CREATE TABLE IF NOT EXISTS `shop_history` (
  `id` int(11) NOT NULL,
  `wechat_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `sku_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_mix`
--

CREATE TABLE IF NOT EXISTS `shop_mix` (
  `id` int(11) NOT NULL,
  `mix_cate` int(11) DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_mix_cate`
--

CREATE TABLE IF NOT EXISTS `shop_mix_cate` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb` int(11) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `is_leaf` smallint(6) NOT NULL DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_mix_rel`
--

CREATE TABLE IF NOT EXISTS `shop_mix_rel` (
  `category_id` int(11) DEFAULT NULL,
  `mix_cate` int(11) DEFAULT '0',
  `goods_id` int(11) DEFAULT NULL,
  `mix_id` int(11) DEFAULT NULL,
  `measure` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(1) DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_order`
--

CREATE TABLE IF NOT EXISTS `shop_order` (
  `id` int(11) NOT NULL,
  `wechat_uid` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `origin_price` decimal(10,2) DEFAULT NULL,
  `type` smallint(6) DEFAULT '1',
  `progress` smallint(6) DEFAULT '1',
  `note` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_order_pay`
--

CREATE TABLE IF NOT EXISTS `shop_order_pay` (
  `id` int(11) NOT NULL,
  `wechat_uid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trade_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_fee` decimal(10,2) DEFAULT NULL,
  `total_pay` decimal(10,2) DEFAULT NULL,
  `pay_method` smallint(6) DEFAULT NULL,
  `pay_result` smallint(6) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `checkout_at` datetime DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `status` smallint(6) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_order_refund`
--

CREATE TABLE IF NOT EXISTS `shop_order_refund` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `wechat_uid` int(11) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `progress` smallint(6) DEFAULT '1',
  `intro` text COLLATE utf8_unicode_ci,
  `note` text COLLATE utf8_unicode_ci,
  `checkout_at` datetime DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_order_rel`
--

CREATE TABLE IF NOT EXISTS `shop_order_rel` (
  `id` int(11) NOT NULL,
  `wechat_uid` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) DEFAULT '1',
  `category_id` smallint(6) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `sku_id` int(11) DEFAULT NULL,
  `sku_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_unit` decimal(10,2) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `use_time` datetime DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` smallint(6) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_process`
--

CREATE TABLE IF NOT EXISTS `shop_process` (
  `id` int(11) NOT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `step` smallint(6) DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) DEFAULT '1',
  `sort` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `shop_sku`
--

CREATE TABLE IF NOT EXISTS `shop_sku` (
  `id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `num` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `av` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `shop_sku`
--

INSERT INTO `shop_sku` (`id`, `goods_id`, `num`, `price`, `name`, `av`, `created_at`) VALUES
(1, 3, NULL, '5280.00', '8G', '4:1', 1481883284),
(2, 3, NULL, '6280.00', '16G', '4:2', 1481883284),
(3, 4, NULL, '12.00', '图书文件', '0:0', 1481897659),
(4, 5, 4, '122.00', '8Gi3', '4:1;5:6', 1481897861),
(5, 5, 5, '211.00', '16Gi3', '4:2;5:6', 1481897861),
(6, 1, 3, '1.00', '8Gi3', '4:1;5:6', 1481898506),
(7, 1, 4, '2.00', '8Gi5', '4:1;5:7', 1481898506),
(8, 1, 3, '1.00', '8Gi3', '4:1;5:6', 1481899815),
(9, 1, 4, '2.00', '8Gi5', '4:1;5:7', 1481899815),
(10, 3, 1012, '21.00', '8Gi3', '4:1;5:6', 1481900240),
(11, 3, 12, '22.00', '16Gi3', '4:2;5:6', 1481900240),
(12, 4, NULL, '12.00', '图书文件', '0:0', 1481973523),
(13, 4, 130, '110.00', '8Gi3', '4:1;5:6', 1481973559),
(14, 4, 140, '120.00', '16Gi3', '4:2;5:6', 1481973559),
(15, 4, 130, '110.00', '8Gi3', '4:1;5:6', 1481974091),
(16, 4, 140, '120.00', '16Gi3', '4:2;5:6', 1481974091),
(17, 1, 3, '1.00', '8Gi3', '4:1;5:6', 1482156792),
(18, 1, 4, '2.00', '8Gi5', '4:1;5:7', 1482156792);

-- --------------------------------------------------------

--
-- 表的结构 `shop_type`
--

CREATE TABLE IF NOT EXISTS `shop_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `shop_type`
--

INSERT INTO `shop_type` (`id`, `title`, `created_at`) VALUES
(1, '衣服', 1481862260),
(2, '小电器', 1481862268),
(3, '整理箱', 1481862291);

-- --------------------------------------------------------

--
-- 表的结构 `sys_menu`
--

CREATE TABLE IF NOT EXISTS `sys_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `icon` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '1',
  `status` smallint(6) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_unicode_ci,
  `panel` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `sys_menu`
--

INSERT INTO `sys_menu` (`id`, `name`, `auth_name`, `pid`, `icon`, `sort`, `status`, `description`, `panel`, `created_at`, `updated_at`) VALUES
(1, '商品管理', NULL, 0, '', 1, 1, NULL, NULL, 1481861899, 1481861899),
(2, '商品列表', 'shop/goods/index', 1, '', 1, 1, NULL, NULL, 1481861927, 1481861927),
(3, '分类管理', 'shop/category/index', 1, '', 1, 1, NULL, NULL, 1481861961, 1481862000),
(4, '类型管理', 'shop/type/index', 1, '', 1, 1, NULL, NULL, 1481861990, 1481861990),
(5, '系统管理', '', 0, '', 1, 1, NULL, NULL, 1481862011, 1481862011),
(6, '菜单管理', 'sys/menu/index', 5, '', 1, 1, NULL, NULL, 1481862041, 1481862041),
(7, '数据信息', 'sys/info/db', 5, '', 1, 1, NULL, NULL, 1481862067, 1481862067),
(8, '权限', 'sys/auth-permission/index', 5, '', 1, 1, NULL, NULL, 1481862110, 1481862135),
(9, '权限项管理', 'sys/auth-permission/index', 8, '', 1, 1, NULL, NULL, 1481862166, 1481862166),
(10, '角色管理', 'sys/auth-role/index', 8, '', 1, 1, NULL, NULL, 1481862205, 1481862205),
(11, '权限组', 'sys/auth-group/index', 8, '', 1, 1, NULL, NULL, 1481862232, 1481862232),
(12, '属性管理', 'shop/attr/index', 1, '', 1, 1, NULL, NULL, 1481862615, 1481862629),
(13, '规格管理', 'shop/spec/index', 1, '', 1, 1, NULL, NULL, 1481862715, 1481862715),
(14, '模块管理', 'mod/default/index', 5, '', 1, 1, NULL, NULL, 1481974703, 1481974703),
(15, '公共方法', 'sys/info/f', 5, '', 1, 1, NULL, NULL, 1482074618, 1482074618),
(16, '用户字段管理', 'user/field/index', 17, '', 1, 1, NULL, NULL, 1482360360, 1482360419),
(17, '用户管理', '', 0, '', 1, 1, NULL, NULL, 1482360381, 1482360381),
(18, '用户列表', 'user/default/index', 17, '', 1, 1, NULL, NULL, 1482360404, 1482360404),
(19, 'CMS管理', '', 0, '', 1, 1, NULL, NULL, 1482367756, 1482367756);

-- --------------------------------------------------------

--
-- 表的结构 `sys_settings`
--

CREATE TABLE IF NOT EXISTS `sys_settings` (
  `sname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `svalue` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `svalues` text COLLATE utf8_unicode_ci,
  `sintro` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stype` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `smodule` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `tag`
--

INSERT INTO `tag` (`id`, `tag_name`, `num`, `created_at`, `status`) VALUES
(1, '手机', '0', 1481882313, 1),
(3, 'phone', '1', 1481883282, 1),
(4, '1', '1', 1481897658, 1),
(5, '12', '1', 1481897859, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tag_rel`
--

CREATE TABLE IF NOT EXISTS `tag_rel` (
  `tag_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `res_id` int(11) DEFAULT NULL,
  `res_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `tag_rel`
--

INSERT INTO `tag_rel` (`tag_id`, `res_id`, `res_name`, `created_at`) VALUES
('3', 3, 'goods', 1481883283),
('4', 4, 'goods', 1481897658),
('5', 5, 'goods', 1481897860);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mid` int(11) DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `new_user` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `mobile`, `mid`, `status`, `created_at`, `updated_at`, `new_user`) VALUES
(1, 'admin', 'boqjqJ1rd4Flns2WzThxsd6uoiLUTQzw', '$2y$13$rn7SjO.2bXVv6YuDtmH8f../LoonFjbG.C2IKXW/hgwB/tr2sX3nC', NULL, 'cboy868@163.com', NULL, 11, 10, 1462504424, 1482358790, NULL),
(2, '测试', 'Y6Fkig67E_zBKpMnO3nHy36Kklocf9AJ', '$2y$13$cI2fAGgqO5D4U6kaRvo8C.BYqR7vDElBMnLm0t0aJaI.AQXaLuAfa', NULL, 'cboy@163.com', NULL, 0, -1, 1482302983, 1482370505, NULL),
(3, 'cboy', 'TvHG4kVKH1PJnCPLW9fbPK2xRAUF7Iae', '$2y$13$OIIuNW284r1DJJlvq7ZPUuTupa6kiPN2ZeYKUI94liMTwTNT6TIt.', NULL, 'c@163.com', NULL, 0, 10, 1482303185, 1482303185, NULL),
(4, '带addition', 'usUZXCSYMJI34M5iBnQn2-mEHFgORJTK', '$2y$13$uslETDI414qPBybhLzwiTe84m3v3Px5GAxCS3k/RA8JoUtHOj3Tt.', NULL, 'c@qq.com', NULL, 0, -1, 1482370283, 1482370430, NULL),
(5, '带addition1', '6_VOgPOyVA3oi8Lzo3q3NOZDUoQuT7hQ', '$2y$13$Dhk.0Gl5cIqqAfq9pXXjUOWQzcLomdhYActPDQjjglAcege52RRb6', NULL, 'e@qq.com', NULL, 0, -1, 1482370309, 1482370433, NULL),
(6, 'NEW', '4lITm31OY4lFn2ReOwLvHAVPGbvCGfRh', '$2y$13$nM..uRxbNHHZxZly472lzudtU/TUCseXZXGBQ3lhLqX0YX18j6l7S', NULL, 'new@qq.com', NULL, 0, 10, 1482370524, 1482370524, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user_addition`
--

CREATE TABLE IF NOT EXISTS `user_addition` (
  `user_id` int(11) NOT NULL,
  `real_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` smallint(1) DEFAULT '1',
  `birth` date DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `qq` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `hobby` text COLLATE utf8_unicode_ci,
  `native_place` text COLLATE utf8_unicode_ci,
  `intro` text COLLATE utf8_unicode_ci,
  `test` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `user_addition`
--

INSERT INTO `user_addition` (`user_id`, `real_name`, `gender`, `birth`, `height`, `weight`, `qq`, `address`, `hobby`, `native_place`, `intro`, `test`) VALUES
(1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '1', 1, '2016-01-01', 2, 3, '467891', '5', '6', '7', '8', '9');

-- --------------------------------------------------------

--
-- 表的结构 `user_field`
--

CREATE TABLE IF NOT EXISTS `user_field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pop_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `option` text COLLATE utf8_unicode_ci,
  `default` text COLLATE utf8_unicode_ci,
  `is_show` smallint(1) DEFAULT '1',
  `order` smallint(1) DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `user_field`
--

INSERT INTO `user_field` (`id`, `name`, `title`, `pop_note`, `html`, `option`, `default`, `is_show`, `order`, `created_at`) VALUES
(5, 'test', 'test', 'test', 'input', NULL, NULL, 1, NULL, 1482373170);

-- --------------------------------------------------------

--
-- 表的结构 `wechat_group`
--

CREATE TABLE IF NOT EXISTS `wechat_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `wechat_menu`
--

CREATE TABLE IF NOT EXISTS `wechat_menu` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT '1',
  `key` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `wechat_token`
--

CREATE TABLE IF NOT EXISTS `wechat_token` (
  `wechat_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expire_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `wechat_user`
--

CREATE TABLE IF NOT EXISTS `wechat_user` (
  `id` int(11) NOT NULL,
  `gid` int(11) DEFAULT NULL,
  `openid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` smallint(6) DEFAULT NULL,
  `language` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `headimgurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subscribe` smallint(6) DEFAULT NULL,
  `subscribe_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `realname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `addr` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attachment_rel`
--
ALTER TABLE `attachment_rel`
  ADD KEY `attach_id` (`attach_id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `cms_category`
--
ALTER TABLE `cms_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grave`
--
ALTER TABLE `grave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grave_tomb`
--
ALTER TABLE `grave_tomb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_field`
--
ALTER TABLE `module_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_attach`
--
ALTER TABLE `post_attach`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_data`
--
ALTER TABLE `post_data`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_id_2` (`post_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `post_id_3` (`post_id`),
  ADD KEY `post_id_4` (`post_id`),
  ADD KEY `post_id_5` (`post_id`);

--
-- Indexes for table `shop_attach`
--
ALTER TABLE `shop_attach`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_attr`
--
ALTER TABLE `shop_attr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_av`
--
ALTER TABLE `shop_av`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_av_rel`
--
ALTER TABLE `shop_av_rel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_cart`
--
ALTER TABLE `shop_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_category`
--
ALTER TABLE `shop_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_goods`
--
ALTER TABLE `shop_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_history`
--
ALTER TABLE `shop_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_mix`
--
ALTER TABLE `shop_mix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_mix_cate`
--
ALTER TABLE `shop_mix_cate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_order`
--
ALTER TABLE `shop_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_order_pay`
--
ALTER TABLE `shop_order_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_order_refund`
--
ALTER TABLE `shop_order_refund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_order_rel`
--
ALTER TABLE `shop_order_rel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_process`
--
ALTER TABLE `shop_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_sku`
--
ALTER TABLE `shop_sku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_type`
--
ALTER TABLE `shop_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_menu`
--
ALTER TABLE `sys_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_settings`
--
ALTER TABLE `sys_settings`
  ADD PRIMARY KEY (`sname`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `user_addition`
--
ALTER TABLE `user_addition`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_field`
--
ALTER TABLE `user_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wechat_group`
--
ALTER TABLE `wechat_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wechat_menu`
--
ALTER TABLE `wechat_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wechat_user`
--
ALTER TABLE `wechat_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `cms_category`
--
ALTER TABLE `cms_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grave`
--
ALTER TABLE `grave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grave_tomb`
--
ALTER TABLE `grave_tomb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `module_field`
--
ALTER TABLE `module_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `post_attach`
--
ALTER TABLE `post_attach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `post_category`
--
ALTER TABLE `post_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_attach`
--
ALTER TABLE `shop_attach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_attr`
--
ALTER TABLE `shop_attr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `shop_av`
--
ALTER TABLE `shop_av`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `shop_av_rel`
--
ALTER TABLE `shop_av_rel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `shop_cart`
--
ALTER TABLE `shop_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_category`
--
ALTER TABLE `shop_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `shop_goods`
--
ALTER TABLE `shop_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `shop_history`
--
ALTER TABLE `shop_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_mix`
--
ALTER TABLE `shop_mix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_mix_cate`
--
ALTER TABLE `shop_mix_cate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_order`
--
ALTER TABLE `shop_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_order_pay`
--
ALTER TABLE `shop_order_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_order_refund`
--
ALTER TABLE `shop_order_refund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_order_rel`
--
ALTER TABLE `shop_order_rel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_process`
--
ALTER TABLE `shop_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shop_sku`
--
ALTER TABLE `shop_sku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `shop_type`
--
ALTER TABLE `shop_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sys_menu`
--
ALTER TABLE `sys_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_field`
--
ALTER TABLE `user_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `wechat_group`
--
ALTER TABLE `wechat_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wechat_menu`
--
ALTER TABLE `wechat_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wechat_user`
--
ALTER TABLE `wechat_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 限制导出的表
--

--
-- 限制表 `attachment_rel`
--
ALTER TABLE `attachment_rel`
  ADD CONSTRAINT `attachment_rel_ibfk_1` FOREIGN KEY (`attach_id`) REFERENCES `attachment` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
