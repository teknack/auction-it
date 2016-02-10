-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2016 at 04:27 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auctionit201602`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `master_admin_control` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`username`, `password`, `master_admin_control`) VALUES
('mit17k', 'mitesh1795', 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `i_id` int(11) NOT NULL COMMENT 'Successive Diff: 321',
  `i_name` varchar(40) NOT NULL,
  `i_imgpath` varchar(50) NOT NULL,
  `i_desc` text NOT NULL,
  `i_baseprice` int(11) NOT NULL DEFAULT '0',
  `i_actualprice` int(11) NOT NULL DEFAULT '0',
  `i_increment` int(11) NOT NULL DEFAULT '0',
  `i_starttime` datetime NOT NULL,
  `i_endtime` datetime NOT NULL,
  `i_bidvalue` int(11) NOT NULL DEFAULT '0',
  `i_biduser_id` varchar(45) DEFAULT NULL,
  `i_biduser_name` varchar(50) DEFAULT NULL,
  `i_is_won` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`i_id`, `i_name`, `i_imgpath`, `i_desc`, `i_baseprice`, `i_actualprice`, `i_increment`, `i_starttime`, `i_endtime`, `i_bidvalue`, `i_biduser_id`, `i_biduser_name`, `i_is_won`) VALUES
(154321, 'Sir Alex Fergussons Chewing Gum', 'item/item1.png', 'Arguably the best manager in history of football,the secret for his calm calculative brain-His chewing gum is on sale !! MANU fans get your bids onn', 200, 400, 100, '2016-02-13 13:30:00', '2016-02-13 13:50:00', 0, '', '', 0),
(154642, 'Nokia 1100', 'item/item2.png', 'ever thought about a unbreakable phone?This was probably the first in the league. Get your hands on the iconic nokia cell phone', 50, 100, 150, '2016-02-13 14:00:00', '2016-02-13 14:20:00', 0, '', '', 0),
(154963, 'Blue&Black/White&Gold', 'item/item3.png', 'The dress that has been creating buzz on the social media is here for grab!! Make the chance count!', 500, 1000, 100, '2016-02-13 14:30:00', '2016-02-13 14:50:00', 0, '', '', 0),
(155284, 'Messi''s 5th ballon d''or', 'item/item4.png', 'This lad been sensational for years now ! Winning the 5th ballon d''or stamps his authority over the football world, Here is his latest trophy on auction to raise money for charity', 1000, 2000, 200, '2016-02-13 15:00:00', '2016-02-13 15:20:00', 0, '', '', 0),
(155605, 'Ronaldo''s Statue with Messi''s name', 'item/item5.png', 'The ronaldo  statue in madrid now has messi''s name inscribed on it! What a thing to own!keep biding! ', 750, 1500, 150, '2016-02-13 15:30:00', '2016-02-13 15:50:00', 0, '', '', 0),
(155926, 'Kai Greene''s Protiens', 'item/item6.png', 'One of the best body-builders has his secret open to us! All fitness enthusiasts keep your eyes on it!', 600, 1200, 150, '2016-02-13 16:00:00', '2016-02-13 16:20:00', 0, '', '', 0),
(156247, 'Bear Grylls Half Eaten Worm', 'item/item7.png', 'The discovery channel sensational show host bear grylls surely has a liking for wired food items!Here is one from his show! ', 300, 600, 100, '2016-02-13 16:30:00', '2016-02-13 16:50:00', 0, '', '', 0),
(156568, 'Driverless Car', 'item/item8.png', 'Ever heared about googles project to build driverless cars? Here is one which existed long before they even started making one!', 1000, 2000, 150, '2016-02-13 17:00:00', '2016-02-13 17:20:00', 0, '', '', 0),
(156889, 'Star Wars Lightsaber', 'item/item9.png', 'May the force be with you!', 750, 1500, 150, '2016-02-13 17:30:00', '2016-02-13 17:50:00', 0, '', '', 0),
(157210, 'Conjuring Chair', 'item/item10.png', 'our admin has emmense love for horror movies! Here is one from his closet', 600, 1200, 200, '2016-02-13 18:00:00', '2016-02-13 18:20:00', 0, '', '', 0),
(157531, 'Bond Aston Martin Classic', 'item/item11.png', 'Gentlemen spies have been a attraction to everyone and what better than Bond, James Bond! Here is one of the best from his fleet', 1500, 3000, 250, '2016-02-13 18:30:00', '2016-02-13 18:50:00', 0, '', '', 0),
(157852, 'Rodger Feds Wimbledon Replica', 'item/item12.png', 'The man who has won over 14 Grand slams  has decided to do some donations! Here is a replica of his first wimbeldon singles championship!', 1000, 2000, 150, '2016-02-13 19:00:00', '2016-02-13 19:20:00', 0, '', '', 0),
(158173, 'Titanics gold wreck', 'item/item13.png', 'The most famous hsip had over a ton of gold onboard before it sank, our diver have managed to recover most of it! Here it is for auction now! ', 1750, 2500, 250, '2016-02-13 19:30:00', '2016-02-13 19:50:00', 0, '', '', 0),
(158494, 'Sir Alan Turings Christopher', 'item/item14.png', 'The best machine made so far by one of the best mathematicians ever! Here is a working prototype of the machine which helped Britain in the world war', 2000, 4000, 250, '2016-02-13 20:00:00', '2016-02-13 20:20:00', 0, '', '', 0),
(158815, 'Hitlers secret reading glasses', 'item/item15.png', 'The best leader also had great fascinations for extravagant devices ! Here is one of his own special glasses designed to read secret messages ', 500, 1000, 200, '2016-02-13 20:30:00', '2016-02-13 20:50:00', 0, '', '', 0),
(159136, 'Winston churchill cigar', 'item/item16.png', 'A man who build his aura around his personality! Certainly the cigar had to do lot in building the aura! We have managed to get one for you!!', 700, 1400, 150, '2016-02-13 21:00:00', '2016-02-13 21:20:00', 0, '', '', 0),
(159457, 'Malinga wig', 'item/item17.png', 'The most lethal and popular limited overs bowler is certainly well known for his hairstyle! Here is wig from the man himself! ', 550, 1100, 100, '2016-02-13 21:30:00', '2016-02-13 21:50:00', 0, '', '', 0),
(159778, 'Sherapovas racquet', 'item/item18.png', 'Does this lady need any introduction?? Certainly no! here is a raquet from her closet up for auction coming in next!', 1500, 3000, 250, '2016-02-13 22:00:00', '2016-02-13 22:20:00', 0, '', '', 0),
(160099, 'Schumachers last race car', 'item/item19.png', 'Arguably the best F1 driver to have come up is the past century!here is his ferrari championship race car!', 2500, 5000, 250, '2016-02-13 22:30:00', '2016-02-13 22:50:00', 0, '', '', 0),
(160420, 'Empty mumbai local train', 'item/item20.png', 'No asking for the 4th seat anymore!', 5000, 10000, 450, '2016-02-13 23:00:00', '2016-02-13 23:20:00', 0, '', '', 0),
(160741, 'Zoozoo', 'item/item21.png', 'the most popular mascot from the house of vodafone! Here is one for auction given by vodafone themselves! Start bidding folks!', 500, 1000, 100, '2016-02-13 23:30:00', '2016-02-13 23:50:00', 0, '', '', 0),
(161062, 'Dimitri Vegas DJ booth', 'item/item22.png', 'Worlds best DJ has decided to sell his DJ booth! Anyone intrested?', 1500, 3000, 150, '2016-02-14 00:00:00', '2016-02-14 00:20:00', 0, '', '', 0),
(161383, 'Dravids WK glove', 'item/item23.png', 'There isnt a more selfless team man! Here is the wicket keeping gloves ge used when asked to keep wickets for team India', 800, 1600, 150, '2016-02-14 00:30:00', '2016-02-14 00:50:00', 0, '', '', 0),
(161704, 'super luxury yatch', 'item/item24.png', 'Easily one the most luxurious posessions one can have !', 4000, 8000, 200, '2016-02-14 01:00:00', '2016-02-14 01:20:00', 0, '', '', 0),
(162025, 'Google Glasses', 'item/item25.png', 'We have our hands on one of the first prototypes, Here it is on Auctio for you guys!!', 1250, 2500, 150, '2016-02-14 01:30:00', '2016-02-14 01:50:00', 0, '', '', 0),
(162346, 'SachinTendulkar signed MRF bat.', 'item/item26.png', 'The God of Cricket has decided to raise money for charity from this Auction. Raise your voice all SRT fans.', 1000, 2000, 150, '2016-02-14 02:00:00', '2016-02-14 02:20:00', 0, '', '', 0),
(162667, 'Steve Job used Macintosh.', 'item/item27.png', 'What''s better than a mac used by the legend himself!', 1250, 2250, 200, '2016-02-14 13:30:00', '2016-02-14 13:50:00', 0, '', '', 0),
(162988, 'Ancient mummy from pyramid of giza', 'item/item28.png', ' Mummy which is close to 3000 years old! If you have a craze for ancient stuff, well it cant get more ancient than this. Come on and raise your voice!', 750, 1500, 150, '2016-02-14 14:00:00', '2016-02-14 14:20:00', 0, '', '', 0),
(163309, 'PK?s Radio transistor', 'item/item29.png', 'After finding the remote controller, P.K doesn?t need this radio anymore as the radio frequency doesn?t reach their planet, he gave it up for auction.', 500, 750, 100, '2016-02-14 14:30:00', '2016-02-14 14:50:00', 0, '', '', 0),
(163630, 'The IRONTHRONE', 'item/item30.png', 'The throne in which no king should sit comfortably. They should know the price one has to pay to lead a king?s commanding life. The throne was allegedly forged from the 1,000 swords that had been surrendered to Aegon in the War of Conquest by the lords who had offered their fealty.', 1500, 2750, 150, '2016-02-14 15:00:00', '2016-02-14 15:20:00', 0, '', '', 0),
(163951, 'Captain america?s shield', 'item/item31.png', 'Captain America''s shield is next on the list. This shield is composed of a unique alloy of Vibranium, steel, and an unknown third component. It is virtually indestructible. If you guys got a lot of bad enemies out there, I guess you need this one!', 1500, 2500, 200, '2016-02-14 15:30:00', '2016-02-14 15:50:00', 0, '', '', 0),
(164272, ' James Bond''s golden gun', 'item/item32.png', 'The iconic thriller star Sean Connery was seen holding this golden gun in the film''s poster. The gun was a part of Christie''s Popular Culture: Film and Entertainment'' auction in London. Originally, the gun was never meant to be used in the movie, but this happened to be used as the original Walther PPK pistol didn''t turn up.', 1250, 1750, 100, '2016-02-14 16:00:00', '2016-02-14 16:20:00', 0, '', '', 0),
(164593, 'World?s oldest champagne', 'item/item33.png', 'What''s more expensive than the most expensive bottle of Dom Perignon ever sold? The answer: a nearly 200-year-old bottle of champagne that spent the last two centuries at the bottom of the ocean.\nIn July 2010, divers off the Aaland archipelago on the Finnish coast discovered 145 bottles of wine and champagne that had gone down with the ship, a two-masted schooner which ran aground sometime between 1825 and 1830. The name of the ship and its intended destination are still unknown, although it''s speculated that they were en route to the court of the Russian tsar in St. Petersburg.\n', 1000, 2000, 250, '2016-02-14 16:30:00', '2016-02-14 16:50:00', 0, '', '', 0),
(164914, 'The  Batman suit', 'item/item34.png', 'Ben Affleck has his new one ! You can grab the one from Dark night rises used by Christian Bale', 2000, 2500, 250, '2016-02-14 17:00:00', '2016-02-14 17:20:00', 0, '', '', 0),
(165235, 'Skin colored headphones to use during le', 'item/item35.png', 'A boring lecture can be fun when you?re listening to music and smiling at the professor. Get this flesh colored earphones and get attendance for fun. Exclusively for engineering students.', 500, 750, 100, '2016-02-14 17:30:00', '2016-02-14 17:50:00', 0, '', '', 0),
(165556, 'Invisibility cloak (harry potter)', 'item/item36.png', 'Wanna sneak around at night or do some mischief without getting noticed!  This guess you?ll know how to use it. If not ask any harry potter fan! ', 750, 1500, 100, '2016-02-14 18:00:00', '2016-02-14 18:20:00', 0, '', '', 0),
(165877, 'James lebron Shoes 12', 'item/item37.png', 'The legendary basket ball player decides to donate all the money raised to charity! Raise your voice folks!', 1200, 1850, 100, '2016-02-14 18:30:00', '2016-02-14 18:50:00', 0, '', '', 0),
(166198, 'The grandfather clock ', 'item/item38.png', 'This ancient clock was sold for more than a million in a recent auction at California. The buyer(anonymous) donated this for teknack. ', 500, 1250, 150, '2016-02-14 19:00:00', '2016-02-14 19:20:00', 0, '', '', 0),
(166519, 'Snitch (Harry Potter)', 'item/item39.png', 'One for all the  Harry potter fans! Get Set to bid folks! ', 1250, 1500, 150, '2016-02-14 19:30:00', '2016-02-14 19:50:00', 0, '', '', 0),
(166840, 'samsung virtual reality', 'item/item40.png', 'A GenNext techonlogy prototype is next for auction!!', 1500, 3000, 200, '2016-02-14 20:00:00', '2016-02-14 20:20:00', 0, '', '', 0),
(167161, '3d printing pen', 'item/item41.png', 'A pen that writes is 3D would definetly one of the best posessions you could have.This surely desrves a high bid, Get it going high folks!', 1500, 2500, 150, '2016-02-14 20:30:00', '2016-02-14 20:50:00', 0, '', '', 0),
(167482, 'self stiring mug', 'item/item42.png', 'One for all the lazt asses out there!', 500, 750, 100, '2016-02-14 21:00:00', '2016-02-14 21:20:00', 0, '', '', 0),
(167803, 'vintage rx100', 'item/item43.png', 'Men are seperated from the boys when the ride their bikes! This is certainly one for the men! Bid to get one of the classic editions!', 1500, 2000, 150, '2016-02-14 21:30:00', '2016-02-14 21:50:00', 0, '', '', 0),
(168124, 'HM Ambassador Car', 'item/item44.png', 'The classic vintage every Indian once owned.', 1000, 2000, 150, '2016-02-14 22:00:00', '2016-02-14 22:20:00', 0, '', '', 0),
(168445, 'Tommy Hilfiger limited edition watch', 'item/item45.png', 'The premium brand which everyone wants to own! Here is a chance to have one!', 1000, 1750, 100, '2016-02-14 22:30:00', '2016-02-14 22:50:00', 0, '', '', 0),
(168766, '1967 Chevrolet Impala', 'item/item46.png', 'You gotta be hot to ride this one. Winchesters Bros slaying it since 1981.', 1500, 2500, 200, '2016-02-14 23:00:00', '2016-02-14 23:20:00', 0, '', '', 0),
(169087, 'Cindrella Glass Shoes', 'item/item47.png', 'A good pair of heels can change your life forever. Cinderella is proof!', 750, 1250, 150, '2016-02-14 23:30:00', '2016-02-14 23:50:00', 0, '', '', 0),
(169408, 'Beverly Hills Mansion', 'item/item48.png', 'Beverly hills surely is one of the best areas to reside in! Bid high to get your own!', 850, 1250, 150, '2016-02-15 00:00:00', '2016-02-15 00:20:00', 0, '', '', 0),
(169729, 'Kobe Bryant Signed Jersey', 'item/item49.png', 'The legend fom NBA has given a autograph on this jersey and we have it here on auction for you guys!', 3000, 7000, 700, '2016-02-15 00:30:00', '2016-02-15 00:50:00', 0, '', '', 0),
(170050, 'Tomorrow Land Tickets', 'item/item50.png', 'The heaven for EDM lovers!surely you want to visit it atleast once, Don?t you? Here is a ticket on offer ..Gear up for a bid all EDM lovers!', 1500, 2000, 200, '2016-02-15 01:00:00', '2016-02-15 01:20:00', 0, '', '', 0),
(170371, 'Cocacola Recipe', 'item/item51.png', 'The best kept secret is now revealed! We found it written in an old diary.', 2000, 3000, 300, '2016-02-15 01:30:00', '2016-02-15 01:50:00', 0, '', '', 0),
(170692, 'MF Hussain Last Painting', 'item/item52.png', 'The master of modern art had created this amazing art piece of art which we have in store next. ', 1200, 1700, 100, '2016-02-15 02:00:00', '2016-02-15 02:20:00', 0, '', '', 0),
(171013, 'Casino Table', 'item/item53.png', 'Once in Las Vegas , it served in a legendary game!', 1300, 2100, 150, '2016-02-15 02:30:00', '2016-02-15 02:50:00', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `q_id` int(11) NOT NULL COMMENT 'start: 23432 incr: 32',
  `q_question` text NOT NULL,
  `q_op1` varchar(200) NOT NULL,
  `q_op2` varchar(200) NOT NULL,
  `q_op3` varchar(200) NOT NULL,
  `q_op4` varchar(200) NOT NULL,
  `q_ans` varchar(200) NOT NULL,
  `q_starttime` datetime NOT NULL,
  `q_endtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`q_id`, `q_question`, `q_op1`, `q_op2`, `q_op3`, `q_op4`, `q_ans`, `q_starttime`, `q_endtime`) VALUES
