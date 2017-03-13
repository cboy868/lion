

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- 表的结构 `client_info`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(128) CHARACTER SET utf8 NOT NULL COMMENT '客户名称',
  `gender` tinyint(4) NOT NULL DEFAULT '1',
  `age` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '账号id',
  `telephone` varchar(128) CHARACTER SET utf8 NOT NULL COMMENT '家庭电话',
  `mobile` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(200) CHARACTER SET utf8 DEFAULT '' COMMENT '邮箱 ',
  `qq` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `wechat` varchar(128) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL DEFAULT '',
  `province_id` int(11) DEFAULT '0',
  `city_id` int(11) DEFAULT '0',
  `zone_id` int(11) DEFAULT '0',
  `address` text CHARACTER SET utf8 NOT NULL COMMENT '详细地址',
  `note` text CHARACTER SET utf8 NOT NULL COMMENT '备注',
  `guide_id` int(11) NOT NULL DEFAULT '0' COMMENT '导购员ID',
  `come_from` tinyint(4) NOT NULL COMMENT '客户来源',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '最终业值ID',
  `status` tinyint(4) DEFAULT '1' COMMENT '1 正常 0 删除',
  `created_by` int(11) DEFAULT '0',
  `created_at` int(11) COMMENT '添加时间',
  `updated_at` int(11) COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='预约表';

-- --------------------------------------------------------

--
-- 表的结构 `client_reception`
--

CREATE TABLE IF NOT EXISTS `client_reception` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户信息ID',
  `guide_id` int(11) NOT NULL DEFAULT '0' COMMENT '导购员id',
  `agent_id` int(11) NOT NULL DEFAULT '0',
  `car_number` varchar(128) NOT NULL DEFAULT '',
  `person_num` int(11) NOT NULL DEFAULT '1',
  `start` datetime NOT NULL COMMENT '开始时间',
  `end` datetime NOT NULL COMMENT '结束时间',
  `un_reason` tinyint(4) NOT NULL DEFAULT '113',
  `is_success` tinyint(4) NOT NULL DEFAULT '0',
  `note` text COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 删除',
  `created_at` int(11) COMMENT '录入时间',
  `updated_at` int(11) COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='接待记录表';

-- --------------------------------------------------------

--
-- 表的结构 `client_deal`
--


CREATE TABLE IF NOT EXISTS `client_deal` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `guide_id` int(11) NOT NULL DEFAULT '0',
  `agent_id` int(11) NOT NULL DEFAULT '0',
  `recep_id` int(11) NOT NULL DEFAULT '0',
  `res_name` varchar(200) NOT NULL DEFAULT '',
  `res_id` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '成交时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1-正常 -1-删除'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_deal`
--
ALTER TABLE `client_deal`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `client_reception`
--
ALTER TABLE `client_reception`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_gid` (`guide_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `client_reception`
--
ALTER TABLE `client_reception`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
