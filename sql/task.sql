/*
Navicat MySQL Data Transfer

Source Server         : 192.168.100.18_3306
Source Server Version : 50616
Source Host           : 192.168.100.18:3306
Source Database       : integle_hui

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2017-02-09 11:58:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for integle_task
-- ----------------------------
DROP TABLE IF EXISTS `integle_task`;
CREATE TABLE `integle_task` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(1) NOT NULL COMMENT '任务类型：1.供应商产品上传，2.库存产品上传',
  `thread_no` varchar(64) DEFAULT NULL,
  `task_status` tinyint(1) DEFAULT '1' COMMENT '1.待处理，2.处理中，3.处理完成，4.中断',
  `version` int(10) DEFAULT '0' COMMENT '版本，用于判断进程执行次数',
  `audit_version` int(10) NOT NULL DEFAULT '0' COMMENT '检测版本',
  `begin_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '1.有效，0.无效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=887 DEFAULT CHARSET=utf8 COMMENT='后台任务列表';
