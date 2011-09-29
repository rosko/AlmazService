/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50511
Source Host           : localhost:3306
Source Database       : cbsh

Target Server Type    : MYSQL
Target Server Version : 50511
File Encoding         : 65001

Date: 2011-08-25 10:24:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL DEFAULT '',
  `pass` varchar(20) DEFAULT NULL,
  `privilege` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`,`login`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('5', 'wmanilo@gmail.com', 'q1we', '0');

-- ----------------------------
-- Table structure for `user_info`
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `id` int(6) NOT NULL DEFAULT '0',
  `name` varchar(30) DEFAULT NULL,
  `surname` varchar(30) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `skype` varchar(20) DEFAULT NULL,
  `phone_1` varchar(11) DEFAULT NULL,
  `phone_2` varchar(11) DEFAULT NULL,
  `mail` varchar(20) NOT NULL DEFAULT '',
  `vkontakte` varchar(40) DEFAULT NULL,
  `facebook` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`,`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_info
-- ----------------------------
INSERT INTO `user_info` VALUES ('5', 'Вовка', 'Манило', '1991-06-13', 'aka_k4jt', '0503089548', '0639811835', 'wmanilo@gmail.com', 'http://vkontakte.ru/aka_k4jt', 'http://www.facebook.com/aka.k4jt');
