/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : laravel-blog

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-01-02 14:54:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for baidu_posted_urls
-- ----------------------------
DROP TABLE IF EXISTS `baidu_posted_urls`;
CREATE TABLE `baidu_posted_urls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `baidu_posted_urls_url_unique` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of baidu_posted_urls
-- ----------------------------

-- ----------------------------
-- Table structure for blog_admins
-- ----------------------------
DROP TABLE IF EXISTS `blog_admins`;
CREATE TABLE `blog_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_super` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `deleted_at` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_admins
-- ----------------------------
INSERT INTO `blog_admins` VALUES ('1', 'admin', 'test@test.com', '$2y$10$UHcxev3BA4oBt4NW9JAgHefEmXJIycHW5S7xA2bSvXBm5alF2Ateq', '', '0', 'Yau8iU90H8s9TyAxYpNVFG3IT7up7CMTz8A7YdaBrcOR1Z1xJJJ43OB8CINv', '1553745930', '1576200168', null);

-- ----------------------------
-- Table structure for blog_articles
-- ----------------------------
DROP TABLE IF EXISTS `blog_articles`;
CREATE TABLE `blog_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'title',
  `keywords` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'keywords',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'description',
  `markdown` longtext COLLATE utf8_unicode_ci COMMENT 'markdown content',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT 'author id',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT 'category id',
  `comment_count` int(11) NOT NULL DEFAULT '0' COMMENT 'comment count',
  `read_count` int(11) NOT NULL DEFAULT '0' COMMENT 'read count',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'status: 1-public;0-private',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT 'sort',
  `is_top` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'sticky to top',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_articles_slug_unique` (`slug`),
  KEY `blog_articles_title_index` (`title`),
  KEY `blog_articles_cate_id_index` (`cate_id`),
  KEY `blog_articles_user_id_index` (`user_id`),
  KEY `blog_articles_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_articles
-- ----------------------------
INSERT INTO `blog_articles` VALUES ('1', 'blog', '基于Laravel支持markdown的博客VienBlog', 'blog,laravel', '基于Laravel支持markdown的博客VienBlog', '界面简洁、适配pc和mobile、有良好的视觉体验\r\n    支持markdown、并且可以拖拽或者粘贴上传图片、分屏实时预览\r\n    SEO友好：支持自定义文章slug、支持meta title、description、keywords\r\n    自定义导航、自定义sidebar、随时去掉不需要的模块\r\n    支持标签、分类、置顶、分享、友链等博客基本属性\r\n    支持AdSense\r\n    支持百度自动提交链接和手动提交链接', '1', '5', '0', '3', '1', '0', '1', '1577070679', '1576200343', null);
INSERT INTO `blog_articles` VALUES ('2', 'jiqi', '机器学习', '机器,C#', '机器学习', '界面简洁、适配pc和mobile、有良好的视觉体验\r\n    支持markdown、并且可以拖拽或者粘贴上传图片、分屏实时预览\r\n    SEO友好：支持自定义文章slug、支持meta title、description、keywords\r\n    自定义导航、自定义sidebar、随时去掉不需要的模块\r\n    支持标签、分类、置顶、分享、友链等博客基本属性\r\n    支持AdSense\r\n    支持百度自动提交链接和手动提交链接', '1', '4', '0', '1', '1', '0', '0', '1576408291', '1576201798', null);
INSERT INTO `blog_articles` VALUES ('8', '29', '22', '22', '22', '22', '1', '1', '0', '1', '1', '0', '0', '1576463965', '1576415116', '1576463965');

