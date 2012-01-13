--
-- Table structure for table `flatpage`
--

CREATE TABLE IF NOT EXISTS `flatpage` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `subtitle` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `abstract` text COLLATE utf8_unicode_ci,
  `text` text COLLATE utf8_unicode_ci,
  `image1` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image2` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video1` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video2` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `groups` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

---
--- Module admin privilege
---

INSERT INTO `sys_privileges` (
`category` ,
`class` ,
`class_id` ,
`label` ,
`description`
)
VALUES (
'Pages', 'flatpage', '1', 'Management of flat html pages', 'Insertion, modification and deletion of flat html pages'
);
