/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50509
Source Host           : localhost:3306
Source Database       : utahesports

Target Server Type    : MYSQL
Target Server Version : 50509
File Encoding         : 65001

Date: 2012-05-02 23:41:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `allowresources`
-- ----------------------------
DROP TABLE IF EXISTS `allowresources`;
CREATE TABLE `allowresources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `resourceId` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accountId` (`accountId`),
  CONSTRAINT `allowresources_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `ue_users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of allowresources
-- ----------------------------

-- ----------------------------
-- Table structure for `denyresources`
-- ----------------------------
DROP TABLE IF EXISTS `denyresources`;
CREATE TABLE `denyresources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `resourceId` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of denyresources
-- ----------------------------

-- ----------------------------
-- Table structure for `resources`
-- ----------------------------
DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(45) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `routeName` varchar(255) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of resources
-- ----------------------------
INSERT INTO `resources` VALUES ('1', 'default', 'auth', 'login', 'default::auth::login', 'authLogin', '2012-04-11 00:49:56', '2012-04-11 00:49:58');
INSERT INTO `resources` VALUES ('2', 'default', 'auth', 'logout', 'default::auth::logout', 'authLogout', '2012-04-11 00:51:07', '2012-04-11 00:51:09');
INSERT INTO `resources` VALUES ('3', 'default', 'error', 'error', 'default::error::error', 'errorError', '2012-04-11 00:51:46', '2012-04-11 00:51:48');
INSERT INTO `resources` VALUES ('4', 'default', 'index', 'index', 'default::index::index', 'indexIndex', '2012-04-11 00:52:03', '2012-04-11 00:52:06');
INSERT INTO `resources` VALUES ('5', 'default', 'users', 'index', 'default::users::index', 'usersIndex', '2012-04-11 00:52:35', '2012-04-11 00:52:38');
INSERT INTO `resources` VALUES ('6', 'default', 'users', 'register', 'default::users::register', 'usersRegister', '2012-04-11 00:53:24', '2012-04-11 00:53:27');
INSERT INTO `resources` VALUES ('7', 'default', 'admin', 'index', 'default::admin::index', 'adminIndex', '2012-04-23 17:55:19', '2012-04-23 17:55:21');
INSERT INTO `resources` VALUES ('8', 'default', 'admin', 'users', 'default::admin::users', 'adminUsers', '2012-04-23 17:56:09', '2012-04-23 17:56:11');
INSERT INTO `resources` VALUES ('9', 'default', 'admin', 'roles', 'default::admin::roles', 'adminRoles', '2012-04-23 17:56:31', '2012-04-23 17:56:36');
INSERT INTO `resources` VALUES ('10', 'default', 'admin', 'resources', 'default::admin::resources', 'adminResources', '2012-04-23 18:45:07', '2012-04-23 18:45:09');
INSERT INTO `resources` VALUES ('11', 'default', 'admin', 'roleresources', 'default::admin:roleresources', 'adminRoleResources', '2012-04-23 18:49:22', '2012-04-23 18:49:25');

-- ----------------------------
-- Table structure for `roleresources`
-- ----------------------------
DROP TABLE IF EXISTS `roleresources`;
CREATE TABLE `roleresources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roleId` int(11) NOT NULL,
  `resourceId` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_idx` (`roleId`),
  KEY `resources_idx` (`resourceId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roleresources
-- ----------------------------
INSERT INTO `roleresources` VALUES ('8', '6', '3', '2012-04-23 17:01:20', '2012-04-23 17:01:23');
INSERT INTO `roleresources` VALUES ('9', '6', '1', '2012-04-23 17:06:06', '2012-04-23 17:06:09');
INSERT INTO `roleresources` VALUES ('15', '6', '2', '2012-04-25 21:54:11', '2012-04-25 21:54:15');
INSERT INTO `roleresources` VALUES ('16', '6', '4', '2012-04-25 21:54:24', '2012-04-25 21:54:27');
INSERT INTO `roleresources` VALUES ('17', '6', '5', '2012-04-25 21:55:20', '2012-04-25 21:55:22');
INSERT INTO `roleresources` VALUES ('18', '6', '6', '2012-04-25 21:55:34', '2012-04-25 21:55:36');
INSERT INTO `roleresources` VALUES ('19', '2', '7', '2012-04-25 21:56:36', '2012-04-25 21:56:39');
INSERT INTO `roleresources` VALUES ('20', '2', '8', '2012-04-25 21:56:46', '2012-04-25 21:56:52');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `default` tinyint(1) DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('2', 'admin', null, '2012-04-25 22:01:52', '2012-02-07 07:45:14');
INSERT INTO `roles` VALUES ('3', 'moderator', null, '2012-04-25 22:01:53', '2012-02-07 07:45:32');
INSERT INTO `roles` VALUES ('4', 'editor', null, '2012-04-25 22:01:55', '2012-02-07 07:45:41');
INSERT INTO `roles` VALUES ('5', 'user', null, '2012-04-25 22:01:56', '2012-02-14 16:19:13');
INSERT INTO `roles` VALUES ('6', 'guest', '1', '2012-04-23 17:06:41', '2012-04-11 21:33:41');

-- ----------------------------
-- Table structure for `rolesinheritances`
-- ----------------------------
DROP TABLE IF EXISTS `rolesinheritances`;
CREATE TABLE `rolesinheritances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentRoleId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rolesinheritances
-- ----------------------------
INSERT INTO `rolesinheritances` VALUES ('2', '2', '6', '1', '2012-05-02 23:15:38', '2012-05-02 23:15:40');

-- ----------------------------
-- Table structure for `ue_events`
-- ----------------------------
DROP TABLE IF EXISTS `ue_events`;
CREATE TABLE `ue_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `is_public` int(1) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creator_id` (`creator_id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `ue_events_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `ue_players` (`id`),
  CONSTRAINT `ue_events_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `ue_property_options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_events
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_event_dates`
-- ----------------------------
DROP TABLE IF EXISTS `ue_event_dates`;
CREATE TABLE `ue_event_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `ue_event_dates_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `ue_events` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_event_dates
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_event_games`
-- ----------------------------
DROP TABLE IF EXISTS `ue_event_games`;
CREATE TABLE `ue_event_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `game_id` (`game_id`),
  CONSTRAINT `ue_event_games_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `ue_events` (`id`),
  CONSTRAINT `ue_event_games_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `ue_games` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_event_games
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_event_tournaments`
-- ----------------------------
DROP TABLE IF EXISTS `ue_event_tournaments`;
CREATE TABLE `ue_event_tournaments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `tournament_id` (`tournament_id`),
  CONSTRAINT `ue_event_tournaments_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `ue_events` (`id`),
  CONSTRAINT `ue_event_tournaments_ibfk_2` FOREIGN KEY (`tournament_id`) REFERENCES `ue_tournaments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_event_tournaments
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_games`
-- ----------------------------
DROP TABLE IF EXISTS `ue_games`;
CREATE TABLE `ue_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `image_url` text,
  `display_order` int(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_games
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_news`
-- ----------------------------
DROP TABLE IF EXISTS `ue_news`;
CREATE TABLE `ue_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `is_public` int(1) NOT NULL DEFAULT '1',
  `title` text NOT NULL,
  `content` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creator_id` (`creator_id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `ue_news_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `ue_players` (`id`),
  CONSTRAINT `ue_news_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `ue_property_options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_news
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_news_games`
-- ----------------------------
DROP TABLE IF EXISTS `ue_news_games`;
CREATE TABLE `ue_news_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `game_id` (`game_id`),
  CONSTRAINT `ue_news_games_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `ue_news` (`id`),
  CONSTRAINT `ue_news_games_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `ue_games` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_news_games
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_players`
-- ----------------------------
DROP TABLE IF EXISTS `ue_players`;
CREATE TABLE `ue_players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `show_email` int(1) NOT NULL DEFAULT '1',
  `contact_info` text,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ue_players_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ue_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_players
-- ----------------------------
INSERT INTO `ue_players` VALUES ('1', '1', 'Austin', 'Welch', 'aikepah@gmail.com', '1', 'Skype: Aikepah', null, null);

-- ----------------------------
-- Table structure for `ue_player_game_infos`
-- ----------------------------
DROP TABLE IF EXISTS `ue_player_game_infos`;
CREATE TABLE `ue_player_game_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `info_id` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `player_id` (`player_id`),
  KEY `game_id` (`game_id`),
  KEY `info_id` (`info_id`),
  CONSTRAINT `ue_player_game_infos_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `ue_players` (`id`),
  CONSTRAINT `ue_player_game_infos_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `ue_games` (`id`),
  CONSTRAINT `ue_player_game_infos_ibfk_3` FOREIGN KEY (`info_id`) REFERENCES `ue_property_options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_player_game_infos
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_player_streams`
-- ----------------------------
DROP TABLE IF EXISTS `ue_player_streams`;
CREATE TABLE `ue_player_streams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  `is_live` int(1) NOT NULL DEFAULT '1',
  `is_featured` int(1) NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `description` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `player_id` (`player_id`),
  KEY `game_id` (`game_id`),
  CONSTRAINT `ue_player_streams_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `ue_players` (`id`),
  CONSTRAINT `ue_player_streams_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `ue_games` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_player_streams
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_property_categories`
-- ----------------------------
DROP TABLE IF EXISTS `ue_property_categories`;
CREATE TABLE `ue_property_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `comment` text,
  `display_order` int(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_property_categories
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_property_lists`
-- ----------------------------
DROP TABLE IF EXISTS `ue_property_lists`;
CREATE TABLE `ue_property_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `comment` text,
  `display_order` int(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ue_property_lists_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ue_property_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_property_lists
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_property_options`
-- ----------------------------
DROP TABLE IF EXISTS `ue_property_options`;
CREATE TABLE `ue_property_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `comment` text,
  `display_order` int(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `list_id` (`list_id`),
  CONSTRAINT `ue_property_options_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `ue_property_lists` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_property_options
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_tournaments`
-- ----------------------------
DROP TABLE IF EXISTS `ue_tournaments`;
CREATE TABLE `ue_tournaments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `is_public` int(1) NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `description` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `checkin_date` datetime NOT NULL,
  `challonge_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `ue_tournaments_ibfk_1` (`creator_id`),
  CONSTRAINT `ue_tournaments_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `ue_players` (`id`),
  CONSTRAINT `ue_tournaments_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `ue_property_options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_tournaments
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_tournament_players`
-- ----------------------------
DROP TABLE IF EXISTS `ue_tournament_players`;
CREATE TABLE `ue_tournament_players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tournament_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `fee` int(1) NOT NULL DEFAULT '0',
  `checkin` int(1) NOT NULL DEFAULT '0',
  `place` text,
  `prize` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tournament_id` (`tournament_id`),
  KEY `ue_tournament_players_ibfk_2` (`player_id`),
  CONSTRAINT `ue_tournament_players_ibfk_1` FOREIGN KEY (`tournament_id`) REFERENCES `ue_tournaments` (`id`),
  CONSTRAINT `ue_tournament_players_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `ue_players` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_tournament_players
-- ----------------------------

-- ----------------------------
-- Table structure for `ue_users`
-- ----------------------------
DROP TABLE IF EXISTS `ue_users`;
CREATE TABLE `ue_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `password_salt` varchar(80) NOT NULL,
  `security_question` varchar(80) NOT NULL,
  `security_answer` varchar(80) NOT NULL,
  `logged_in` int(1) DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `is_banned` int(1) DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '4',
  PRIMARY KEY (`id`,`username`),
  KEY `role_id` (`role_id`),
  KEY `id` (`id`),
  CONSTRAINT `ue_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ue_users
-- ----------------------------
INSERT INTO `ue_users` VALUES ('1', 'aikepah', '7ba41a247ec6d028250a1f98298fc183', '54757350185182054516535508033965632273837900174882', 'hello?', 'hi', null, '2012-02-14 16:19:52', '2012-02-14 16:19:52', null, '2');
