-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ql_tourdulich
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customer_groups`
--

DROP TABLE IF EXISTS `customer_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_groups` (
  `REPRESENT_ID` int(10) NOT NULL AUTO_INCREMENT,
  `IDCARD` varchar(12) NOT NULL DEFAULT 'Không Có',
  `CUSTOMERNAME` varchar(50) NOT NULL,
  `AGE` tinyint(4) NOT NULL,
  PRIMARY KEY (`REPRESENT_ID`,`IDCARD`,`CUSTOMERNAME`),
  CONSTRAINT `customer_groups_ibfk_1` FOREIGN KEY (`REPRESENT_ID`) REFERENCES `customers` (`ID`),
  CONSTRAINT `fk_cusgroup_cus` FOREIGN KEY (`REPRESENT_ID`) REFERENCES `customers` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1000001 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_groups`
--

LOCK TABLES `customer_groups` WRITE;
/*!40000 ALTER TABLE `customer_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) NOT NULL,
  `IDCARD` varchar(12) NOT NULL,
  `ADDRESS` varchar(50) DEFAULT NULL,
  `PHONENUMBER` varchar(13) NOT NULL,
  `BIRTHDAY` date NOT NULL,
  `EMAIL` varchar(40) NOT NULL,
  `CHILDS_AMOUNT` tinyint(4) DEFAULT 0,
  `ADULTS_AMOUNT` tinyint(4) NOT NULL DEFAULT 0,
  `NOTES` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1000097 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1000084,'Hiếu KH','42342234235','Hồ Chí Minh','3123321','2000-11-13','hieu.kh@gmail.com',0,0,NULL),(1000086,'Đạt','352280000','Hồ Chí Minh','0766906751','1995-09-12','tratdat95@gmail.com',0,0,NULL),(1000096,'Hoàng','352280000','','0766900000','1998-10-15','nhathoang@gmail.com',0,0,NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) NOT NULL,
  `IDCARD` varchar(12) NOT NULL,
  `ADDRESS` varchar(50) NOT NULL,
  `PHONENUMBER` varchar(13) NOT NULL,
  `POSITION` varchar(20) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `PART_DAY` date NOT NULL,
  `BIRTHDAY` date NOT NULL,
  `IS_ACTIVE` tinyint(1) DEFAULT 1,
  `EMAIL` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `IS_ACTIVE` (`IS_ACTIVE`)
) ENGINE=InnoDB AUTO_INCREMENT=1001027 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1001000,'Superadmin','05665344','Hồ Chí Minh E','0333690617','SUPERADMIN','2020-06-30','2001-12-09',1,NULL),(1001014,'Đạt E','352200000','Hồ Chí Minh E E','0766900001','USER','2024-11-12','1995-12-30',1,'tratdat_e@gmail.co'),(1001020,'Đạttt','352280944','Hồ Chí Minh','0766906751','ADMIN','2024-10-19','2003-12-31',1,'tratdat@gmail.com'),(1001021,'Đạt 01','352280944','Hồ Chí Minh EEE','0766900004','USER','2024-11-17','1995-12-09',1,'dat_01@gmail.com'),(1001023,'tratdat95 E','352280944','tratdat95','0766906751','USER','2024-11-17','2001-12-09',1,'tratdat95@gmail.com');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `TYPE` varchar(45) DEFAULT 'USER',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1001027 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1000096,'nhathoang','161ebd7d45089b3446ee4e0d86dbcf92','CUSTOMER'),(1001000,'superadmin','161ebd7d45089b3446ee4e0d86dbcf92','USER'),(1001014,'tratdat95','161ebd7d45089b3446ee4e0d86dbcf92','USER'),(1001020,'tratdat','161ebd7d45089b3446ee4e0d86dbcf92','USER'),(1001021,'dat01','161ebd7d45089b3446ee4e0d86dbcf92','USER'),(1001023,'tratdat96','161ebd7d45089b3446ee4e0d86dbcf92','USER');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_details`
--

DROP TABLE IF EXISTS `tour_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tour_details` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `START` date NOT NULL,
  `END` date NOT NULL,
  `HOTEL_NAME` varchar(100) DEFAULT 'ĐANG CẬP NHẬT',
  `VEHICLE` varchar(30) NOT NULL,
  `CHILD_PRICE` float NOT NULL,
  `ADULT_PRICE` float NOT NULL,
  `TOUR_PROGRAM` text DEFAULT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `tour_details_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `tours` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2000000026 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_details`
--

LOCK TABLES `tour_details` WRITE;
/*!40000 ALTER TABLE `tour_details` DISABLE KEYS */;
INSERT INTO `tour_details` VALUES (2000000001,'2024-06-01','2024-06-11','4*- Yamashira Hotel','Máy bay',12990000,13990000,'Khởi hành từ TpHCM '),(2000000006,'2024-06-01','2024-06-10','4*- Luxury Hotel','Máy bay',15990000,21900000,'Khởi hành từ TpHCM '),(2000000009,'2024-01-01','2024-01-01','Home stay Kim  Hoàng','bus',1190000,1290000,'Sáng: Quý khách có mặt tại ga quốc nội, sân bay Tân Sơn Nhất trước giờ bay ít nhất ba tiếng, đại diện công ty Du Lịch Việt đón và hỗ trợ Quý khách làm thủ tục đón chuyến bay đi Hà Nội. Đến sân bay Nội Bài, Hướng dẫn viên đón Quý khách khởi hành du lịch Hà Giang mùa Hè 2019. Trưa: Đoàn dừng chân ở Phú Thọ để dùng cơm trưa. Sau đó, đoàn tiếp tục hành trình tour Hà Giang mùa Hè giá rẻ để đến với mảnh đất Hà Giang – nơi có những con đường đèo, cứ nối nhau quanh co uốn lượn, nơi có những con người dân tộc chân chất, mặc dù cuộc sống nghèo khổ nhưng trên môi luôn nở nụ cười. Tối: Dùng cơm tối và nghỉ đêm ở Hà Giang.'),(2000000010,'2024-01-01','2024-01-01','4*- danis Hotel','Máy bay',15990000,17990000,'05h30: Xe và Hướng dẫn viên (HDV) đón Quý khách tại Nhà hát lớn, Xe khởi hành đi Bắc Kạn. Đoàn ăn sáng tại nhà hàng trên đường đi (Chi phí tự túc). 11h30: Ăn trưa tại nhà hàng ở thị trấn Chợ Rã Ba Bể. Đoàn tiếp tục hành trình đến Hồ Ba Bể. Qua những bản nhà sàn thấp thoáng bên sườn núi khoảng một giờ sau Quý khách có mặt tại bờ Hồ Ba Bể, nhận phòng. Quý khách thư giãn nghỉ ngơi trong không gian yên tĩnh của núi rừng.  Chiều: Xuống thuyền tại bến thuyền, quý khách đi quanh hồ Ba Bể thăm quan Lòng hồ, với các địa danh như: Đảo Bà Góa, Đền An Mã, chèo thuyền Kayaking trên lòng hồ, thuyền ghé thăm bản Pác Ngòi, Động Hua mạ,.. quý khách dạo bộ thăm quan bản với những nếp nhà sàn bên ven bờ hồ Ba Bể đặc trưng cho văn hóa dân tộc Tày sống bên lòng Hồ Ba bể Ăn tối với những món đặc sản núi rừng Ba Bể. Quý khách có thể tham gia giao lưu văn nghệ hát then, sli, lượn cùng đội văn nghệ của bản (Chi phí tự túc). Những bản tình ca mượt mà đằm thắm của cư dân vùng hồ, nhấp chén rượu ngô nho nhỏ trong ánh lửa bập bùng từ nhà sàn chắc hẳn không say cảnh nơi đây cũng say tình người bản xứ. Quý khách sẽ có một đêm ngon giấc và một kỷ niệm khó quên với Hồ Ba Bể.'),(2000000011,'2024-06-05','2024-06-07','ĐANG CẬP NHẬT','Xe du lịch',1990000,2390000,'Quý khách tập trung tại Công ty Vietravel (190 Pasteur, Phường 6, Quận 3, TP.HCM) khởi hành đi Phan Thiết. Quý khách ăn sáng trên cung đường đi. Đến Phan Thiết đoàn tham quan: - Làng Chài Xưa: du khách sẽ được đi xuyên vào không gian tương tác tái hiện Làng Chài Xưa Mũi Né với lịch sử 300 năm cái nôi của nghề làm nước mắm, trải nghiệm cảm giác lao động trên đồng muối, đi trên con đường rạng xưa, thăm phố cổ Phan Thiết, vào xóm lò tĩn, thăm nhà lều của hàm hộ nước mắm xưa, đắm chìm cảm xúc trong biển 3D và thích thú khi đi chợ làng chài xưa với bàn tính tay, bàn cân xưa thú vị Nhận phòng nghỉ ngơi, tự do tắm biển hồ bơi tại khách sạn/resort, buổi chiều đoàn tham quan: - Đồi Cát Vàng: một trong những khu vực đẹp nhất nằm ở Mũi Né thu hút khá nhiều du khách do hình dáng đẹp của cát và màu sắc của cát, nơi đây được xem là đồi cát có một không hai tại Việt nam bắt nguồn từ mỏ sắt cổ tồn tại hàng trăm năm tạo nên.  Sau khi dùng bữa tối, Quý khách sẽ thưởng thức chương trình biểu diễn nghệ thuật: - Fishermen Show – Huyền Thoại Làng Chài: với không gian nghệ thuật độc đáo về sự giao thoa văn hóa hai dân tộc Kinh và Chăm tại Phan Thiết. Nội dung của chương trình lấy cảm hứng từ làng chài Phan Thiết năm 1762.  Nghỉ đêm tại Mũi Né '),(2000000012,'2024-05-31','2024-06-03','ĐANG CẬP NHẬT','Máy bay',4390000,4890000,'Sáng:  Quý khách có mặt tại ga quốc nội, sân bay Tân Sơn Nhất trước giờ bay ít nhất ba tiếng. Đại diện công ty Du Lịch Việt đón và hỗ trợ Quý khách làm thủ tục đón chuyến bay đi Hà Nội. Đến sân bay Nội Bài, Hướng dẫn viên đón Quý khách khởi hành đến Hà Giang. Trưa: Dừng chân Phú Thọ, dùng cơm trưa. Đoàn tiếp tục khởi hành đến Hà Giang – nơi có những con đường đèo, cứ nối nhau quanh co uốn lượn, nơi có những con người dân tộc chân chất, mặc dù cuộc sống nghèo khổ nhưng trên môi luôn nở nụ cười. Tham quan Làng văn hóa du lịch sinh thái Hạ Thành, được bao quanh bởi những thửa ruộng bậc thang xếp nối nhau. Đến với Hạ Thành là đến với những ngôi nhà sàn truyền thống nguyên sơ, đến với những câu hát lượn, hát cọi, hát then ngọt ngào, những điệu múa dân gian, múa tín ngưỡng, những lễ hội truyền thống huyền bí, tạo cho bạn một cảm giác như trở về nơi cội nguồn của dân tộc. Tối: Dùng cơm tối. Nghỉ đêm Hà Giang.'),(2000000013,'2024-07-07','2024-07-10','ĐANG CẬP NHẬT','Máy bay',4388000,4580000,'Ngày 01: TP. HỒ CHÍ MINH - PHÚ QUỐC (Ăn sáng, trưa, chiều) Đón khách tại văn phòng Saigontourist và đáp chuyến VJ321 lúc 07:05. Tham quan vườn tiêu, lò chế biến rượu Sim rừng Phú Quốc, trung tâm nuôi cấy ngọc trai Phú Quốc, thắng cảnh Dinh Cậu. Nghỉ đêm tại Vinpearl Resort Phú Quốc - khu nghỉ dưỡng 5 sao lớn nhất Phú Quốc. Ngày 02: NGHĨ DƯỠNG & GIẢI TRÍ TẠI VINPEARL RESORT PHÚ QUỐC  (Ăn sáng, trưa, chiều) Nghỉ ngơi tại resort, tắm biển và thư giãn trong hồ bơi lớn nhất Phú Quốc; tận hưởng các tiện ích của khu nghỉ dưỡng: đánh golf, các môn thể thao biển: chèo xuồng kayak, mô tô nước, dù lượn, lặn ngắm san hô…(tự túc chi phí) Nghỉ đêm tại Vinpearl Resort Phú Quốc  Lựa chọn (tự túc chi phí cho mỗi lần tham quan): - Khám phá Khu vui chơi giải trí Vinpearl Land Phú Quốc với các trò chơi trong nhà, trò chơi ngoài trời lần đầu tiên xuất hiện tại Việt Nam: Đĩa quay siêu tốc, Cối xay gió, Đĩa bay…, Lâu đài Cổ tích; Khu công viên nước với các trò chơi mạo hiểm: Boomerang khổng lồ, Đường trượt siêu lòng chảo, Dòng sông lười, lâu đài, bể tạo sóng…; Phim 5D với nhiều kỹ xảo và hiệu ứng hiện đại; Khu Thủy Cung với hàng trăm loài sinh vật biển quý hiếm: chim Cánh cụt,  cá Nemo, cá Napoleon, cá Mập trắng, cua King Crab…Thưởng thức chương trình biểu diễn nhạc nước, biểu diễn cá heo, nàng tiên cá,… - Trải nghiệm Khu Vinpearl Safari: khám phá Vườn Thú Hoang Dã đầu tiên tại Việt Nam cùng hơn 130 loài động vật quý hiếm và các chương trình Biểu diễn động vật, Khám phá và trải nghiệm Vườn thú mở trong rừng tự nhiên, gần gũi và thân thiện với con người'),(2000000014,'2024-06-01','2024-06-04','Bangquaches Resort','Máy bay',7990000,8990000,'Khởi hành từ TpHCM '),(2000000015,'2024-06-01','2024-06-05','Hotel Kim Long','Máy bay',7490000,8290000,'Vịnh Hạ Long nơi rồng đáp xuống, là danh thắng quốc gia được xếp hạng từ năm 1962. Hạ Long có 1.969 hòn đảo, lô nhô trên mặt biển, nổi tiếng nhất là các hòn Lư Hương, Gà Chọi, Cánh Buồm, Mâm Xôi, đảo '),(2000000016,'2024-08-01','2024-08-06','5*- Baiyoke Resort','Máy bay',9891000,10990000,'Nằm trong khu vực Đông Nam Á, Thái Lan được du khách ưu ái dành tặng cho nhiều mỹ danh như: “Đất Nước Chùa Vàng”, “Thiên Đường Du Lịch”, “Thiên Đường Mua Sắm”, “Xứ Sở Của Những Nụ Cười Thân Thiện”. Th'),(2000000017,'2024-08-26','2024-09-01','3*- Kumlampark Resort','Máy bay',5490000,6470000,'Đất nước Malaysia xinh đẹp và quyến rũ được tạo hóa hào phóng ban tặng rất nhiều cảnh quan thiên nhiên đẹp mê lòng người. Không quá ồn ào, náo nhiệt, trời trong mát, những ngày du lịch tại Malaysia sẽ'),(2000000018,'2024-10-01','2024-10-07','4*- Tân Triều Hotel','Máy bay',19990000,21990000,'Vạn Lý Trường Thành - một trong những kỳ quan của thế giới, là công trình nhân tạo với mục đích phục vụ cho quân sự có một không hai trên thế giới, Thập Tam Lăng - nơi thờ phụng 13 ngôi mộ Thời nhà Mi'),(2000000025,'2024-10-27','2024-10-26','Trùng Khánh','Máy bay, Xe du lịch',10000000,16900000,'Tp Hồ Chí Minh – Trùng Khánh – Quý Dương - Số bữa ăn: 03 bữa (Sáng / Trưa/ Tối)  ');
/*!40000 ALTER TABLE `tour_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_log`
--

DROP TABLE IF EXISTS `tour_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tour_log` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CUSTOMER_ID` int(10) NOT NULL,
  `TOUR_ID` int(10) NOT NULL,
  `CREATED_AT` datetime DEFAULT NULL,
  `STATUS` enum('NEW','PENDING','CANCELLED','DONE') DEFAULT 'NEW',
  PRIMARY KEY (`ID`),
  KEY `FK_CUSTOMER_ID` (`CUSTOMER_ID`),
  KEY `FK_TOUR_ID` (`TOUR_ID`),
  CONSTRAINT `FK_CUSTOMER_ID` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customers` (`ID`),
  CONSTRAINT `FK_TOUR_ID` FOREIGN KEY (`TOUR_ID`) REFERENCES `tours` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_log`
--

LOCK TABLES `tour_log` WRITE;
/*!40000 ALTER TABLE `tour_log` DISABLE KEYS */;
INSERT INTO `tour_log` VALUES (1,1000084,2000000013,'2024-11-03 10:00:00','NEW');
/*!40000 ALTER TABLE `tour_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tours` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) NOT NULL,
  `KIND_TOUR` varchar(50) NOT NULL,
  `MAX_PEOPLE` tinyint(4) NOT NULL,
  `IMAGE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2000000026 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tours`
--


--
-- Cấu trúc cho view `fullinfo_employees`
--
DROP TABLE IF EXISTS `fullinfo_employees`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fullinfo_employees`  AS  select `a`.`ID` AS `ID`,`a`.`NAME` AS `NAME`,`a`.`IDCARD` AS `IDCARD`,`a`.`ADDRESS` AS `ADDRESS`,`a`.`PHONENUMBER` AS `PHONENUMBER`,`a`.`POSITION` AS `POSITION`,`a`.`PART_DAY` AS `PART_DAY`,`a`.`BIRTHDAY` AS `BIRTHDAY` from (`employees` `a` join `login` `b`) where `a`.`ID` = `b`.`ID` ;

-- --------------------------------------------------------

--
-- Cấu trúc cho DROP TABLE IF EXISTS `thongtinchitiettour`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `thongtinchitiettour`  AS  select `tours`.`ID` AS `ID`,`tours`.`NAME` AS `NAME`,`tours`.`KIND_TOUR` AS `KIND_TOUR`,`tours`.`MAX_PEOPLE` AS `MAX_PEOPLE`,`tours`.`IMAGE` AS `IMAGE`,`tour_details`.`START` AS `START`,`tour_details`.`END` AS `END`,`tour_details`.`HOTEL_NAME` AS `HOTEL_NAME`,`tour_details`.`VEHICLE` AS `VEHICLE`,`tour_details`.`CHILD_PRICE` AS `CHILD_PRICE`,`tour_details`.`ADULT_PRICE` AS `ADULT_PRICE`,`tour_details`.`TOUR_PROGRAM` AS `TOUR_PROGRAM` from (`tours` join `tour_details`) where `tours`.`ID` = `tour_details`.`ID` ; `thongtinchitiettour`
--
DROP TABLE IF EXISTS `thongtinchitiettour`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `thongtinchitiettour`  AS  select `tours`.`ID` AS `ID`,`tours`.`NAME` AS `NAME`,`tours`.`KIND_TOUR` AS `KIND_TOUR`,`tours`.`MAX_PEOPLE` AS `MAX_PEOPLE`,`tours`.`IMAGE` AS `IMAGE`,`tour_details`.`START` AS `START`,`tour_details`.`END` AS `END`,`tour_details`.`HOTEL_NAME` AS `HOTEL_NAME`,`tour_details`.`VEHICLE` AS `VEHICLE`,`tour_details`.`CHILD_PRICE` AS `CHILD_PRICE`,`tour_details`.`ADULT_PRICE` AS `ADULT_PRICE`,`tour_details`.`TOUR_PROGRAM` AS `TOUR_PROGRAM` from (`tours` join `tour_details`) where `tours`.`ID` = `tour_details`.`ID` ;


LOCK TABLES `tours` WRITE;
/*!40000 ALTER TABLE `tours` DISABLE KEYS */;
INSERT INTO `tours` VALUES (2000000001,'Japan-Tokyo-Hiroshima-Fuji 6 ngày 5 đêm','Nước Ngoài',20,'2.jpg'),(2000000006,'Paris-London-Monaco','Nước Ngoài',20,'paris.jpg'),(2000000009,'Tây Bắc -Thái Nguyên -Cao Bằng','Trong Nước',17,'taybac.jpg'),(2000000010,'Tây Bắc Thái Nguyên','Trong Nước',14,'thainguyen.jpg'),(2000000011,'Du Lịch Phan Thiết Thiên Đường Resort 2N2Đ','Trong Nước',10,'muine.jpg'),(2000000012,'Du lịch Đà Nẵng | Huế | Bà Nà Hills | Hội An 3N2Đ','Trong Nước',15,'hanoi.jpg'),(2000000013,'Du lịch Phú Quốc | Vinpearland | Tắm biển Bãi Sao 3N2Đ','Trong Nước',20,'phuquocnew.jpg'),(2000000014,'Malaysia- Kular Lumpur 3N2Đ','Nước Ngoài',15,'malaysia.jpg'),(2000000015,'Du lịch Hạ Long ','Trong Nước',10,'halong.jpg'),(2000000016,'Bangkok - Pattaya (Khách sạn 5* & 3*, Tặng buffet Baiyoke Sky, Tour Tiêu Chuẩn)  ','Nước Ngoài',20,'pattaya.jpg'),(2000000017,'Genting - Kuala Lumpur (Tour Tiết Kiệm) ','Tiết kiệm',10,'genting.jpg'),(2000000018,'Bắc Kinh - Phượng Hoàng Cổ Trấn - Trương Gia Giới (Chiêm ngưỡng cây cầu kính dài nhất Thế Giới','Nước Ngoài',20,'backinh.jpg'),(2000000025,'Trùng Khánh – Quý Dương – Hưng Nghĩa – Khu Du Lịch Vạn Phong Lâm –Thác Nước Hoàng Quả Thụ','Nước Ngoài',20,'Hong_Nhai_Dong.jpg');
/*!40000 ALTER TABLE `tours` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-19 21:37:56

ALTER TABLE `ql_tourdulich`.`tour_details` ADD COLUMN `EXPIRED` DATE NULL AFTER `TOUR_PROGRAM`, ADD COLUMN `IMAGE_DETAIL` TEXT NULL AFTER `EXPIRED`, ADD COLUMN `PDF` TEXT NULL AFTER `IMAGE_DETAIL`; 