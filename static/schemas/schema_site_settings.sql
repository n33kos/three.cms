DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE IF NOT EXISTS `site_settings` (
  `sitetitle` text NOT NULL,
  `siteurl` text NOT NULL,
  `admincontact` text NOT NULL,
  `timezone` text NOT NULL,
  `robotsbit` int(11) NOT NULL,
  `homecontroller` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;