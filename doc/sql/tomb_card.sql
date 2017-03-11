
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `grave_card` (
  `id` int(11) NOT NULL,
  `tomb_id` int(11) NOT NULL COMMENT '墓位id',
  `start` date COMMENT '开始时间',
  `end` date COMMENT '结束日期',
  `total` int(11) COMMENT '续费总年数',
  `created_by` int(11) DEFAULT '0' COMMENT '添加人',
  `created_at` int(11) COMMENT '添加时间',
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Indexes for table `tomb_card_main`
--

ALTER TABLE `grave_card`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `tomb_card_main`
--
ALTER TABLE `grave_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 表的结构 `tomb_card_detail`
--

CREATE TABLE IF NOT EXISTS `grave_card_rel` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL COMMENT '主表id',
  `tomb_id` int(11) NOT NULL COMMENT '墓位id',
  `start` date COMMENT '开始日期',
  `end` date COMMENT '结束日期',
  `order_id` int(11) DEFAULT '0' COMMENT '订单id',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '续费钱数',
  `total` int(11) COMMENT '续费年数',
  `num` int(11) DEFAULT '0' COMMENT '周期数',
  `customer_name` varchar(50) DEFAULT '',
  `mobile` varchar(20) DEFAULT '',
  `created_by` int(11) DEFAULT '0' COMMENT '添加人',
  `created_at` int(11) COMMENT '添加时间',
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Indexes for table `tomb_card_detail`
--
ALTER TABLE `grave_card_rel`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `tomb_card_detail`
--
ALTER TABLE `grave_card_rel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