(23624, 'India''s first Technicolor film ____ in the early 1950s was produced by ____', ' ''Jhansi Ki Rani'', Sohrab Modi', 'Jhansi Ki Rani'', Sir Syed Ahmed', ' ''Mirza Ghalib'', Sohrab Modi', 'Mirza Ghalib'', Munshi Premchand', '''Jhansi Ki Rani'', Sohrab Modi', '2016-02-13 13:30:00', '2016-02-13 14:00:00'),
(23656, '  \n\nIndia has largest deposits of ____ in the world.', 'gold', 'copper', 'mica', '  None of the above', 'mica', '2016-02-13 13:30:00', '2016-02-13 14:00:00'),
(23688, '  \n\nHow many Lok Sabha seats belong to Rajasthan?', '32', '25', '30', '17', '25', '2016-02-13 14:00:00', '2016-02-13 14:30:00'),
(23720, '  \n\nIndia''s first satellite is named after', 'Aryabhatta', 'Bhaskara II', 'Bhaskara I', 'Albert Einstein', 'Aryabhatta', '2016-02-13 14:00:00', '2016-02-13 14:30:00'),
(23752, '  \n\nIndia''s first atomic reactor was', 'Zerlina', 'Dhruva', 'Apsara', 'Kamini', 'Apsara', '2016-02-13 14:30:00', '2016-02-13 15:00:00'),
(23784, '  \n\nIn which year, terrorists crash two planes into New York''s World Trade Centre on September 11 in a sequence of destruction?', '2000', '2001', '2002', '2003', '2001', '2016-02-13 14:30:00', '2016-02-13 15:00:00'),
(23816, '  \n\nIndia''s first ocean wave''s energy project was launched in', '1981', '1991', '1995', '2000', '1991', '2016-02-13 15:00:00', '2016-02-13 15:30:00'),
(23848, '  \n\nIn which of the following years, the membership of the Security Council was increased from 11 to 15 (under Article 23)?', '1960', '1965', '1972', '1975', '1965', '2016-02-13 15:00:00', '2016-02-13 15:30:00'),
(23880, 'India''s tallest stone statue of the Jain sage Gomateswara is at', 'Mysore, Karnakata', 'New Delhi', 'Sravanabelagola, Karnataka', 'Mandu, Madhya Pradesh', 'Sravanabelagola, Karnataka', '2016-02-13 15:30:00', '2016-02-13 16:00:00'),
(23912, '  \n\nIn 1945, fifty nations met to phrase the basic charter for a world organization which would "save succeeding generations from the scourge of war". This conference took place at', 'Dumbarton Oaks', '  London', 'San Francisco', 'Yalta', 'San Francisco', '2016-02-13 15:30:00', '2016-02-13 16:00:00'),
(23944, 'In a normal human body, the total number of red blood cells is', '15 trillion', '  20 trillion', '25 trillion', '30 trillion', '30 trillion', '2016-02-13 16:00:00', '2016-02-13 16:30:00'),
(23976, '  \n\nINS Venduruthy is located at', 'Kochi', 'Lonavla', 'Jamnagar', 'Mumbai', 'Kochi', '2016-02-13 16:00:00', '2016-02-13 16:30:00'),
(24008, '  \n\nIn which season do we need more fat?', '  Rainy season', 'Spring', 'Winter', 'Summer', 'Winter', '2016-02-13 16:30:00', '2016-02-13 17:00:00'),
(24040, 'How much districts are there in Punjab?', '13', '17', '22', '15', '22', '2016-02-13 16:30:00', '2016-02-13 17:00:00'),
(24072, '  \n\nIndia participated in Olympics Hockey in', '1918', '1928', '1938', '1948', '1928', '2016-02-13 17:00:00', '2016-02-13 17:30:00'),
(24104, 'If force is expressed in Newton and the distance in metre, then the work done is expressed in', 'Joule', 'Kg wt', 'Kg wt m', 'Watt', 'Joule', '2016-02-13 17:00:00', '2016-02-13 17:30:00'),
(24136, '  \n\nHow many teeth does a normal adult dog have?', '32', '34', '38', '42', '42', '2016-02-13 17:30:00', '2016-02-13 18:00:00'),
(24168, 'How many red blood cells does the bone marrow produce every second?', '  5 million', '7 million', '10 million', '12 million', '10 million', '2016-02-13 17:30:00', '2016-02-13 18:00:00'),
(24200, 'How many times has Brazil won the World Cup Football Championship?', 'Four times', 'Twice', 'Five times', 'Once', 'Five times', '2016-02-13 18:00:00', '2016-02-13 18:30:00'),
(24232, '  \n\nIf speed of rotation of the earth increases, weight of the body', 'increases', 'remains unchanged', 'decreases', 'may decrease or increase', 'decreases', '2016-02-13 18:00:00', '2016-02-13 18:30:00'),
(24264, '  \n\nIn August, 1996 at Kolar(near Bangalore), India made successful test flights of Unmanned Air Vehicle (UAV) named', 'Arjun', 'Nishant', 'Vijayanta', 'Lakshya', 'Nishant', '2016-02-13 18:30:00', '2016-02-13 19:00:00'),
(24296, '  \n\nIDA stands for', '  Indian Development Agency', '  International Development Agency', '  Industrial Development Analyses', 'None of the above', '  International Development Agency', '2016-02-13 18:30:00', '2016-02-13 19:00:00'),
(24328, 'Indira Gandhi was assassinated in', '1974', '1984', '1994', '2004', '1984', '2016-02-13 19:00:00', '2016-02-13 19:30:00'),
(24360, '  \n\nIndia''s first nuclear blast at Pokhran in Rajasthan took place in', '1984', '1974', '1964', '1954', '1974', '2016-02-13 19:00:00', '2016-02-13 19:30:00'),
(24392, '  \n\nHow many players are there on each side in the game of Basketball?', '4', '5', '6', '7', '5', '2016-02-13 19:30:00', '2016-02-13 20:00:00'),
(24424, '  \n\nIn a normal human being, how much time does food take to reach the end of the intestine for complete absorption?', 'About 8 hours', 'About 12 hours', 'About 16 hours', 'About 18 hours', 'About 12 hours', '2016-02-13 19:30:00', '2016-02-13 20:00:00'),
(24456, 'In certain diseases antibiotics are administered. The object is', 'stimulate production of white blood cells for fighting the disease', 'stimulate production of antibodies', 'inhibit the growth of bacteria', 'produce toxins against bacteria', 'inhibit the growth of bacteria', '2016-02-13 20:00:00', '2016-02-13 20:30:00'),
(24488, '  \n\nIn cricket, the two sets of wickets are', '18 yards apart', '20 yards apart', '22 yards apart', '24 yards apart', '  22 yards apart', '2016-02-13 20:00:00', '2016-02-13 20:30:00'),
(24520, '  \n\nIndia''s first indigenous helicopter was successfully flown in Bangalore on', '30-Aug-92', '30-Aug-82', '30-Aug-90', '  None of the above', '30-Aug-92', '2016-02-13 20:30:00', '2016-02-13 21:00:00'),
(24552, '  \n\nIn which of the followings places was the last Winter Olympics Games held?', 'Albertville', 'Lillehammer', '  Sochi, Russia', 'Salt Lake City (USA)', 'Sochi, Russia', '2016-02-13 20:30:00', '2016-02-13 21:00:00'),
(24584, 'Hundred year war was fought between', 'France and England', 'Greek and Persian forces', 'Civil war in England', 'None of the above', '  France and England', '2016-02-13 21:00:00', '2016-02-13 21:30:00'),
(24616, '  \n\nIn which of the following pairs, the two substances forming the pair are chemically most dissimilar?', 'Sugar and paper', 'Butter and paraffin wax', 'Chalk and marble', 'Charcoal and diamond', 'Butter and paraffin wax', '2016-02-13 21:00:00', '2016-02-13 21:30:00'),
(24648, '  \n\nIndia''s Integrated Missiles Development Programme was started in ____ under the chairmanship of Dr. A.P.J. Abdul Kalam.', '1979-80', '1980-81', '1981-82', '1982-83', '1982-83', '2016-02-13 21:30:00', '2016-02-13 22:00:00'),
(24680, '  \n\nINS Agrani (Petty Officers'' School) is situated at', 'Mumbai', 'Jamnagar', 'Coimbatore', 'Lonavla', 'Coimbatore', '2016-02-13 21:30:00', '2016-02-13 22:00:00'),
(24712, 'Hybridization is', 'downward movement of water through soil', 'a process of tilling the land', 'decayed vegetable matter', 'cross-fertilization between two varieties', 'cross-fertilization between two varieties', '2016-02-13 22:00:00', '2016-02-13 22:30:00'),
(24744, '  \n\nIn which world cup cricket final, Australia beat England?', '1983, Lord''s - England', '1987, Kolkata - India', '1992, Melbourne - Australia', '1996, Lahore - Pakistan', '1987, Kolkata - India', '2016-02-13 22:00:00', '2016-02-13 22:30:00'),
(24776, '  \n\n\nIndia is the ____ grower of pulses.', '  largest', 'smallest', 'appropriate for national need', 'None of the above', 'largest', '2016-02-13 22:30:00', '2016-02-13 23:00:00'),
(24808, '  \n\nIn cricket, a run taken when the ball passes the batsman without touching his bat or body is called', 'leg bye', 'bye', 'bosie', 'drive', 'bye', '2016-02-13 22:30:00', '2016-02-13 23:00:00'),
(24840, '  \n\nHow many non-permanent Security Council (UNO) members are from Afro-Asian countries?', '5', '15', '2', '1', '5', '2016-02-13 23:00:00', '2016-02-13 23:30:00'),
(24872, '  \n\nIndira Gandhi Centre for Atomic Research, established in 1971, is located at', 'Indore', '  Trombay, Maharashtra', '  Kalpakkam, Chennai', 'Kolkata', 'Kalpakkam, Chennai', '2016-02-13 23:00:00', '2016-02-13 23:30:00'),
(24904, 'In which year of First World War Germany declared war on Russia and France?', '1914', '1915', '1916', '1917', '1914', '2016-02-13 23:30:00', '2016-02-14 00:00:00'),
(24936, '  \n\nICAO stands for', 'International Civil Aviation Organization', 'Indian Corporation of Agriculture Organization', 'Institute of Company of Accounts Organization', 'None of the above', 'International Civil Aviation Organization', '2016-02-13 23:30:00', '2016-02-14 00:00:00'),
(24968, '  \n\nIn which year did Sir Edmund Hillary reach the summit of Mount Everest?', '1952', '1953', '1954', '1955', '1953', '2016-02-14 00:00:00', '2016-02-14 00:30:00'),
(25000, '  \n\nHP stands for', 'Harmonic Progression', '  Horse Power', 'both (a) and (b)', 'None of the above', 'both (a) and (b)', '2016-02-14 00:00:00', '2016-02-14 00:30:00'),
(25032, 'India''s first fast breeder neutron reactor was', 'Zerlina', 'Apsara', 'Purnima-I', 'Kamini', 'Kamini', '2016-02-14 00:30:00', '2016-02-14 01:00:00'),
(25064, '  \n\nIndia''s first atomic power station was set up at', 'Surat (Gujarat)', '  Tarapur (Maharashtra)', 'Trombay (Maharashtra)', 'Solapur (Maharashtra)', 'Tarapur (Maharashtra)', '2016-02-14 00:30:00', '2016-02-14 01:00:00'),
(25096, 'How many Ergs are there in 1 joule?', '10^2', '10^4', '10^6', '10^7', '10^7', '2016-02-14 01:00:00', '2016-02-14 01:30:00'),
(25128, '  \n\nIn 1943, Franklin D. Roosevelt, Winston Churchill and Joseph Stalin met at Teheran primarily', 'to discuss the strategy to be adopted by the Allies to invade Germany', 'to consider a common plan of action by the Allies forces against the axis powers', '  for creating an effective instrument for maintaining international peace', 'to work out a common line of action against Japan', 'for creating an effective instrument for maintaining international peace', '2016-02-14 01:00:00', '2016-02-14 01:30:00'),
(25160, '  \n\nInnocent III, who became pope in 1198 led', 'the first crusade', '  the second crusade', 'the third crusade', '  the fourth crusade', '  the fourth crusade', '2016-02-14 01:30:00', '2016-02-14 02:00:00'),
(25192, '  \n\nIn which year a resolution ''Uniting for Peace'' was adopted by UN General Assembly?', '1950', '1960', '1965', '1980', '1950', '2016-02-14 01:30:00', '2016-02-14 02:00:00'),
(25224, '  \n\nIn which of the following organs of human body does maximum absorption of food take place?', 'Gullet', '  Large intestine', 'Small intestine', 'Stomach', 'Small intestine', '2016-02-14 02:00:00', '2016-02-14 02:30:00'),
(25256, '  In the last World Cup Hockey Finals in 2002, Germany beat ____', 'Pakistan', 'Australia', 'India', 'Spain', 'Australia', '2016-02-14 02:00:00', '2016-02-14 02:30:00'),
(25288, '  \n\nHow much of blood does the normal human heart on each of its contraction pump into the arteries?', '30 cm^3', '60 cm^3', '30 cm^5', '60 cm^5', '60 cm^3', '2016-02-14 13:30:00', '2016-02-14 14:00:00'),
(25320, 'Hygrometer is used to measure', 'relative humidity', 'purity of milk', '  specific gravity of liquid', 'None of the above', 'relative humidity', '2016-02-14 13:30:00', '2016-02-14 14:00:00'),
(25352, ' India became a member of the United Nations in', '1945', '1947', '1959', '1960', '1945', '2016-02-14 14:00:00', '2016-02-14 14:30:00'),
(25384, '  \n\nIndia has', 'largest turmeric production', 'largest tea production', 'largest ginger production', 'All of the above', 'All of the above', '2016-02-14 14:00:00', '2016-02-14 14:30:00'),
(25416, '  \n\nIndia''s first indigenously built submarine was', 'INS Savitri', '  INS Shalki', 'INS Delhi', 'INS Vibhuti', 'INS Shalki', '2016-02-14 14:30:00', '2016-02-14 15:00:00'),
(25448, 'How many medals came into the account of India during the last Commonwealth Games in 2002 at Manchester?', '32', '24', '69', '16', '69', '2016-02-14 14:30:00', '2016-02-14 15:00:00'),
(25480, '  \n\nIf the plane of the earth''s equator were not inclined to the plane of the earth''s orbit', 'the year would be longer', '  the winters would be longer', 'there would be no change of seasons', '  the summers would be warmer', 'there would be no change of seasons', '2016-02-14 15:00:00', '2016-02-14 15:30:00'),
(25512, 'India played its first cricket Test Match in', '1922', '1932', '1942', '1952', '1932', '2016-02-14 15:00:00', '2016-02-14 15:30:00'),
(25544, '  \n\nIndia has been represented as a non-permanent member of the Security Council (UNO) during', '1972-73', '1984-85', '1991-92', '  All of the above', '  All of the above', '2016-02-14 15:30:00', '2016-02-14 16:00:00'),
(25576, '  \n\nHow many Lok Sabha seats does Goa have?', '16', '2', '11', '15', '2', '2016-02-14 15:30:00', '2016-02-14 16:00:00'),
(25608, 'In Air Force, Air Commodore has one rank higher than', 'Squadron Leader', 'Air Vice-Marshal', 'Group Captain', 'Air Marshal', 'Group Captain', '2016-02-14 16:00:00', '2016-02-14 16:30:00'),
(25640, 'How much districts are there in Tamil Nadu?', '26', '27', '28', '32', '32', '2016-02-14 16:00:00', '2016-02-14 16:30:00'),
(25672, 'Kiran Bedi received Magsaysay Award for government service in', '1992', '1993', '1994', '1995', '1994', '2016-02-14 16:30:00', '2016-02-14 17:00:00'),
(25704, '  \n\nLogarithm tables were invented by', 'John Napier', 'John Doe', '  John Harrison', 'John Douglas', 'John Napier', '2016-02-14 16:30:00', '2016-02-14 17:00:00'),
(25736, 'With which sport is the Jules Rimet trophy associated?', 'Basketball', 'Football', 'Hockey', 'Golf', 'Football', '2016-02-14 17:00:00', '2016-02-14 17:30:00'),
(25768, 'Joule is the unit of', 'temperature', 'pressure', 'energy', 'heat', 'energy', '2016-02-14 17:00:00', '2016-02-14 17:30:00'),
(25800, 'Kemal Ataturk was', 'the first President of Independent Kenya', 'the founder of modern Turkey', 'revolutionary leader of Soviet Union', 'None of the above', 'the founder of modern Turkey', '2016-02-14 17:30:00', '2016-02-14 18:00:00'),
(25832, '  \nMilkha Singh Stood ____ in 1960 Olympics, in Athletics.', 'fourth in 400m final', 'second in 400m final', '  eighth in 50km walk', 'seventh in 800m final', 'fourth in 400m final', '2016-02-14 17:30:00', '2016-02-14 18:00:00'),
(25864, '  \n\nMs. Medha Patkar is associated with the', '  Tehri project', 'Enron project', 'Sardar Sarovar project', 'Dabhol project', 'Sardar Sarovar project', '2016-02-14 18:00:00', '2016-02-14 18:30:00'),
(25896, 'Kathakali, Mohiniatam and Ottamthullal are the famous dances of', 'Kerala', 'Karnataka', 'Orissa', 'Tamil Nadu', 'Kerala', '2016-02-14 18:00:00', '2016-02-14 18:30:00'),
(25928, '  \n\nJaspal Rana is associated with which of the following games?', 'Swimming', 'Archery', 'Shooting', 'Weightlifting', 'Shooting', '2016-02-14 18:30:00', '2016-02-14 19:00:00'),
(25960, 'Lala Lajpat Rai is also known as', 'Sher-e-Punjab', 'Punjab Kesari', 'both (a) and (b)', 'None of the above', 'both (a) and (b)', '2016-02-14 18:30:00', '2016-02-14 19:00:00'),
(25992, '  \n\nModern football is said to have evolved from', 'England', 'India', 'France', 'Spain', 'England', '2016-02-14 19:00:00', '2016-02-14 19:30:00'),
(26024, 'Modern Indo-Aryan languages are based on an ancient language called', 'Hindi', 'Sanskrit', 'Kannada', 'Tamil', 'Sanskrit', '2016-02-14 19:00:00', '2016-02-14 19:30:00'),
(26056, 'Lakshmibai National College of Physical Education is located at', 'Bhopal', 'Gwalior', 'Karnal', 'Patiala', 'Gwalior', '2016-02-14 19:30:00', '2016-02-14 20:00:00'),
(26088, 'Malfunctioning of which of the following organs causes jaundice?', 'Stomach', 'Pancreas', 'Liver', 'Kidney', 'Liver', '2016-02-14 19:30:00', '2016-02-14 20:00:00'),
(26120, 'Olympic creed and oath was composed by ____ the founder of modern Olympics.', 'Rev Father Didon', 'Baron Pierre de Coubertin', 'Norman Pitchard', 'None of the above', 'None of the above', '2016-02-14 20:00:00', '2016-02-14 20:30:00'),
(26152, 'Kathak, Nauntanki, Jhora and Kajri are the important dances of', 'Uttaranchal', 'Uttar Pradesh', 'Jharkhand', 'Chhattisgarh', 'Uttar Pradesh', '2016-02-14 20:00:00', '2016-02-14 20:30:00'),
(26184, 'Lance Armstrong, a sportsperson of international repute, belongs to which of the following countries?', 'USA', 'Ukraine', 'Spain', 'Brazil', 'USA', '2016-02-14 20:30:00', '2016-02-14 21:00:00'),
(26216, 'Ludhiana is situated on ____ river.', 'Gomti', 'Yamuna', 'Satluj', 'Godavari', 'Satluj', '2016-02-14 20:30:00', '2016-02-14 21:00:00'),
(26248, 'Kiran Bedi is', 'first woman IAS officer', 'first woman IPS officer', 'first woman advocate', 'first woman judge', 'first woman IPS officer', '2016-02-14 21:00:00', '2016-02-14 21:30:00'),
(26280, 'K.S. Ranjit Singhji was', 'first Bar-at-law', 'first Air Marshal', 'first Indian test cricketer', 'first Field Marshal', 'first Indian test cricketer', '2016-02-14 21:00:00', '2016-02-14 21:30:00'),
(26312, 'National Defence Academy is situated at', 'Khadakvasla', 'New Delhi', 'Wellington', 'Dehradun', 'Khadakvasla', '2016-02-14 21:30:00', '2016-02-14 22:00:00'),
(26344, 'Number of commands of Air Force are', 'five', 'six', 'seven', 'eight', 'seven', '2016-02-14 21:30:00', '2016-02-14 22:00:00'),
(26376, 'Of the following foods, which one is the best source of protein?', 'Butter', 'Fish', 'Lettuce', 'Milk', 'Fish', '2016-02-14 22:00:00', '2016-02-14 22:30:00'),
(26408, 'MISA stands for', 'Maintenance of Internal Security Act', 'Multinational Internal Society Authority', 'Movement for Indian System Act', 'None of the above', 'Maintenance of Internal Security Act', '2016-02-14 22:00:00', '2016-02-14 22:30:00'),
(26440, 'Mount Everest was captured by Edmund Hillary and Tenzing Norgay in the year', '1951', '1952', '1953', '', '1954', '2016-02-14 22:30:00', '2016-02-14 23:00:00'),
(26472, 'Karoline Mikkelsen was the first woman to', 'reach North Pole', 'reach South Pole', 'climb Mt. Everest', 'set foot on the moon', 'reach South Pole', '2016-02-14 22:30:00', '2016-02-14 23:00:00'),
(26504, 'Liquids transmit pressure equally in all directions. This is known as', 'Boyle-Pascal''s Law', 'Pascal''s Law', 'Archimedes'' Principle', 'None of the above', 'Pascal''s Law', '2016-02-14 23:00:00', '2016-02-14 23:30:00'),
(26536, 'John F. Kennedy, President of USA, died on', '1963', '1964', '1965', '1966', '1963', '2016-02-14 23:00:00', '2016-02-14 23:30:00'),
(26568, 'Normally the Commonwealth Games are held at intervals of', '3 years', '4 years', '5 years', 'there is no fixed interval', '4 years', '2016-02-14 23:30:00', '2016-02-15 00:00:00'),
(26600, 'Name the instrument used to measure relative humidity', 'Hydrometer', 'Hygrometer', 'Barometer', 'Mercury Thermometer', 'Hygrometer', '2016-02-14 23:30:00', '2016-02-15 00:00:00'),
(26632, 'National Remote Sensing Agency (NRSA) was setup in', '1980', '1985', '1990', '1995', '1980', '2016-02-15 00:00:00', '2016-02-15 00:30:00'),
(26664, 'Mina is the tribe of', 'Tripura', 'Sikkim', 'Rajasthan', 'Nagaland, Assam', 'Rajasthan', '2016-02-15 00:00:00', '2016-02-15 00:30:00'),
(26696, 'King Hammurabi raised the first army of the world in', '2000 BC', '1500 BC', '1480 BC', '1027 BC', '2000 BC', '2016-02-15 00:30:00', '2016-02-15 01:00:00'),
(26728, 'National Institute of Occupation Health is located at', 'Bangalore', 'Ahmedabad', 'Pune', 'Mumbai', 'Ahmedabad', '2016-02-15 00:30:00', '2016-02-15 01:00:00'),
(26760, 'Kanishka was', 'the king of Kushan dynasty', 'a great conqueror but later became a follower of Buddha', 'the only ruler of India whose territory extended up to central Asia', 'All of the above', 'All of the above', '2016-02-15 01:00:00', '2016-02-15 01:30:00'),
(26792, 'National Institute of Oceanography is located at', 'Panaji (Goa)', 'Lucknow (Uttar Pradesh)', 'Pune (Maharashtra)', 'Nagpur (Maharashtra)', 'Panaji (Goa)', '2016-02-15 01:00:00', '2016-02-15 01:30:00'),
(26824, 'Nuclear power is ____ thermal power.', 'cheaper than', 'costlier than', 'equal in amount', 'they cannot be related', 'cheaper than', '2016-02-15 01:30:00', '2016-02-15 02:00:00'),
(26856, 'Michael Faraday discovered', 'electromagnetism', 'benzene, liquid gases and optical glass', ' the induction of electric current', 'All of the above', 'All of the above', '2016-02-15 01:30:00', '2016-02-15 02:00:00'),
(26888, 'Mother Teresa won the Nobel Prize for Peace in', '1992', '1979', '1988', '1954', '1979', '2016-02-15 02:00:00', '2016-02-15 02:30:00'),
(26920, 'Most commonly used bleaching agent is', 'alcohol', 'carbon dioxide', 'chlorine', 'sodium chloride', 'chlorine', '2016-02-15 02:00:00', '2016-02-15 02:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `tek_userid` varchar(45) NOT NULL COMMENT 'User email id',
  `tek_name` varchar(50) NOT NULL,
  `u_firstvisit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 means first visit',
  `u_cashbalance` int(11) NOT NULL DEFAULT '0',
  `u_cashspent` int(11) NOT NULL DEFAULT '0',
  `meg_points` int(11) NOT NULL DEFAULT '0' COMMENT 'mega event points < 1000',
  `u_itemswon` int(11) NOT NULL DEFAULT '0',
  `u_itempoints` int(11) NOT NULL DEFAULT '0',
  `u_quizlevel` int(11) NOT NULL DEFAULT '0' COMMENT 'quiz level cleared',
  `chat_status` int(1) NOT NULL,
  `quiz_attempt_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`q_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`tek_userid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