-- ----------------------------
-- Table structure for blog_article_tags
-- ----------------------------
DROP TABLE IF EXISTS `blog_article_tags`;
CREATE TABLE `blog_article_tags` (
  `article_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  `deleted_at` int(10) unsigned DEFAULT NULL,
  KEY `blog_article_tags_article_id_index` (`article_id`),
  KEY `blog_article_tags_tag_id_index` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_article_tags
-- ----------------------------
INSERT INTO `blog_article_tags` VALUES ('1', '1', null);
INSERT INTO `blog_article_tags` VALUES ('1', '2', null);
INSERT INTO `blog_article_tags` VALUES ('1', '3', null);
INSERT INTO `blog_article_tags` VALUES ('1', '4', null);
INSERT INTO `blog_article_tags` VALUES ('1', '5', null);
INSERT INTO `blog_article_tags` VALUES ('1', '6', null);
INSERT INTO `blog_article_tags` VALUES ('2', '7', null);
INSERT INTO `blog_article_tags` VALUES ('2', '8', null);
INSERT INTO `blog_article_tags` VALUES ('3', '9', null);
INSERT INTO `blog_article_tags` VALUES ('4', '9', null);
INSERT INTO `blog_article_tags` VALUES ('5', '9', null);
INSERT INTO `blog_article_tags` VALUES ('6', '9', null);
INSERT INTO `blog_article_tags` VALUES ('7', '9', null);
INSERT INTO `blog_article_tags` VALUES ('8', '9', null);

-- ----------------------------
-- Table structure for blog_categories
-- ----------------------------
DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE `blog_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'tag name',
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_cate_name_unique` (`cate_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_categories
-- ----------------------------
INSERT INTO `blog_categories` VALUES ('1', '建站教程', null);
INSERT INTO `blog_categories` VALUES ('2', '科学上网', null);
INSERT INTO `blog_categories` VALUES ('3', '网站导航', null);
INSERT INTO `blog_categories` VALUES ('4', '机器学习', null);
INSERT INTO `blog_categories` VALUES ('5', 'Laravel教程', null);
INSERT INTO `blog_categories` VALUES ('6', 'Python教程', null);
INSERT INTO `blog_categories` VALUES ('7', 'Git教程', null);
INSERT INTO `blog_categories` VALUES ('8', 'Docker教程', null);

-- ----------------------------
-- Table structure for blog_tags
-- ----------------------------
DROP TABLE IF EXISTS `blog_tags`;
CREATE TABLE `blog_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'tag name',
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_tags_tag_name_unique` (`tag_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_tags
-- ----------------------------
INSERT INTO `blog_tags` VALUES ('1', 'Laravel', null);
INSERT INTO `blog_tags` VALUES ('2', 'Markdown', null);
INSERT INTO `blog_tags` VALUES ('3', 'VienBlog', null);
INSERT INTO `blog_tags` VALUES ('4', 'Blog', null);
INSERT INTO `blog_tags` VALUES ('5', '开源', null);
INSERT INTO `blog_tags` VALUES ('6', '博客', null);
INSERT INTO `blog_tags` VALUES ('7', '机器', null);
INSERT INTO `blog_tags` VALUES ('8', 'C#', null);
INSERT INTO `blog_tags` VALUES ('9', '22', null);

-- ----------------------------
-- Table structure for blog_users
-- ----------------------------
DROP TABLE IF EXISTS `blog_users`;
CREATE TABLE `blog_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email_verified_at` int(10) unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `deleted_at` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_users
-- ----------------------------
INSERT INTO `blog_users` VALUES ('1', 'blogtest', '123@qq.com', '$2y$10$MdbjBf8JAbTM6vVjFdvk5.yWs3EB22mpEDtdM3nltSbIdwlHgKmFu', '', null, 'sc0r9ERVkKer51Gwv8C1dXcqYni3YsMmVNK1pIRcb5uYCaKniSLMYVeLupys', '1576200024', '1576200024', null);

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'content',
  `uuid` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'title',
  `keywords` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'keywords',
  `markdown` longtext COLLATE utf8_unicode_ci COMMENT 'markdown content',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT 'author id',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT 'category id',
  `comment_count` int(11) NOT NULL DEFAULT '0' COMMENT 'comment count',
  `read_count` int(11) NOT NULL DEFAULT '0' COMMENT 'read count',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'status: 1-public;0-private',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT 'sort',
  `is_top` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'sticky to top',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `comments_uuid_unique` (`uuid`),
  KEY `comments_title_index` (`title`),
  KEY `comments_cate_id_index` (`cate_id`),
  KEY `comments_user_id_index` (`user_id`),
  KEY `comments_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for friend_links
-- ----------------------------
DROP TABLE IF EXISTS `friend_links`;
CREATE TABLE `friend_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `follow` tinyint(3) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `deleted_at` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `friend_links_title_index` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of friend_links
-- ----------------------------
INSERT INTO `friend_links` VALUES ('1', 'Vien Blog', '免费开源博客、基于Laravel5.8、支持Markdown、支持图片拖拽上传', 'https://vienblog.com', '', '1', '1553745930', '1576200176', '1576200176');
INSERT INTO `friend_links` VALUES ('2', '小白一键VPN', 'ss/ssr一键搭建教程、outline教程、国外VPS优惠购买、免费ss/ssr账号分享', 'https://viencoding.com', '', '1', '1553745930', '1576200174', '1576200174');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2019_03_17_052657_create_blog_admins_table', '1');
INSERT INTO `migrations` VALUES ('4', '2019_03_18_084506_create_blog_articles_table', '1');
INSERT INTO `migrations` VALUES ('5', '2019_03_18_085451_create_blog_tags_table', '1');
INSERT INTO `migrations` VALUES ('6', '2019_03_18_085727_create_blog_categories_table', '1');
INSERT INTO `migrations` VALUES ('7', '2019_03_18_090336_create_blog_article_tags_table', '1');
INSERT INTO `migrations` VALUES ('8', '2019_03_25_220957_create_blog_users_table', '1');
INSERT INTO `migrations` VALUES ('9', '2019_04_04_061012_create_baidu_posted_urls', '1');
INSERT INTO `migrations` VALUES ('10', '2019_04_05_040146_create_friend_links_table', '1');
INSERT INTO `migrations` VALUES ('11', '2019_04_26_020035_create_comments_table', '1');
