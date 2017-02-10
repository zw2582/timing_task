/*
Navicat MySQL Data Transfer

Source Server         : 192.168.100.18_3306
Source Server Version : 50616
Source Host           : 192.168.100.18:3306
Source Database       : integle_hui

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2017-02-09 11:58:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for integle_s_mission_error
-- ----------------------------
DROP TABLE IF EXISTS `integle_s_mission_error`;
CREATE TABLE `integle_s_mission_error` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '错误日志记录id',
  `missions_id` int(10) unsigned NOT NULL COMMENT 'csv任务id',
  `line_number` int(10) unsigned NOT NULL COMMENT '在csv文件中错误记录的行号',
  `error_info` text COMMENT '具体错误描述',
  `content` varchar(2000) NOT NULL DEFAULT '' COMMENT 'Excel原数据 json格式',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '该错误日志创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '该记录的状态 1正常 0逻辑删除',
  PRIMARY KEY (`id`),
  KEY `csv_missions_id` (`missions_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22940 DEFAULT CHARSET=utf8 COMMENT='供应商csv_missions文件错误日志记录表';
