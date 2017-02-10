/*
Navicat MySQL Data Transfer

Source Server         : 192.168.100.18_3306
Source Server Version : 50616
Source Host           : 192.168.100.18:3306
Source Database       : integle_hui

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2017-02-09 11:58:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for integle_s_mission
-- ----------------------------
DROP TABLE IF EXISTS `integle_s_mission`;
CREATE TABLE `integle_s_mission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '任务处理记录表id',
  `number` varchar(32) NOT NULL COMMENT '上传编号',
  `deep_path` char(9) NOT NULL COMMENT 'csv文件相对路径',
  `save_name` varchar(32) NOT NULL COMMENT 'csv文件名称',
  `real_name` varchar(255) NOT NULL COMMENT '真实名称',
  `sfile_id` int(10) NOT NULL DEFAULT '0' COMMENT '文件名编号【废弃】',
  `handle_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '处理结果表 0未处理 1处理中 2处理完毕',
  `line` int(10) NOT NULL DEFAULT '0' COMMENT '执行到的行数',
  `audit_line` int(10) NOT NULL DEFAULT '0' COMMENT '检查行数',
  `total_line` int(10) NOT NULL DEFAULT '0' COMMENT '总行数',
  `success_line` int(10) NOT NULL DEFAULT '0' COMMENT '成功行数',
  `thread_no` varchar(64) NOT NULL DEFAULT '' COMMENT '进程号',
  `task_id` int(10) NOT NULL COMMENT '任务编号',
  `pro_type` tinyint(1) NOT NULL COMMENT '产品类型 1、化学品 2、生物制剂 4、仪器耗材 8、服务 ',
  `supplier_id` int(10) NOT NULL COMMENT '库存编号',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户编号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '该记录的状态 1正常 0逻辑删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=427 DEFAULT CHARSET=utf8 COMMENT='供应商csv文件任务表';
