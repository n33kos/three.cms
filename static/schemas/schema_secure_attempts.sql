DROP TABLE IF EXISTS `secure_attempts`;
CREATE TABLE IF NOT EXISTS `secure_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
