-- Adminer 4.7.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `billing`;
CREATE DATABASE `billing` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `billing`;

DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `sno` varchar(64) DEFAULT NULL COMMENT '单号',
  `amount` double NOT NULL COMMENT '金额',
  `favour` double NOT NULL COMMENT '优惠',
  `pay` double NOT NULL COMMENT '已付金额',
  `settlement` varchar(5) NOT NULL COMMENT '支付方式',
  `book_date` timestamp NOT NULL COMMENT '订货日期',
  `deliver_date` date DEFAULT NULL COMMENT '交货日期',
  `contract` varchar(20) DEFAULT NULL COMMENT '合同单号',
  `customer` varchar(20) NOT NULL COMMENT '客户 待定',
  `contact` varchar(20) DEFAULT NULL COMMENT '联系人',
  `number` varchar(20) DEFAULT NULL COMMENT '电话',
  `remark` varchar(100) DEFAULT NULL COMMENT '摘要',
  `comment` varchar(100) DEFAULT NULL COMMENT '备注',
  `clerk` varchar(10) NOT NULL COMMENT '业务员',
  `designer` varchar(10) NOT NULL COMMENT '设计员',
  `tracker` varchar(10) NOT NULL COMMENT '跟单员',
  `source` varchar(10) NOT NULL COMMENT '业务来源',
  `writer` varchar(10) NOT NULL COMMENT '开单员',
  `address` varchar(50) NOT NULL COMMENT '地址',
  `bill_type` tinyint(1) DEFAULT NULL COMMENT '单据类型 0-正常 1-返工 2-小样',
  `deliver_type` tinyint(1) NOT NULL COMMENT '送货/自提',
  `deliver_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-未送 1-已送',
  PRIMARY KEY (`id`),
  KEY `clerk` (`clerk`),
  KEY `designer` (`designer`),
  KEY `tracker` (`tracker`),
  KEY `source` (`source`),
  KEY `writer` (`writer`),
  CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`clerk`) REFERENCES `user` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bill_ibfk_2` FOREIGN KEY (`designer`) REFERENCES `user` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bill_ibfk_3` FOREIGN KEY (`tracker`) REFERENCES `user` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bill_ibfk_4` FOREIGN KEY (`source`) REFERENCES `user` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bill_ibfk_5` FOREIGN KEY (`writer`) REFERENCES `user` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `bill_item`;
CREATE TABLE `bill_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(20) DEFAULT NULL,
  `width` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `length_unit` int(11) DEFAULT NULL COMMENT '长度单位 0-mm 1-cm 2-m',
  `price_unit` int(11) DEFAULT NULL COMMENT '计价方式 0-成品 1-面积 2-长边 3-宽 4-高 5-周长',
  `price` float DEFAULT NULL,
  `remark` text,
  `amount` float unsigned DEFAULT NULL,
  `product_num` int(10) unsigned DEFAULT NULL,
  `bill` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bill` (`bill`),
  CONSTRAINT `bill_item_ibfk_2` FOREIGN KEY (`bill`) REFERENCES `bill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `number` varchar(20) NOT NULL,
  `address` char(200) NOT NULL,
  `deliver` tinyint(1) NOT NULL COMMENT '0送货/1自提',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `account` bigint(11) NOT NULL,
  `password` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-正常 0-辞退',
  `authority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-普通 1-管理员',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2021-02-25 03:47:58
