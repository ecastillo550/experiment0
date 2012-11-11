-- MySQL dump 10.9
--
-- Host: localhost    Database: dokeos_main
-- ------------------------------------------------------
-- Server version	4.1.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


--
-- Table structure for table user
--

DROP TABLE IF EXISTS user;
CREATE TABLE user (
  user_id int unsigned NOT NULL auto_increment,
  lastname varchar(60) default NULL,
  firstname varchar(60) default NULL,
  username varchar(20) NOT NULL default '',
  password varchar(50) NOT NULL default '',
  auth_source varchar(50) default 'platform',
  email varchar(100) default NULL,
  status tinyint NOT NULL default '5',
  official_code varchar(40) default NULL,
  phone varchar(30) default NULL,
  picture_uri varchar(250) default NULL,
  creator_id int unsigned default NULL,
  competences text,
  diplomas text,
  openarea text,
  teach text,
  productions varchar(250) default NULL,
  chatcall_user_id int unsigned NOT NULL default '0',
  chatcall_date datetime NOT NULL default '0000-00-00 00:00:00',
  chatcall_text varchar(50) NOT NULL default '',
  language varchar(40) default NULL,
  registration_date datetime NOT NULL default '0000-00-00 00:00:00',
  expiration_date datetime NOT NULL default '0000-00-00 00:00:00',
  active tinyint unsigned NOT NULL default 1,
  openid varchar(255) DEFAULT NULL,
  theme varchar(255) DEFAULT NULL,
  hr_dept_id smallint unsigned NOT NULL default 0,
  login_counter INT(11), 
  login_failed_counter INT(11),
  country_code varchar(10) NOT NULL default '',
  civility     varchar(100) NOT NULL default '',
  payment_method  int NOT NULL default '1',
  default_enrolment int NOT NULL default '0',
  PRIMARY KEY  (user_id),
  UNIQUE KEY username (username)
);
ALTER TABLE user ADD INDEX (status);

--
-- Dumping data for table user
--

/*!40000 ALTER TABLE user DISABLE KEYS */;
LOCK TABLES user WRITE;
INSERT INTO user (lastname, firstname, username, password, auth_source, email, status, official_code,phone, creator_id, registration_date, expiration_date,active,openid,language) VALUES ('{ADMINLASTNAME}','{ADMINFIRSTNAME}','{ADMINLOGIN}','{ADMINPASSWORD}','{PLATFORM_AUTH_SOURCE}','{ADMINEMAIL}',1,'ADMIN','{ADMINPHONE}',1,NOW(),'0000-00-00 00:00:00','1',NULL,'{ADMINLANGUAGE}');
-- Insert anonymous user
INSERT INTO user (lastname, firstname, username, password, auth_source, email, status, official_code, creator_id, registration_date, expiration_date,active,openid,language) VALUES ('Anonymous', 'Joe', '', '', 'platform', 'anonymous@localhost', 6, 'anonymous', 1, NOW(), '0000-00-00 00:00:00', 1,NULL,'{ADMINLANGUAGE}');
UNLOCK TABLES;
/*!40000 ALTER TABLE user ENABLE KEYS */;

--
-- Table structure for table admin
--

DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
  user_id int unsigned NOT NULL default '0',
  UNIQUE KEY user_id (user_id)
);

--
-- Dumping data for table admin
--


/*!40000 ALTER TABLE admin DISABLE KEYS */;
LOCK TABLES admin WRITE;
INSERT INTO admin VALUES (1);
UNLOCK TABLES;
/*!40000 ALTER TABLE admin ENABLE KEYS */;

--
-- Table structure for table class
--

DROP TABLE IF EXISTS class;
CREATE TABLE class (
  id mediumint unsigned NOT NULL auto_increment,
  code varchar(40) default '',
  name text NOT NULL,
  PRIMARY KEY  (id)
);

--
-- Dumping data for table class
--


/*!40000 ALTER TABLE class DISABLE KEYS */;
LOCK TABLES class WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE class ENABLE KEYS */;

--
-- Table structure for table class_user
--

DROP TABLE IF EXISTS class_user;
CREATE TABLE class_user (
  class_id mediumint unsigned NOT NULL default '0',
  user_id int unsigned NOT NULL default '0',
  PRIMARY KEY  (class_id,user_id)
);

--
-- Dumping data for table class_user
--


/*!40000 ALTER TABLE class_user DISABLE KEYS */;
LOCK TABLES class_user WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE class_user ENABLE KEYS */;

--
-- Table structure for table course
--

DROP TABLE IF EXISTS course;
CREATE TABLE course (
  code varchar(40) NOT NULL,
  directory varchar(40) default NULL,
  db_name varchar(40) default NULL,
  course_language varchar(20) default NULL,
  title varchar(250) default NULL,
  description text,
  category_code varchar(40) default NULL,
  visibility tinyint default '0',
  show_score int NOT NULL default '1',
  tutor_name varchar(200) default NULL,
  visual_code varchar(40) default NULL,
  department_name varchar(30) default NULL,
  department_url varchar(180) default NULL,
  disk_quota bigint unsigned default NULL,
  last_visit datetime default NULL,
  last_edit datetime default NULL,
  creation_date datetime default NULL,
  expiration_date datetime default NULL,
  target_course_code varchar(40) default NULL,
  subscribe tinyint NOT NULL default '1',
  unsubscribe tinyint NOT NULL default '1',
  registration_code varchar(255) NOT NULL default '',
  default_enrolment int NOT NULL default '0',
  payment INT NULL DEFAULT '0',
  PRIMARY KEY  (code)
);

--
-- Dumping data for table course
--


/*!40000 ALTER TABLE course DISABLE KEYS */;
LOCK TABLES course WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE course ENABLE KEYS */;

--
-- Table structure for table course_category
--

DROP TABLE IF EXISTS course_category;
CREATE TABLE course_category (
  id int unsigned NOT NULL auto_increment,
  name varchar(100) NOT NULL default '',
  code varchar(40) NOT NULL default '',
  parent_id varchar(40) default NULL,
  tree_pos int unsigned default NULL,
  children_count smallint default NULL,
  auth_course_child enum('TRUE','FALSE') default 'TRUE',
  auth_cat_child enum('TRUE','FALSE') default 'TRUE',
  PRIMARY KEY  (id),
  UNIQUE KEY code (code),
  KEY parent_id (parent_id),
  KEY tree_pos (tree_pos)
);

--
-- Dumping data for table course_category
--


/*!40000 ALTER TABLE course_category DISABLE KEYS */;
LOCK TABLES course_category WRITE;
INSERT INTO course_category VALUES (1,'Language skills','LANG',NULL,1,0,'TRUE','TRUE'),(2,'PC Skills','PC',NULL,2,0,'TRUE','TRUE'),(3,'Projects','PROJ',NULL,3,0,'TRUE','TRUE');
UNLOCK TABLES;
/*!40000 ALTER TABLE course_category ENABLE KEYS */;

--
-- Table structure for table course_field
--

DROP TABLE IF EXISTS course_field;
CREATE TABLE course_field (
    id  int NOT NULL auto_increment,
    field_type int NOT NULL default 1,
    field_variable  varchar(64) NOT NULL,
    field_display_text  varchar(64),
    field_default_value text,
    field_order int,
    field_visible tinyint default 0,
    field_changeable tinyint default 0,
    field_filter tinyint default 0,
    tms TIMESTAMP,
    PRIMARY KEY(id)
);

--
-- Table structure for table course_field_values
--

DROP TABLE IF EXISTS course_field_values;
CREATE TABLE course_field_values(
    id  int NOT NULL auto_increment,
    course_code varchar(40) NOT NULL,
    field_id int NOT NULL,
    field_value text,
    tms TIMESTAMP,
    PRIMARY KEY(id)
);


--
-- Table structure for table course_module
--

DROP TABLE IF EXISTS course_module;
CREATE TABLE course_module (
  id int unsigned NOT NULL auto_increment,
  name varchar(100) NOT NULL,
  link varchar(255) NOT NULL,
  image varchar(100) default NULL,
  row int unsigned NOT NULL default '0',
  column int unsigned NOT NULL default '0',
  position varchar(20) NOT NULL default 'basic',
  PRIMARY KEY  (id)
);

--
-- Dumping data for table course_module
--


/*!40000 ALTER TABLE course_module DISABLE KEYS */;
LOCK TABLES course_module WRITE;
INSERT INTO course_module VALUES
(1,'calendar_event','calendar/agenda.php','agenda.png',1,1,'basic'),
(2,'link','link/link.php','links.gif',4,1,'basic'),
(3,'document','document/document.php','documents.gif',3,1,'basic'),
(4,'student_publication','work/work.php','works.gif',3,2,'basic'),
(5,'announcement','announcements/announcements.php','valves.png',2,1,'basic'),
(6,'user','user/user.php','members.gif',2,3,'basic'),
(7,'forum','forum/index.php','forum.gif',1,2,'basic'),
(8,'quiz','exercice/exercice.php','quiz.gif',2,2,'basic'),
(9,'group','group/group.php','group.gif',3,3,'basic'),
(10,'course_description','course_description/','info.gif',1,3,'basic'),
(11,'chat','chat/chat.php','chat.gif',0,0,'external'),
(12,'dropbox','dropbox/index.php','dropbox.gif',4,2,'basic'),
(13,'tracking','tracking/courseLog.php','statistics.png',1,3,'courseadmin'),
(14,'homepage_link','link/link.php?action=addlink','npage.gif',1,1,'courseadmin'),
(15,'course_setting','course_info/infocours.php','reference.gif',1,1,'courseadmin'),
(16,'External','','external.gif',0,0,'external'),
(17,'AddedLearnpath','','scormbuilder.gif',0,0,'external'),
(18,'conference','conference/index.php?type=conference','conf.gif',0,0,'external'),
(19,'conference','conference/index.php?type=classroom','conf.gif',0,0,'external'),
(20,'learnpath','newscorm/lp_controller.php','scorm.gif',5,1,'basic'),
(21,'blog','blog/blog.php','blog.gif',1,2,'basic'),
(22,'blog_management','blog/blog_admin.php','blog_admin.gif',1,2,'courseadmin'),
(23,'course_maintenance','course_info/maintenance.php','backup.gif',2,3,'courseadmin'),
(24,'survey','survey/survey_list.php','survey.gif',2,1,'basic'),
(25,'wiki','wiki/index.php','wiki.gif',2,3,'basic'),
(26,'gradebook','gradebook/index.php','gradebook.gif',2,2,'basic'),
(27,'glossary','glossary/index.php','glossary.gif',2,1,'basic'),
(28,'notebook','notebook/index.php','notebook.gif',2,1,'basic');
UNLOCK TABLES;
/*!40000 ALTER TABLE course_module ENABLE KEYS */;

--
-- Table structure for table course_rel_class
--

DROP TABLE IF EXISTS course_rel_class;
CREATE TABLE course_rel_class (
  course_code char(40) NOT NULL,
  class_id mediumint unsigned NOT NULL,
  PRIMARY KEY  (course_code,class_id)
);

--
-- Dumping data for table course_rel_class
--


/*!40000 ALTER TABLE course_rel_class DISABLE KEYS */;
LOCK TABLES course_rel_class WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE course_rel_class ENABLE KEYS */;

--
-- Table structure for table course_rel_user
--

DROP TABLE IF EXISTS course_rel_user;
CREATE TABLE course_rel_user (
  course_code varchar(40) NOT NULL,
  user_id int unsigned NOT NULL default '0',
  status tinyint NOT NULL default '5',
  role varchar(60) default NULL,
  group_id int NOT NULL default '0',
  tutor_id int unsigned NOT NULL default '0',
  sort int default NULL,
  user_course_cat int default '0',
  PRIMARY KEY  (course_code,user_id)
);
ALTER TABLE course_rel_user ADD INDEX (user_id);

--
-- Dumping data for table course_rel_user
--


/*!40000 ALTER TABLE course_rel_user DISABLE KEYS */;
LOCK TABLES course_rel_user WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE course_rel_user ENABLE KEYS */;

--
-- Table structure for table language
--

DROP TABLE IF EXISTS language;
CREATE TABLE language (
  id tinyint unsigned NOT NULL auto_increment,
  original_name varchar(255) default NULL,
  english_name varchar(255) default NULL,
  isocode varchar(10) default NULL,
  dokeos_folder varchar(250) default NULL,
  available tinyint NOT NULL default 1,
  parent_id tinyint unsigned,
  PRIMARY KEY  (id)
);
ALTER TABLE language ADD INDEX idx_language_dokeos_folder(dokeos_folder);

--
-- Dumping data for table language
--


/*!40000 ALTER TABLE language DISABLE KEYS */;
LOCK TABLES language WRITE;
INSERT INTO language (original_name, english_name, isocode, dokeos_folder, available) VALUES
('Arabija (el)','arabic','ar','arabic',0),
('Asturian','asturian','ast','asturian',0),
('Balgarski','bulgarian','bg','bulgarian',0),
('Bosanski','bosnian','bs','bosnian',1),
('Catal&agrave;','catalan','ca','catalan',0),
('Chinese (simplified)','simpl_chinese','zh','simpl_chinese',0),
('Chinese (traditional)','trad_chinese','zh-TW','trad_chinese',0),
('Czech','czech','cs','czech',0),
('Dansk','danish','da','danish',0),
('Dari','dari','prs','dari',0),
('Deutsch','german','de','german',1),
('Ellinika','greek','el','greek',0),
('English','english','en','english',1),
('Espa&ntilde;ol','spanish','es','spanish',1),
('Esperanto','esperanto','eo','esperanto',0),
('Euskara','euskera','eu','euskera',0),
('Farsi','persian','fa','persian',0),
('Fran&ccedil;ais','french','fr','french',1),
('Friulian','friulian','fur','friulian',0),
('Galego','galician','gl','galician',0),
('Georgian','georgian','ka','georgian',0),
('Hrvatski','croatian','hr','croatian',0),
('Hebrew','hebrew','he','hebrew',0),
('Indonesia (Bahasa I.)','indonesian','id','indonesian',1),
('Italiano','italian','it','italian',1),
('Korean','korean','ko','korean',0),
('Latvian','latvian','lv','latvian',0),
('Lithuanian','lithuanian','lt','lithuanian',0),
('Macedonian','macedonian','mk','macedonian',0),
('Magyar','hungarian','hu','hungarian',1),
('Melayu (Bahasa M.)','malay','ms','malay',0),
('Nederlands','dutch','nl','dutch',1),
('Nihongo','japanese','ja','japanese',0),
('Norsk','norwegian','no','norwegian',0),
('Occitan','occitan','oc','occitan',0),
('Pashto','pashto','ps','pashto',0),
('Polski','polish','pl','polish',0),
('Portugu&ecirc;s (Portugal)','portuguese','pt','portuguese',1),
('Portugu&ecirc;s (Brazil)','brazilian','pt-BR','brazilian',1),
('Romanian','romanian','ro','romanian',0),
('Runasimi','quechua_cusco','qu','quechua_cusco',0),
('Russkij','russian','ru','russian',0),
('Slovak','slovak','sk','slovak',0),
('Slovenscina','slovenian','sl','slovenian',1),
('Srpski','serbian','sr','serbian',0),
('Suomi','finnish','fi','finnish',0),
('Svenska','swedish','sv','swedish',0),
('Thai','thai','th','thai',0),
('T&uuml;rk&ccedil;e','turkce','tr','turkce',0),
('Ukrainian','ukrainian','uk','ukrainian',0),
('Vi&ecirc;t (Ti&ecirc;ng V.)','vietnamese','vi','vietnamese',0),
('Swahili (kiSw.)','swahili','sw','swahili',0),
('Yoruba','yoruba','yo','yoruba',0);

UNLOCK TABLES;
/*!40000 ALTER TABLE language ENABLE KEYS */;

--
-- Table structure for table slides
--

DROP TABLE IF EXISTS slides;
CREATE TABLE slides (
   id int(10) unsigned NOT NULL AUTO_INCREMENT,
   title varchar(255) NOT NULL DEFAULT '',
   alternate_text varchar(255) NOT NULL DEFAULT '',
   link varchar(255) NOT NULL DEFAULT '',
   caption text,
   image varchar(255) NOT NULL DEFAULT '',
   language varchar(255) NOT NULL DEFAULT 'English',
   display_order int(11) NOT NULL,
  PRIMARY KEY (id)
);

--
-- Table structure for table slides_management
--

DROP TABLE IF EXISTS slides_management;
CREATE TABLE slides_management (
   id int(11) NOT NULL AUTO_INCREMENT,
   show_slide int(11) NOT NULL DEFAULT '1',
   slide_speed int(11) NOT NULL DEFAULT '6',
  PRIMARY KEY (id)
);

--
-- Dumping data for table slides_management
--

LOCK TABLES slides_management WRITE;
INSERT INTO slides_management(id, show_slide, slide_speed) VALUES
(1, 1, 6);

UNLOCK TABLES;
/*!40000 ALTER TABLE slides_management ENABLE KEYS */;

--
-- Table structure for table php_session
--

DROP TABLE IF EXISTS php_session;
CREATE TABLE php_session (
  session_id varchar(32) NOT NULL default '',
  session_name varchar(10) NOT NULL default '',
  session_time int NOT NULL default '0',
  session_start int NOT NULL default '0',
  session_value mediumtext NOT NULL,
  PRIMARY KEY  (session_id)
);

--
-- Table structure for table sessions category
--

CREATE TABLE session_category (
  id int(11) NOT NULL auto_increment,
  name varchar(100) DEFAULT NULL,
  description text,
  topic int(11) NOT NULL DEFAULT '0',
  location varchar(250) DEFAULT NULL,
  modality varchar(255) DEFAULT NULL,
  keywords text,
  date_start date DEFAULT NULL,
  date_end date DEFAULT NULL,
  student_access varchar(50) DEFAULT NULL,
  language varchar(50) NOT NULL DEFAULT 'English',
  visible char(1) NOT NULL DEFAULT '0',
  cost float NOT NULL DEFAULT '0',
  currency varchar(250) DEFAULT NULL,
  tax int(11) NOT NULL DEFAULT '0',
  method_payment varchar(100) NOT NULL,
  code varchar(100) DEFAULT NULL,
  inscription_date_start date DEFAULT NULL,
  inscription_date_end date DEFAULT NULL,
  PRIMARY KEY  (id)
);

--
-- Table structure for table session
--
DROP TABLE IF EXISTS session;
CREATE TABLE session (
  id smallint unsigned NOT NULL auto_increment,
  id_coach int unsigned NOT NULL DEFAULT '0',
  name char(50) NOT NULL DEFAULT '',
  description text,
  nbr_courses smallint unsigned NOT NULL DEFAULT '0',
  nbr_users mediumint unsigned NOT NULL DEFAULT '0',
  nbr_classes mediumint unsigned NOT NULL DEFAULT '0',
  date_start date NOT NULL DEFAULT '0000-00-00',
  date_end date NOT NULL DEFAULT '0000-00-00',
  nb_days_access_before_beginning TINYINT UNSIGNED NULL DEFAULT '0',
  nb_days_access_after_end TINYINT UNSIGNED NULL DEFAULT '0',
  session_admin_id INT UNSIGNED NOT NULL,
  visibility int NOT NULL DEFAULT '1',
  session_category_id int NOT NULL,
  seats int(11) NOT NULL DEFAULT '-1',
  max_seats int(11) NOT NULL DEFAULT '-1',
  optional_subject int(11) NOT NULL DEFAULT '0',
  certif_template int(11) NOT NULL DEFAULT '0',
  certif_tool varchar(50) NOT NULL DEFAULT '',
  certif_min_score float(6,2) NOT NULL DEFAULT '0.00',
  certif_min_progress float(6,2) NOT NULL DEFAULT '0.00',
  cost float(6,2)  NOT NULL DEFAULT '0.00',
  PRIMARY KEY  (id),
  INDEX (session_admin_id),
  UNIQUE KEY name (name)
);

-- --------------------------------------------------------

--
-- Table structure for table session_rel_course
--
DROP TABLE IF EXISTS session_rel_course;
CREATE TABLE session_rel_course (
  id_session smallint unsigned NOT NULL DEFAULT '0',  
  course_code char(40) NOT NULL DEFAULT '',
  hours int(11) NOT NULL DEFAULT '0',
  schedule date NOT NULL DEFAULT '0000-00-00',
  time_from varchar(50) NOT NULL DEFAULT '00:00',
  time_to varchar(50) NOT NULL DEFAULT '00:00',
  repeats varchar(50) NOT NULL DEFAULT '',
  repeats_on varchar(50) NOT NULL DEFAULT '',
  ends_on int(11) NOT NULL DEFAULT '0',
  occurence varchar(50) NOT NULL DEFAULT '0',
  position int(11) NOT NULL DEFAULT '0',
  nbr_users smallint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (id_session,course_code),
  KEY course_code (course_code)
);

-- --------------------------------------------------------

--
-- Table structure for table session_rel_course_rel_user
--
DROP TABLE IF EXISTS session_rel_course_rel_user;
CREATE TABLE session_rel_course_rel_user (
  id_session smallint unsigned NOT NULL DEFAULT '0',
  course_code char(40) NOT NULL DEFAULT '',
  id_user int unsigned NOT NULL DEFAULT '0',
  visibility int NOT NULL DEFAULT '1',
  status int NOT NULL DEFAULT 0,
  PRIMARY KEY  (id_session,course_code,id_user),
  KEY id_user (id_user),
  KEY course_code (course_code)
);

-- --------------------------------------------------------

--
-- Table structure for table session_rel_user
--
DROP TABLE IF EXISTS session_rel_user;
CREATE TABLE session_rel_user (
  id_session mediumint unsigned NOT NULL DEFAULT '0',
  id_user mediumint unsigned NOT NULL DEFAULT '0',
status varchar(4) DEFAULT NULL,
  PRIMARY KEY  (id_session,id_user)
);

--
-- Table structure for table catalogue
--

DROP TABLE IF EXISTS catalogue;
CREATE TABLE catalogue (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) DEFAULT NULL,
  economic_model char(1) NOT NULL DEFAULT '0',
  visible char(1) NOT NULL DEFAULT '0',
  catalogue_display text,
  payment char(50) DEFAULT NULL,
  atos_account_number mediumint(8) unsigned NOT NULL DEFAULT '0',
  paypal_account_ref mediumint(8) unsigned NOT NULL DEFAULT '0',
  second_installment mediumint(8) unsigned NOT NULL DEFAULT '0',
  second_installment_delay mediumint(8) unsigned NOT NULL DEFAULT '0',
  third_installment mediumint(8) unsigned NOT NULL DEFAULT '0',
  third_installment_delay mediumint(8) unsigned NOT NULL DEFAULT '0',
  options_selection text,
  payment_message text,
  cc_payment_message text,
  installment_payment_message text,
  cheque_payment_message text,
  email char(1) NOT NULL DEFAULT '0',
  company_logo varchar(255) DEFAULT NULL,
  company_address text,
  bank_details text,
  cheque_message text,
  terms_conditions text,
  tva_description text,
  currency VARCHAR( 5 ) NOT NULL DEFAULT  '840'  COMMENT  'default value 840 iso code for usd dollars',    
  PRIMARY KEY (id)
);

--
-- Table structure for table session_category_rel_user
--

DROP TABLE IF EXISTS session_category_rel_user;
CREATE TABLE session_category_rel_user (
  category_id int(11) NOT NULL DEFAULT '0',
  user_id int(11) NOT NULL DEFAULT '0',
  session_id int(11) NOT NULL DEFAULT '0',
  course_code varchar(200) DEFAULT NULL
);

--
-- Table structure for table session_rel_category
--

DROP TABLE IF EXISTS session_rel_category;
CREATE TABLE session_rel_category (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  category_id int(11) DEFAULT '0',
  session_set char(1) NOT NULL DEFAULT '1',
  session_set_name varchar(255) DEFAULT NULL,
  session_id int(11) NOT NULL DEFAULT '0',
  session_range varchar(20) DEFAULT NULL,
  PRIMARY KEY (id)
);

--
-- Table structure for table topic
--

DROP TABLE IF EXISTS topic;
CREATE TABLE topic (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  topic varchar(255) DEFAULT NULL,
  language char(50) NOT NULL DEFAULT 'English',
  visible char(1) NOT NULL DEFAULT '0',
  catalogue_id int(11) DEFAULT NULL,
  PRIMARY KEY (id)
);


DROP TABLE IF EXISTS session_field;
CREATE TABLE session_field (
    id  int NOT NULL auto_increment,
    field_type int NOT NULL default 1,
    field_variable  varchar(64) NOT NULL,
    field_display_text  varchar(64),
    field_default_value text,
    field_order int,
    field_visible tinyint default 0,
    field_changeable tinyint default 0,
    field_filter tinyint default 0,
    tms TIMESTAMP,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS session_field_values;
CREATE TABLE session_field_values(
    id  int NOT NULL auto_increment,
    session_id int NOT NULL,
    field_id int NOT NULL,
    field_value text,
    tms TIMESTAMP,
    PRIMARY KEY(id)
);

--
-- Table structure for course_ecommerce
--
DROP TABLE IF EXISTS lp_module ;

CREATE  TABLE IF NOT EXISTS lp_module (
  lp_module_id INT(10) UNSIGNED NOT NULL ,
  course_code VARCHAR(40) NOT NULL ,
  lp_title TINYTEXT NULL ,
  lp_description TINYTEXT NULL ,
  PRIMARY KEY (lp_module_id, course_code)
  )
ENGINE = MyISAM;
-- -----------------------------------------------------
-- Table ecommerce_items
-- -----------------------------------------------------
DROP TABLE IF EXISTS ecommerce_items ;

CREATE  TABLE IF NOT EXISTS ecommerce_items (
  id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT ,
  code VARCHAR(255) NOT NULL ,
  cost DECIMAL(10,2) NOT NULL DEFAULT '0.00' ,
  item_type TINYINT(2) NOT NULL DEFAULT '0' ,
  status TINYINT(2) NOT NULL DEFAULT '0' ,
  currency TINYINT(2) NOT NULL DEFAULT '0' ,
  date_start DATE NOT NULL DEFAULT '0000-00-00' ,
  date_end DATE NOT NULL DEFAULT '0000-00-00' ,
  PRIMARY KEY (id) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table lp_module_packs
-- -----------------------------------------------------
DROP TABLE IF EXISTS lp_module_packs ;

CREATE  TABLE IF NOT EXISTS lp_module_packs (
  ecommerce_items_id MEDIUMINT(8) UNSIGNED NOT NULL ,
  lp_module_lp_module_id INT(10) UNSIGNED NOT NULL ,
  lp_module_course_code VARCHAR(40) NOT NULL ,
  PRIMARY KEY (ecommerce_items_id, lp_module_lp_module_id, lp_module_course_code))
ENGINE = MyISAM;

-- -----------------------------------------------------
-- User permissions
-- -----------------------------------------------------
create table ecommerce_user_privileges(
	user_id int(10) UNSIGNED NOT NULL,
	ecommerce_items_id mediumint(8) UNSIGNED  NOT NULL,
	role varchar(60) DEFAULT NULL,
	group_id int(11) NOT NULL,
	tutor_id int(11) NOT NULL,
	sort int(11) DEFAULT NULL,
	user_course_cat int(11) DEFAULT 0,
PRIMARY KEY (  user_id ,  ecommerce_items_id )
);  



--
-- Table structure for table settings_current
--

DROP TABLE IF EXISTS settings_current;
CREATE TABLE settings_current (
  id int unsigned NOT NULL auto_increment,
  variable varchar(255) default NULL,
  subkey varchar(255) default NULL,
  type varchar(255) default NULL,
  category varchar(255) default NULL,
  subcategory varchar(250) default NULL,
  selected_value varchar(255) default NULL,
  title varchar(255) NOT NULL default '',
  comment varchar(255) default NULL,
  scope varchar(50) default NULL,
  subkeytext varchar(255) default NULL,
  access_url int unsigned not null default 1,
  access_url_changeable int unsigned not null default 0,
  PRIMARY KEY id (id),
  INDEX (access_url)
);

ALTER TABLE settings_current ADD UNIQUE unique_setting ( variable , subkey , category, access_url) ;

--
-- Dumping data for table settings_current
--

/*!40000 ALTER TABLE settings_current DISABLE KEYS */;
LOCK TABLES settings_current WRITE;
INSERT INTO settings_current
(variable, subkey, type, category, selected_value, title, comment, scope, subkeytext, access_url_changeable)
VALUES
('Institution', NULL, 'textfield', 'Platform', 'Organisation', 'InstitutionTitle', 'InstitutionComment', NULL, NULL, 1),
('InstitutionUrl', NULL, 'textfield', 'Platform', 'http://www.dokeos.com', 'InstitutionUrlTitle', 'InstitutionUrlComment', NULL, NULL, 1),
('siteName', NULL, 'textfield', 'Platform', 'Academy', 'SiteNameTitle', 'SiteNameComment', NULL, NULL, 1),
('emailAdministrator', NULL, 'textfield', 'Platform', 'newportal@dokeos.com', 'emailAdministratorTitle', 'emailAdministratorComment', NULL, NULL, 1),
('administratorSurname', NULL, 'textfield', 'Platform', 'Doe', 'administratorSurnameTitle', 'administratorSurnameComment', NULL, NULL, 1),
('administratorName', NULL, 'textfield', 'Platform', 'John', 'administratorNameTitle', 'administratorNameComment', NULL, NULL, 1),
('show_administrator_data', NULL, 'radio', 'Platform', 'true', 'ShowAdministratorDataTitle', 'ShowAdministratorDataComment', NULL, NULL, 1),
('show_tutor_data', NULL, 'radio', 'Platform', 'true', 'ShowTutorDataTitle', 'ShowTutorDataComment', NULL, NULL, 1),
('show_teacher_data', NULL, 'radio', 'Platform', 'true', 'ShowTeacherDataTitle', 'ShowTeacherDataComment', NULL, NULL, 1),
('homepage_view', NULL, 'radio', 'Advanced', 'activity', 'HomepageViewTitle', 'HomepageViewComment', '0', NULL, 1),
('show_toolshortcuts', NULL, 'radio', 'Advanced', 'false', 'ShowToolShortcutsTitle', 'ShowToolShortcutsComment', NULL, NULL, 1),
('allow_group_categories', NULL, 'radio', 'Advanced', 'false', 'AllowGroupCategories', 'AllowGroupCategoriesComment', NULL, NULL, 1),
('server_type', NULL, 'radio', 'Advanced', 'production', 'ServerStatusTitle', 'ServerStatusComment', NULL, NULL, 1),
('platformLanguage', NULL, 'link', 'Languages', 'english', 'PlatformLanguageTitle', 'PlatformLanguageComment', NULL, NULL, 1),
('showonline', 'world', 'checkbox', 'Advanced', 'true', 'ShowOnlineTitle', 'ShowOnlineComment', NULL, 'ShowOnlineWorld', 1),
('showonline', 'users', 'checkbox', 'Advanced', 'true', 'ShowOnlineTitle', 'ShowOnlineComment', NULL, 'ShowOnlineUsers', 1),
('showonline', 'course', 'checkbox', 'Advanced', 'true', 'ShowOnlineTitle', 'ShowOnlineComment', NULL, 'ShowOnlineCourse', 1),
('profile', 'name', 'checkbox', 'User', 'true', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'name', 1),
('profile', 'officialcode', 'checkbox', 'User', 'false', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'officialcode', 1),
('profile', 'email', 'checkbox', 'User', 'true', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'Email', 1),
('profile', 'picture', 'checkbox', 'User', 'true', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'UserPicture', 1),
('profile', 'login', 'checkbox', 'User', 'false', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'Login', 1),
('profile', 'password', 'checkbox', 'User', 'true', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'UserPassword', 1),
('profile', 'language', 'checkbox', 'User', 'true', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'Language', 1),
('default_category_course', NULL, 'textfield', 'Course', 'Default category', 'DefaultCategoryName', 'DefaultCategoryComment', NULL, NULL, 1),
('default_document_quotum', NULL, 'textfield', 'Course', '500000000', 'DefaultDocumentQuotumTitle', 'DefaultDocumentQuotumComment', NULL, NULL, 1),
('registration', 'officialcode', 'checkbox', 'User', 'false', 'RegistrationRequiredFormsTitle', 'RegistrationRequiredFormsComment', NULL, 'OfficialCode', 1),
('registration', 'email', 'checkbox', 'User', 'true', 'RegistrationRequiredFormsTitle', 'RegistrationRequiredFormsComment', NULL, 'Email', 1),
('registration', 'language', 'checkbox', 'User', 'true', 'RegistrationRequiredFormsTitle', 'RegistrationRequiredFormsComment', NULL, 'Language', 1),
('default_group_quotum', NULL, 'textfield', 'Course', '5000000', 'DefaultGroupQuotumTitle', 'DefaultGroupQuotumComment', NULL, NULL, 1),
('allow_registration', NULL, 'radio', 'Platform', 'true', 'AllowRegistrationTitle', 'AllowRegistrationComment', NULL, NULL, 1),
('allow_registration_as_teacher', NULL, 'radio', 'Platform', 'true', 'AllowRegistrationAsTeacherTitle', 'AllowRegistrationAsTeacherComment', NULL, NULL, 1),
('allow_lostpassword', NULL, 'radio', 'Platform', 'true', 'AllowLostPasswordTitle', 'AllowLostPasswordComment', NULL, NULL, 1),
('allow_user_headings', NULL, 'radio', 'Advanced', 'false', 'AllowUserHeadings', 'AllowUserHeadingsComment', NULL, NULL, 1),
('course_create_active_tools', 'course_description', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'CourseDescription', 1),
('course_create_active_tools', 'agenda', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Agenda', 1),
('course_create_active_tools', 'documents', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Documents', 1),
('course_create_active_tools', 'learning_path', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'LearningPath', 1),
('course_create_active_tools', 'links', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Links', 1),
('course_create_active_tools', 'announcements', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Announcements', 1),
('course_create_active_tools', 'forums', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Forums', 1),
('course_create_active_tools', 'dropbox', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Dropbox', 1),
('course_create_active_tools', 'quiz', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Quiz', 1),
('course_create_active_tools', 'users', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Users', 1),
('course_create_active_tools', 'groups', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Groups', 1),
('course_create_active_tools', 'chat', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Chat', 1),
('course_create_active_tools', 'online_conference', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'OnlineConference', 1),
('course_create_active_tools', 'student_publications', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'StudentPublications', 1),
('allow_personal_agenda', NULL, 'radio', 'User', 'true', 'AllowPersonalAgendaTitle', 'AllowPersonalAgendaComment', NULL, NULL, 1),
('display_coursecode_in_courselist', NULL, 'radio', 'Advanced', 'true', 'DisplayCourseCodeInCourselistTitle', 'DisplayCourseCodeInCourselistComment', NULL, NULL, 1),
('display_teacher_in_courselist', NULL, 'radio', 'Advanced', 'true', 'DisplayTeacherInCourselistTitle', 'DisplayTeacherInCourselistComment', NULL, NULL, 1),
('use_document_title', NULL, 'radio', 'Tools', 'true', 'UseDocumentTitleTitle', 'UseDocumentTitleComment', NULL, NULL, 1),
('permanently_remove_deleted_files', NULL, 'radio', 'Tools', 'false', 'PermanentlyRemoveFilesTitle', 'PermanentlyRemoveFilesComment', NULL, NULL, 1),
('dropbox_allow_overwrite', NULL, 'radio', 'Advanced', 'true', 'DropboxAllowOverwriteTitle', 'DropboxAllowOverwriteComment', NULL, NULL, 1),
('dropbox_max_filesize', NULL, 'textfield', 'Advanced', '100000000', 'DropboxMaxFilesizeTitle', 'DropboxMaxFilesizeComment', NULL, NULL, 1),
('dropbox_allow_just_upload', NULL, 'radio', 'Advanced', 'true', 'DropboxAllowJustUploadTitle', 'DropboxAllowJustUploadComment', NULL, NULL, 1),
('dropbox_allow_student_to_student', NULL, 'radio', 'Advanced', 'true', 'DropboxAllowStudentToStudentTitle', 'DropboxAllowStudentToStudentComment', NULL, NULL, 1),
('dropbox_allow_group', NULL, 'radio', 'Advanced', 'true', 'DropboxAllowGroupTitle', 'DropboxAllowGroupComment', NULL, NULL, 1),
('dropbox_allow_mailing', NULL, 'radio', 'Advanced', 'false', 'DropboxAllowMailingTitle', 'DropboxAllowMailingComment', NULL, NULL, 1),
('administratorTelephone', NULL, 'textfield', 'Advanced', '(000) 001 02 03', 'administratorTelephoneTitle', 'administratorTelephoneComment', NULL, NULL, 1),
('extended_profile', NULL, 'radio', 'Advanced', 'true', 'ExtendedProfileTitle', 'ExtendedProfileComment', NULL, NULL, 1),
('student_view_enabled', NULL, 'radio', 'Advanced', 'true', 'StudentViewEnabledTitle', 'StudentViewEnabledComment', NULL, NULL, 1),
('show_navigation_menu', NULL, 'radio', 'Advanced', 'false', 'ShowNavigationMenuTitle', 'ShowNavigationMenuComment', NULL, NULL, 1),
('enable_tool_introduction', NULL, 'radio', 'course', 'false', 'EnableToolIntroductionTitle', 'EnableToolIntroductionComment', NULL, NULL, 1),
('page_after_login', NULL, 'radio', 'Advanced', 'user_portal.php', 'PageAfterLoginTitle', 'PageAfterLoginComment', NULL, NULL, 1),
('time_limit_whosonline', NULL, 'textfield', 'Advanced', '30', 'TimeLimitWhosonlineTitle', 'TimeLimitWhosonlineComment', NULL, NULL, 1),
('breadcrumbs_course_homepage', NULL, 'radio', 'Advanced', 'session_name_and_course_title', 'BreadCrumbsCourseHomepageTitle', 'BreadCrumbsCourseHomepageComment', NULL, NULL, 1),
('example_material_course_creation', NULL, 'radio', 'Advanced', 'true', 'ExampleMaterialCourseCreationTitle', 'ExampleMaterialCourseCreationComment', NULL, NULL, 1),
('account_valid_duration', NULL, 'textfield', 'Advanced', '3660', 'AccountValidDurationTitle', 'AccountValidDurationComment', NULL, NULL, 1),
('use_session_mode', NULL, 'radio', 'Platform', 'true', 'UseSessionModeTitle', 'UseSessionModeComment', NULL, NULL, 1),
('allow_email_editor', NULL, 'radio', 'Tools', 'false', 'AllowEmailEditorTitle', 'AllowEmailEditorComment', NULL, NULL, 1),
('registered', NULL, 'textfield', NULL, 'false', NULL, NULL, NULL, NULL, 1),
('donotlistcampus', NULL, 'textfield', NULL, 'false', NULL, NULL, NULL, NULL, 1),
('show_email_addresses', NULL, 'radio', 'Advanced', 'false', 'ShowEmailAddresses', 'ShowEmailAddressesComment', NULL, NULL, 1),
('profile', 'phone', 'checkbox', 'User', 'true', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'phone', 1),
('service_visio', 'active', 'radio', NULL, 'false', 'VisioEnable', NULL, NULL, NULL, 1),
('service_visio', 'visio_host', 'textfield', NULL, NULL, 'VisioHost', NULL, NULL, NULL, 1),
('service_visio', 'visio_port', 'textfield', NULL, '1935', 'VisioPort', NULL, NULL, NULL, 1),
('service_visio', 'visio_pass', 'textfield', NULL, NULL, 'VisioPassword', NULL, NULL, NULL, 1),
('service_ppt2lp', 'active', 'radio', NULL, 'false', 'ppt2lp_actived', NULL, NULL, NULL, 1),
('service_ppt2lp', 'host', 'textfield', NULL, NULL, 'Host', NULL, NULL, NULL, 1),
('service_ppt2lp', 'port', 'textfield', NULL, '2002', 'Port', NULL, NULL, NULL, 1),
('service_ppt2lp', 'user', 'textfield', NULL, NULL, 'UserOnHost', NULL, NULL, NULL, 1),
('service_ppt2lp', 'ftp_password', 'textfield', NULL, NULL, 'FtpPassword', NULL, NULL, NULL, 1),
('service_ppt2lp', 'path_to_lzx', 'textfield', NULL, NULL, NULL, NULL, NULL, NULL, 1),
('service_ppt2lp', 'size', 'radio', NULL, '720x540', NULL, NULL, NULL, NULL, 1),
('wcag_anysurfer_public_pages', NULL, 'radio', 'Editor', 'false', 'PublicPagesComplyToWAITitle', 'PublicPagesComplyToWAIComment', NULL, NULL, 1),
('stylesheets', NULL, 'textfield', 'stylesheets', 'dokeos2_black_tablet', NULL, NULL, NULL, NULL, 1),
('upload_extensions_list_type', NULL, 'radio', 'Security', 'blacklist', 'UploadExtensionsListType', 'UploadExtensionsListTypeComment', NULL, NULL, 1),
('upload_extensions_blacklist', NULL, 'textfield', 'Security', NULL, 'UploadExtensionsBlacklist', 'UploadExtensionsBlacklistComment', NULL, NULL, 1),
('upload_extensions_whitelist', NULL, 'textfield', 'Security', 'htm;html;jpg;jpeg;gif;png;swf;avi;mpg;mpeg;mov;flv;doc;docx;xls;xlsx;ppt;pptx;odt;odp;ods;pdf', 'UploadExtensionsWhitelist', 'UploadExtensionsWhitelistComment', NULL, NULL, 1),
('upload_extensions_skip', NULL, 'radio', 'Security', 'true', 'UploadExtensionsSkip', 'UploadExtensionsSkipComment', NULL, NULL, 1),
('upload_extensions_replace_by', NULL, 'textfield', 'Security', 'dangerous', 'UploadExtensionsReplaceBy', 'UploadExtensionsReplaceByComment', NULL, NULL, 1),
('show_number_of_courses', NULL, 'radio', 'Advanced', 'false', 'ShowNumberOfCourses', 'ShowNumberOfCoursesComment', NULL, NULL, 1),
('show_empty_course_categories', NULL, 'radio', 'Advanced', 'true', 'ShowEmptyCourseCategories', 'ShowEmptyCourseCategoriesComment', NULL, NULL, 1),
('show_back_link_on_top_of_tree', NULL, 'radio', 'Advanced', 'false', 'ShowBackLinkOnTopOfCourseTree', 'ShowBackLinkOnTopOfCourseTreeComment', NULL, NULL, 1),
('show_different_course_language', NULL, 'radio', 'Advanced', 'true', 'ShowDifferentCourseLanguage', 'ShowDifferentCourseLanguageComment', NULL, NULL, 1),
('split_users_upload_directory', NULL, 'radio', 'Advanced', 'false', 'SplitUsersUploadDirectory', 'SplitUsersUploadDirectoryComment', NULL, NULL, 1),
('hide_dltt_markup', NULL, 'radio', 'Advanced', 'true', 'HideDLTTMarkup', 'HideDLTTMarkupComment', NULL, NULL, 1),
('display_categories_on_homepage', NULL, 'radio', 'Advanced', 'false', 'DisplayCategoriesOnHomepageTitle', 'DisplayCategoriesOnHomepageComment', NULL, NULL, 1),
('permissions_for_new_directories', NULL, 'textfield', 'Security', '777', 'PermissionsForNewDirs', 'PermissionsForNewDirsComment', NULL, NULL, 1),
('permissions_for_new_files', NULL, 'textfield', 'Security', '666', 'PermissionsForNewFiles', 'PermissionsForNewFilesComment', NULL, NULL, 1),
('show_tabs', 'campus_homepage', 'checkbox', 'Platform', 'true', 'ShowTabsTitle', 'ShowTabsComment', NULL, 'TabsCampusHomepage', 1),
('show_tabs', 'my_courses', 'checkbox', 'Platform', 'true', 'ShowTabsTitle', 'ShowTabsComment', NULL, 'TabsMyCourses', 1),
('show_tabs', 'reporting', 'checkbox', 'Platform', 'true', 'ShowTabsTitle', 'ShowTabsComment', NULL, 'TabsReporting', 1),
('show_tabs', 'platform_administration', 'checkbox', 'Platform', 'true', 'ShowTabsTitle', 'ShowTabsComment', NULL, 'TabsPlatformAdministration', 1),
('show_tabs', 'my_agenda', 'checkbox', 'Platform', 'true', 'ShowTabsTitle', 'ShowTabsComment', NULL, 'TabsMyAgenda', 1),
('show_tabs', 'my_profile', 'checkbox', 'Platform', 'false', 'ShowTabsTitle', 'ShowTabsComment', NULL, 'TabsMyProfile', 1),
('show_tabs', 'search', 'checkbox', 'Platform', 'false', 'ShowTabsTitle', 'ShowTabsComment', NULL, 'TabsSearch', 1),
('default_forum_view', NULL, 'radio', 'Course', 'flat', 'DefaultForumViewTitle', 'DefaultForumViewComment', NULL, NULL, 1),
('platform_charset', NULL, 'textfield', 'Advanced', 'iso-8859-15', 'PlatformCharsetTitle', 'PlatformCharsetComment', 'platform', NULL, 1),
('noreply_email_address', NULL, 'textfield', 'Advanced', NULL, 'NoReplyEmailAddress', 'NoReplyEmailAddressComment', NULL, NULL, 1),
('survey_email_sender_noreply', NULL, 'radio', 'Course', 'coach', 'SurveyEmailSenderNoReply', 'SurveyEmailSenderNoReplyComment', NULL, NULL, 1),
('openid_authentication', NULL, 'radio', 'Security', 'false', 'OpenIdAuthentication', 'OpenIdAuthenticationComment', NULL, NULL, 1),
('profile', 'openid', 'checkbox', 'User', 'false', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'OpenIDURL', 1),
('gradebook_enable', NULL, 'radio', 'Advanced', 'true', 'GradebookActivation', 'GradebookActivationComment', NULL, NULL, 1),
('show_tabs', 'my_gradebook', 'checkbox', 'Platform', 'true', 'ShowTabsTitle', 'ShowTabsComment', NULL, 'TabsMyGradebook', 1),
('gradebook_score_display_coloring', 'my_display_coloring', 'checkbox', 'Advanced', 'false', 'GradebookScoreDisplayColoring', 'GradebookScoreDisplayColoringComment', NULL, 'TabsGradebookEnableColoring', 1),
('gradebook_score_display_custom', 'my_display_custom', 'checkbox', 'Advanced', 'false', 'GradebookScoreDisplayCustom', 'GradebookScoreDisplayCustomComment', NULL, 'TabsGradebookEnableCustom', 1),
('gradebook_score_display_colorsplit', NULL, 'textfield', 'Advanced', '50', 'GradebookScoreDisplayColorSplit', 'GradebookScoreDisplayColorSplitComment', NULL, NULL, 1),
('gradebook_score_display_upperlimit', 'my_display_upperlimit', 'checkbox', 'Advanced', 'false', 'GradebookScoreDisplayUpperLimit', 'GradebookScoreDisplayUpperLimitComment', NULL, 'TabsGradebookEnableUpperLimit', 1),
('user_selected_theme', NULL, 'radio', 'Advanced', 'false', 'UserThemeSelection', 'UserThemeSelectionComment', NULL, NULL, 1),
('profile', 'theme', 'checkbox', 'User', 'false', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'UserTheme', 1),
('allow_course_theme', NULL, 'radio', 'Advanced', 'true', 'AllowCourseThemeTitle', 'AllowCourseThemeComment', NULL, NULL, 1),
('display_mini_month_calendar', NULL, 'radio', 'Advanced', 'true', 'DisplayMiniMonthCalendarTitle', 'DisplayMiniMonthCalendarComment', NULL, NULL, 1),
('display_upcoming_events', NULL, 'radio', 'Advanced', 'true', 'DisplayUpcomingEventsTitle', 'DisplayUpcomingEventsComment', NULL, NULL, 1),
('number_of_upcoming_events', NULL, 'textfield', 'Advanced', '1', 'NumberOfUpcomingEventsTitle', 'NumberOfUpcomingEventsComment', NULL, NULL, 1),
('show_closed_courses', NULL, 'radio', 'Advanced', 'false', 'ShowClosedCoursesTitle', 'ShowClosedCoursesComment', NULL, NULL, 1),
('ldap_main_server_address', NULL, 'textfield', 'LDAP', 'localhost', 'LDAPMainServerAddressTitle', 'LDAPMainServerAddressComment', NULL, NULL, 1),
('ldap_main_server_port', NULL, 'textfield', 'LDAP', '389', 'LDAPMainServerPortTitle', 'LDAPMainServerPortComment', NULL, NULL, 1),
('ldap_domain', NULL, 'textfield', 'LDAP', 'dc=nodomain', 'LDAPDomainTitle', 'LDAPDomainComment', NULL, NULL, 1),
('ldap_replicate_server_address', NULL, 'textfield', 'LDAP', 'localhost', 'LDAPReplicateServerAddressTitle', 'LDAPReplicateServerAddressComment', NULL, NULL, 1),
('ldap_replicate_server_port', NULL, 'textfield', 'LDAP', '389', 'LDAPReplicateServerPortTitle', 'LDAPReplicateServerPortComment', NULL, NULL, 1),
('ldap_search_term', NULL, 'textfield', 'LDAP', NULL, 'LDAPSearchTermTitle', 'LDAPSearchTermComment', NULL, NULL, 1),
('ldap_version', NULL, 'radio', 'LDAP', '3', 'LDAPVersionTitle', 'LDAPVersionComment', NULL, NULL, 1),
('ldap_filled_tutor_field', NULL, 'textfield', 'LDAP', 'employeenumber', 'LDAPFilledTutorFieldTitle', 'LDAPFilledTutorFieldComment', NULL, NULL, 1),
('ldap_authentication_login', NULL, 'textfield', 'LDAP', NULL, 'LDAPAuthenticationLoginTitle', 'LDAPAuthenticationLoginComment', NULL, NULL, 1),
('ldap_authentication_password', NULL, 'textfield', 'LDAP', NULL, 'LDAPAuthenticationPasswordTitle', 'LDAPAuthenticationPasswordComment', NULL, NULL, 1),
('service_visio', 'visio_use_rtmpt', 'radio', NULL, 'false', 'VisioUseRtmptTitle', 'VisioUseRtmptComment', NULL, NULL, 1),
('extendedprofile_registration', 'mycomptetences', 'checkbox', 'Advanced', 'false', 'ExtendedProfileRegistrationTitle', 'ExtendedProfileRegistrationComment', NULL, 'MyCompetences', 1),
('extendedprofile_registration', 'mydiplomas', 'checkbox', 'Advanced', 'false', 'ExtendedProfileRegistrationTitle', 'ExtendedProfileRegistrationComment', NULL, 'MyDiplomas', 1),
('extendedprofile_registration', 'myteach', 'checkbox', 'Advanced', 'false', 'ExtendedProfileRegistrationTitle', 'ExtendedProfileRegistrationComment', NULL, 'MyTeach', 1),
('extendedprofile_registration', 'mypersonalopenarea', 'checkbox', 'Advanced', 'false', 'ExtendedProfileRegistrationTitle', 'ExtendedProfileRegistrationComment', NULL, 'MyPersonalOpenArea', 1),
('extendedprofile_registrationrequired', 'mycomptetences', 'checkbox', 'Advanced', 'false', 'ExtendedProfileRegistrationRequiredTitle', 'ExtendedProfileRegistrationRequiredComment', NULL, 'MyCompetences', 1),
('extendedprofile_registrationrequired', 'mydiplomas', 'checkbox', 'Advanced', 'false', 'ExtendedProfileRegistrationRequiredTitle', 'ExtendedProfileRegistrationRequiredComment', NULL, 'MyDiplomas', 1),
('extendedprofile_registrationrequired', 'myteach', 'checkbox', 'Advanced', 'false', 'ExtendedProfileRegistrationRequiredTitle', 'ExtendedProfileRegistrationRequiredComment', NULL, 'MyTeach', 1),
('extendedprofile_registrationrequired', 'mypersonalopenarea', 'checkbox', 'Advanced', 'false', 'ExtendedProfileRegistrationRequiredTitle', 'ExtendedProfileRegistrationRequiredComment', NULL, 'MyPersonalOpenArea', 1),
('ldap_filled_tutor_field_value', NULL, 'textfield', 'LDAP', NULL, 'LDAPFilledTutorFieldValueTitle', 'LDAPFilledTutorFieldValueComment', NULL, NULL, 1),
('registration', 'phone', 'textfield', 'User', 'false', 'RegistrationRequiredFormsTitle', 'RegistrationRequiredFormsComment', NULL, 'Phone', 1),
('add_users_by_coach', NULL, 'radio', 'Security', 'false', 'AddUsersByCoachTitle', 'AddUsersByCoachComment', NULL, NULL, 1),
('extend_rights_for_coach', NULL, 'radio', 'Security', 'false', 'ExtendRightsForCoachTitle', 'ExtendRightsForCoachComment', NULL, NULL, 1),
('extend_rights_for_coach_on_survey', NULL, 'radio', 'Security', 'true', 'ExtendRightsForCoachOnSurveyTitle', 'ExtendRightsForCoachOnSurveyComment', NULL, NULL, 1),
('course_create_active_tools', 'wiki', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Wiki', 1),
('show_session_coach', NULL, 'radio', 'Platform', 'false', 'ShowSessionCoachTitle', 'ShowSessionCoachComment', NULL, NULL, 1),
('course_create_active_tools', 'Advanced', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Gradebook', 1),
('allow_users_to_create_courses', NULL, 'radio', 'Platform', 'true', 'AllowUsersToCreateCoursesTitle', 'AllowUsersToCreateCoursesComment', NULL, NULL, 1),
('course_create_active_tools', 'survey', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Survey', 1),
('course_create_active_tools', 'glossary', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Glossary', 1),
('course_create_active_tools', 'notebook', 'checkbox', 'Tools', 'true', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Notebook', 1),
('advanced_filemanager', NULL, 'radio', 'Advanced', 'false', 'AdvancedFileManagerTitle', 'AdvancedFileManagerComment', NULL, NULL, 1),
('allow_reservation', NULL, 'radio', 'Advanced', 'false', 'AllowReservationTitle', 'AllowReservationComment', NULL, NULL, 1),
('profile', 'apikeys', 'checkbox', 'User', 'false', 'ProfileChangesTitle', 'ProfileChangesComment', NULL, 'ApiKeys', 1),
('allow_message_tool', NULL, 'radio', 'Advanced', 'true', 'AllowMessageToolTitle', 'AllowMessageToolComment', NULL, NULL, 1),
('allow_social_tool', NULL, 'radio', 'Tools', 'true', 'AllowSocialToolTitle', 'AllowSocialToolComment', NULL, NULL, 1),
('allow_students_to_browse_courses', NULL, 'radio', 'Platform', 'true', 'AllowStudentsToBrowseCoursesTitle', 'AllowStudentsToBrowseCoursesComment', NULL, NULL, 1),
('show_session_data', NULL, 'radio', 'Advanced', 'false', 'ShowSessionDataTitle', 'ShowSessionDataComment', NULL, NULL, 1),
('allow_use_sub_language', NULL, 'radio', 'Advanced', 'false', 'AllowUseSubLanguageTitle', 'AllowUseSubLanguageComment', NULL, NULL, 1),
('show_glossary_in_documents', NULL, 'radio', 'Advanced', 'isautomatic', 'ShowGlossaryInDocumentsTitle', 'ShowGlossaryInDocumentsComment', NULL, NULL, 1),
('allow_terms_conditions', NULL, 'radio', 'Platform', 'false', 'AllowTermsAndConditionsTitle', 'AllowTermsAndConditionsComment', NULL, NULL, 1),
('course_create_active_tools', 'enable_search', 'checkbox', 'Tools', 'false', 'CourseCreateActiveToolsTitle', 'CourseCreateActiveToolsComment', NULL, 'Search', 1),
('search_enabled', NULL, 'radio', 'Tools', 'false', 'EnableSearchTitle', 'EnableSearchComment', NULL, NULL, 1),
('search_prefilter_prefix', NULL, NULL, 'Search', NULL, 'SearchPrefilterPrefix', 'SearchPrefilterPrefixComment', NULL, NULL, 1),
('search_show_unlinked_results', NULL, 'radio', 'Search', 'true', 'SearchShowUnlinkedResultsTitle', 'SearchShowUnlinkedResultsComment', NULL, NULL, 1),
('show_courses_descriptions_in_catalog', NULL, 'radio', 'Course', 'true', 'ShowCoursesDescriptionsInCatalogTitle', 'ShowCoursesDescriptionsInCatalogComment', NULL, NULL, 1),
('allow_coach_to_edit_course_session', NULL, 'radio', 'Course', 'false', 'AllowCoachsToEditInsideTrainingSessions', 'AllowCoachsToEditInsideTrainingSessionsComment', NULL, NULL, 1),
('show_glossary_in_extra_tools', NULL, 'radio', 'Advanced', 'false', 'ShowGlossaryInExtraToolsTitle', 'ShowGlossaryInExtraToolsComment', NULL, NULL, 1),
('dokeos_database_version', NULL, 'textfield', NULL, '2.2.14317', 'DokeosDatabaseVersion', NULL, NULL, NULL, 1),
('send_email_to_admin_when_create_course', NULL, 'radio', 'Platform', 'false', 'SendEmailToAdminTitle', 'SendEmailToAdminComment', NULL, NULL, 1),
('go_to_course_after_login', NULL, 'radio', 'Course', 'false', 'GoToCourseAfterLoginTitle', 'GoToCourseAfterLoginComment', NULL, NULL, 1),
('math_mimetex', NULL, 'radio', 'Advanced', 'false', 'MathMimetexTitle', 'MathMimetexComment', NULL, NULL, 1),
('math_asciimathML', NULL, 'radio', 'Editor', 'false', 'MathASCIImathMLTitle', 'MathASCIImathMLComment', NULL, NULL, 1),
('youtube_for_students', NULL, 'radio', 'Advanced', 'true', 'YoutubeForStudentsTitle', 'YoutubeForStudentsComment', NULL, NULL, 1),
('block_copy_paste_for_students', NULL, 'radio', 'Editor', 'false', 'BlockCopyPasteForStudentsTitle', 'BlockCopyPasteForStudentsComment', NULL, NULL, 1),
('more_buttons_maximized_mode', NULL, 'radio', 'Editor', 'false', 'MoreButtonsForMaximizedModeTitle', 'MoreButtonsForMaximizedModeComment', NULL, NULL, 1),
('students_download_folders', NULL, 'radio', 'Advanced', 'true', 'AllowStudentsDownloadFoldersTitle', 'AllowStudentsDownloadFoldersComment', NULL, NULL, 1),
('installation_date', NULL, 'text', 'Advanced', '1319211472', 'InstallationDateTitle', 'InstallationDateComment', NULL, NULL, 1),
('cas_activate', NULL, 'radio', 'CAS', 'false', 'CasMainActivateTitle', 'CasMainActivateComment', NULL, NULL, 1),
('cas_server', NULL, 'textfield', 'CAS', NULL, 'CasMainServerTitle', 'CasMainServerComment', NULL, NULL, 1),
('cas_server_uri', NULL, 'textfield', 'CAS', NULL, 'CasMainServerURITitle', 'CasMainServerURIComment', NULL, NULL, 1),
('cas_port', NULL, 'textfield', 'CAS', NULL, 'CasMainPortTitle', 'CasMainPortComment', NULL, NULL, 1),
('cas_protocol', NULL, 'radio', 'CAS', NULL, 'CasMainProtocolTitle', 'CasMainProtocolComment', NULL, NULL, 1),
('cas_add_user_activate', NULL, 'radio', 'CAS', NULL, 'CasUserAddActivateTitle', 'CasUserAddActivateComment', NULL, NULL, 1),
('cas_add_user_login_attr', NULL, 'textfield', 'CAS', NULL, 'CasUserAddLoginAttributeTitle', 'CasUserAddLoginAttributeComment', NULL, NULL, 1),
('cas_add_user_email_attr', NULL, 'textfield', 'CAS', NULL, 'CasUserAddEmailAttributeTitle', 'CasUserAddEmailAttributeComment', NULL, NULL, 1),
('cas_add_user_firstname_attr', NULL, 'textfield', 'CAS', NULL, 'CasUserAddFirstnameAttributeTitle', 'CasUserAddFirstnameAttributeComment', NULL, NULL, 1),
('cas_add_user_lastname_attr', NULL, 'textfield', 'CAS', NULL, 'CasUserAddLastnameAttributeTitle', 'CasUserAddLastnameAttributeComment', NULL, NULL, 1),
('calendar_types', 'platformevents', 'checkbox', 'Advanced', 'true', 'CalendarTypesTitle', 'CalendarTypesComment', '1', 'PlatformEvents', 1),
('calendar_types', 'quizevents', 'checkbox', 'Advanced', 'true', 'CalendarTypesTitle', 'CalendarTypesComment', '1', 'QuizEvents', 1),
('calendar_types', 'sessionevents', 'checkbox', 'Advanced', 'true', 'CalendarTypesTitle', 'CalendarTypesComment', '1', 'SessionEvents', 1),
('mindmap_converter_activated', NULL, 'radio', 'Advanced', 'false', 'MindmapConverterTitle', 'MindmapConverterComment', NULL, NULL, 1),
('agenda_default_view', NULL, 'radio', 'Tools', 'agendaWeek', 'AgendaDefaultViewTitle', 'AgendaDefaultViewComment', '1', NULL, 1),
('agenda_action_icons', NULL, 'radio', 'Tools', 'false', 'AgendaActionIconsTitle', 'AgendaActionIconsComment', '1', NULL, 1),
('calendar_detail_view', NULL, 'radio', 'Advanced', 'edit', 'CalendarDetailViewTitle', 'CalendarDetailViewComment', '1', NULL, 1),
('calendar_navigation', NULL, 'radio', 'Advanced', 'actions', 'CalendarNavigationTitle', 'CalendarNavigationComment', '1', NULL, 1),
('display_feedback_messages', NULL, 'radio', 'Advanced', 'false', 'DisplayFeedbackMessagesTitle', 'DisplayFeedbackMessagesComment', '1', NULL, 1),
('allow_user_edit_agenda', NULL, 'radio', 'Advanced', 'false', 'AllowUserEditAgendaTitle', 'AllowUserEditAgendaTitle', '1', NULL, 1),
('user_manage_group_agenda', NULL, 'radio', 'Advanced', 'true', 'CanUsersMangeGroupAgendaTitle', 'CanUsersMangeGroupAgendaComment', '1', NULL, 1),
('captcha', NULL, 'radio', 'Advanced', 'false', 'CaptchaTitle', 'CaptchaComment', NULL, NULL, 1),
('number_of_announcements', NULL, 'textfield', 'Advanced', '8', 'NumberOfAnnouncementsInListTitle', 'NumberOfAnnouncementsInListComment', '0', NULL, 1),
('calendar_export_all', NULL, 'radio', 'Advanced', 'false', 'CalendarExportAllTitle', 'CalendarExportAllComment', '0', NULL, 1),
('display_context_help', NULL, 'radio', 'Advanced', 'false', 'DisplayContextHelpTitle', 'DisplayContextHelpComment', '0', NULL, 1),
('display_breadcrumbs', NULL, 'radio', 'Advanced', 'false', 'DisplayBreadcrumbsTitle', 'DisplayBreadcrumbsComment', '0', NULL, 1),
('groupscenariofield', 'description', 'checkbox', 'Advanced', 'false', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldDescription', 1),
('groupscenariofield', 'limit', 'checkbox', 'Advanced', 'true', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldLimit', 1),
('groupscenariofield', 'registration', 'checkbox', 'Advanced', 'true', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldRegistration', 1),
('groupscenariofield', 'unregistration', 'checkbox', 'Advanced', 'false', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldUnRegistration', 1),
('groupscenariofield', 'publicprivategroup', 'checkbox', 'Advanced', 'true', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldPublicPrivateGroup', 1),
('groupscenariofield', 'document', 'checkbox', 'Advanced', 'false', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldDocument', 1),
('groupscenariofield', 'work', 'checkbox', 'Advanced', 'false', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldWork', 1),
('groupscenariofield', 'calendar', 'checkbox', 'Advanced', 'false', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldCalendar', 1),
('groupscenariofield', 'announcements', 'checkbox', 'Advanced', 'false', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldAnnouncements', 1),
('groupscenariofield', 'forum', 'checkbox', 'Advanced', 'false', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldForum', 1),
('groupscenariofield', 'wiki', 'checkbox', 'Advanced', 'false', 'GroupScenarioFieldTitle', 'GroupScenarioFieldComment', '0', 'GroupScenarioFieldWiki', 1),
('message_max_upload_filesize', NULL, 'textfield', 'Advanced', '20971520', 'MessageMaxUploadFilesizeTitle', 'MessageMaxUploadFilesizeComment', NULL, NULL, 1),
('show_tabs', 'social', 'checkbox', 'Platform', 'true', 'ShowTabsTitle', 'ShowTabsComment', NULL, 'TabsSocial', 1),
('show_quizcategory', NULL, 'radio', 'Advanced', 'false', 'ShowQuizCategoryTitle', 'ShowQuizCategoryComment', '0', NULL, 1),
('show_emailtemplates', NULL, 'radio', 'Advanced', 'true', 'ShowEmailTemplatesTitle', 'ShowEmailTemplatesComment', '0', NULL, 1),
('show_catalogue', NULL, 'radio', 'Platform', 'true', 'ShowCatalogueTitle', 'ShowCatalogueComment', '0', NULL, 1),
('automatic_group_filling', NULL, 'radio', 'Advanced', 'true', 'ShowAutomaticGroupTitle', 'ShowAutomaticGroupComment', '0', NULL, 1),
('create_new_group', NULL, 'radio', 'Advanced', 'true', 'ShowNewGroupTitle', 'ShowNewGroupComment', '0', NULL, 1),
('new_group_seats', NULL, 'textfield', 'Advanced', '20', 'ShowNewGroupSeatTitle', 'ShowNewGroupSeatComment', '0', NULL, 1),
('show_force_password_change', NULL, 'radio', 'Security', '0', 'ShowForcePasswordChangeTitle', 'ShowForcePasswordChangeTitleComment', NULL, NULL, 1),
('force_password_change', NULL, 'textfield', 'Security', '0', 'ForcePasswordChangeTitle', 'ForcePasswordChangeComment', NULL, NULL, 1),
('force_password_change_account_creation', NULL, 'radio', 'Security', '0', 'ForcePasswordChangeAccountCreationTitle', 'ForcePasswordChangeAccountCreationComment', NULL, NULL, 1),
('password_rule', 'numbers', 'checkbox', 'Security', 'true', 'PasswordRuleTitle', 'PasswordRuleComment', NULL, 'PasswordRuleNumbers', 1),
('password_rule', 'camelcase', 'checkbox', 'Security', 'true', 'PasswordRuleTitle', 'PasswordRuleComment', NULL, 'PasswordRuleCamelCase', 1),
('password_rule', 'symbols', 'checkbox', 'Security', 'false', 'PasswordRuleTitle', 'PasswordRuleComment', NULL, 'PasswordRuleSymbol', 1),
('password_length', NULL, 'textfield', 'Security', '6', 'PasswordLengthTitle', 'PasswordLengthComment', NULL, NULL, 1),
('login_fail_lock', NULL, 'textfield', 'Security', '0', 'LoginFailLockTitle', 'LoginFailLockComment', NULL, NULL, 1),
('e_commerce', NULL, 'radio', 'Ecommerce', '0', 'EcommerceTitle', 'EcommerceComment', NULL, NULL, 1),
('e_commerce_catalog_type', NULL, 'radio', 'Ecommerce', '1', 'EcommerceCatalogTypeTitle', 'EcommerceCatalogTypeComment', NULL, NULL, 1),
('e_commerce_catalog_currency', NULL, 'radio', 'Ecommerce', '840', 'EcommerceCatalogCurrency', 'EcommerceCatalogCurrencyComment', NULL, NULL, 1),
('use_default_editor', NULL, 'radio', 'Platform', 'Fckeditor', 'UseDefaultEditorTitle', 'UseDefaultEditorComment', NULL, NULL, 1),
('e_commerce_payment_method', 'online', 'checkbox', 'Ecommerce', 'true', 'EcommercePaymentTitle', 'EcommercePaymentComment', NULL, 'EcommercePaymentOnline', 1),
('e_commerce_payment_method', 'cheque', 'checkbox', 'Ecommerce', 'false', 'EcommercePaymentTitle', 'EcommercePaymentComment', NULL, 'EcommercePaymentCheque', 1),
('e_commerce_payment_method', 'installment', 'checkbox', 'Ecommerce', 'false', 'EcommercePaymentTitle', 'EcommercePaymentComment', NULL, 'EcommercePaymentInstallment', 1),
('ldap_server_type', NULL, 'radio', 'LDAP', '0', 'LDAPServerTypeTitle', 'LDAPServerTypeComment', NULL, NULL, 1),
('enable_platform_chat', NULL, 'radio', 'Platform', 'true', 'EnablePlatformChatTitle', 'EnablePlatformChatComment', '0', NULL, 1),
('platform_chat_request', NULL, 'textfield', 'Platform', '2', 'PlatformChatRequestTitle', 'PlatformChatRequestComment', NULL, NULL, 1);

UPDATE settings_current SET access_url_changeable=1 WHERE access_url =  1;

UNLOCK TABLES;
/*!40000 ALTER TABLE settings_current ENABLE KEYS */;

--
-- Table structure for table settings_options
--

DROP TABLE IF EXISTS settings_options;
CREATE TABLE settings_options (
  id int unsigned NOT NULL auto_increment,
  variable varchar(255) default NULL,
  value varchar(255) default NULL,
  display_text varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  UNIQUE KEY id (id)
);

ALTER TABLE settings_options ADD UNIQUE unique_setting_option (variable , value) ;

--
-- Dumping data for table settings_options
--


/*!40000 ALTER TABLE settings_options DISABLE KEYS */;
LOCK TABLES settings_options WRITE;
INSERT INTO settings_options
(variable, value, display_text)
VALUES
('show_administrator_data','true','Yes'),
('show_administrator_data','false','No'),
('show_tutor_data','true','Yes'),
('show_tutor_data','false','No'),
('show_teacher_data','true','Yes'),
('show_teacher_data','false','No'),
('homepage_view','activity','HomepageViewActivity'),
('homepage_view','2column','HomepageView2column'),
('homepage_view','3column','HomepageView3column'),
('show_toolshortcuts','true','Yes'),
('show_toolshortcuts','false','No'),
('allow_group_categories','true','Yes'),
('allow_group_categories','false','No'),
('server_type','production','ProductionServer'),
('server_type','test','TestServer'),
('allow_name_change','true','Yes'),
('allow_name_change','false','No'),
('allow_officialcode_change','true','Yes'),
('allow_officialcode_change','false','No'),
('allow_registration','true','Yes'),
('allow_registration','false','No'),
('allow_registration','approval','AfterApproval'),
('allow_registration_as_teacher','true','Yes'),
('allow_registration_as_teacher','false','No'),
('allow_lostpassword','true','Yes'),
('allow_lostpassword','false','No'),
('allow_user_headings','true','Yes'),
('allow_user_headings','false','No'),
('allow_personal_agenda','true','Yes'),
('allow_personal_agenda','false','No'),
('display_coursecode_in_courselist','true','Yes'),
('display_coursecode_in_courselist','false','No'),
('display_teacher_in_courselist','true','Yes'),
('display_teacher_in_courselist','false','No'),
('use_document_title','true','Yes'),
('use_document_title','false','No'),
('permanently_remove_deleted_files','true','YesWillDeletePermanently'),
('permanently_remove_deleted_files','false','NoWillDeletePermanently'),
('dropbox_allow_overwrite','true','Yes'),
('dropbox_allow_overwrite','false','No'),
('dropbox_allow_just_upload','true','Yes'),
('dropbox_allow_just_upload','false','No'),
('dropbox_allow_student_to_student','true','Yes'),
('dropbox_allow_student_to_student','false','No'),
('dropbox_allow_group','true','Yes'),
('dropbox_allow_group','false','No'),
('dropbox_allow_mailing','true','Yes'),
('dropbox_allow_mailing','false','No'),
('extended_profile','true','Yes'),
('extended_profile','false','No'),
('student_view_enabled','true','Yes'),
('student_view_enabled','false','No'),
('show_navigation_menu','false','No'),
('show_navigation_menu','icons','IconsOnly'),
('show_navigation_menu','text','TextOnly'),
('show_navigation_menu','iconstext','IconsText'),
('enable_tool_introduction','true','Yes'),
('enable_tool_introduction','false','No'),
('page_after_login', 'index.php', 'CampusHomepage'),
('page_after_login', 'user_portal.php', 'MyCourses'),
('breadcrumbs_course_homepage', 'get_lang', 'CourseHomepage'),
('breadcrumbs_course_homepage', 'course_code', 'CourseCode'),
('breadcrumbs_course_homepage', 'course_title', 'CourseTitle'),
('example_material_course_creation', 'true', 'Yes'),
('example_material_course_creation', 'false', 'No'),
('use_session_mode', 'true', 'Yes'),
('use_session_mode', 'false', 'No'),
('allow_email_editor', 'true' ,'Yes'),
('allow_email_editor', 'false', 'No'),
('show_email_addresses','true','Yes'),
('show_email_addresses','false','No'),
('wcag_anysurfer_public_pages', 'true', 'Yes'),
('wcag_anysurfer_public_pages', 'false', 'No'),
('upload_extensions_list_type', 'blacklist', 'Blacklist'),
('upload_extensions_list_type', 'whitelist', 'Whitelist'),
('upload_extensions_skip', 'true', 'Remove'),
('upload_extensions_skip', 'false', 'Rename'),
('show_number_of_courses', 'true', 'Yes'),
('show_number_of_courses', 'false', 'No'),
('show_empty_course_categories', 'true', 'Yes'),
('show_empty_course_categories', 'false', 'No'),
('show_back_link_on_top_of_tree', 'true', 'Yes'),
('show_back_link_on_top_of_tree', 'false', 'No'),
('show_different_course_language', 'true', 'Yes'),
('show_different_course_language', 'false', 'No'),
('split_users_upload_directory', 'true', 'Yes'),
('split_users_upload_directory', 'false', 'No'),
('hide_dltt_markup', 'false', 'No'),
('hide_dltt_markup', 'true', 'Yes'),
('display_categories_on_homepage','true','Yes'),
('display_categories_on_homepage','false','No'),
('default_forum_view', 'flat', 'Flat'),
('default_forum_view', 'threaded', 'Threaded'),
('default_forum_view', 'nested', 'Nested'),
('survey_email_sender_noreply', 'coach', 'CourseCoachEmailSender'),
('survey_email_sender_noreply', 'noreply', 'NoReplyEmailSender'),
('openid_authentication','true','Yes'),
('openid_authentication','false','No'),
('gradebook_enable','true','Yes'),
('gradebook_enable','false','No'),
('user_selected_theme','true','Yes'),
('user_selected_theme','false','No'),
('allow_course_theme','true','Yes'),
('allow_course_theme','false','No'),
('display_mini_month_calendar', 'true', 'Yes'),
('display_mini_month_calendar', 'false', 'No'),
('display_upcoming_events', 'true', 'Yes'),
('display_upcoming_events', 'false', 'No'),
('show_closed_courses', 'true', 'Yes'),
('show_closed_courses', 'false', 'No'),
('ldap_version', '2', 'LDAPVersion2'),
('ldap_version', '3', 'LDAPVersion3'),
('visio_use_rtmpt','true','Yes'),
('visio_use_rtmpt','false','No'),
('add_users_by_coach', 'true', 'Yes'),
('add_users_by_coach', 'false', 'No'),
('extend_rights_for_coach', 'true', 'Yes'),
('extend_rights_for_coach', 'false', 'No'),
('extend_rights_for_coach_on_survey', 'true', 'Yes'),
('extend_rights_for_coach_on_survey', 'false', 'No'),
('show_session_coach', 'true', 'Yes'),
('show_session_coach', 'false', 'No'),
('allow_users_to_create_courses','true','Yes'),
('allow_users_to_create_courses','false','No'),
('breadcrumbs_course_homepage', 'session_name_and_course_title', 'SessionNameAndCourseTitle'),
('advanced_filemanager','true','Yes'),
('advanced_filemanager','false','No'),
('allow_reservation', 'true', 'Yes'),
('allow_reservation', 'false', 'No'),
('allow_message_tool', 'true', 'Yes'),
('allow_message_tool', 'false', 'No'),
('allow_social_tool', 'true', 'Yes'),
('allow_social_tool', 'false', 'No'),
('allow_students_to_browse_courses','true','Yes'),
('allow_students_to_browse_courses','false','No'),
('show_email_of_teacher_or_tutor ', 'true', 'Yes'),
('show_email_of_teacher_or_tutor ', 'false', 'No'),
('show_session_data ', 'true', 'Yes'),
('show_session_data ', 'false', 'No'),
('allow_use_sub_language', 'true', 'Yes'),
('allow_use_sub_language', 'false', 'No'),
('show_glossary_in_documents', 'none', 'ShowGlossaryInDocumentsIsNone'),
('show_glossary_in_documents', 'ismanual', 'ShowGlossaryInDocumentsIsManual'),
('show_glossary_in_documents', 'isautomatic', 'ShowGlossaryInDocumentsIsAutomatic'),
('allow_terms_conditions', 'true', 'Yes'),
('allow_terms_conditions', 'false', 'No'),
('search_enabled', 'true', 'Yes'),
('search_enabled', 'false', 'No'),
('search_show_unlinked_results', 'true', 'SearchShowUnlinkedResults'),
('search_show_unlinked_results', 'false', 'SearchHideUnlinkedResults'),
('show_courses_descriptions_in_catalog', 'true', 'Yes'),
('show_courses_descriptions_in_catalog', 'false', 'No'),
('allow_coach_to_edit_course_session','true','Yes'),
('allow_coach_to_edit_course_session','false','No'),
('show_glossary_in_extra_tools', 'true', 'Yes'),
('show_glossary_in_extra_tools', 'false', 'No'),
('send_email_to_admin_when_create_course','true','Yes'),
('send_email_to_admin_when_create_course','false','No'),
('go_to_course_after_login','true','Yes'),
('go_to_course_after_login','false','No'),
('math_mimetex','true','Yes'),
('math_mimetex','false','No'),
('math_asciimathML','true','Yes'),
('math_asciimathML','false','No'),
('youtube_for_students','true','Yes'),
('youtube_for_students','false','No'),
('block_copy_paste_for_students','true','Yes'),
('block_copy_paste_for_students','false','No'),
('more_buttons_maximized_mode','true','Yes'),
('more_buttons_maximized_mode','false','No'),
('students_download_folders','true','Yes'),
('students_download_folders','false','No'),
('cas_activate', 'true', 'Yes'),
('cas_activate', 'false', 'No'),
('cas_protocol', 'CAS1', 'CAS1Text'),
('cas_protocol', 'CAS2', 'CAS2Text'),
('cas_protocol', 'SAML', 'SAMLText'),
('cas_add_user_activate', 'true', 'Yes'),
('cas_add_user_activate', 'false', 'No'),
('mindmap_converter_activated','true','Yes'),
('mindmap_converter_activated','false','No'),
('agenda_default_view','month','MonthView'),
('agenda_default_view','agendaWeek','WeekView'),
('agenda_default_view','agendaDay','DayView'),
('agenda_action_icons','true','Yes'),
('agenda_action_icons','false','No'),
('calendar_detail_view','detail','DetailView'),
('calendar_detail_view','edit','EditView'),
('calendar_navigation','actions','CalendarNavigationActions'),
('calendar_navigation','default','CalendarNavigationDefault'),
('display_feedback_messages','true','Yes'),
('display_feedback_messages','false','No'),
('allow_user_edit_agenda','true','Yes'),
('allow_user_edit_agenda','false','No'),
('user_manage_group_agenda','true','Yes'),
('user_manage_group_agenda','false','No'),
('captcha','true','Yes'),
('captcha','false','No'),
('calendar_export_all','true','Yes'),
('calendar_export_all','false','No'),
('display_context_help','true','Yes'),
('display_context_help','false','No'),
('display_breadcrumbs','true','Yes'),
('display_breadcrumbs','false','No'),
('show_quizcategory','true','Yes'),
('show_quizcategory','false','No'),
('show_emailtemplates','true','Yes'),
('show_emailtemplates','false','No'),
('show_catalogue','true','Yes'),
('show_catalogue','false','No'),
('automatic_group_filling','true','Yes'),
('automatic_group_filling','false','No'),
('create_new_group','true','Yes'),
('create_new_group','false','No'),
('force_password_change_account_creation','true','Yes'),
('force_password_change_account_creation','false','No'),
('show_force_password_change','true','Yes'),
('show_force_password_change','false','No'),
('e_commerce' ,'0','None'),
('e_commerce' ,'1','Atos'),
('e_commerce' ,'2','Paypal'),
('e_commerce_catalog_type', 1, 'Sessions'),
('e_commerce_catalog_type', 2, 'Courses'),
('e_commerce_catalog_type', 3, 'Modules'),
('e_commerce_catalog_currency', 840, 'USD Dollar'),
('e_commerce_catalog_currency', 978, 'Euro'),
('use_default_editor','Fckeditor','FckEditorInfo'),
('use_default_editor','Ckeditor','CkEditorInfo'),
('ldap_server_type', '0', 'LDAPServerTypeDefault'),
('ldap_server_type', '1', 'LDAPServerTypeMSAD'),
('enable_platform_chat', 'true', 'EnablePlatformChat'),
('enable_platform_chat', 'false', 'DisablePlatformChat');

--
UNLOCK TABLES;

/*!40000 ALTER TABLE settings_options ENABLE KEYS */;

--
-- Table structure for table sys_announcement
--

DROP TABLE IF EXISTS sys_announcement;
CREATE TABLE sys_announcement (
  id int unsigned NOT NULL auto_increment,
  date_start datetime NOT NULL default '0000-00-00 00:00:00',
  date_end datetime NOT NULL default '0000-00-00 00:00:00',
  visible_teacher tinyint NOT NULL default 0,
  visible_student tinyint NOT NULL default 0,
  visible_guest tinyint NOT NULL default 0,
  title varchar(250) NOT NULL default '',
  content text NOT NULL,
  lang varchar(70) NULL default NULL,
  PRIMARY KEY  (id)
);

--
-- Dumping data for table sys_announcement
--


/*!40000 ALTER TABLE sys_announcement DISABLE KEYS */;
LOCK TABLES sys_announcement WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE sys_announcement ENABLE KEYS */;

--
-- Table structure for shared_survey
--

DROP TABLE IF EXISTS shared_survey;
CREATE TABLE shared_survey (
  survey_id int unsigned NOT NULL auto_increment,
  code varchar(20) default NULL,
  title text default NULL,
  subtitle text default NULL,
  author varchar(250) default NULL,
  lang varchar(20) default NULL,
  template varchar(20) default NULL,
  intro text,
  surveythanks text,
  creation_date datetime NOT NULL default '0000-00-00 00:00:00',
  course_code varchar(40) NOT NULL default '',
  PRIMARY KEY  (survey_id),
  UNIQUE KEY id (survey_id)
);

-- --------------------------------------------------------

--
-- Table structure for shared_survey_question
--

DROP TABLE IF EXISTS shared_survey_question;
CREATE TABLE shared_survey_question (
  question_id int NOT NULL auto_increment,
  survey_id int NOT NULL default '0',
  survey_question text NOT NULL,
  survey_question_comment text NOT NULL,
  type varchar(250) NOT NULL default '',
  display varchar(10) NOT NULL default '',
  sort int NOT NULL default '0',
  code varchar(40) NOT NULL default '',
  max_value int NOT NULL,
  PRIMARY KEY  (question_id)
);

-- --------------------------------------------------------

--
-- Table structure for shared_survey_question_option
--

DROP TABLE IF EXISTS shared_survey_question_option;
CREATE TABLE shared_survey_question_option (
  question_option_id int NOT NULL auto_increment,
  question_id int NOT NULL default '0',
  survey_id int NOT NULL default '0',
  option_text text NOT NULL,
  sort int NOT NULL default '0',
  PRIMARY KEY  (question_option_id)
);


-- --------------------------------------------------------

--
-- Table structure for templates (User's FCKEditor templates)
--

DROP TABLE IF EXISTS templates;
CREATE TABLE templates (
  id int NOT NULL auto_increment,
  title varchar(100) NOT NULL,
  description varchar(250) NOT NULL,
  course_code varchar(40) NOT NULL,
  user_id int NOT NULL,
  ref_doc int NOT NULL,
  image varchar(250) NOT NULL,
  PRIMARY KEY  (id)
);


-- --------------------------------------------------------

--
-- Table structure for quiz templates
--
DROP TABLE IF EXISTS quiz_answer_templates;
CREATE TABLE quiz_answer_templates (
  id mediumint(8) unsigned NOT NULL,
  question_id mediumint(8) unsigned NOT NULL,
  answer text NOT NULL,
  correct mediumint(8) unsigned DEFAULT NULL,
  comment text,
  ponderation float(6,2) NOT NULL DEFAULT '0.00',
  position mediumint(8) unsigned NOT NULL DEFAULT '1',
  hotspot_coordinates text,
  hotspot_type enum('square','circle','poly','delineation') DEFAULT NULL,
  destination text NOT NULL,
  PRIMARY KEY (id,question_id)
);

DROP TABLE IF EXISTS quiz_question_templates;
CREATE TABLE quiz_question_templates (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  question varchar(200) NOT NULL,
  description text,
  ponderation float(6,2) NOT NULL DEFAULT '0.00',
  position mediumint(8) unsigned NOT NULL DEFAULT '1',
  type tinyint(3) unsigned NOT NULL DEFAULT '2',
  picture varchar(50) DEFAULT NULL,
  level int(10) unsigned NOT NULL DEFAULT '0',
  image varchar(50) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY position (position)
);


--

-- --------------------------------------------------------

--
-- Table structure of openid_association (keep info on openid servers)
--

DROP TABLE IF EXISTS openid_association;
CREATE TABLE IF NOT EXISTS openid_association (
  id int NOT NULL auto_increment,
  idp_endpoint_uri text NOT NULL,
  session_type varchar(30) NOT NULL,
  assoc_handle text NOT NULL,
  assoc_type text NOT NULL,
  expires_in bigint NOT NULL,
  mac_key text NOT NULL,
  created bigint NOT NULL,
  PRIMARY KEY  (id)
);
--
-- --------------------------------------------------------
--
-- Tables for gradebook
--
DROP TABLE IF EXISTS gradebook_category;
CREATE TABLE gradebook_category (
  id int NOT NULL auto_increment,
  name text NOT NULL,
  description text,
  user_id int NOT NULL,
  course_code varchar(40) default NULL,
  parent_id int default NULL,
  weight smallint NOT NULL,
  visible tinyint NOT NULL,
  certif_min_score int DEFAULT NULL,
  PRIMARY KEY  (id)
);
DROP TABLE IF EXISTS gradebook_evaluation;
CREATE TABLE gradebook_evaluation (
  id int unsigned NOT NULL auto_increment,
  name text NOT NULL,
  description text,
  user_id int NOT NULL,
  course_code varchar(40) default NULL,
  category_id int default NULL,
  date int default 0,
  weight smallint NOT NULL,
  max float unsigned NOT NULL,
  visible tinyint NOT NULL,
  type varchar(40) NOT NULL default 'evaluation',
  PRIMARY KEY  (id)
);
DROP TABLE IF EXISTS gradebook_link;
CREATE TABLE gradebook_link (
  id int NOT NULL auto_increment,
  type int NOT NULL,
  ref_id int NOT NULL,
  user_id int NOT NULL,
  course_code varchar(40) NOT NULL,
  category_id int NOT NULL,
  date int default NULL,
  weight smallint NOT NULL,
  visible tinyint NOT NULL,
  PRIMARY KEY  (id)
);
DROP TABLE IF EXISTS gradebook_result;
CREATE TABLE gradebook_result (
  id int NOT NULL auto_increment,
  user_id int NOT NULL,
  evaluation_id int NOT NULL,
  date int NOT NULL,
  score float unsigned default NULL,
  PRIMARY KEY  (id)
);
DROP TABLE IF EXISTS gradebook_score_display;
CREATE TABLE gradebook_score_display (
  id int NOT NULL auto_increment,
  score float unsigned NOT NULL,
  display varchar(40) NOT NULL,
  PRIMARY KEY (id)
);
DROP TABLE IF EXISTS user_field;
CREATE TABLE user_field (
	id	INT NOT NULL auto_increment,
	field_type int NOT NULL DEFAULT 1,
	field_variable	varchar(64) NOT NULL,
	field_display_text	varchar(64),
	field_default_value text,
	field_order int,
	field_visible tinyint default 0,
	field_changeable tinyint default 0,
	field_filter tinyint default 0,
	tms	TIMESTAMP,
        field_registration int DEFAULT 0,
	PRIMARY KEY(id)
);

DROP TABLE IF EXISTS user_field_options;
CREATE TABLE user_field_options (
	id	int NOT NULL auto_increment,
	field_id int	NOT NULL,
	option_value	text,
	option_display_text varchar(64),
	option_order int,
	tms	TIMESTAMP,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS user_field_values;
CREATE TABLE user_field_values(
	id	int	NOT NULL auto_increment,
	user_id	int	unsigned NOT NULL,
	field_id int NOT NULL,
	field_value	text,
	tms TIMESTAMP,        
	PRIMARY KEY(id)
);


ALTER TABLE gradebook_category ADD session_id int DEFAULT NULL;

DROP TABLE IF EXISTS gradebook_result_log;
CREATE TABLE gradebook_result_log (
	id int NOT NULL auto_increment,
	id_result int NOT NULL,
	user_id int NOT NULL,
	evaluation_id int NOT NULL,
	date_log datetime default '0000-00-00 00:00:00',
	score float unsigned default NULL,
	PRIMARY KEY(id)
);

DROP TABLE IF EXISTS gradebook_linkeval_log;
CREATE TABLE gradebook_linkeval_log (
	id int NOT NULL auto_increment,
	id_linkeval_log int NOT NULL,
	name text,
	description text,
	date_log int,
	weight smallint default NULL,
	visible tinyint default NULL,
	type varchar(20) NOT NULL,
	user_id_log int NOT NULL,
	PRIMARY KEY  (id)
);

--
-- --------------------------------------------------------
--
-- Tables for the access URL feature
--

DROP TABLE IF EXISTS access_url;
CREATE TABLE access_url(
	id	int	unsigned NOT NULL auto_increment,
	url	varchar(255) NOT NULL,
	description text,
	active	int unsigned not null default 0,
	created_by	int	not null,
	tms TIMESTAMP,
	PRIMARY KEY (id)
);

INSERT INTO access_url(url, description, active, created_by) VALUES ('http://localhost/',' ',1,1);

DROP TABLE IF EXISTS access_url_rel_user;
CREATE TABLE access_url_rel_user (
  access_url_id int unsigned NOT NULL,
  user_id int unsigned NOT NULL,
  PRIMARY KEY (access_url_id, user_id)
);

ALTER TABLE access_url_rel_user ADD INDEX idx_access_url_rel_user_user (user_id);
ALTER TABLE access_url_rel_user ADD INDEX idx_access_url_rel_user_access_url(access_url_id);
ALTER TABLE access_url_rel_user ADD INDEX idx_access_url_rel_user_access_url_user (user_id,access_url_id);

DROP TABLE IF EXISTS access_url_rel_course;
CREATE TABLE access_url_rel_course (
  access_url_id int unsigned NOT NULL,
  course_code char(40) NOT NULL,
  PRIMARY KEY (access_url_id, course_code)
);


DROP TABLE IF EXISTS access_url_rel_session;
CREATE TABLE access_url_rel_session (
  access_url_id int unsigned NOT NULL,
  session_id int unsigned NOT NULL,
  PRIMARY KEY (access_url_id, session_id)
);
DROP TABLE IF EXISTS access_url_rel_admin;
CREATE TABLE access_url_rel_admin (
  access_url_id int unsigned NOT NULL,
  user_id int unsigned NOT NULL,
  PRIMARY KEY (access_url_id, user_id)
);
--
-- Table structure for table sys_calendar
--
CREATE TABLE IF NOT EXISTS sys_calendar (
  id int unsigned NOT NULL auto_increment,
  title varchar(200) NOT NULL,
  content text,
  start_date datetime NOT NULL default '0000-00-00 00:00:00',
  end_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
);

CREATE TABLE IF NOT EXISTS system_template (
  id int UNSIGNED NOT NULL auto_increment,
  title varchar(250) NOT NULL,
  comment text NOT NULL,
  image varchar(250) NOT NULL,
  content text NOT NULL,
  PRIMARY KEY  (id)
);

--
-- Adding the platform templates
--

INSERT INTO system_template VALUES(14, 'TemplateTitleTwoColumns', 'TemplateTitleTwoColumnsDescription', 'twocolumns.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent table_actions table_actions_rows"><tr>\r\n				\r\n				    \r\n			    <td class="roundcell"><h2>Essi bla </h2>\r\n                                   <p>Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam.</p>\r\n                                   <p>Gue verilisl del ullut prat wisl eraestrud dolumsan vendreet nostinim volum iustrud te dolobore magniamet ullamet utetum dunt wiscipit, volenis acin henit lum zzrit aci tin vel utpatem vulput adit lum zzriure delisi bla feu feummodit vel utetue eum dolor sequi ting ero et non volessequi euis nulluta tummolor sequis enismodit ex eugiamet in ut utet ulla facipis nos ad </p>\r\n                                 \r\n			    </td>\r\n                                             \r\n			\r\n				\r\n				\r\n				<td class="imagecenter" valign="bottom">\r\n				\r\n						<img src="{IMG_DIR}templates/instructor-hands.jpg" />\r\n						\r\n				</td>\r\n				\r\n				\r\n				<td class="roundcell"><h2>Essi bla </h2>\r\n                                   <p>Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam.</p>\r\n                                   <p>Ut alit lor inim volobore dit, quipit venissi bla ad dolor adit augiat. Pit landit iriliquisi te cons et in ut eu feuguerci blandipit alis dit atueriure magna faccum velenim velit wis eu feugait et adipis nis nullaor perosto dolorem ipit iurerci eraesto</p>\r\n                                   <p>Duip eugiate consed magna faci blam.</p>                                        \r\n			\r\n				</td>\r\n			</tr>\r\n			</table><!-- end table for the cells of content -->\r\n			\r\n			</td>\r\n			</tr>			\r\n		  </table> <!-- end white table for the course -->\r\n</body>');
INSERT INTO system_template VALUES(15, 'TemplateTitleArrowChannel', 'TemplateTitleArrowChannelDescription', 'arrowchannel.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n			\r\n			<td>\r\n				<!--- tableau droit pour l''illustration et la bulle--->\r\n				<table class="perso-and-buble">\r\n				<tr><td id="buble-talk">\r\n				  <p>Deliquat ute faccummy nullums andionsed et wisci bla consequis eraestrud magna adipsus cidunt ullam, consed erci blandipit landre.</p>\r\n				  </td>\r\n				</tr>\r\n				<tr><td><img src="{IMG_DIR}templates/instructor-puzzle.jpg" alt="" /></td>\r\n				</tr>\r\n				</table> \r\n				<!--- fin tableau droit pour lillustration et la bulle --->\r\n				</td>\r\n				<td>\r\n			   <!-- tableau fleche-->\r\n			   <table class="arrow-ch table_actions table_actions_rows">				\r\n			   <tr valign="bottom"><td class="arrow-ch-int">\r\n			    <h2>Ad ming erit</h2>\r\n			   <p>Consequat nis elenibh eugiam zzrit utet.</p>\r\n			   </td></tr>\r\n			    <tr><td class="arrow-ch-int">\r\n				 <h2>Ad ming erit</h2>\r\n			   <p>Consequat nis elenibh eugiam zzrit utet.</p>\r\n			   </td></tr>\r\n			    <tr><td class="arrow-ch-int">\r\n				 <h2>Ad ming erit</h2>\r\n			   <p>Consequat nis elenibh eugiam zzrit utet.</p>\r\n			   </td></tr>\r\n			   </table>\r\n				<!-- fin tableau fleche-->		\r\n				\r\n				\r\n				 <!-- tableau fin -->\r\n			   <table class="ch-end">				\r\n			   <tr><td>\r\n			   <h2>Magna corper sum iriurercipit </h2>\r\n			  \r\n				<p>Oborem qui tat diat.<br />\r\n				Consequat nis elenibh eugiam zzrit utet.</p>\r\n				</td></tr>\r\n			  \r\n			  \r\n				</table>\r\n				<!-- fin tableau fin -->\r\n				</td>\r\n				\r\n				\r\n				\r\n		  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course -->\r\n</body>');
INSERT INTO system_template VALUES(16, 'TemplateTitleBiblio', 'TemplateTitleBiblioDescription', 'biblio.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent">\r\n				<tr><td>\r\n			\r\n				\r\n					   <table class="liste-livre table_actions table_actions_rows">\r\n					   <tr><td class="book">\r\n				    <h3>si erilit ad magna ad </h3>\r\n					 <h4 class="details">ad lorem ipsum - ipsum</h4>\r\n					 <p>\r\n					 si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p><p>\r\n					 si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p></td></tr>\r\n					 <tr><td class="book">\r\n				    <h3>si erilit ad magna ad </h3>\r\n					 <h4 class="details">ad lorem ipsum - ipsum</h4>\r\n					 <p>\r\n					si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p></td></tr>\r\n					<tr><td class="book">\r\n				    <h3>si erilit ad magna ad </h3>\r\n					 <h4 class="details">ad lorem ipsum - ipsum</h4>\r\n					 <p>\r\n					 si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p>\r\n					 </td></tr>\r\n					 </table>\r\n					\r\n					 <td><img src="{IMG_DIR}templates/instructor-with-books.jpg" /></td>\r\n                     </tr>\r\n		           </table>\r\n				  \r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td></tr>				\r\n		  </table><!-- end white table for the course --></body>		           ');
INSERT INTO system_template VALUES(17, 'TemplateTitleCertificate', 'TemplateTitleCertificateDescription', 'certificate.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				<!-- tableau gauche pour bulle + perso -->\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk"><p>volenis acin henit lum zzrit aci tin vel feummodit vel utetue eum dolor sequi ting ero !</p>\r\n			      </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-certificate.jpg" alt="" /></td>\r\n				</tr>\r\n				\r\n				</table>\r\n				<!-- fin tableau gauche -->\r\n				</td>\r\n				\r\n				<td>\r\n				<!--- right table certificate --->\r\n				<table class="certif" >\r\n				<tr><td>\r\n				<table class="certif-in">\r\n				<tr>\r\n				<td>\r\n				<h2>Faccummy nim</h2>\r\n				<p>Ex et, qui estrud eu faccummy nostie dolorti nciliqu ipiscil utat</p><p>Qatuercil dolore dipit volorpe raeseni ssenis aliquatue.</p>\r\n				<p class="little">Dunt am eummy nullaorem incillaortie te</p>\r\n				<p class="little-bold-right">Dunt am te</p>\r\n				</td>\r\n				</tr>\r\n				</table></td></tr>\r\n				</table> \r\n				<!--- end certificate--->\r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course -->\r\n</body>');
INSERT INTO system_template VALUES(18, 'TemplateTitleCircularFourCells', 'TemplateTitleCircularFourCellsDescription', 'circularfourcells.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				<!-- tableau gauche pour bulle + perso -->\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk"><p>si erilit ad magna ad dolorercing.Pit landit iriliquisi te cons et in ut eu feuguerci blandipit alis dit atueriure magna faccum velenim velit wis eu feugait et adipis</p>\r\n			      </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-showleft.jpg" alt="" /></td>\r\n				</tr>\r\n				\r\n				</table>\r\n				<!-- fin tableau gauche -->\r\n				</td>\r\n				\r\n				<td>\r\n				<!--- tableau droit pour cercle --->\r\n				<table class="circular" >\r\n				<!--HAUT--><tr><td><table class="circ-a1"><tr><td><table id="circ-a2">\r\n				  <tr><td width="150">&nbsp;</td><td class="circular-item"><p>Do ero eum iustrud</p>\r\n				     </td><td>&nbsp;</td></tr><tr><td colspan="3" height="60px">&nbsp;</td></tr></table></td></tr></table>\r\n				</td></tr>\r\n				<!-- MILIEU--><tr><td><table class="circ-a1"><tr><td class="circular-item"><p>Ci ex et landipit </p>\r\n				          </td><td>&nbsp;</td><td class="circular-item"><p>Dolesequip essisit aut </p></td></tr>\r\n				</table>\r\n				</td></tr>\r\n				<!-- BAS--><tr><td><table class="circ-a1"><tr><td><table id="circ-a3">\r\n				  <tr><td colspan="3" height="50px">&nbsp;</td></tr>\r\n				  <tr><td width="160">&nbsp;</td><td class="circular-item"><p>Ut wis diamet in vulputpate </p>\r\n				      </td><td>&nbsp;</td></tr></table></td></tr></table>\r\n				</td></tr>\r\n				</table> \r\n				<!--- fin tableau droit pour cercle--->\r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course -->\r\n</body>');
INSERT INTO system_template VALUES(19, 'TemplateTitleCircularFiveCells', 'TemplateTitleCircularFiveCellsDescription', 'circularfivecells.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				<!-- tableau gauche pour bulle + perso -->\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk"><p>si erilit ad magna ad dolorercing. Ut alit ecte dolor iuscil enit numsand ionsenim niate do ent lorperate volor accum nissed molenis nulput in ero.</p>\r\n			      </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-showleft.jpg" alt="" /></td>\r\n				</tr>\r\n				\r\n				</table>\r\n				<!-- fin tableau gauche -->\r\n				</td>\r\n				\r\n				<td>\r\n				<!--- tableau droit pour cercle --->\r\n				<table class="circular" >\r\n				<!--HAUT--><tr><td><table class="circ-a1"><tr><td><table id="circ-a2">\r\n				  <tr><td width="150">&nbsp;</td><td class="circular-item"><p>Do ero eum iustrud</p>\r\n				\r\n				      </td><td>&nbsp;</td></tr><tr><td colspan="5" height="40px">&nbsp;</td></tr></table></td></tr></table>\r\n				</td></tr>\r\n				<!-- MILIEU--><tr><td><table class="circ-a1"><tr><td class="circular-item"><p>Ci ex et landipit </p>\r\n				          </td><td colspan="3">&nbsp;</td><td class="circular-item"><p>Dolesequip essisit aut </p></td></tr>\r\n				</table>\r\n				</td></tr>\r\n				<!-- BAS--><tr><td><table class="circ-a1"><tr><td><table id="circ-a3">\r\n				  <tr><td colspan="5" height="60px">&nbsp;</td></tr>\r\n				  <tr><td width="60">&nbsp;</td><td class="circular-item"><p>Ut wis diamet in diamet </p>\r\n				     </td><td width="50">&nbsp;</td><td class="circular-item"><p>Ut wis diamet</p>\r\n				      </td><td width="60">&nbsp;</td></tr></table></td></tr></table>\r\n				</td></tr>\r\n				</table> \r\n				<!--- fin tableau droit pour cercle--->\r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(20, 'TemplateTitleDiagram', 'TemplateTitleDiagramDescription', 'diagram2.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent">\r\n				\r\n				<tr>\r\n				  \r\n				<td><img src="{IMG_DIR}templates/instructor-diagram.jpg" alt="" /></td>\r\n							\r\n				<td>\r\n				<table class="diag table_actions table_actions_columns">\r\n                             \r\n                             <tr class="diagcorpus">\r\n                               <td><h2>Essi bla </h2>\r\n							       <img src="{IMG_DIR}templates/diagram1.png" />\r\n                                   <p>Essi bla accum zzrit.</p></td>\r\n								<td><h2>Essi bla </h2>\r\n								<img src="{IMG_DIR}templates/diagram2.png" />\r\n                                   <p>Erostio dolore doloreet aliquat.</p></td>\r\n								<td><h2>Essi bla </h2>\r\n								<img src="{IMG_DIR}templates/diagram3.png" />\r\n                                   <p>Duip eugiate consed magna faci blam.</p></td>\r\n                             </tr>\r\n                             <tr class="diagarrow">\r\n                                <td><p>Essi bla </p>\r\n                                  </td>\r\n								<td><p>Essi bla </p>\r\n                                   </td>\r\n								<td><p>Essi bla </p>\r\n                                   </td>\r\n                             </tr>\r\n							 <tr class="diagcomment">\r\n                                <td colspan="3"><h2>Ea faciduis nullummy</h2><p>Essi bla Ut ad enissequat wismolum augait essenibh ea faciduis nullummy nulla alis nos nullam num dolum adigna faccum ilisl ex er sim vercipi scidunt la facinim deliqui scidunt alit praestie dignisit inibh eriustrud eraestinit nibh ectet essim duipissecte dit erit eummodo lendre vel er illa faccum irillaor </p>\r\n                               </td>\r\n                             </tr>\r\n                            \r\n               </table>                      \r\n\r\n				</td>\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(21, 'TemplateTitleFaq', 'TemplateTitleFaqDescription', 'faq.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n			<td >\r\n				<!---  left table for perso --->\r\n				\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk"><p>si erilit ad magna ad dolorercing. Ut alit lor inim volobore dit, quipit venissi bla ad dolor adit.</p>\r\n			      </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-faq.jpg" alt="" /></td>\r\n				</tr>\r\n				\r\n				</table>\r\n				\r\n				<!-- end left table perso -->		\r\n				</td>\r\n				<td>\r\n			\r\n				<!-- tableau 1 gauche -->\r\n				<table class="right-table">\r\n				<tr><td>\r\n				\r\n				  <!-- tableau gris container -->\r\n				     <table cellpadding="0" cellspacing="0" class="grey-frame">\r\n                       <tr>\r\n                         <td>\r\n						 <!-- tableau de contenu haut degrade -->\r\n						 <table class="item table_actions table_actions_rows">\r\n                             \r\n                             <tr>\r\n                               <td class="faq"><h2>Mod magna feuisis elit ut wisim ipis nulla ?</h2>\r\n                                   <p>Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam. Tatue moluptatis ad enibh.</p>\r\n                               </td>\r\n								 \r\n                             </tr>\r\n							 <tr>\r\n                               <td class="faq"><h2>Aute faccummy nim do od tio esse ? </h2>\r\n                                   <p>Cillaortie te dolortin utat adignis at, quip estrud dolorpe rostrud tet ut init at delit luptat, se exercin henim nonsequating ero dip essisl in et wisit wis erosto eu feugue consed moloreet vel eumsand.</p>\r\n                               </td>\r\n								 \r\n                             </tr>\r\n							 <tr>\r\n                               <td class="faq"><h2>Qui estrud eu faccummy nostie dolorti ?</h2>\r\n                                   <p>Re eui eu feuipisim autem vendipsum zzrit dunt alisisl ip eros at diate mincilla amcon henibh elisi.</p>\r\n                                   </td>\r\n								 \r\n                             </tr>\r\n							 <tr>\r\n                               <td class="faq"><h2>Isse magnismolore dolore con henim nummy ?</h2>\r\n                                   <p>It, consed ent ilis nullaore vel ullum volessenibh ex er se venit alis nulluptat. La feum aliquis ismoluptat ulput et atumsandrer ing ex euissi etummodo el ullan ulpute feum ilit nullaorem dolenit augait.</p>\r\n                                   </td>\r\n								 \r\n                             </tr>\r\n                           </table>\r\n                           <!-- fin tableau de contenu haut degrade -->                      \r\n						   </td>\r\n                       </tr>\r\n		          </table>\r\n				     <!-- fin du tableau gris containeur -->\r\n				</td>\r\n				</tr>\r\n				</table> \r\n				<!-- fin tableau 1 gauche -->\r\n				</td>				\r\n				\r\n				\r\n				\r\n			</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(22, 'TemplateTitleFrame', 'TemplateTitleFrameDescription', 'frame.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				\r\n					   <td>\r\n					   <table class="left-table-for-text table_actions table_actions_rows">\r\n					   <tr><td>\r\n				    <h3>Si erilit ad magna ad </h3>\r\n					 <h4 class="details">ad lorem ipsum - ipsum</h4>\r\n					 <p>\r\n					 Si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Ut alit lor inim volobore dit, quipit venissi bla ad dolor adit augiat. Pit landit iriliquisi te cons et in ut eu feuguerci blandipit alis dit atueriure magna faccum velenim velit wis eu feugait et adipis nis nullaor perosto dolorem ipit iurerci eraesto.</p>\r\n				    <p>In el do od deliquatio odit esequisit ipsummo dolessequat lorer aliquis eumsandio consequamcon ut ing et, quisse dipit ver.</p>\r\n				    <p> incillam eum iusci tate del ut lut wiscilit aute faccummy nim do od tio esse dolore venim vent nis augiamcon hendre feuis at. </p>\r\n				    <p>It, consed ent ilis nullaore vel ullum volessenibh ex er se venit alis nulluptat. Uptatue raestrud duisi.\r\nLa feum aliquis ismoluptat ulput et atumsandrer ing ex euissi etummodo el ullan ulpute feum ilit nullaorem dolenit augait.</p>\r\n				    </td></tr>\r\n					   </table>\r\n					</td>\r\n						 \r\n                     <td>\r\n						<table class="persoandframe"><tr><td><img src="{IMG_DIR}templates/instructor-frame.jpg" /></td>\r\n						</tr><tr><td class="frame-for-text"><h2>Ea consenibh eugiam</h2>\r\n						<p>Ex et, qui estrud eu faccummy nostie dolorti nciliqu ipiscil utat, quatuercil dolore dipit volorpe raeseni ssenis aliquatue.</p>\r\n						<p>Em vel dolorer ciliqui smolor sequat. Put prat nit.</p></td></tr></table>\r\n					 </td>\r\n                       				\r\n			    </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course -->\r\n</body>');
INSERT INTO system_template VALUES(23, 'TemplateTitleGallery', 'TemplateTitleGalleryDescription', 'gallery.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent2 table_actions table_actions_rows">\r\n						<tr>\r\n						<td class="item-image-legende">\r\n						<img src="{IMG_DIR}templates/little-placeholder-image.jpg" />\r\n						<p>lorem ipsum and ipsum lorem ipsum and ipsum</p>\r\n						</td>\r\n						\r\n						<td class="item-image-legende">\r\n						<img src="{IMG_DIR}templates/little-placeholder-image.jpg" />\r\n						<p>lorem ipsum and ipsum lorem ipsum and ipsum</p>\r\n						</td>\r\n						\r\n						<td class="item-image-legende">\r\n						<img src="{IMG_DIR}templates/little-placeholder-image.jpg" />\r\n						<p>lorem ipsum and ipsum lorem ipsum and ipsum</p>\r\n						</td>\r\n						</tr>\r\n						<tr>						\r\n						<td class="item-image-legende">\r\n						<img src="{IMG_DIR}templates/little-placeholder-image.jpg" />\r\n						<p>lorem ipsum and ipsum lorem ipsum and ipsum</p>\r\n						</td>\r\n						\r\n						<td class="item-image-legende">\r\n						<img src="{IMG_DIR}templates/little-placeholder-image.jpg" />\r\n						<p>lorem ipsum and ipsum lorem ipsum and ipsum</p>\r\n						</td>\r\n						\r\n						<td class="item-image-legende">\r\n						<img src="{IMG_DIR}templates/little-placeholder-image.jpg" />\r\n						<p>lorem ipsum and ipsum lorem ipsum and ipsum</p>\r\n						</td>\r\n						</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(24, 'TemplateTitleGears', 'TemplateTitleGearsDescription', 'gears.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				<!-- tableau gauche pour bulle + perso -->\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk-ud"><p>si erilit ad magna ad dolorercing.Isse magnismolore dolore con henim nummy nulla.</p>\r\n			      </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-impulsion.jpg" alt="" /></td>\r\n				</tr>\r\n				\r\n				</table>\r\n				<!-- fin tableau gauche -->\r\n				</td>\r\n				\r\n				<td>\r\n				<!--- tableau droit pour rouages --->\r\n				<table class="rouages" >\r\n				<tr>\r\n				<td id="bord-un"></td>\r\n				<td id="rouage-un">Er sum vulla am diamet</td>\r\n				<td id="bord-deux"></td>\r\n				<td id="rouage-deux">Quisci bla conullam zzrilit</td>\r\n				<td id="rouage-trois">Ci ex et landipit nosto</td>\r\n				<td id="bord-trois"></td>\r\n				</tr>\r\n				\r\n				</table> \r\n				<!--- fin tableau droit pour rouages--->\r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(25, 'TemplateTitleGrowth', 'TemplateTitleGrowthDescription', 'growth.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				<!-- tableau gauche pour bulle + perso -->\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk"><p>si erilit ad magna ad dolorercing.</p><p>Ipisseq uissit lor secte faccumsandit ipsum diamcom modolortie.  nulput in ero exercipit wismodi.</p>\r\n			      </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-climbing.jpg" alt="" /></td>\r\n				</tr>\r\n				\r\n				</table>\r\n				<!-- fin tableau gauche -->\r\n				</td>\r\n				\r\n				<td>\r\n				<!--- tableau droit pour rouages --->\r\n				<table class="growth" >\r\n			\r\n				<tr><td class="text-growth-stage">\r\n				<table class="table_actions table_actions_rows">\r\n				<tr><td style="padding-left:240px"><p><span class="orange-bold">Ipit num ip</span></p></td></tr>\r\n				<tr>\r\n				  <td style="padding-left:190px">Esto ent feugiat</td>\r\n				</tr>\r\n				<tr><td style="padding-left:150px">Magna facillu ptating</td></tr>\r\n				<tr><td style="padding-left:125px">Vel eumsand rerat</td></tr>\r\n				<tr><td style="padding-left:100px">Faccummy nim do od tio</td></tr>\r\n				<tr><td style="padding-left:80px">Ex et, qui estrud eu faccummy</td></tr>\r\n				<tr><td style="padding-left:60px">Ipisseq uissit lor secte</td></tr>\r\n				</table>\r\n				</td>\r\n				</tr>\r\n				\r\n				\r\n				</table> \r\n				<!--- fin tableau droit pour rouages--->\r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(26, 'TemplateTitleImage', 'TemplateTitleImageDescription', 'image.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent table_actions table_actions_rows"><tr>\r\n				<td>\r\n			\r\n				\r\n					   <!-- tableau image et sa legende -->\r\n					   <table class="image-and-legend"><tr><td><img src="{IMG_DIR}templates/placeholder-image.jpg" /></td></tr><tr><td class="legendingrey"><p>Aliquis er in erostio dolore dolore et aliquat. Duip eugiate consed magna</p>\r\n					     </td></tr>\r\n						</table>\r\n						<!-- fin tableau image et sa legende -->\r\n				</td>\r\n						 \r\n                <td >\r\n						<h2>Essi bla </h2>\r\n						<p>Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam.</span> <span class="item-desc">Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam.</p>\r\n					   <p> Duip eugiate consed magna faci blam. Essi bla accum zzrit ali.</p>\r\n					   <p>Consed magna faci blam.</p>\r\n					   <p>Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam. Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam.</p>\r\n                                      \r\n				</td>\r\n                </tr>\r\n			  </table>\r\n			  <!-- fin du tableau gris contenant le tableau texte et le tableau image -->\r\n\r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(27, 'TemplateTitlePostIt', 'TemplateTitlePostItDescription', 'postit.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				<!-- tableau  post-it -->\r\n				<table class="post-it-table">\r\n				<tr>\r\n				<td class="PI" >\r\n				  <!-- tableau enchesse pour le coin droit -->\r\n				  <table class="PI-corner">\r\n				    <tr><td>\r\n				  <h2>Vendre do dolorpe</h2>\r\n				  <p>Ulla conse feugait lor sustrud minit prat. Esto odolorpero con vendipsusto eum adit wisit, si erilit ad magna.			    </p>\r\n				\r\n				  <p>Isse magnismolore dolore con henim nummy nulla ad magna facin vel dolore dolese endre conse dolesse del euis nis dunt in henim quamcommy nim dolore veliquat, verit lum nonsequatuer ipis nostiscinibh ea cortio odo dip ea corperat in hendipisim ing eliqui.</p>\r\n				 \r\n		\r\n				  \r\n				  </td></tr></table>\r\n				  <!-- fin tableau enchesse -->\r\n				</td>\r\n				</tr>\r\n				</table>\r\n				<!-- fin tableau post-it-->\r\n			  </td>\r\n				\r\n				<td class="imagecenter">\r\n				<img src="{IMG_DIR}templates/instructor-writing.jpg" alt="" />\r\n				\r\n			  </td>\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(28, 'TemplateTitlePyramid', 'TemplateTitlePyramidDescription', 'pyramid.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n			     <table class="pyramide-background table_actions table_actions_rows">				\r\n			   \r\n				 <tr><td style="font-size:0.8em; padding-top:80px;">ad lorem ipsum</td></tr>\r\n				 <tr><td style="font-size:0.9em">ad lorem ipsum</td></tr>\r\n				 <tr><td style="font-size:1em">ad lorem ipsum</td></tr>\r\n				 <tr><td style="font-size:1.1em">ad lorem ipsum</td></tr>\r\n				 <tr><td style="font-size:1.2em">ad lorem ipsum</td></tr>\r\n				 <tr><td style="font-size:1.3em">ad lorem ipsum</td></tr>\r\n				 <tr><td style="font-size:1.4em">ad lorem ipsum</td></tr>\r\n				 <tr><td style="font-size:1.5em">ad lorem ipsum</td></tr>\r\n				\r\n			\r\n				</table>\r\n\r\n				\r\n				</td>\r\n				\r\n				<td>\r\n				<table class="perso-and-buble">\r\n				<tr><td id="buble-talk"><p>\r\n				Riure con et vulluptat, veniam, consequamet, commolor iliquat dunt iureraessi.\r\nUptat. Ectem doloreet alis nonsed magna feuisim et at. Rit vullaore vullan.</p></td>\r\n				</tr>\r\n				<tr><td><img src="{IMG_DIR}templates/instructor-coming.jpg" alt="" /></td>\r\n				</tr>\r\n				</table> \r\n				<!--- fin tableau droit pour lillustration et la bulle --->\r\n				</td>\r\n				\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(29, 'TemplateTitleResult', 'TemplateTitleResultDescription', 'result.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent">\r\n				<tr><td>\r\n				<!-- left table buble + perso -->\r\n				<table class="perso-and-buble" style="width:250px">\r\n				<tr>\r\n				  <td id="buble-talk"><p>si erilit ad magna ad dolorercing ea consequis dolorpe raessequat.</p>\r\n				    </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-faq.jpg" /></td>\r\n				</tr>\r\n				</table>\r\n				<!-- end left table -->\r\n				</td>\r\n				<td>\r\n				<table class="result">\r\n                             \r\n                             \r\n                            \r\n                             <tr>\r\n                               <td class="add1"><h2>Od eliquis at erostrud</h2>\r\n                                 <p>Duisl iureetue mod te molobor perilisl do con erit at pratue</p>\r\n                               </td>\r\n								   <td class="add2"><h2>Sis nonsed etumsandre</h2><p>Eugait loreet praesse min vulpute tat</p>\r\n                                   </td>\r\n								   \r\n                             </tr>\r\n							 <tr>\r\n                               <td class="res" colspan="2"><img src="{IMG_DIR}templates/egal.png" />\r\n                                   </td>						   \r\n								   \r\n                             </tr>\r\n							 <tr>\r\n                               <td class="res" colspan="2"><h2>Od eliquis erostrud</h2>\r\n							   <p>Duisl iureetue mod te molobor perilisl do con erit at pratue.</p><p>Nonsequ ipsusci esequam zzrillan eu faccum veliquamcor sisi tet ad molesti sismodolore facidunt niscinibh ese min et alisl utpat.</p>\r\n                                   </td>						   \r\n								   \r\n                             </tr>\r\n               </table>\r\n                         \r\n\r\n				</td>\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(30, 'TemplateTitleTextFourX', 'TemplateTitleTextFourXDescription', 'textxfour.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent">\r\n				<tr>\r\n				<td valign="top">\r\n			\r\n				<!-- tableau gauche pour les 4 items -->\r\n				<table class="quatreitems table_actions table_actions_rows" cellspacing="10">\r\n				<tr>\r\n				  <td class="rond" style="background-color:#e6e5e4; background-image:url(design/degrade3.jpg)"><p>si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p>\r\n				    <p>si erilit ad magna ad </p>\r\n				    </td>\r\n					<td class="rond" style="background-color:#d3d2d1; background-image:url(design/degrade2.jpg)"><p>Deliquisim vero ex enibh ectem il in ullummodolor at.<br />\r\nRatem ipis at alit irit ipit wis nim in veliscipit</p>\r\n				    </td>				  \r\n				</tr>\r\n				<tr>\r\n					<td class="rond" style="background-color:#d3d2d1; background-image:url(design/degrade2.jpg)"><p>Ulla conse feugait lor sustrud minit prat. Esto odolorpero   con vendipsusto eum adit wisit, si erilit ad magna.</p>\r\n				    </td>\r\n					<td class="rond" style="background-color:#e8e1dc; background-image:url(design/degrade1.jpg)"><p>Essi bla accum zzrit aliquis er in erostio dolore   doloreet aliquat. Duip eugiate consed magna faci blam.</p>\r\n				    </td>	\r\n				</tr>\r\n				</table>\r\n				<!-- fin tableau gauche pour les 4 items -->\r\n				</td>\r\n				\r\n				<td class="imagecenter">\r\n				<h2>Ad lorem ipsum</h2>\r\n				<p>Riure con et vulluptat, veniam, consequamet, commolor iliquat dunt iureraessi.\r\nUptat. Ectem doloreet alis nonsed magna feuisim et at. Rit vullaore vullan ut nulla commy nos num ver sim ver</p>\r\n				 <img src="{IMG_DIR}templates/carrefour.jpg" alt="" />\r\n				</td>\r\n				\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(31, 'TemplateTitleTitle', 'TemplateTitleTitleDescription', 'title.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr><td>\r\n	    \r\n				\r\n				<!-- tableau gris container -->\r\n				<table class="greyframetitle">\r\n				<tr><td>\r\n					 <!-- tableau blanc container -->\r\n					 <table class="whiteframetitle">\r\n                       <tr>\r\n					   <td><table><tr><td><img src="{IMG_DIR}templates/instructor-coming.jpg" /></td></tr></table></td>\r\n                       <td><h1 class="orange">Ad Lorem Ipsum</h1><h2 class="orange">Essi bla accum zzrit aliquis</h2></td>\r\n                       </tr>\r\n					   </table>\r\n					   </td></tr>\r\n		              </table>\r\n				     <!-- fin du tableau blanc container -->\r\n				</td>\r\n				</tr>\r\n				</table><!-- fin du tableau gris container -->\r\n	  		</td>\r\n			</tr>\r\n                         \r\n\r\n				</td>\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(38, 'TemplateTitleSound', 'TemplateTitleSoundDescription', 'sound.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				<!-- tableau gauche pour bulle + perso -->\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk-ud"><p>si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p>\r\n				    </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-speaking.jpg" alt="" /></td>\r\n				</tr>\r\n				\r\n				</table>\r\n				<!-- fin tableau gauche -->\r\n				</td>\r\n				\r\n				<td>\r\n				\r\n				\r\n				     <!-- tableau gris container -->\r\n				     <table class="sound table_actions table_actions_rows" >\r\n                        <tr><td class="readsound"><img src="{IMG_DIR}templates/placeholder-son.jpg" /></td></tr>                           \r\n                       <tr><td class="commentsound"><h2>Isse magnismolore dolore con</h2>							   \r\n                                   <p>Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam.</p>\r\n                                   <p>Ulla conse feugait lor sustrud minit prat. Esto odolorpero con vendipsusto eum adit wisit, si erilit ad magna.</p>\r\n								   <p>Riure con et vulluptat, veniam, consequamet, commolor iliquat dunt iureraessi.\r\nUptat. Ectem doloreet alis nonsed magna feuisim et at. Rit vullaore vullan ut nulla commy nos num ver sim ver.</p></td></tr>\r\n					   \r\n                      </table>\r\n				     \r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES (39, 'TemplateTitleSimpleBase', 'TemplateTitleSimpleBaseDescription', 'simplebase.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr><td>\r\n				<!-- left table buble + perso -->\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk"><p>si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p>\r\n				    </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-two.jpg" alt="" /></td>\r\n				</tr>\r\n				</table>\r\n				<!-- end left table -->\r\n				</td>\r\n				\r\n				<td>\r\n                                <h2 style="padding-left:27px">Essi bla </h2>\r\n				<table class="base table_actions table_actions_rows">\r\n                             \r\n                             <tr>\r\n							 <td>\r\n				\r\n							  <h3>Endrem zzrit dolorem in velit volor sustrud</h3>\r\n                                   <p>Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam.</p>\r\n								   <h4>Vel delessis nos nullandre</h4>\r\n								   <p>Re tat lutem nullaor ercing eugait loreet praesse min vulpute tat. Luptate tat aci enim quiscidui bla feuisis cipissecte cons non heniat lumsan vullut ut.</p>\r\n								   <h4>Velenis dipis dolor si</h4>\r\n								   <p>Aliquatem volore dolor sustio eugiat la cons nibh exercing ea facidui scipit iustie corem dolore erit ad magnibh et, consequis dit atum zzrilit landrerostin.</p>\r\n</tr>\r\n</td>\r\n<tr>\r\n<td>\r\n								   <h3>Etumsandre euguer adigna</h3>\r\n<p>Lore ming ex endre euis nullaor adit voloborero od eliquis erostrud dignit luptat. Ex ea facilismod tet acincip sustrud modiam, cons nonum init, sis nonsed etumsandre euguer adigna feuguer cidunt iuscilis num augait lore consequisi.</p></td>\r\n                             </tr>\r\n                             \r\n               </table>\r\n                         \r\n\r\n				</td>\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course -->\r\n</body>');
INSERT INTO system_template VALUES(32, 'TemplateTitleVideo320', 'TemplateTitleVideo320Description', 'video320.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				\r\n				\r\n				     <!-- tableau gris contenant le tableau video et le tableau texte -->\r\n				     \r\n					   <!-- tableau video et sa legende -->\r\n					   <table class="videoplace"><tr><td><img src="{IMG_DIR}templates/little-placeholder-video.jpg" /></td></tr><tr><td class="undervideo"><p>Aliquis er in erostio dolore dolore et aliquat. Duip eugiate consed magna</p>\r\n					     </td></tr>\r\n						</table>\r\n						<!-- fin tableau video et sa legende -->\r\n						 </td>\r\n						 \r\n                         <td>\r\n						 <!-- tableau pour le texte a droite -->\r\n						 <table class="commentvideo">\r\n                          \r\n                           <tr>\r\n                             <td><h2 class="orange">Ad lorem ipsum</h2>\r\n							     <table><tr><td><p>Aliquis er in erostio dolore dolore et aliquat. Duip eugiate consed magna.</p>\r\n							           <p>Si tatet alit nullaor sum aut prat num illa facip etum quat verilit la faci te tat. Oborem qui tat diat. Ut alit lor inim volobore dit, quipit venissi bla ad dolor adit augiat. Pit landit iriliquisi te cons et in ut eu feuguerci blandipit alis dit atueriure magna faccum velenim velit wis eu feugait et adipis nis nullaor perosto dolorem ipit iurerci eraesto.</p></td><td><img src="{IMG_DIR}templates/instructor-projection.jpg" /></td></tr></table>\r\n                           \r\n                             </td>\r\n                           </tr>\r\n                         </table>\r\n                           <!-- fin du tableau pour le texte a droite -->                         \r\n					\r\n\r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(33, 'TemplateTitleVideo480', 'TemplateTitleVideo480Description', 'video480.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				\r\n				\r\n				     <!-- tableau gris contenant le tableau video et le tableau texte -->\r\n				     \r\n					   <!-- tableau video et sa l?gende -->\r\n					   <table class="videoplace480"><tr><td><img src="{IMG_DIR}templates/placeholder-video2.jpg" /></td></tr><tr><td class="undervideo"><p>Aliquis er in erostio dolore dolore et aliquat. Duip eugiate consed magna.</p>\r\n					     </td></tr>\r\n						</table>\r\n						<!-- fin tableau video et sa legende -->\r\n						 </td>\r\n						 \r\n                         <td>\r\n						 <!-- tableau pour le texte a droite -->\r\n						 <table class="commentvideo">\r\n                          \r\n                           <tr>\r\n                             <td><h2 class="orange">Ad lorem ipsum</h2>\r\n							     <table><tr><td><p>Aliquis er in erostio dolore dolore et aliquat. Duip eugiate consed magna.</p>\r\n							           <p>Si tatet alit nullaor sum aut prat num illa facip etum quat verilit la faci te tat. Oborem qui tat diat. Ut alit lor inim volobore dit, quipit venissi bla ad dolor adit augiat. Pit landit iriliquisi te cons et in ut eu feuguerci.</p><p>Ommy nostionsed exeros esto eliqui bla facipsumsan volenit velestisl diat.</p></td><td><img src="{IMG_DIR}templates/instructor-projection.jpg" /></td></tr></table>\r\n                           \r\n                             </td>\r\n                           </tr>\r\n                         </table>\r\n                           <!-- fin du tableau pour le texte a droite -->                         \r\n					\r\n\r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(34, 'TemplateTitleTrueFalse', 'TemplateTitleTrueFalseDescription', 'truefalse.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent">\r\n				<tr>\r\n			    <td class="imagecenter"><img src="{IMG_DIR}templates/instructor-truefalse.jpg" /></td>				\r\n				<td>\r\n				   <!-- tableau mis en page -->\r\n				   <table class="tabletruefalse table_actions table_actions_rows">\r\n				   <tr><th>Re tat lutem nullaor ercing</th><th>Cipissecte</th><th>Od eliquis</th>\r\n				   <tr>\r\n				   <td class="theQ"><p>Luptate tat aci enim quiscidui bla feuisis cipissecte cons non heniat lumsan</p></td><td class="TF"><img src="{IMG_DIR}templates/icone-V-QUIZ.png" /></td><td class="TF"></td>\r\n				   </tr>\r\n				   <tr>\r\n				   <td class="theQ"><p>Lore ming ex endre euis nullaor adit voloborero od eliquis erostrud dignit luptat</p></td><td class="TF"></td><td class="TF"><img src="{IMG_DIR}templates/icone-V-QUIZ.png" /></td>\r\n				   </tr>\r\n				   <tr>\r\n				   <td class="theQ"><p>Faccum veliquamcor sisi tet ad molesti sismodolore facidunt niscinibh ese min et alisl utpat</p></td><td class="TF"><img src="{IMG_DIR}templates/icone-V-QUIZ.png" /></td><td class="TF"><img src="{IMG_DIR}templates/icone-V-QUIZ.png" /></td>\r\n				   </tr>\r\n				   <tr>\r\n				   <td class="theQ"><p>Re tat lutem nullaor ercing eugait loreet praesse min vulpute ta</p></td><td class="TF"><img src="{IMG_DIR}templates/icone-V-QUIZ.png" /></td><td class="TF"></td>\r\n				   </tr>\r\n				   <tr>\r\n				   <td class="theQ"><p>Tem nis endions equat. Lestisl ut prat, sum zzrit, consequat</p></td><td class="TF"><img src="{IMG_DIR}templates/icone-V-QUIZ.png" /></td><td class="TF"><img src="{IMG_DIR}templates/icone-V-QUIZ.png" /></td\r\n				   </tr>			   \r\n				   </table>\r\n				   <!-- fin tableau mis en page -->				\r\n			  </td>\r\n			</tr>\r\n			</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n		  </td>\r\n		  </tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(35, 'TemplateTitleTable', 'TemplateTitleTableDescription', 'table2.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr><td>\r\n				 <!-- tableau mis en page -->\r\n				   <table class="the-tableau table_actions table_actions_rows">\r\n				   <tr class="premiere">\r\n				   <td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td>\r\n				   </tr>\r\n				   <tr class="ligne">\r\n				   <td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td>\r\n				   </tr>\r\n				   <tr class="ligne">\r\n				   <td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td>\r\n				   </tr>\r\n				   <tr class="ligne">\r\n				   <td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td>\r\n				   </tr>\r\n				   <tr class="ligne">\r\n				   <td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td><td>ad lorem ipsum</td>\r\n				   </tr>\r\n				   </table>\r\n				   <!-- fin tableau mis en page -->\r\n\r\n				</td>\r\n				</tr>\r\n				\r\n				<tr><td>\r\n				<table class="comments"> \r\n				<tr>\r\n				<td>\r\n			\r\n				<!-- tableau post-it -->\r\n				<table class="post-it-table">\r\n				<tr>\r\n				<td class="PI">\r\n				  <!-- tableau enchesse pour le bord corne droit -->\r\n				  <table class="PI-corner">\r\n				  <tr><td>\r\n				  <h2>LOREM IPSUM </h2>\r\n				  <p>Ulla conse feugait lor sustrud minit prat. Esto odolorpero con vendipsusto eum adit wisit, si erilit ad magna.			    </p>\r\n				  </td></tr></table>\r\n				  <!-- fin tableau enchenchesse pour le bord corne droit -->\r\n				</td>\r\n				</tr>\r\n				</table>\r\n				<!-- fin tableau post-it -->\r\n			   </td>\r\n				\r\n				<td >\r\n				<img src="{IMG_DIR}templates/instructor-board.jpg" alt="" /></td></tr>\r\n				</td>				\r\n		  	   </tr>	\r\n			   </table>\r\n			\r\n			   </td></tr></table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(40, 'TemplateTitleProcess', 'TemplateTitleProcessDescription', 'process.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent">\r\n				<tr><td>\r\n						<table style="background-color:#dcdcde; margin:0px 12px" class="table_actions table_actions_columns">\r\n				  		<tr height="150"  >\r\n						<td class="first-item-process">Lor sustrud minit prat</td>\r\n						<td class="cell-item-process">Esto odolorpero con vendipsusto</td>\r\n						<td class="cell-item-process">Vendipsusto eum adit wisit, si erilit ad magna</td>\r\n						<td class="cell-item-process">Si erilit ad magna.</td>\r\n						<td class="cell-item-process">Si erilit ad magna.</td>\r\n						<td width="40" style="background-image:url(design/process-end.jpg); background-repeat:no-repeat; background-position:center right">&nbsp;</td>\r\n				  		</tr>\r\n				       </table>\r\n				</td></tr>\r\n				<tr><td><table class="comments">\r\n                  <tr>\r\n                    <td><!-- tableau post-it -->\r\n                        <table class="post-it-table">\r\n                          <tr>\r\n                            <td class="PI"><!-- tableau enchesse pour le bord corne droit -->\r\n                                <table class="PI-corner">\r\n                                  <tr>\r\n                                    <td><h2>LOREM IPSUM </h2>\r\n                                        <p>Ulla conse feugait lor sustrud minit prat. Esto odolorpero con vendipsusto eum adit wisit, si erilit ad magna.</p>\r\n                                      <p>Riure con et vulluptat, veniam, consequamet, commolor iliquat dunt iureraessi.\r\n                                        Uptat. Ectem doloreet alis nonsed magna feuisim et at. Rit vullaore vullan ut nulla commy nos num ver sim ver.</p></td>\r\n                                  </tr>\r\n                                </table>\r\n                              <!-- fin tableau enchesse pour le bord corne droit -->                            </td>\r\n                          </tr>\r\n                        </table>\r\n                      <!-- fin tableau post-it -->                    \r\n					</td>\r\n                    <td class="imagecenter"><img src="{IMG_DIR}templates/instructor-analysis.jpg" /> </td>\r\n                  </tr>\r\n                </table></td>\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(41, 'TemplateTitlePhases', 'TemplateTitlePhasesDescription', 'phases.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent">\r\n				<tr><td>\r\n				<!-- left table buble + perso -->\r\n				<table class="perso-and-buble" style="width:250px">\r\n				<tr>\r\n				  <td id="buble-talk"><p>si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p>\r\n				    </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-two.jpg" alt="" /></td>\r\n				</tr>\r\n				</table>\r\n				<!-- end left table -->\r\n				</td>\r\n				<td>\r\n				<table class="phases table_actions table_actions_columns">\r\n                             \r\n                             <tr>\r\n                               <td class="phase"><h2>CONS NOMUM</h2>\r\n                                   </td>\r\n								   <td class="phase"><h2>ESSI BLA</h2>\r\n                                   </td>\r\n								   <td class="phase"><h2>SUM IN HENIM</h2>\r\n                                   </td>\r\n                             </tr>\r\n                            \r\n                             <tr>\r\n                               <td class="phaseresult"><h2>Od eliquis erostrud</h2>\r\n							   <p>Duisl iureetue mod te molobor perilisl do con erit at pratue</p>\r\n                                   </td>\r\n								   <td class="phaseresult"><h2>Sis nonsed etumsandre</h2><p>Eugait loreet praesse min vulpute tat</p>\r\n                                   </td>\r\n								   <td class="phaseresult"><h2>Dionsed te commy</h2><p>Luptate tat aci enim quiscidui bla feuisis cipissecte cons non heniat lumsan</p>\r\n                                   </td>\r\n                             </tr>\r\n               </table>\r\n                         \r\n\r\n				</td>\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(42, 'TemplateTitleMethodology', 'TemplateTitleMethodologyDescription', 'methodology.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent">\r\n				\r\n				<tr>						\r\n				<td>\r\n				<table class="methodology table_actions table_actions_columns">\r\n                             \r\n                             <tr>\r\n                               <td class="methofirst">\r\n							       <ul>\r\n								   <li>Od eliquis erostrud</li> <li>Re tat lutem nullaor ercing eugait loreet</li> <li>Corem dolore erit ad magnibh et, vel ute tatum ad te ea ad modolor </li></td>\r\n								<td class="methoarrow">\r\n								<img src="{IMG_DIR}templates/little-placeholder-image150.jpg" />\r\n								<h2>Veliquamcor sisi</h2>\r\n								  <p>Erostio dolore doloreet aliquat.</p>\r\n								  <p>Re tat lutem nullaor ercing eugait loreet.</p></td>\r\n								<td class="methoarrow">\r\n								<img src="{IMG_DIR}templates/little-placeholder-image150.jpg" />\r\n								<h2>Sis etumsandre</h2>\r\n								  <p>Duip eugiate consed magna faci blam.</p>\r\n								  <p>Nonsequ ipsusci esequam zzrillan eu.</p></td>\r\n								  <td class="methoarrow">\r\n								  <img src="{IMG_DIR}templates/little-placeholder-image150.jpg" />\r\n								  <h2>Essi bla </h2>\r\n								  <p>Duip eugiate consed magna faci blam.</p>\r\n								  <p>Ut ad enissequat wismolum augait.</p></td>\r\n                             </tr>\r\n                             \r\n							 \r\n                            \r\n               </table>                      \r\n\r\n				</td>\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n				<tr><td><table class="cellscontent"><tr><td><img src="{IMG_DIR}templates/instructor-coming.jpg"/></td><td><h2>Ea faciduis nullummy</h2><p>Essi bla Ut ad enissequat wismolum augait essenibh ea faciduis nullummy nulla alis nos nullam num dolum adigna faccum ilisl ex er sim vercipi scidunt la facinim deliqui scidunt alit praestie dignisit inibh eriustrud eraestinit nibh ectet essim duipissecte dit erit eummodo lendre vel er illa faccum irillaor </p></td></tr></table></td></tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(43, 'TemplateTitleItemsList', 'TemplateTitleItemsListDescription', 'itemslist.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr><td>\r\n				<!-- left table buble + perso -->\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk"><p>si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p>\r\n				    </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-two.jpg" alt="" /></td>\r\n				</tr>\r\n				</table>\r\n				<!-- end left table -->\r\n				</td>\r\n				\r\n				<td>\r\n				<table class="items table_actions table_actions_rows">\r\n                             \r\n                             <tr>\r\n                               <td class="arrow"><h2>Essi bla </h2>\r\n                                   <p>Essi bla accum zzrit aliquis er in erostio dolore doloreet aliquat. Duip eugiate consed magna faci blam.</p></td>\r\n                             </tr>\r\n                             <tr>\r\n                               <td class="arrow"><h2>Deliquissim vero </h2>\r\n                                   <p>Deliquisim vero ex enibh ectem il in ullummodolor at.<br />\r\n                                     Ratem ipis at alit irit ipit wis nim in veliscipit </p></td>\r\n                             </tr>\r\n                             <tr>\r\n                               <td class="arrow"><h2>Ulla conse </h2>\r\n                                   <p>Ulla conse feugait lor sustrud minit prat. Esto odolorpero con vendipsusto eum adit wisit, si erilit ad magna.</p></td>\r\n                             </tr>\r\n               </table>\r\n                         \r\n\r\n				</td>\r\n				</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(44, 'TemplateTitleK', 'TemplateTitleKDescription', 'k.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n			    <td class="illusleft"><img src="{IMG_DIR}templates/instructor-analysis.jpg" /></td>				\r\n				<td>\r\n				   <!-- tableau mis en page -->\r\n				   <table class="the-tableau table_actions table_actions_rows" id="the-tableau-K">\r\n				   <tr class="ligne-K">\r\n				   <td class="theK"><h3>ad lorem ipsum</h3></td><td class="expl">\r\n				   <h4>Ci ex et landipit nosto dolor sectet vel il dolore molore duisisit, quis exer</h4>\r\n				   <ul>\r\n				     <li>Velestrud mod dionsequate dolor.</li>\r\n				     <li>Iril ipisse magna faccum ex eugiatum dolesequip.</li></ul>\r\n				   \r\n				   </td>\r\n				   </tr>\r\n				   <tr class="ligne-K">\r\n				   <td class="theK"><h3>ad lorem ipsum</h3></td><td class="expl">\r\n				   <h4>Onsequi smodolore velit ullan eugiam enim do od modolorem vel ut aliquis</h4>\r\n				   <p>Deliquisim vero ex enibh ectem il in ullummodolor at.</p></td>\r\n				   </tr>\r\n				   <tr class="ligne-K">\r\n				   <td class="theK"><h3>ad lorem ipsum</h3></td><td class="expl">\r\n				   <h4>Magna corper sum iriurercipit lortisisi</h4>\r\n				  <ul>\r\n				  <li>Er sum vulla am diamet nisim irit, quisci bla</li>\r\n				  <li>Consequat nis elenibh eugiam zzrit utet do ero eum.</li>\r\n				  </ul>\r\n				  </td>\r\n				   </tr>\r\n				  \r\n				   \r\n				   </table>\r\n				   <!-- fin tableau mis en page -->\r\n				\r\n			  </td>\r\n			</tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(45, 'TemplateTitleMap', 'TemplateTitleMapDescription', 'map.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<!-- white table for the course -->\r\n		<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			\r\n				<!-- tableau gauche pour bulle + perso -->\r\n				<table class="perso-and-buble">\r\n				<tr>\r\n				  <td id="buble-talk"><p>si erilit ad magna ad dolorercing ea consequis dolorpe raessequat. Si erilit ad magna ad dolorercing.</p>\r\n				    </td>\r\n				  \r\n				</tr>\r\n				<tr>\r\n				<td><img src="{IMG_DIR}templates/instructor-path.jpg" alt="" /></td>\r\n				</tr>\r\n				\r\n				</table>\r\n				<!-- fin tableau gauche -->\r\n				</td>\r\n				\r\n				<td>\r\n				<!--- tableau droit pour la map --->\r\n				\r\n				     <table class="map table_actions table_actions_rows">\r\n                             <tr>\r\n                               <td class="part"><h2>Essi bla </h2>\r\n							   <h3>Eer in erostio dolore</h3>\r\n                                   <h4>Essi bla accum zzrit aliquis</h4><ul><li>Er in erostio dolore doloreet aliquat</li><li>Duip eugiate consed magna faci blam</li></ul>\r\n								   \r\n								<h3>Re eui eu feuipisim autem</h3>\r\n                                   <h4>zzrit dunt alisisl</h4><ul><li>Re eui eu feuipisim autem vendipsum </li><li>Nostie dolorti nciliqu ipiscil utat</li><li>Quisse dipit ver incillam eum iusci </li></ul>\r\n								</td>\r\n                             </tr>\r\n                             <tr>\r\n                               <td class="part"><h2>Esent irilisi blaor sisi</h2>\r\n                                 \r\n								   \r\n								<h3>Faccummy nim do od tio esse</h3>\r\n                                   <h4>Ut vero conullam</h4><ul><li>Ex et, qui estrud eu faccummy nostie dolorti nciliqu ipiscil</li><li>Em vel dolorer ciliqui smolor sequat</li></ul></td>\r\n                             </tr>\r\n				</table> \r\n				<!--- fin tableau droit pour la map"--->\r\n				</td>\r\n				\r\n			  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES(46, 'TemplateTitleTextArrow', 'TemplateTitleTextArrowDescription', 'textarrowthree.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n<table class="white"> \r\n		<tr><td><h1> LOREM IPSUM</h1></td></tr>\r\n		<tr>\r\n				<td>\r\n				<!-- table for the cells of content -->\r\n			    <table class="cellscontent"><tr>\r\n				<td>\r\n			   <!-- tableau fleche1 -->\r\n			   <table class="grey-arrow">				\r\n			   <tr><td>\r\n			   <h2>Ad ming erit</h2>\r\n			   <p>Consequat nis elenibh eugiam zzrit utet do ero eum iustrud dit alisisisit ad ming erit nim iure doloreetue doloreet nim dipit vulput dolorem venibh etum.</p>\r\n			   </td></tr>\r\n			   <tr><td class="fleche-grise"></td></tr>\r\n			  \r\n				</table>\r\n				<!-- fin tableau fleche1 -->\r\n				 <!-- tableau fleche2 -->\r\n			   <table class="grey-arrow">				\r\n			   <tr><td>\r\n			   <h2>Aut vel ex essequam veriustrud</h2>\r\n			     <p>Iril ipisse magna faccum ex eugiatum dolesequip essisit aut vel ex essequam veriustrud tatie mincip elisisl incip eliquip sustrud mincip ea feugue feuis. </p>\r\n			</td></tr>\r\n			   <tr>\r\n			     <td class="fleche-grise"></td>\r\n			   </tr>\r\n			  \r\n				</table>\r\n				<!-- fin tableau fleche2 -->\r\n				\r\n				 <!-- tableau 3 -->\r\n			   <table class="dark-grey">				\r\n			   <tr><td>\r\n			   <h2>Magna corper sum iriurercipit lortisisi</h2>\r\n			  \r\n<p>Si tatet alit nullaor sum aut prat num illa facip etum quat verilit la faci te tat. Oborem qui tat diat.</p>\r\n			 \r\n			   </td></tr>\r\n			  \r\n			  \r\n				</table>\r\n				<!-- fin tableau 3 -->\r\n				</td>\r\n				\r\n				<td>\r\n				<!--- tableau droit pour lillustration et la bulle--->\r\n				<table class="perso-and-buble">\r\n				<tr><td id="buble-talk">\r\n				<p>Deliquat ute faccummy nullums andionsed et wisci bla consequis eraestrud magna adipsus cidunt ullam, consed erci blandipit landre.</p></td>\r\n				</tr>\r\n				<tr><td><img src="{IMG_DIR}templates/instructor-3fingers.jpg" alt="" /></td>\r\n				</tr>\r\n				</table> \r\n				<!--- fin tableau droit pour lillustration et la bulle --->\r\n				</td>\r\n				\r\n		  </tr>\r\n				</table>\r\n				<!-- end table for the cells of content -->\r\n				\r\n				</td>\r\n				</tr>\r\n								\r\n		  </table><!-- end white table for the course --></body>');
INSERT INTO system_template VALUES (50, 'Template01Dokeos', 'Template01DokeosDescription', 'template01.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">       \r\n.background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center center;\r\n}\r\n\r\n        .justify {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 20px;\r\n	padding-bottom: 5px;\r\n	padding-left: 20px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #333;\r\n}\r\n        .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 20px;\r\n	padding-right: 40px;\r\n	padding-top: 5px;\r\n}\r\n        </style></p>\r\n        <p></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" height="38" class="h1_tmp">LOREM IPSUM</td>\r\n                </tr>\r\n                <tr>\r\n                    <td height="3"><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td>\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td valign="top">\r\n                                                        <table align="center" width="100%" cellspacing="2" cellpadding="1" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td valign="middle" class="h2_tmp">Blandit sit amet eros</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td valign="top" class="justify">\r\n                                                                    <p>Fusce lobortis interdum tempus. Sed elit risus, cursus vitae bibendum sed, malesuada scelerisque mi.</p>\r\n                                                                    <p>Maecenas interdum tristique eros, eget scelerisque ligula cursus eget. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque mauris mi, pharetra posuere posuere at, sollicitudin ac felis. Aenean non lorem orci.</p>\r\n                                                                    <p>Nunc lobortis, elit vitae adipiscing varius, erat mi venenatis nisl, eu blandit mauris justo ac ante. Nam consequat, dolor quis lobortis malesuada, nibh augue tristique mauris, at adipiscing purus justo eu libero. Vestibulum laoreet velit ac mi mattis vel vestibulum sapien vulputate. Donec volutpat magna ac turpis congue vitae congue sem convallis. Nulla rhoncus vestibulum sapien.</p>\r\n                                                                    <p>Fusce odio lectus, cursus ut cursus a, rutrum a orci. Donec nunc libero, eleifend et rhoncus ornare, blandit sit amet eros. Vivamus fermentum malesuada tempus. Aliquam sollicitudin tristique eros vel tempor.</p>\r\n                                                                    <p>Ut fringilla sodales eros in laoreet. Morbi gravida fermentum quam at luctus.</p>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </td>\r\n                                                        <td width="289" valign="bottom" height="327"><img align="absmiddle" width="327" vspace="0" border="0" hspace="0" height="265" src="mascot/mascot1.png" alt="mascot1.png" /></td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>');
INSERT INTO system_template VALUES (51, 'Template02Dokeos', 'Template02DokeosDescription', 'template02.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n    .background {\r\n        background-image: url(images/templates/background.png);\r\n        background-repeat: repeat-x;\r\n        background-position: center center;\r\n    }\r\n    \r\n    \r\n            .justify {\r\n        text-align: justify;\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n        padding-top: 10px;\r\n        padding-bottom: 10px;\r\n    }\r\n            .background_top {\r\n        background-image: url(img/background_box_top.png);\r\n        background-position: left top;\r\n        background-repeat: no-repeat;\r\n    }\r\n            .background_top_middle {\r\n        background-image: url(img/background_box_middle.png);\r\n        background-repeat: repeat-y;\r\n        background-position: left;\r\n    }\r\n            .background_top_bottom {\r\n        background-image: url(img/background_box_bottom.png);\r\n        background-repeat: no-repeat;\r\n        background-position: left bottom;\r\n    }\r\n                .h1_tmp {\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 20px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n        padding-left: 5px;\r\n    }\r\n            .h2_tmp {\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n    }\r\n            \r\n              #tmp_left{\r\n       background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n \r\n	position:relative;\r\n	display:inline;\r\n	margin:8px 13px 0 19px;\r\n	text-align:justify;\r\n	padding:15px;\r\n	width:230px;\r\n	min-height:420px;\r\n	height:auto;\r\n	float:left;\r\n	-webkit-box-shadow: 3px 3px 3px #cccccc;\r\n	-moz-box-shadow: 3px 3px 3px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	border-radius:1px;\r\n            }	   \r\n          \r\n            #tmp_righ{\r\n	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	 \r\n	position:relative;\r\n	display:inline;\r\n	margin:8px 13px 0 19px;\r\n	text-align:justify;\r\n	padding:15px;\r\n	width:230px;\r\n	min-height:420px;\r\n	height:auto;\r\n	float:right;\r\n	-webkit-box-shadow: 3px 3px 3px #cccccc;\r\n	-moz-box-shadow: 3px 3px 3px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	border-radius:1px;\r\n            }	\r\n            \r\n                       .justify1 {	text-align: justify;\r\n        padding-top: 10px;\r\n        padding-right: 40px;\r\n        padding-bottom: 5px;\r\n        padding-left: 30px;\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n    }\r\n                .h2_tmp1 {	font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n        padding-left: 30px;\r\n        padding-right: 40px;\r\n        padding-top: 5px;\r\n    }\r\n                </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" class="h1_tmp">LOREM IPSUM</td>\r\n                </tr>\r\n                <tr>\r\n                    <td height="4"><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td>\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td width="612" valign="top" height="100%">\r\n                                                        <div id="tmp_left">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td>\r\n                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                                        <tbody>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp">Le passage de Lorem Ipsum</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify">Sed a purus in quam bibendum placerat. Integer id fermentum erat. Donec eget dui purus, ut imperdiet ante. Aliquam erat volutpat.                                      Nullam dapibus pretium leo at vestibulum. Suspendisse potenti. Pellentesque et dolor nisi, eget lacinia lectus. Etiam et elit vel felis consequat pellentesque.</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp">Fusce est augue accumsan vitae adipiscing</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut ut fermentum felis.&nbsp;</td>\r\n                                                                            </tr>\r\n                                                                        </tbody>\r\n                                                                    </table>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        <div id="tmp_righ">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp">Le passage de Lorem Ipsum</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify">Vivamus orci elit, dapibus a tempus placerat, porta a libero. Integer rhoncus urna quis sapien semper vehicula. Fusce est augue, accumsan vitae adipiscing vitae, sagittis ultricies orci.</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp">Ut semper tellus ac erat ornare vel.</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td span="" dolor.="" vehicula="" vel="" risus="" id="" ultrices.="" sagittis="" vestibulum="" pellentesque="" libero.="" a="" sollicitudin="" aliquet="" ut="" ornare="" justo="" nunc="" class="justify">Suspendisse potenti. Pellentesque et dolor nisi, eget lacinia lectus. Etiam et elit vel felis consequat pellentesque.</td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        <table align="center" width="100%" cellspacing="2" cellpadding="1" border="0">\r\n                                                        </table>\r\n                                                        <p>&nbsp;</p>\r\n                                                        </td>\r\n                                                        <td align="center" width="286" valign="bottom" height="327"><img align="absmiddle" width="285" vspace="0" border="0" hspace="0" height="291" alt="mascot2.png" src="mascot/mascot2.png" /></td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>\r\n');
INSERT INTO system_template VALUES (52, 'Template03Dokeos', 'Template03DokeosDescription', 'template03.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n \r\n    <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n.background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center center;\r\n}\r\n\r\n\r\n        .justify {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 45px;\r\n	padding-bottom: 5px;\r\n	padding-left: 30px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #333;\r\n}\r\n      \r\n         .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 30px;\r\n	padding-right: 40px;\r\n	padding-top: 5px;\r\n}\r\n        .h2_tmp1 {        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n.justify1 {        text-align: justify;\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n        padding-top: 10px;\r\n        padding-bottom: 10px;\r\n}\r\n#tmp_left {        background-color:#ffffff;\r\n        border: 1px solid #ffffff;\r\n        margin:left;\r\n        positio:relative;\r\n        display:inline;\r\n        margin:8px 13px 0 19px;\r\n        text-align:justify;\r\n        padding:15px;\r\n        width:560px;\r\n        min-height:270px;\r\n        float:left;\r\n        -webkit-box-shadow: 3px 3px 3px #cccccc;\r\n        -moz-box-shadow: 3px 3px 3px #cccccc;\r\n        box-shadow: 0px 0px 7px #cccccc;\r\n        border-radius:1px;\r\n}\r\n           </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" height="38" class="h1_tmp">VESTIBULUM ID SAPIEN NEC ENIM.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td height="4"><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td>\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td valign="top">\r\n                                                        <div id="tmp_left">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td>\r\n                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                                        <tbody>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp1">Le passage de Lorem Ipsum</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">Sed a purus in quam bibendum placerat. Integer id fermentum erat. Donec eget dui purus, ut imperdiet ante. Aliquam erat volutpat.                                      Nullam dapibus pretium leo at vestibulum. Suspendisse potenti. Pellentesque et dolor nisi, eget lacinia lectus. Etiam et elit vel felis consequat pellentesque.</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp1">Fusce est augue accumsan vitae adipiscing</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut ut fermentum felis.&nbsp;</td>\r\n                                                                            </tr>\r\n                                                                        </tbody>\r\n                                                                    </table>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        </td>\r\n                                                        <td align="right" width="320" valign="bottom" height="327"><img align="absmiddle" width="276" vspace="0" border="0" hspace="0" height="240" alt="avatar3.png" src="mascot/avatar3.png" /></td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n       </body>\r\n');
INSERT INTO system_template VALUES (53, 'Template04Dokeos', 'Template04DokeosDescription', 'template04.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n.background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center center;\r\n}\r\n\r\n\r\n        .justify {\r\n	text-align: justify;\r\n	padding-top: 10px;\r\n	padding-bottom: 10px; \r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #333;\r\n}\r\n         \r\n       .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	 \r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	 \r\n}\r\n	      #tmp_left{\r\n        background-color:#ffffff;\r\n        border: 1px solid #ffffff;\r\n       \r\n        \r\n      \r\n        margin:8px 13px 0 50px;\r\n        text-align:justify;\r\n        padding:15px;\r\n        width:260px;\r\n        min-height:350px;\r\n        float:left;\r\n        -webkit-box-shadow: 0px 0px 7px #cccccc;\r\n        -moz-box-shadow: 0px 0px 7px #cccccc;\r\n        box-shadow: 0px 0px 7px #cccccc;\r\n        border-radius:1px;\r\n            }	   \r\n          \r\n            #tmp_righ{\r\n	 background-color:#ffffff;\r\n        border: 1px solid #ffffff;\r\n       \r\n     \r\n        margin:8px 50px 0 19px;\r\n        text-align:justify;\r\n        padding:15px;\r\n        width:260px;\r\n        min-height:350px;\r\n        float:right;\r\n        -webkit-box-shadow: 0px 0px 7px #cccccc;\r\n        -moz-box-shadow: 0px 0px 7px #cccccc;\r\n        box-shadow: 0px 0px 7px #cccccc;\r\n        border-radius:1px;\r\n            }	\r\n	   \r\n	   \r\n	   \r\n\r\n           </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895">\r\n                    <h1 class="h1_tmp">LOREM IPSUM</h1>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td height="3"><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="350" class="background">\r\n                    <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                        <tbody>\r\n                            <tr>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <div id="tmp_left">\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td class="h2_tmp"><span class="justify1">Pellentesque id risus tellus</span></td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="justify"><span class="justify1">Pellentesque id risus tellus</span> urna quis sapien semper vehicula. Fusce est augue, accumsan vitae adipiscing vitae, sagittis ultricies orci.</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="h2_tmp">Fusce est augue, accumsan</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="justify"><span class="justify1"> A libero. Pellentesque vestibulum sagittis ultrices. Pellentesque id risus tellus, vel vehicula dolor. </span></td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </div>\r\n                                <div id="tmp_righ">\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td class="h2_tmp">Le passage de Lorem Ipsum</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="justify">Vivamus orci elit, dapibus a tempus placerat, porta a libero. Integer rhoncus urna quis sapien semper vehicula. Fusce est augue, accumsan vitae adipiscing vitae, sagittis ultricies orci.</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="h2_tmp">Ut semper tellus ac erat ornare vel.</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="justify"><span class="justify1">Nunc justo dui, ornare ut aliquet sed, sollicitudin a libero. Pellentesque vestibulum sagittis ultrices. Pellentesque id risus tellus, vel vehicula dolor. </span></td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </div>\r\n                                </td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td align="center"><img align="absmiddle" width="285" vspace="0" border="0" hspace="0" height="197" src="mascot/mascot4.png" alt="mascot4.png" /></td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>');
INSERT INTO system_template VALUES (54, 'Template05Dokeos', 'Template05DokeosDescription', 'template05.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n        .background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center center;\r\n}        .justify {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 30px;\r\n	padding-bottom: 5px;\r\n	padding-left: 30px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #333;\r\n}               \r\n       .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 30px;\r\n	padding-right: 40px;\r\n	padding-top: 8px;\r\n	padding-bottom: 5px;\r\n}\r\n	   \r\n	   \r\n	   \r\n	    .h2_tmp1 {	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 30px;\r\n	padding-right: 40px;\r\n	padding-top: 5px;\r\n}\r\n.h2_tmp1 {font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n.justify1 {text-align: justify;\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n        padding-top: 10px;\r\n        padding-bottom: 10px;\r\n}\r\n        .h2_tmp2 {	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 30px;\r\n	padding-right: 40px;\r\n	padding-top: 5px;\r\n}\r\n.h2_tmp11 {font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n#tmp_left {background-color:#ffffff;\r\n        border: 1px solid #ffffff;\r\n        margin:left;\r\n        positio:relative;\r\n        display:inline;\r\n        margin:8px 13px 0 19px;\r\n        text-align:justify;\r\n        padding:15px;\r\n        width:520px;\r\n        min-height:265px;\r\n        float:left;\r\n        -webkit-box-shadow: 0px 0px 7px #cccccc;\r\n        -moz-box-shadow: 0px 0px 7px #cccccc;\r\n        box-shadow: 0px 0px 7px #cccccc;\r\n        border-radius:1px;\r\n}\r\n        </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" height="27" class="h1_tmp">Aliquam quis ipsum urna quis varius nulla.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td height="3" class="h1_tmp"><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td>\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td width="550" valign="top">\r\n                                                        <div id="tmp_left">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td>\r\n                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                                        <tbody>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp11">Le passage de Lorem Ipsum</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">Pellentesque eget ligula in felis consectetur commodo. Aliquam et erat et nunc ornare vehicula. Nulla facilisi. Phasellus nunc augue, adipiscing id pellentesque eu, faucibus non nisl. Ut libero turpis, pellentesque ut vestibulum et, bibendum dignissim felis. Vivamus viverra, tellus eget mollis facilisis, leo ante viverra nisi, sit amet faucibus arcu magna at nisl. Vestibulum at lectus eros, imperdiet semper ipsum. Vestibulum non molestie ligula.</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp11"><span class="h2_tmp2">Suspendisse leo quam </span></td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">\r\n                                                                                <p>Ut tortor ipsum, elementum id convallis consequat, laoreet eu tortor. Maecenas at adipiscing nunc. Nunc sollicitudin, tellus et tincidunt semper, odio elit pharetra leo, quis faucibus tellus diam at est. Curabitur vel turpis vitae urna tincidunt viverra. Sed et purus quis neque venenatis cursus vitae at risus.</p>\r\n                                                                                <p></p>\r\n                                                                                </td>\r\n                                                                            </tr>\r\n                                                                        </tbody>\r\n                                                                    </table>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        </td>\r\n                                                        <td width="309" valign="bottom" height="327"><img align="absmiddle" width="321" vspace="0" border="0" hspace="0" height="330" src="mascot/img5.png" alt="img5.png" /></td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>\r\n');
INSERT INTO system_template VALUES (55, 'Template06Dokeos', 'Template06DokeosDescription', 'template06.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n \r\n    <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n        .background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center center;\r\n}       \r\n       .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 30px;\r\n	padding-right: 40px;\r\n	padding-top: 8px;\r\n	padding-bottom: 5px;\r\n}\r\n	    .h2_tmp1 {        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n\r\n.justify {text-align: justify;\r\n        padding-top: 10px;\r\n        padding-bottom: 10px;\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n}\r\n\r\n#tmp_left {\r\n	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	 \r\n	 \r\n	margin-top:10px;\r\nmargin-left:10px;\r\nmargin-right: 10px;\r\nmargin-bottom: 10px;\r\n	text-align:justify;\r\n	padding:15px;\r\n	width:200px;\r\n	min-height:250px;\r\n	height: auto;\r\n	float:left;\r\n	-webkit-box-shadow: 0px 0px 7px #cccccc;\r\n	-moz-box-shadow: 0px 0px 7px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	filter: progid:DXImageTransform.Microsoft.Shadow(color=\'#cccccc\', Direction=  135, 180,  Strength=5);\r\n	border-radius:1px;\r\n}\r\n\r\n\r\n#tmp_right {\r\n	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	 \r\n	 \r\n	margin-top:10px;\r\nmargin-left:10px;\r\nmargin-right: 10px;\r\nmargin-bottom: 10px;\r\n	text-align:justify;\r\n	padding:15px;\r\n	width:200px;\r\n	min-height:250px;\r\n	height: auto;\r\n	float:left;\r\n	-webkit-box-shadow: 0px 0px 7px #cccccc;\r\n	-moz-box-shadow: 0px 0px 7px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	filter: progid:DXImageTransform.Microsoft.Shadow(color=\'#cccccc\', Direction=  135, 180,  Strength=5);\r\n	border-radius:1px;\r\n}\r\n 	\r\n         </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" height="38" class="h1_tmp">Ut pellentesque ullamcorper nisi sed venenatis.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td height="3"><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td>\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td width="524" valign="top">\r\n                                                        <div id="tmp_left">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp1">Aliquam quis erat at</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify">\r\n                                                                    <p>Aliquam erat volutpat. Aliquam enim nisi, rutrum imperdiet fermentum eget, ultrices sit amet libero. Mauris eget leo tellus, et auctor lacus. Pellentesque lobortis eros imperdiet nisl mollis a bibendum sem aliquam.</p>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        <div id="tmp_right">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp1">Porta sit amet consectetur nec</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify">\r\n                                                                    <p>Curabitur in massa vel mauris rutrum varius non vitae risus. Duis iaculis elementum risus vitae cursus. Quisque vel felis arcu, eget lobortis arcu.</p>\r\n                                                                    <p>Suspendisse euismod ipsum in erat molestie interdum. Nunc tempus luctus elit sed fermentum.</p>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        </td>\r\n                                                        <td align="center" width="353" valign="bottom" rowspan="2"><img align="absmiddle" width="327" vspace="0" border="0" hspace="0" height="343" src="mascot/mascot6.png" alt="mascot6.png" /></td>\r\n                                                    </tr>\r\n                                                    <tr>\r\n                                                        <td width="524" valign="top">\r\n                                                        <div id="tmp_left">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp1">Quisque vel felis arcu</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify">\r\n                                                                    <p>Curabitur in massa vel mauris rutrum varius non vitae risus. libero. Mauris eget leo tellus, et auctor lacus. Pellentesque lobortis eros imperdiet nisl mollis a bibendum sem aliquam.</p>\r\n                                                                    <p>&nbsp;</p>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        <div id="tmp_right">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp1">Porta sit amet consectetur nec</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify">\r\n                                                                    <p>Curabitur in massa vel mauris rutrum varius non vitae risus. Duis iaculis elementum risus vitae cursus. Quisque vel felis arcu, eget lobortis arcu.</p>\r\n                                                                    <p>Suspendisse euismod ipsum in erat molestie interdum. Nunc tempus luctus elit sed fermentum.</p>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        </td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>\r\n');
INSERT INTO system_template VALUES (56, 'Template07Dokeos', 'Template07DokeosDescription', 'template07.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n \r\n    <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n        .background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center bottom;\r\n}        .justify {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 20px;\r\n	padding-bottom: 5px;\r\n	padding-left: 5px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #333;\r\n}        .justify2 {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 95px;\r\n	padding-bottom: 5px;\r\n	padding-left: 90px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #333;\r\n}\r\n.background_top {\r\n	background-image: url(images/templates/background_box_top.png);\r\n	background-position: left top;\r\n	background-repeat: no-repeat;\r\n}        .background_top_middle {\r\n	background-image: url(images/templates/background_box_middle.png);\r\n	background-repeat: repeat-y;\r\n	background-position: left;\r\n}        .background_top_bottom {\r\n	background-image: url(images/templates/background_box_bottom.png);\r\n	background-repeat: no-repeat;\r\n	background-position: left bottom;\r\n}        \r\n       .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n	padding-right: 40px;\r\n	padding-top: 8px;\r\n	padding-bottom: 5px;\r\n}\r\n	    .h2_tmp1 {font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n.justify1 {text-align: justify;\r\n        padding-top: 10px;\r\n        padding-bottom: 10px;\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n}\r\n#tmp_right {\r\n	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	 \r\n	margin: 0 68px 10px 10px;\r\n	 \r\n	padding:15px;\r\n	width:470px;\r\n	min-height:250px;\r\n	height: auto;\r\n	float:right;\r\n	-webkit-box-shadow: 0px 0px 7px #cccccc;\r\n	-moz-box-shadow: 0px 0px 7px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	filter: progid:DXImageTransform.Microsoft.Shadow(color=\'#cccccc\', Direction=  135, 180,  Strength=5);\r\n	border-radius:1px;\r\n	left: 45px;\r\n}\r\n\r\n#tmp_left {\r\n	 \r\n	 \r\n	margin:left;\r\n	 \r\n	 \r\n	 \r\n	padding:10px;\r\n	width:235px;\r\n	min-height:250px;\r\n	height: auto;\r\n	float:left;\r\n	 \r\n	 \r\n	 \r\n}\r\n\r\n   </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" class="h1_tmp">\r\n                    <p>Maecenas viverra quam quis diam luctus pharetra</p>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td>\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td width="250" valign="top">\r\n                                                        <div id="tmp_left2">\r\n                                                        <table width="235" cellspacing="0" cellpadding="0" border="0" id="tmp_left">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td width="235" class="h2_tmp1">Porta sit amet consectetur nec</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify1">\r\n                                                                    <p>Curabitur in massa vel mauris rutrum varius non vitae risus. Duis iaculis elementum risus vitae cursus. Quisque vel felis arcu, eget lobortis arcu.</p>\r\n                                                                    <p>Suspendisse euismod ipsum in erat molestie interdum. Nunc tempus luctus elit sed fermentum.</p>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        </td>\r\n                                                        <td width="650" valign="top" height="327">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                        </table>\r\n                                                        <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td class="background_top">&nbsp;</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="background_top_middle">\r\n                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                                        <tbody>\r\n                                                                            <tr>\r\n                                                                                <td align="center">\r\n                                                                                <div id="tmp_right">\r\n                                                                                <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                                                    <tbody>\r\n                                                                                        <tr>\r\n                                                                                            <td class="h2_tmp1">Porta sit amet consectetur nec</td>\r\n                                                                                        </tr>\r\n                                                                                        <tr>\r\n                                                                                            <td class="justify1">\r\n                                                                                            <p>Curabitur in massa vel mauris rutrum varius non vitae risus. Duis iaculis elementum risus vitae cursus. Quisque vel felis arcu, eget lobortis arcu.</p>\r\n                                                                                            <p>Suspendisse euismod ipsum in erat molestie interdum. Nunc tempus luctus elit sed fermentum.</p>\r\n                                                                                            <p></p>\r\n                                                                                            </td>\r\n                                                                                        </tr>\r\n                                                                                    </tbody>\r\n                                                                                </table>\r\n                                                                                </div>\r\n                                                                                </td>\r\n                                                                            </tr>\r\n                                                                        </tbody>\r\n                                                                    </table>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td height="65" class="background_top_bottom">&nbsp;</td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        <p></p>\r\n                                                        </td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n       \r\n    </body>\r\n');
INSERT INTO system_template VALUES (57, 'Template08Dokeos', 'Template08DokeosDescription', 'template08.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n \r\n    <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n        .background {\r\n	background-image: url(images/templates/img/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center bottom;\r\n}        .justify {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 170px;\r\n	padding-bottom: 5px;\r\n	padding-left: 160px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #333;\r\n}        .background_top {\r\n	background-image: url(images/templates/background_box_top8.png);\r\n	background-position: left top;\r\n	background-repeat: no-repeat;\r\n}        .background_top_middle {\r\n	background-image: url(images/templates/background_box_middle8.png);\r\n	background-repeat: repeat-y;\r\n	background-position: left;\r\n}        .background_top_bottom {\r\n	background-image: url(images/templates/background_box_bottom8.png);\r\n	background-repeat: no-repeat;\r\n	background-position: left bottom;\r\n}        \r\n         .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 160px;\r\n	padding-right: 40px;\r\n	padding-top: 10px;\r\n	padding-bottom: 5px;\r\n}\r\n	   \r\n	    .h2_tmp1 {font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n.justify1 {text-align: justify;\r\n        padding-top: 10px;\r\n        padding-bottom: 10px;\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n}\r\n#tmp_center{\r\n	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	 \r\n	 \r\n	 \r\n	margin: -10px 0 10px 133px;\r\n	padding:15px;\r\n	width:594px;\r\n	min-height:250px;\r\n	height: auto;\r\n	float:left;\r\n	-webkit-box-shadow: 0px 0px 7px #cccccc;\r\n	-moz-box-shadow: 0px 0px 7px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	filter: progid:DXImageTransform.Microsoft.Shadow(color=\'#cccccc\', Direction=  135, 180,  Strength=5);\r\n	border-radius:1px;\r\n	 \r\n}\r\n         </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" height="38" class="h1_tmp">Aliquam sollicitudin tristique eros vel tempor.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td class="background_top">&nbsp;</td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td class="background_top_middle">\r\n                                            <div id="tmp_center">\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td class="h2_tmp1">Porta sit amet consectetur nec</td>\r\n                                                    </tr>\r\n                                                    <tr>\r\n                                                        <td class="justify1">\r\n                                                        <p>Curabitur in massa vel mauris rutrum varius non vitae risus. Duis iaculis elementum risus vitae cursus. Quisque vel felis arcu, eget lobortis arcu.</p>\r\n                                                        <p>Suspendisse euismod ipsum in erat molestie interdum. Nunc tempus luctus elit sed fermentum.</p>\r\n                                                        <p></p>\r\n                                                        <p></p>\r\n                                                        <p></p>\r\n                                                        </td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </div>\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td valign="top" height="75" class="background_top_bottom">\r\n                                            <p></p>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td valign="top" height="30">&nbsp;</td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>\r\n');
INSERT INTO system_template VALUES (58, 'Template09Dokeos', 'Template09DokeosDescription', 'template09.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n        .background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center center;\r\n}        .justify {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 80px;\r\n	padding-bottom: 5px;\r\n	padding-left: 70px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #333;\r\n}        .justify2 {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 20px;\r\n	padding-bottom: 5px;\r\n	padding-left: 70px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #333;\r\n}\r\n \r\n      .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 70px;\r\n	padding-right: 40px;\r\n	padding-top: 10px;\r\n	padding-bottom: 5px;\r\n}\r\n	\r\n	    .h2_tmp1 {font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n.justify1 {text-align: justify;\r\n        padding-top: 10px;\r\n        padding-bottom: 10px;\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n}\r\n#tmp_center {	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	/* [disabled]margin:left; */\r\n	position:relative;\r\n	display:inline;\r\n	/* [disabled]margin:-10px 0 5px 87px; */\r\n	padding:15px;\r\n	width:807px;\r\n	min-height:250px;\r\n	height: 280px;\r\n	float:left;\r\n	-webkit-box-shadow: 0px 0px 7px #cccccc;\r\n	-moz-box-shadow: 0px 0px 7px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	filter: progid:DXImageTransform.Microsoft.Shadow(color=\'#cccccc\', Direction=  135, 180,  Strength=5);\r\n	border-radius:1px;\r\n	left:25px;\r\n}\r\n            </style>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" height="38" class="h1_tmp">Sed posuere nisi id mi tempus et consequat neque tristique.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td>\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td valign="top" height="327">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                        </table>\r\n                                                        <div id="tmp_center">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp1">Porta sit amet consectetur nec</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify1">\r\n                                                                    <p>Curabitur in massa vel mauris rutrum varius non vitae risus. Duis iaculis elementum risus vitae cursus. Quisque vel felis arcu, eget lobortis arcu.</p>\r\n                                                                    <p>Suspendisse euismod ipsum in erat molestie interdum. Nunc tempus luctus elit sed fermentum.</p>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp1">&nbsp;Pellentesque nec magna eu ligula mollis laoreet.</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify1">&nbsp;Vestibulum id sapien nec enim congue dictum. Suspendisse facilisis orci sit amet nulla iaculis tincidunt in sed quam. Sed posuere tempor mauris, non sollicitudin sem porttitor quis. Praesent id nunc orci, eget sollicitudin eros Duis ipsum mauris, gravida nec fermentum id, ornare id lacus. Nam vel volutpat risus. Nam euismod risus ac nisi pellentesque venenatis. Donec auctor sem eget ipsum tincidunt suscipit. Sed fringilla libero interdum nibh imperdiet ut consequat nulla fermentum. Vivamus et lectus a augue eleifend accumsan id sed tellus.</td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        </td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n     \r\n    </body>\r\n');
INSERT INTO system_template VALUES (59, 'Template10Dokeos', 'Template10DokeosDescription', 'template10.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n<body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n        .background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center center;\r\n}        .justify {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 80px;\r\n	padding-bottom: 5px;\r\n	padding-left: 8px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #666;\r\n}             \r\n      .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 8px;\r\n	padding-right: 40px;\r\n	padding-top: 10px;\r\n	padding-bottom: 5px;\r\n}\r\n	 \r\n        .h2_tmp1 {font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n.justify1 {text-align: justify;\r\n        padding-top: 10px;\r\n        padding-bottom: 10px;\r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n}\r\n#tmp_center {	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	/* [disabled]margin:left; */\r\n	 \r\n	/* [disabled]margin:-10px 0 5px 87px; */\r\n	padding:15px;\r\n	width:800px;\r\n	min-height:430px;\r\n	margin-left:32px;\r\n	min-height:250px;\r\n	height: auto;\r\n	float:left;\r\n	-webkit-box-shadow: 0px 0px 7px #cccccc;\r\n	-moz-box-shadow: 0px 0px 7px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	filter: progid:DXImageTransform.Microsoft.Shadow(color=\'#cccccc\', Direction=  135, 180,  Strength=5);\r\n	border-radius:1px;\r\n	 \r\n}\r\n        </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" height="38" class="h1_tmp">Mi dui suscipit  porta convallis magna purus sit amet sapien.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td>\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr valign="top">\r\n                                                        <td align="center" height="327">\r\n                                                        <div id="tmp_center">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td align="center" width="200" valign="bottom" class="h2_tmp1" rowspan="4">\r\n                                                                    <p><img align="absmiddle" width="229" vspace="0" border="0" hspace="0" height="354" alt="mascot10.png" src="mascot/mascot10.png" /></p>\r\n                                                                    </td>\r\n                                                                    <td class="h2_tmp1"><span class="h2_tmp">Luptate tat aci enim quiscidui bla feuisis</span></td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify1">\r\n                                                                    <p>Vivamus sit amet sem erat. Donec varius pulvinar sapien, non ultrices purus blandit et. Vestibulum venenatis luctus sem, vitae accumsan erat rutrum id. Quisque malesuada cursus neque, vestibulum luctus ante egestas non. Duis id lectus ligula. Proin ornare, velit non dapibus feugiat, metus nulla feugiat nibh, sit amet cursus justo nisi quis justo. Quisque eget eros quam.</p>\r\n                                                                    <p>Quisque sit amet risus in augue viverra posuere. Ut et tortor est. Maecenas ut libero eget dolor consequat fermentum. Proin mollis, lorem in vestibulum fermentum,</p>\r\n                                                                    In accumsan felis eget mauris volutpat ac tempus nisi euismod. Cras urna massa, elementum eu mollis ut, cursus mollis purus. Phasellus facilisis risus nec orci faucibus sed dictum orci pretium.</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify1"><span class="h2_tmp">Luptate tat Duisl iureetue mod te molobor perilisl </span></td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify1">\r\n                                                                    <p>Curabitur ut nibh quis lorem mattis pretium ut quis neque. Donec volutpat commodo felis. Pellentesque a convallis nunc. Aenean lobortis lobortis congue. In et erat nisi, quis volutpat nisl. Vivamus a pulvinar enim. Nullam ligula eros, eleifend vitae adipiscing ac, molestie eget lorem. Duis et feugiat dui.</p>\r\n                                                                    <p>Pellentesque quis volutpat est. Morbi nec metus nec tortor fermentum sagittis. Pellentesque sagittis rutrum sapien a ornare. Vestibulum posuere augue vel urna semper fermentum ac eget enim. Proin eu porttitor tortor. Nulla facilisi. Duis congue, ante ut interdum lobortis, orci purus tempus diam, auctor facilisis metus odio egestas justo. Aliquam erat volutpat.Curabitur ut nibh quis lorem mattis pretium ut quis neque. Donec volutpat commodo felis. Pellentesque a convallis nunc. Aenean lobortis lobortis congue. In et erat nisi, quis volutpat nisl. Vivamus a pulvinar enim. Nullam ligula eros, eleifend vitae adipiscing ac, molestie eget lorem. Duis et feugiat dui.</p>\r\n                                                                    <p>Pellentesque quis volutpat est. Morbi nec metus nec tortor fermentum sagittis. Pellentesque sagittis rutrum sapien a ornare. Vestibulum posuere augue vel urna semper fermentum ac eget enim. Proin eu porttitor tortor. Nulla facilisi. Duis congue, ante ut interdum lobortis, orci purus tempus diam, auctor facilisis metus odio egestas justo. Aliquam erat volutpat.</p>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </div>\r\n                                                        </td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>\r\n ');
INSERT INTO system_template VALUES (60, 'Template11Dokeos', 'Template11DokeosDescription', 'template11.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n        .background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center center;\r\n}        .justify {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 40px;\r\n	padding-bottom: 5px;\r\n	padding-left: 40px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #666;\r\n}        .background_top {\r\n	background-image: url(img/background_box_top.png);\r\n	background-position: left top;\r\n	background-repeat: no-repeat;\r\n}        .background_top_middle {\r\n	background-image: url(img/background_box_middle.png);\r\n	background-repeat: repeat-y;\r\n	background-position: left;\r\n}        .background_top_bottom {\r\n	background-image: url(img/background_box_bottom.png);\r\n	background-repeat: no-repeat;\r\n	background-position: left bottom;\r\n}        \r\n       .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 40px;\r\n	padding-right: 40px;\r\n	padding-top: 10px;\r\n	padding-bottom: 5px;\r\n}  \r\n        .h2_tmp1 {        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n \r\n.justify1 {text-align: justify;\r\n        padding-top: 10px;\r\n        \r\n        padding-bottom: 5px;\r\n        \r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n}\r\n#tmp_left {\r\n	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	position:relative;\r\n	display:inline;\r\n	/* [disabled]margin:8px 13px 0 19px; */\r\n	text-align:justify;\r\n	padding:15px;\r\n	width:220px;\r\n	left:25px;\r\n	min-height:400px;\r\n	float:left;\r\n	-webkit-box-shadow: 3px 3px 3px #cccccc;\r\n	-moz-box-shadow: 3px 3px 3px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	border-radius:1px;\r\n}\r\n#tmp_center {\r\n	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	position:relative;\r\n	display:inline;\r\n	/* [disabled]margin:8px 13px 0 19px; */\r\n	text-align:justify;\r\n	padding:15px;\r\n	width:220px;\r\n	left:25px;\r\n	min-height:400px;\r\n	float:left;\r\n	-webkit-box-shadow: 3px 3px 3px #cccccc;\r\n	-moz-box-shadow: 3px 3px 3px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	border-radius:1px;\r\n}\r\n#tmp_right {\r\n	background-color:#ffffff;\r\n	border: 1px solid #ffffff;\r\n	position:relative;\r\n	display:inline;\r\n	/* [disabled]margin:8px 13px 0 19px; */\r\n	text-align:justify;\r\n	padding:15px;\r\n	width:220px;\r\n	left:25px;\r\n	min-height:400px;\r\n	float:left;\r\n	-webkit-box-shadow: 3px 3px 3px #cccccc;\r\n	-moz-box-shadow: 3px 3px 3px #cccccc;\r\n	box-shadow: 0px 0px 7px #cccccc;\r\n	border-radius:1px;\r\n}\r\n            </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" height="38" class="h1_tmp">Maecenas eget augue sit amet purus.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td>\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="border">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td>\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr valign="top">\r\n                                                        <td align="center" height="327">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                        </table>\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td valign="top">\r\n                                                                    <div id="tmp_left">\r\n                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                                        <tbody>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp1">Le passage de Lorem Ipsum</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">Vivamus orci elit, dapibus a tempus placerat, porta a libero. Integer rhoncus urna quis sapien semper vehicula. Fusce est augue, accumsan vitae adipiscing vitae, sagittis ultricies orci.</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp1">Ut semper tellus ac erat ornare vel.</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">Nunc justo dui, ornare ut aliquet sed, sollicitudin a libero. Pellentesque vestibulum sagittis ultrices. Pellentesque id risus tellus, vel vehicula dolor.</td>\r\n                                                                            </tr>\r\n                                                                        </tbody>\r\n                                                                    </table>\r\n                                                                    </div>\r\n                                                                    </td>\r\n                                                                    <td valign="top">\r\n                                                                    <div id="tmp_center">\r\n                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                                        <tbody>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp1">Le passage de Lorem Ipsum</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">Vivamus orci elit, dapibus a tempus placerat, porta a libero. Integer rhoncus urna quis sapien semper vehicula. Fusce est augue, accumsan vitae adipiscing vitae, sagittis ultricies orci.</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp1">Ut semper tellus ac erat ornare vel.</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">Nunc justo dui, ornare ut aliquet sed, sollicitudin a libero. Pellentesque vestibulum sagittis ultrices. Pellentesque id risus tellus, vel vehicula dolor.</td>\r\n                                                                            </tr>\r\n                                                                        </tbody>\r\n                                                                    </table>\r\n                                                                    </div>\r\n                                                                    </td>\r\n                                                                    <td valign="top">\r\n                                                                    <div id="tmp_right">\r\n                                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                                        <tbody>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp1">Le passage de Lorem Ipsum</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">Vivamus orci elit, dapibus a tempus placerat, porta a libero. Integer rhoncus urna quis sapien semper vehicula. Fusce est augue, accumsan vitae adipiscing vitae, sagittis ultricies orci.</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="h2_tmp1">Ut semper tellus ac erat ornare vel.</td>\r\n                                                                            </tr>\r\n                                                                            <tr>\r\n                                                                                <td class="justify1">Nunc justo dui, ornare ut aliquet sed, sollicitudin a libero. Pellentesque vestibulum sagittis ultrices. Pellentesque id risus tellus, vel vehicula dolor.</td>\r\n                                                                            </tr>\r\n                                                                        </tbody>\r\n                                                                    </table>\r\n                                                                    </div>\r\n                                                                    </td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>\r\n ');
INSERT INTO system_template VALUES (61, 'Template12Dokeos', 'Template12DokeosDescription', 'template12.gif', '<head>\r\n{CSS}\r\n</head>\r\n\r\n \r\n    <body>\r\n        <!-- white table for the course -->\r\n        <p><style type="text/css">\r\n        .background {\r\n	background-image: url(images/templates/background.png);\r\n	background-repeat: repeat-x;\r\n	background-position: center bottom;\r\n}        .justify {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 70px;\r\n	padding-bottom: 5px;\r\n	padding-left: 5px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #666;\r\n}        .justify2 {\r\n	text-align: justify;\r\n	padding-top: 5px;\r\n	padding-right: 20px;\r\n	padding-bottom: 5px;\r\n	padding-left: 25px;\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 12px;\r\n	color: #666;\r\n}\r\n.background_top {\r\n	background-image: url(images/templates/background_box_top12.png);\r\n	background-position: right top;\r\n	background-repeat: repeat-y;\r\n}        .background_top_middle {\r\n	background-image: url(images/templates/background_box_middle12.png);\r\n	background-repeat: repeat-y;\r\n	background-position: right center;\r\n}        .background_top_bottom {\r\n	background-image: url(images/templates/background_box_bottom12.png);\r\n	background-repeat: no-repeat;\r\n	background-position: right bottom;\r\n}        \r\n .h1_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 20px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n}\r\n        .h2_tmp {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 5px;\r\n	padding-right: 50px;\r\n	padding-top: 10px;\r\n	padding-bottom: 5px;\r\n}  \r\n\r\n        .h2_tmp1 {\r\n	font-family: Verdana, Geneva, sans-serif;\r\n	font-size: 16px;\r\n	color: #009EE3;\r\n	font-weight: bold;\r\n	padding-left: 25px;\r\n	padding-right: 40px;\r\n	padding-top: 10px;\r\n	padding-bottom: 5px;\r\n}\r\n        .h2_tmp11 {font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 16px;\r\n        color: #009EE3;\r\n        font-weight: bold;\r\n}\r\n \r\n.justify1 {text-align: justify;\r\n        padding-top: 10px;\r\n      \r\n        padding-bottom: 10px;\r\n       \r\n        font-family: Verdana, Geneva, sans-serif;\r\n        font-size: 12px;\r\n        color: #333;\r\n}\r\n#tmp_left {	\r\n	 \r\n	 \r\n	text-align:justify;\r\n	padding:15px;\r\n	width:200px;\r\n	 height:auto;\r\n	min-height:240x;\r\n	float:left;\r\n	\r\n	 \r\n}\r\n      \r\n	  #tmp_right {	 \r\n/*	border: 1px solid #ffffff;*/\r\n	 \r\n	 \r\n	text-align:justify;\r\n	padding:15px;\r\n	width:456px;\r\n \r\n	min-height:52px;\r\n	float:right;\r\n	margin-right: 115px;\r\n	height:auto;\r\n	min-height: 250px;\r\n \r\n}\r\n	 	  #tmp_right_down {\r\n	/*border: 1px solid #ffffff;*/\r\n	 \r\n	 \r\n	 \r\n    float: right;\r\n    height: auto;\r\n    min-height: 220px;\r\n    padding-right: 65px;\r\n    text-align: justify;\r\n    width: 530px;\r\n	 \r\n	 \r\n} \r\n	  \r\n	  \r\n	    </style></p>\r\n        <table class="white">\r\n            <tbody>\r\n                <tr>\r\n                    <td width="895" height="38" class="h1_tmp">Suspendisse consequat sem felis.</td>\r\n                </tr>\r\n                <tr>\r\n                    <td height="3"><hr size="1" />\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td align="center" width="895" valign="top" height="300">\r\n                    <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="background">\r\n                        <tbody>\r\n                            <tr>\r\n                                <td valign="top" height="480">\r\n                                <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                    <tbody>\r\n                                        <tr>\r\n                                            <td class="background_top_middle">\r\n                                            <div id="tmp_left">\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td class="h2_tmp11">Le passage de Lorem Ipsum</td>\r\n                                                    </tr>\r\n                                                    <tr>\r\n                                                        <td class="justify1">Vivamus orci elit, dapibus a tempus placerat, porta a libero.</td>\r\n                                                    </tr>\r\n                                                    <tr>\r\n                                                        <td class="h2_tmp11">Ut semper tellus ac erat ornare vel.</td>\r\n                                                    </tr>\r\n                                                    <tr>\r\n                                                        <td class="justify1">Nunc justo dui, ornare ut aliquet sed, sollicitudin a libero. Pellentesque vestibulum</td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </div>\r\n                                            <div id="tmp_right">\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td class="h2_tmp11">Le passage de Lorem Ipsum</td>\r\n                                                    </tr>\r\n                                                    <tr>\r\n                                                        <td class="justify1">Vivamus orci elit, dapibus a tempus placerat, porta a libero. Integer rhoncus urna quis sapien semper vehicula. Fusce est augue, accumsan vitae adipiscing vitae, sagittis ultricies orci.</td>\r\n                                                    </tr>\r\n                                                    <tr>\r\n                                                        <td class="h2_tmp11">Ut semper tellus ac erat ornare vel.</td>\r\n                                                    </tr>\r\n                                                    <tr>\r\n                                                        <td class="justify1">Nunc justo dui, ornare ut aliquet sed, sollicitudin a libero. Pellentesque vestibulum sagittis ultrices. Pellentesque id risus tellus, vel vehicula dolor.</td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </div>\r\n                                            </td>\r\n                                        </tr>\r\n                                        <tr>\r\n                                            <td valign="top" height="80" class="background_top_bottom">\r\n                                            <div id="tmp_right_down">\r\n                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                <tbody>\r\n                                                    <tr>\r\n                                                        <td valign="top">\r\n                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">\r\n                                                            <tbody>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp11">Le passage de Lorem Ipsum</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify1">Vivamus orci elit, dapibus a tempus placerat, porta a libero. Integer rhoncus urna quis sapien semper vehicula. Fusce est augue, accumsan vitae adipiscing vitae, sagittis ultricies orci.</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="h2_tmp11">Ut semper tellus ac erat ornare vel.</td>\r\n                                                                </tr>\r\n                                                                <tr>\r\n                                                                    <td class="justify1"></td>\r\n                                                                </tr>\r\n                                                            </tbody>\r\n                                                        </table>\r\n                                                        </td>\r\n                                                        <td align="right" width="200" valign="bottom"><span class="justify1"><img width="212" height="213" alt="" src="mascot/mascot12.png" /></span></td>\r\n                                                    </tr>\r\n                                                </tbody>\r\n                                            </table>\r\n                                            </div>\r\n                                            </td>\r\n                                        </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                            </tr>\r\n                        </tbody>\r\n                    </table>\r\n                    </td>\r\n                </tr>\r\n            </tbody>\r\n        </table>\r\n    </body>\r\n ');
 




--
-- Adding the quiz templates
--

INSERT INTO quiz_question_templates VALUES(1, 'DefaultQuizQuestion1', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;"><tbody>\n	<tr><td align="center" height="323px"><img border="0" align="absmiddle" width="350" vspace="0" hspace="0" height="328" alt="Price_elasticity_of_demand2.png" src="../default_course_document/images/diagrams/templates/Price_elasticity_of_demand2.png" /></td></tr></tbody></table>', 20.00, 1, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(2, 'DefaultQuizQuestion2', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;"><tbody>\n	<tr><td align="center" height="323px"><img border="0" align="absmiddle" width="310" vspace="0" hspace="0" height="310" alt="Cross_elasticity_of_demand_complements.png" src="../default_course_document/images/diagrams/templates/Cross_elasticity_of_demand_complements.png" /></td>\n	</tr></tbody></table>', 20.00, 2, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(3, 'DefaultQuizQuestion3', '<table height="100%" width="98%" cellspacing="2" cellpadding="0" style="font-family: Comic Sans MS; font-size: 16px;">\r\n    <tbody>\r\n        <tr>\r\n            <td height="323px" align="center"><img  src="../default_course_document/images/diagrams/templates/heartArrows4Numbers300.png"  /></td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 20.00, 3, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(4, 'DefaultQuizQuestion4', '<table height="100%" width="98%" cellspacing="2" cellpadding="0" style="font-family: Comic Sans MS; font-size: 16px;">\r\n    <tbody>\r\n        <tr>\r\n            <td height="323px" align="center"><img height="310px" src="../img/instructor-faq.png"  /></td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 20.00, 4, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(5, 'DefaultQuizQuestion5', '<p style="text-align: center;">Group Quarters: Any living quarters occupied by<br />ten or more unrelated persons is called a group<br /> 		quarters. Examples of a group quarters are worker''s<br />dormitories, boarding houses, halfway houses,<br />convents, etc. In addition, college dormitories,<br />fraternity houses, or nurse''s dormitories are always<br />considered to be a group quarters, regardless of the<br /> number of students who live there.</p><p style="text-align: center;"></p><p style="text-align: center;"><img border="0" align="absmiddle" width="200" vspace="0" hspace="0" height="133" alt="Cornell_dormitories2.jpg" src="../default_course_document/images/diagrams/templates/Cornell_dormitories2.jpg" /></p>', 20.00, 5, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(6, 'DefaultQuizQuestion6', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;">\n	<tbody><tr><td align="center" height="323px"><img border="0" align="absmiddle" width="377" vspace="0" hspace="0" height="300" alt="HPQuestion_1.png" src="../default_course_document/images/diagrams/templates/HPQuestion_1.png" /></td></tr></tbody></table>', 20.00, 6, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(7, 'DefaultQuizQuestion7', '<table cellspacing="2" cellpadding="0 width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;">\n    <tbody><tr><td align="center" height="323px"><p><img height="310px" alt="" src="../img/instructor-faq.png" /></p>\n	<p><embed width="300" height="20" flashvars="file=../default_course_document/audio/EconomicCensus.mp3&amp;autostart=false" allowscriptaccess="always" allowfullscreen="false" src="/main/inc/lib/mediaplayer/player.swf" bgcolor="#FFFFFF" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed></p></td></tr></tbody></table>', 20.00, 7, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(8, 'DefaultQuizQuestion8', '<table height="100%" width="98%" cellspacing="2" cellpadding="0" style="font-family: Comic Sans MS; font-size: 16px;">\n	<tbody><tr><td height="323px" align="center">           \n			<div id="player504837-parent" style="text-align: center;">\n			<div style="border-style: none; height: 240px; width: 320px; overflow: hidden; background-color: rgb(220, 220, 220);"><script src="/main/inc/lib/swfobject/swfobject.js" type="text/javascript"></script>\n			<div id="player504837"><a href="http://www.macromedia.com/go/getflashplayer" target="_blank">Get the Flash Player</a> to see this video.\n			<div id="player504837-config" style="display: none; visibility: hidden; width: 0px; height: 0px; overflow: hidden;">url=../default_course_document/video/flv/OpenofficeSlideshow.flv width=320 height=240 loop=false play=false downloadable=false fullscreen=true displayNavigation=true displayDigits=true align=left playlistThumbs=false</div>\n			</div>\n			<script type="text/javascript">\n	var s1 = new SWFObject("/main/inc/lib/mediaplayer/player.swf","single","320","240","7");\n	s1.addVariable("width","320");\n	s1.addVariable("height","240");\n	s1.addVariable("autostart","false");\n	s1.addVariable("file","../default_course_document/video/flv/OpenofficeSlideshow.flv");\n	s1.addVariable("repeat","false");\n	s1.addVariable("showdownload","false");\n	s1.addVariable("link","../default_course_document/video/flv/OpenofficeSlideshow.flv");\n	s1.addParam("allowfullscreen","true");\n	s1.addVariable("showdigits","true");\n	s1.addVariable("shownavigation","true");\n	s1.addVariable("logo","");\n	s1.write("player504837");\n	</script></div></div><p>&nbsp;</p></td></tr></tbody></table>', 20.00, 8, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(9, 'DefaultQuizQuestion9', '<table height="100%" width="98%" cellspacing="2" cellpadding="0" style="font-family: Comic Sans MS; font-size: 16px;">\n	<tbody><tr><td height="323px" align="center"><embed height="300" width="350" menu="true" loop="true" play="true" src="../default_course_document/animations/SpinEchoSequence.swf" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed></td></tr></tbody></table>', 20.00, 9, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(10, 'DefaultQuizQuestion10', '<p style="text-align: center;">&nbsp;</p>\n	<div id="player28445-parent" style="text-align: center;">\n	<div style="border-style: none; height: 240px; width: 320px; overflow: hidden; background-color: rgb(220, 220, 220); margin-left: auto; margin-right: auto;"><script src="/main/inc/lib/swfobject/swfobject.js" type="text/javascript"></script>\n	<div id="player28445"><a target="_blank" href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this video.\n	<div id="player28445-config" style="display: none; visibility: hidden; width: 0px; height: 0px; overflow: hidden;">url=../default_course_document/video/flv/Bloedstolling.flv width=320 height=240 loop=false play=false downloadable=false fullscreen=true displayNavigation=true displayDigits=true align=center playlistThumbs=false</div>\n	</div><script type="text/javascript">\n		var s1 = new SWFObject("/main/inc/lib/mediaplayer/player.swf","single","320","240","7");\n		s1.addVariable("width","320");\n		s1.addVariable("height","240");\n		s1.addVariable("autostart","false");\n		s1.addVariable("file","../default_course_document/video/flv/Bloedstolling.flv");\n		s1.addVariable("repeat","false");\n		s1.addVariable("showdownload","false");\n		s1.addVariable("link","../default_course_document/video/flv/Bloedstolling.flv");\n		s1.addParam("allowfullscreen","true");\n		s1.addVariable("showdigits","true");\n		s1.addVariable("shownavigation","true");\n		s1.addVariable("logo","");\n		s1.write("player28445");\n	</script></div></div>', 20.00, 10, 1, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(11, 'DefaultQuizQuestion11', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;">\n	<tbody><tr><td align="center" height="323px"><img border="0" align="absmiddle" width="380" vspace="0" hspace="0" height="143" alt="sleeping_1.png" src="../default_course_document/images/diagrams/templates/sleeping_1.png" /></td></tr></tbody></table>', 20.00, 11, 2, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(12, 'DefaultQuizQuestion12', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;"><tbody>\n	<tr><td align="center" height="323px"><img border="0" align="absmiddle" width="380" vspace="0" hspace="0" height="239" alt="Solar_sys.jpg" src="../default_course_document/images/diagrams/templates/Solar_sys.jpg" /></td></tr></tbody></table>', 20.00, 12, 8, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(13, 'DefaultQuizQuestion13', '<table height="100%" width="98%" cellspacing="2" cellpadding="0" style="font-family: Comic Sans MS; font-size: 16px;"><tbody>\n	<tr><td height="323px" align="center"><img hspace="0" height="345" width="350" vspace="0" border="0" align="absmiddle" alt="Traffic_lights.jpg" src="../default_course_document/images/diagrams/templates/Traffic_lights.jpg" /></td></tr></tbody></table>', 20.00, 13, 2, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(14, 'DefaultQuizQuestion14', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;"><tbody>\n	<tr><td align="center" height="323px"><img border="0" align="absmiddle" width="300" vspace="0" hspace="0" height="227" alt="ViolentCrimeAmerica.png" src="../default_course_document/images/diagrams/templates/ViolentCrimeAmerica.png" /></td></tr></tbody></table>', 20.00, 14, 8, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(15, 'DefaultQuizQuestion15', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;"><tbody>\n	<tr><td align="center" height="323px"><img alt="" src="../img/KnockOnWood.png" /></td></tr></tbody></table>', 60.00, 15, 3, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(16, 'DefaultQuizQuestion16', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;"><tbody>\n	<tr><td align="center" height="323px"><img border="0" align="absmiddle" width="270" vspace="0" hspace="0" height="320" alt="balance_scale_redone.jpg" src="../default_course_document/images/diagrams/templates/balance_scale_redone.jpg" /></td></tr></tbody></table>', 20.00, 16, 3, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(17, 'DefaultQuizQuestion17', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;"><tbody>\n	<tr><td align="center" height="323px"><img alt="" src="../img/KnockOnWood.png" /></td></tr></tbody></table>', 50.00, 17, 3, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(18, 'DefaultQuizQuestion18', '<table cellspacing="2" cellpadding="0" style="font-family: Comic Sans MS; font-size: 16px; width: 375px; height: 277px;"><tbody>\n	<tr><td align="center" height="323px"><img border="0" align="absmiddle" width="254" vspace="0" hspace="0" height="200" alt="SpeechMike.png" src="../default_course_document/mascot/SpeechMike.png" /><embed width="300" height="20" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" bgcolor="#FFFFFF" src="/main/inc/lib/mediaplayer/player.swf" allowfullscreen="false" allowscriptaccess="always" flashvars="file=../default_course_document/audio/EconCensus64.mp3&amp;autostart=false"></embed></td></tr></tbody></table>', 30.00, 18, 3, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(19, 'DefaultQuizQuestion19', '<p>&nbsp;</p><p>1 Vertical&nbsp; : In the B-bath Company, it is to make soap<br />1 Horizontal : Intended direction <br />2 Horizontal : provides a guideline to managers decision making<br />3 Horizontal contains rules</p><p style="text-align: center;">&nbsp;</p><p style="text-align: center;"><img border="0" align="absmiddle" width="239" vspace="0" hspace="0" height="150" alt="240business_meeting.jpg" src="../default_course_document/images/diagrams/templates/240business_meeting.jpg" /></p>', 250.00, 19, 3, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(20, 'DefaultQuizQuestion20', '<table height="100%" width="98%" cellspacing="2" cellpadding="0" style="font-family: Comic Sans MS; font-size: 16px;"><tbody>\n	<tr><td height="323px" align="center"><img hspace="0" height="205" width="350" vspace="0" border="0" align="absmiddle" alt="6Hats_1.png" src="../default_course_document/images/diagrams/templates/6Hats_1.png" /></td></tr></tbody></table>', 20.00, 20, 5, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(21, 'DefaultQuizQuestion21', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;"><tbody><tr>  <td align="center" height="323px"><img alt="" src="../img/instructor-idea.jpg" /></td></tr></tbody></table>', 20.00, 21, 5, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(22, 'DefaultQuizQuestion22', '<table cellspacing="2" cellpadding="0" width="98%" height="100%" style="font-family: Comic Sans MS; font-size: 16px;"><tbody><tr>  <td align="center" height="323px"><img border="0" align="absmiddle" width="380" vspace="0" hspace="0" height="309" alt="Board2_1.png" src="../default_course_document/images/diagrams/templates/Board2_1.png" /></td></tr></tbody></table>', 20.00, 22, 5, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(23, 'DefaultQuestion18', '', 20.00, 23, 4, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(24, 'DefaultQuestion19', '', 20.00, 24, 4, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(25, 'DefaultQuizQuestion24', '', 20.00, 25, 4, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(26, 'DefaultQuizQuestion25', '', 20.00, 26, 4, '', 1, NULL);
INSERT INTO quiz_question_templates VALUES(27, 'DefaultQuizQuestion27', '', 40.00, 27, 6, 'quiz-27.jpg', 1, NULL);
INSERT INTO quiz_question_templates VALUES(28, 'DefaultQuizQuestion28', '', 30.00, 28, 6, 'quiz-28.jpg', 1, NULL);
INSERT INTO quiz_question_templates VALUES(29, 'DefaultQuizQuestion29', '', 30.00, 29, 6, 'quiz-29.jpg', 1, NULL);
INSERT INTO quiz_question_templates VALUES(30, 'DefaultQuizQuestion30', '', 30.00, 30, 6, 'quiz-30.jpg', 1, NULL);

INSERT INTO quiz_answer_templates VALUES(1, 1, 'QuizAnswer_1a', 0, 'Feedback_qn1_true', 0.00, 1, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(2, 1, 'QuizAnswer_1b', 1, 'Feedback_qn1_true', 20.00, 2, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(1, 2, 'QuizAnswer_2a', 0, 'Feedback_qn2_true', 0.00, 1, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(2, 2, 'QuizAnswer_2b', 1, 'Feedback_qn2_true', 20.00, 2, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(3, 2, 'QuizAnswer_2c', 0, 'Feedback_qn2_true', 0.00, 3, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(4, 2, 'QuizAnswer_2d', 0, 'Feedback_qn2_true', 0.00, 4, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(1, 3, 'QuizAnswer_3a', 0, '', 0.00, 1, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(2, 3, 'QuizAnswer_3b', 1, '', 20.00, 2, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(3, 3, 'QuizAnswer_3c', 0, '', 0.00, 3, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(4, 3, 'QuizAnswer_3d', 0, '', 0.00, 4, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(1, 4, 'QuizAnswer_4a', 0, 'Feedback_qn4_true', 0.00, 1, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(2, 4, 'QuizAnswer_4b', 0, 'Feedback_qn4_true', 0.00, 2, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(3, 4, 'QuizAnswer_4c', 0, 'Feedback_qn4_true', 0.00, 3, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(4, 4, 'QuizAnswer_4d', 1, 'Feedback_qn4_true', 20.00, 4, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(1, 5, 'QuizAnswer_5a', 0, 'Feedback_qn5_true', 0.00, 1, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(2, 5, 'QuizAnswer_5b', 0, 'Feedback_qn5_true', 0.00, 2, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(3, 5, 'QuizAnswer_5c', 0, 'Feedback_qn5_true', 0.00, 3, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(4, 5, 'QuizAnswer_5d', 1, 'Feedback_qn5_true', 20.00, 4, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(1, 6, '<p><img border="0" align="absmiddle" width="250" vspace="0" hspace="0" height="63" alt="HPAnswer1_1.png" src="../default_course_document/images/diagrams/templates/HPAnswer1_1.png" /></p>', 0, '<p><img border="0" align="absmiddle" width="376" vspace="0" hspace="0" height="300" alt="HPfeedback_1.png" src="../default_course_document/images/diagrams/templates/HPfeedback_1.png" />The working fluid, in its gaseous state, is pressurized and circulated through the system by a compressor. On the discharge side of the compressor, the now hot and highly pressurized vapor is cooled in a heat exchanger, called a condenser, until it condenses into a high pressure, moderate temperature liquid. The condensed refrigerant then passes through a pressure-lowering device also called a metering device like an expansion valve, capillary tube, or possibly a work-extracting device such as a turbine. The low pressure, liquid refrigerant leaving the expansion device enters another heat exchanger, the evaporator, in which the fluid absorbs heat and boils. The refrigerant then returns to the compressor and the cycle is repeated.</p>', 0.00, 1, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(2, 6, '<p><img border="0" align="absmiddle" width="250" vspace="0" hspace="0" height="63" alt="HPAnswer2.png" src="../default_course_document/images/diagrams/templates/HPAnswer2.png" /></p>', 0, '<p><img border="0" align="absmiddle" width="376" vspace="0" hspace="0" height="300" alt="HPfeedback_1.png" src="../default_course_document/images/diagrams/templates/HPfeedback_1.png" />The working fluid, in its gaseous state, is pressurized and circulated through the system by a compressor. On the discharge side of the compressor, the now hot and highly pressurized vapor is cooled in a heat exchanger, called a condenser, until it condenses into a high pressure, moderate temperature liquid. The condensed refrigerant then passes through a pressure-lowering device also called a metering device like an expansion valve, capillary tube, or possibly a work-extracting device such as a turbine. The low pressure, liquid refrigerant leaving the expansion device enters another heat exchanger, the evaporator, in which the fluid absorbs heat and boils. The refrigerant then returns to the compressor and the cycle is repeated.</p>', 0.00, 2, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(3, 6, '<p><img border="0" align="absmiddle" width="250" vspace="0" hspace="0" height="63" alt="HPAnswer3_1.png" src="../default_course_document/images/diagrams/templates/HPAnswer3_1.png" /></p>', 1, '<p><img border="0" align="absmiddle" width="376" vspace="0" hspace="0" height="300" alt="HPfeedback_1.png" src="../default_course_document/images/diagrams/templates/HPfeedback_1.png" />The working fluid, in its gaseous state, is pressurized and circulated through the system by a compressor. On the discharge side of the compressor, the now hot and highly pressurized vapor is cooled in a heat exchanger, called a condenser, until it condenses into a high pressure, moderate temperature liquid. The condensed refrigerant then passes through a pressure-lowering device also called a metering device like an expansion valve, capillary tube, or possibly a work-extracting device such as a turbine. The low pressure, liquid refrigerant leaving the expansion device enters another heat exchanger, the evaporator, in which the fluid absorbs heat and boils. The refrigerant then returns to the compressor and the cycle is repeated.</p>', 20.00, 3, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(4, 6, '<p><img border="0" align="absmiddle" width="250" vspace="0" hspace="0" height="63" alt="HPAnswer4_3.png" src="../default_course_document/images/diagrams/templates/HPAnswer4_3.png" /></p>', 0, '<p><img border="0" align="absmiddle" width="376" vspace="0" hspace="0" height="300" alt="HPfeedback_1.png" src="../default_course_document/images/diagrams/templates/HPfeedback_1.png" />The working fluid, in its gaseous state, is pressurized and circulated through the system by a compressor. On the discharge side of the compressor, the now hot and highly pressurized vapor is cooled in a heat exchanger, called a condenser, until it condenses into a high pressure, moderate temperature liquid. The condensed refrigerant then passes through a pressure-lowering device also called a metering device like an expansion valve, capillary tube, or possibly a work-extracting device such as a turbine. The low pressure, liquid refrigerant leaving the expansion device enters another heat exchanger, the evaporator, in which the fluid absorbs heat and boils. The refrigerant then returns to the compressor and the cycle is repeated.</p>', 0.00, 4, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(1, 7, 'QuizAnswer_7d', 0, 'Feedback_qn7_true', 0.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 7, 'QuizAnswer_7c', 0, 'Feedback_qn7_true', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 7, 'QuizAnswer_7b', 0, 'Feedback_qn7_true', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 7, 'QuizAnswer_7a', 1, 'Feedback_qn7_true', 20.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 8, 'QuizAnswer_8a', 0, '', 0.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 8, 'QuizAnswer_8b', 0, '', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 8, 'QuizAnswer_8c', 0, '', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 8, 'QuizAnswer_8d', 1, '', 20.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 9, 'QuizAnswer_9a', 0, 'Feedback_qn9_true', 0.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 9, 'QuizAnswer_9b', 0, 'Feedback_qn9_true', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 9, 'QuizAnswer_9c', 0, 'Feedback_qn9_true', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 9, 'QuizAnswer_9d', 1, 'Feedback_qn9_true', 20.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 10, 'QuizAnswer_10a', 1, 'Feedback_qn10_true', 20.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 10, 'QuizAnswer_10b', 0, 'Feedback_qn10_true', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 10, 'QuizAnswer_10c', 0, 'Feedback_qn10_true', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 10, 'QuizAnswer_10d', 0, 'Feedback_qn10_true', 0.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 11, 'QuizAnswer_11a', 1, 'Feedback_qn8_true', 10.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 11, 'QuizAnswer_11b', 1, 'Feedback_qn8_true', 10.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 11, 'QuizAnswer_11c', 0, 'Feedback_qn8_true', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 11, 'QuizAnswer_11d', 1, 'Feedback_qn8_true', 10.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 12, 'QuizAnswer_12a', 1, 'Feedback_qn12_true', 10.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 12, 'QuizAnswer_12b', 0, 'Feedback_qn12_true', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 12, 'QuizAnswer_12c', 0, 'Feedback_qn12_true', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 12, 'QuizAnswer_12d', 1, 'Feedback_qn12_true', 10.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 13, '<p><img hspace="0" height="100" width="100" vspace="0" border="0" align="absmiddle" alt="truck.jpg" src="../default_course_document/images/diagrams/templates/truck.jpg" /></p>', 1, 'Feedback_qn13_true', 10.00, 1, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(2, 13, '<p><img hspace="0" height="100" width="100" vspace="0" border="0" align="absmiddle" alt="railroad.jpg" src="../default_course_document/images/diagrams/templates/railroad.jpg" /></p>', 0, 'Feedback_qn13_true', 0.00, 2, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(3, 13, '<p><img hspace="0" height="100" width="100" vspace="0" border="0" align="absmiddle" alt="deer.jpg" src="../default_course_document/images/diagrams/templates/deer.jpg" /></p>', 0, 'Feedback_qn13_true', 0.00, 3, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(4, 13, '<p><img hspace="0" height="100" width="100" vspace="0" border="0" align="absmiddle" alt="pedestrian.jpg" src="../default_course_document/images/diagrams/templates/pedestrian.jpg" /></p>', 1, 'Feedback_qn13_true', 10.00, 4, '', '', '0@@0@@0@@0');
INSERT INTO quiz_answer_templates VALUES(1, 14, 'QuizAnswer_14a', 1, '', 10.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 14, 'QuizAnswer_14b', 0, '', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 14, 'QuizAnswer_14c', 0, '', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 14, 'QuizAnswer_14d', 1, '', 10.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 15, '<table cellspacing="0" cellpadding="10" border="1" align="center" width="420"><tbody><tr><td style="text-align: center;"><strong>Treatment</strong></td><td style="text-align: center;"><strong>Y</strong> or<strong> N</strong></td><td><p><strong>1</strong> = on day 1</p><p><strong>0</strong> = none</p><p><strong>D</strong> = discharge day</p></td></tr><tr><td style="text-align: center;"><strong>Malaria </strong></td>\n	<td style="text-align: center;">[<u>Y</u>]&nbsp;&nbsp;</td><td style="text-align: center;">&nbsp;[<u>1</u>]&nbsp;&nbsp;</td></tr><tr><td style="text-align: center;"><strong>Polio </strong></td><td style="text-align: center;">[<u>Y</u>]&nbsp;&nbsp;</td><td style="text-align: center;">[<u> D</u>]&nbsp;&nbsp;</td></tr><tr><td style="text-align: center;"><strong>Pneumococcus vaccin </strong></td><td style="text-align: center;">[<u>N</u>]&nbsp;&nbsp;</td><td style="text-align: center;">[<u>0</u>]&nbsp;&nbsp;</td></tr></tbody></table><p>&nbsp;</p>::10,10,10,10,10,10@', 1, 'a:2:{s:10:"comment[1]";s:0:"";s:10:"comment[2]";s:0:"";}', 0.00, 0, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 16, '<table cellspacing="0" cellpadding="10" border="1" align="center" width="380"><tbody><tr><td bgcolor="#f5f5f5" style="text-align: right;"><strong>Patient</strong></td><td bgcolor="#f5f5f5" style="text-align: center;"><strong>Laura</strong></td><td bgcolor="#f5f5f5" style="text-align: center;"><strong>Bill</strong></td></tr><tr><td style="text-align: right;">Age</td><td style="text-align: center;">38</td><td style="text-align: center;">44</td></tr><tr><td style="text-align: right;">Height</td><td style="text-align: center;">1.72 m</td><td style="text-align: center;">1.88 m</td>   </tr><tr><td style="text-align: right;">Weight</td><td style="text-align: center;">65 kg</td><td style="text-align: center;">[<u>103</u>] kg</td></tr><tr><td style="text-align: right;">Blood Pressure</td><td style="text-align: center;">120/75</td><td style="text-align: center;">11/65</td></tr> <tr><td style="vertical-align: top; text-align: right;">BMI</td><td style="vertical-align: top; text-align: center;">[<u>22</u>]&nbsp;&nbsp;</td><td style="text-align: center;">&nbsp;29</td></tr></tbody></table>::10,10@', 1, 'a:2:{s:10:"comment[1]";s:0:"";s:10:"comment[2]";s:0:"";}', 0.00, 0, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 17, '<table cellspacing="0" cellpadding="10" border="1" align="center" width="420"><tbody><tr><td>&nbsp;</td><td style="text-align: center;"><strong>H</strong></td><td style="text-align: center;"><strong>W</strong></td><td style="text-align: center;"><strong>M</strong></td><td style="text-align: center;"><strong>O</strong></td><td style="text-align: center;"><strong>NS<br /></strong></td></tr><tr><td style="text-align: center;"><strong>Laura</strong></td><td style="text-align: center;">89</td><td style="text-align: center;">12.3</td><td style="text-align: center;">140</td><td style="text-align: center;">Y</td><td style="text-align: center;">[<u>SAM</u>]&nbsp;&nbsp;</td></tr><tr><td style="text-align: center;"><strong>John</strong></td><td style="text-align: center;">73.5</td><td style="text-align: center;">6.3</td><td style="text-align: center;">124</td><td style="text-align: center;">N</td><td style="text-align: center;">[<u>SAM</u>]&nbsp;&nbsp;</td></tr><tr><td style="text-align: center;"><strong>Anna</strong></td><td style="text-align: center;">94.5</td><td style="text-align: center;">10</td><td style="text-align: center;">108</td><td style="text-align: center;">N</td><td style="text-align: center;">[<u>SAM</u>]&nbsp;&nbsp;</td></tr><tr><td style="text-align: center;"><strong>Bill</strong></td><td style="text-align: center;">120</td><td style="text-align: center;">13.8</td><td style="text-align: center;">112</td><td style="text-align: center;">N</td><td style="text-align: center;">[<u>SAM</u>]&nbsp;&nbsp;</td></tr><tr><td style="text-align: center;"><strong>Peter</strong></td><td style="text-align: center;">67</td><td style="text-align: center;">7.4</td><td style="text-align: center;">130</td><td style="text-align: center;">N</td><td style="text-align: center;">[<u>N</u>]&nbsp;&nbsp;</td></tr></tbody></table><p>H = Height in cm, W = Weight in kg, M = Muac in mm, O = Oedema present Yes/No</p>::10,10,10,10,10@', 1, 'a:2:{s:10:"comment[1]";s:0:"";s:10:"comment[2]";s:0:"";}', 0.00, 0, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 18, '<p>The Economic Census produces a portrait of business activities in  industries and communities all across our nation. Alan Greenspan calls  the Economic Census indispensable to understanding Americas economy. Commonly used economic indicators - such as the [<u>gross</u>]�� domestic product  and monthly [<u>retail</u>]�� sales - depend on the Economic Census for continued  [<u>accuracy</u>] .<sqdf></sqdf></p>::10,10,10@', 1, 'a:2:{s:10:"comment[1]";s:0:"";s:10:"comment[2]";s:0:"";}', 0.00, 0, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 19, '<table cellspacing="0" cellpadding="10" border="1" align="center" width="420"><tbody><tr><td>&nbsp;</td><td style="text-align: center;">[<u>M</u>]&nbsp;&nbsp;</td><td>&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td></tr><tr><td style="text-align: center;">[<u>V</u>]&nbsp;&nbsp;</td><td style="text-align: center;">[<u>I</u>]&nbsp;&nbsp;</td><td style="text-align: center;">[<u>S</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>I</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>O</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>N</u>]&nbsp;&nbsp;</td>\n   <td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td></tr><tr><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>S</u>]&nbsp;&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td>\n   <td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td></tr>\n	<tr><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>S</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>T</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>R</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>A</u>]&nbsp;&nbsp;</td><td style="vertical-align: top;">[<u>T</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>E</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>G</u>]&nbsp;&nbsp;</td>\n	<td style="vertical-align: top; text-align: center;">[<u>Y</u>]&nbsp;&nbsp;</td></tr><tr><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>I</u>]&nbsp;&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td></tr><tr><td style="vertical-align: top; text-align: center;">[<u>P</u>]&nbsp;&nbsp;</td><td style="vertical-align: top;">[<u>O</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>L</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>I</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>C</u>]&nbsp;&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>Y</u>]&nbsp;&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td></tr><tr><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top; text-align: center;">[<u>N</u>]&nbsp;&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td><td style="vertical-align: top;">&nbsp;</td></tr></tbody></table><p>&nbsp;</p>::10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10@', 1, '', 0.00, 0, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 23, '<p>Columbia River <img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/ColumbiaRiverTr64.png" alt="ColumbiaRiverTr64.png" /></p>', 0, 'Great. Now go to the map of American Mountains and find out the 5 top highest.', 0.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 23, '<p>Rio Grande <img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/RioGrandeTr64.png" alt="RioGrandeTr64.png" /></p>', 0, 'Go back to the map of American River and notice 3 characteristics for each of them', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 23, '<p>Tenesse River <img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/TenesseeRiverTr64.png" alt="TenesseeRiverTr64.png" /></p>', 0, '', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 23, '<p>Arkanas River&nbsp; <img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/ArkansasRiverTr64.png" alt="ArkansasRiverTr64.png" /></p>', 0, '', 0.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(5, 23, '<p>New Mexico <img hspace="0" height="64" width="68" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/New_Mexico2tr64.png" alt="New_Mexico2tr64.png" /></p>', 1, '', 5.00, 5, '', '', '');
INSERT INTO quiz_answer_templates VALUES(6, 23, '<p>Alabama <img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/AlabampaMapOutlineBlue2Tr64.png" alt="AlabampaMapOutlineBlue2Tr64.png" /></p>', 1, '', 5.00, 6, '', '', '');
INSERT INTO quiz_answer_templates VALUES(7, 23, '<p>Oklahoma&nbsp; <img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/OklahomaMapOutline3Tr64.png" alt="OklahomaMapOutline3Tr64.png" /></p>', 1, '', 5.00, 7, '', '', '');
INSERT INTO quiz_answer_templates VALUES(8, 23, '<p>Washington <img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/WashingtonStateMapOutline2tr64.png" alt="WashingtonStateMapOutline2tr64.png" /></p>', 1, '', 5.00, 8, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 24, '<p><img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/medical15.png" alt="medical15.png" />&nbsp; Check Skin Temperature</p>', 0, '', 0.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 24, '<p><img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/medic25.png" alt="medic25.png" />&nbsp; Call Ambulance</p>', 0, '', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 24, '<p><img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/medicalhandpointing.png" alt="medicalhandpointing.png" /> Tell casuality not to move</p>', 0, '', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 24, '', 0, '', 0.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(5, 24, '<p><img style="text-align: center;" hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/icons/logic/01.png" alt="01.png" /></p>', 3, '', 6.67, 5, '', '', '');
INSERT INTO quiz_answer_templates VALUES(6, 24, '<p><img style="text-align: center;" hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/icons/logic/02.png" alt="02.png" /></p>', 2, '', 6.67, 6, '', '', '');
INSERT INTO quiz_answer_templates VALUES(7, 24, '<p><img style="text-align: center;" hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/icons/logic/03.png" alt="03.png" /></p>', 1, '', 6.67, 7, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 25, '<p style="text-align: center;"><img hspace="0" height="37" width="31" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/A.png" alt="A.png" /></p>', 0, 'Feedback_qn24_true', 0.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 25, '<p style="text-align: center;"><img hspace="0" height="37" width="37" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/B_1.png" alt="B_1.png" /></p>', 0, 'Feedback_qn24_true', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 25, '<p style="text-align: center;"><img hspace="0" height="36" width="199" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/_AorB_andnonA.png" alt="_AorB_andnonA.png" /></p>', 0, '', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 25, '<p style="text-align: center;"><img hspace="0" height="37" width="145" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/AandnonA.png" alt="AandnonA.png" /></p>', 0, '', 0.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(5, 25, '<p style="text-align: center;"><img hspace="0" height="37" width="111" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/diagrams/templates/AorB.png" alt="AorB.png" /></p>', 0, '', 0.00, 5, '', '', '');
INSERT INTO quiz_answer_templates VALUES(6, 25, '<p style="text-align: center;"><img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/icons/logic/01.png" alt="01.png" /></p>', 4, '', 4.00, 6, '', '', '');
INSERT INTO quiz_answer_templates VALUES(7, 25, '<p style="text-align: center;"><img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/icons/logic/02.png" alt="02.png" /></p>', 1, '', 4.00, 7, '', '', '');
INSERT INTO quiz_answer_templates VALUES(8, 25, '<p style="text-align: center;"><img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/icons/logic/03.png" alt="03.png" /></p>', 5, '', 4.00, 8, '', '', '');
INSERT INTO quiz_answer_templates VALUES(9, 25, '<p style="text-align: center;"><img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/icons/logic/04.png" alt="04.png" /></p>', 3, '', 4.00, 9, '', '', '');
INSERT INTO quiz_answer_templates VALUES(10, 25, '<p style="text-align: center;"><img hspace="0" height="64" width="64" vspace="0" border="0" align="absmiddle" src="../default_course_document/images/icons/logic/05.png" alt="05.png" /></p>', 2, '', 4.00, 10, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 26, '<p><img hspace="0" height="100" width="50" vspace="0" border="0" align="absmiddle" alt="Compression.jpeg" src="../default_course_document/images/diagrams/templates/Compression.jpeg" /></p>', 0, 'Feedback_qn25_true', 0.00, 1, '', '', '');
INSERT INTO quiz_answer_templates VALUES(2, 26, '<p><img hspace="0" height="100" width="50" vspace="0" border="0" align="absmiddle" alt="Emission.jpeg" src="../default_course_document/images/diagrams/templates/Emission.jpeg" /></p>', 0, 'Feedback_qn25_true', 0.00, 2, '', '', '');
INSERT INTO quiz_answer_templates VALUES(3, 26, '<p><img hspace="0" height="100" width="50" vspace="0" border="0" align="absmiddle" alt="Ignition.jpeg" src="../default_course_document/images/diagrams/templates/Ignition.jpeg" /></p>', 0, '', 0.00, 3, '', '', '');
INSERT INTO quiz_answer_templates VALUES(4, 26, '<p><img hspace="0" height="100" width="50" vspace="0" border="0" align="absmiddle" alt="Induction.jpeg" src="../default_course_document/images/diagrams/templates/Induction.jpeg" /></p>', 0, '', 0.00, 4, '', '', '');
INSERT INTO quiz_answer_templates VALUES(5, 26, 'langQuizAnswer_25a', 3, '', 5.00, 5, '', '', '');
INSERT INTO quiz_answer_templates VALUES(6, 26, 'langQuizAnswer_25b', 1, '', 5.00, 6, '', '', '');
INSERT INTO quiz_answer_templates VALUES(7, 26, 'langQuizAnswer_25c', 4, '', 5.00, 7, '', '', '');
INSERT INTO quiz_answer_templates VALUES(8, 26, 'langQuizAnswer_25d', 2, '', 5.00, 8, '', '', '');
INSERT INTO quiz_answer_templates VALUES(1, 27, 'langQuizAnswer_27a', 0, '', 10.00, 1, '42;166|32|38', 'square', '');
INSERT INTO quiz_answer_templates VALUES(2, 27, 'langQuizAnswer_27b', 0, '', 10.00, 2, '122;283|75|120', 'circle', '');
INSERT INTO quiz_answer_templates VALUES(3, 27, 'langQuizAnswer_27c', 0, '', 10.00, 3, '116;45|13|55', 'square', '');
INSERT INTO quiz_answer_templates VALUES(4, 27, 'langQuizAnswer_27d', 0, '', 10.00, 4, '116;152|50|90', 'square', '');
INSERT INTO quiz_answer_templates VALUES(1, 28, 'langQuizAnswer_28a', 0, '', 10.00, 1, '114;221|27|28', 'square', '');
INSERT INTO quiz_answer_templates VALUES(2, 28, 'langQuizAnswer_28b', 0, '', 10.00, 2, '164;53|39|18', 'square', '');
INSERT INTO quiz_answer_templates VALUES(3, 28, 'langQuizAnswer_28c', 0, '', 10.00, 3, '158;87|48|26', 'square', '');
INSERT INTO quiz_answer_templates VALUES(1, 29, 'langQuizAnswer_29a', 0, '', 10.00, 1, '203;17|23|30', 'square', '');
INSERT INTO quiz_answer_templates VALUES(2, 29, 'langQuizAnswer_29b', 0, '', 10.00, 2, '133;294|59|20', 'square', '');
INSERT INTO quiz_answer_templates VALUES(3, 29, 'langQuizAnswer_29c', 0, '', 10.00, 3, '306;184|93|22', 'square', '');
INSERT INTO quiz_answer_templates VALUES(1, 30, 'langQuizAnswer_30a', 0, '', 10.00, 1, '37;31|8|13', 'square', '');
INSERT INTO quiz_answer_templates VALUES(2, 30, 'langQuizAnswer_30b', 0, '', 10.00, 2, '52;71|9|14', 'square', '');
INSERT INTO quiz_answer_templates VALUES(3, 30, 'langQuizAnswer_30c', 0, '', 10.00, 3, '22;98|11|14', 'square', '');

CREATE TABLE IF NOT EXISTS email_template (
  id int UNSIGNED NOT NULL auto_increment,
  title varchar(250) NOT NULL,
  description text NOT NULL,
  image varchar(250) NOT NULL,
  language varchar(250) NOT NULL,
  content text NOT NULL,
  PRIMARY KEY  (id)
);

INSERT INTO email_template VALUES(1,'User Registration','Userregistration','emailtemplate.png','english','Dear {Name} ,<br />\r\n<br />\r\nYou are registered on {siteName} with the following settings:<br />\r\n<br />\r\nUsername: {username}<br />\r\nPass :{password}<br />\r\n<br />\r\nThe address of {siteName} is - {url}<br />\r\n<br />\r\nIn case of trouble, contact us.<br />\r\n<br />\r\nYours sincerely, {administratorSurname}<br />\r\n<br />\r\nManager {administratorTelephone}<br />\r\nE-mail : {emailAdministrator}');
INSERT INTO email_template VALUES(2,'Quiz Report','Quizreport','emailtemplate.png','english','Dear learner,<br />\r\n<br />\r\nYour following attempt has been viewed/commented/corrected by the trainer<br />\r\n<br />\r\nQuestion: {ques_name}<br />\r\nQuiz :{test}<br />\r\n<br />\r\nClick the link below to access your account and view your commented Examsheet. - {url}<br />\r\n<br />\r\nRegards {administratorSurname}<br />\r\nManager {administratorTelephone}<br />\r\nE-mail : {emailAdministrator}');
INSERT INTO email_template VALUES(3,'Utilisateurs inscrire','Userregistration','emailtemplate.png','french','Cher(&egrave;re) {Name} ,<br />\r\nVous &ecirc;tes inscrit(e) sur {siteName} avec les param&egrave;tres suivants:<br />\r\n<br />\r\nNom d&#39;utilisateur: {username}<br />\r\nMot de passe :{password}<br />\r\n<br />\r\nL&#39;adresse de {siteName} est - {url}<br />\r\n<br />\r\nEn cas de probl&egrave;me, n&#39;h&eacute;sitez pas &agrave; prendre contact avec nous<br />\r\n<br />\r\nCordialement, {administratorSurname}<br />\r\nFormateur {administratorTelephone}<br />\r\nCourrier &eacute;lectronique : {emailAdministrator}');
INSERT INTO email_template VALUES(4,'Quiz suivi','Quizreport','emailtemplate.png','french','Cher apprenant,<br />\r\n<br />\r\nVotre tentative d&eacute;taill&eacute;e ci-dessous a &eacute;t&eacute; vue/corrig&eacute;e/comment&eacute;e par un prof<br />\r\n<br />\r\nQuestion: {ques_name}<br />\r\nTest :{test}<br />\r\n<br />\r\nCliquez sur le lien ci-dessous pour acc&eacute;der &agrave; votre compte et voir votre feuille d&#39;examen corrig&eacute;e. - {url}<br />\r\n<br />\r\nCordialement {administratorSurname}<br />\r\nFormateur {administratorTelephone}<br />\r\nCourrier &eacute;lectronique : {emailAdministrator}');
INSERT INTO email_template VALUES(5,'Nutzer registrieren','Userregistration','emailtemplate.png','german','Guten Tag {Name} ,<br />\r\n<br />\r\nSie wurden registriert am {siteName}&nbsp;WithTheFollowingSettings<br />\r\n<br />\r\nBenutzername: {username}<br />\r\nPasswort :{password}<br />\r\n<br />\r\nDie Adresse von {siteName} ist - {url}<br />\r\n<br />\r\nFalls Probleme auftreten sollten, treten Sie bitte mit uns in Kontakt.<br />\r\n<br />\r\nMit freundlichen Gr&uuml;&szlig;en, {administratorSurname}<br />\r\n<br />\r\nVerantwortlicher {administratorTelephone}<br />\r\nE-mail : {emailAdministrator}');
INSERT INTO email_template VALUES(6,'Test statistik','Quizreport','emailtemplate.png','german','Sehr geehrte(r) Teilnehmer(in),<br />\r\n<br />\r\nDein nachfolgender Versuch wurde vom Lehrer angesehen/kommentiert/korrigiert.<br />\r\n<br />\r\nFrage: {ques_name}<br />\r\nTest :{test}<br />\r\n<br />\r\nKlicke nachfolgenden Link, um zu Deinem Account zu gelangen und Dein kommentiertes Examensblatt anzusehen - {url}<br />\r\n<br />\r\nMit freundlichen Gr&uuml;&szlig;en {administratorSurname}<br />\r\nVerantwortlicher {administratorTelephone}<br />\r\nE-mail : {emailAdministrator}');
INSERT INTO email_template VALUES(7,'Quiz Success Report','Quizsuccess','emailtemplate.png','english','Dear learner,<br />\r\n<br />\r\nYour following attempt has been viewed/commented/corrected by the trainer<br />\r\n<br />\r\nYou have succeeded in the quiz<br />\r\n<br />\r\nQuestion: {ques_name}<br />\r\nQuiz :{test}<br />\r\n<br />\r\nClick the link below to access your account and view your commented<br />\r\n<br />\r\nExamsheet. - {url}<br />\r\nRemarks {notes}<br />\r\n<br />\r\nRegards {administratorSurname}<br />\r\nManager {administratorTelephone}<br />\r\nE-mail : {emailAdministrator}');
INSERT INTO email_template VALUES(8,'Quiz Failure Report','Quizfailure','emailtemplate.png','english','Dear learner,<br />\r\n<br />\r\nYour following attempt has been viewed/commented/corrected by the trainer<br />\r\n<br />\r\nYou have failed in the quiz<br />\r\n<br />\r\nQuestion: {ques_name}<br />\r\n<br />\r\nQuiz :{test}<br />\r\n<br />\r\nClick the link below to access your account and view your commented<br />\r\n<br />\r\nExamsheet. - {url}<br />\r\n<br />\r\nRemarks {notes}<br />\r\n<br />\r\nRegards {administratorSurname}<br />\r\nManager {administratorTelephone}<br />\r\nE-mail : {emailAdministrator}');
INSERT INTO email_template VALUES(9,'Rapport de reussite Quiz','Quizsuccess','emailtemplate.png','french','Cher apprenant,<br />\r\n<br />\r\nVotre tentative d&eacute;taill&eacute;e ci-dessous a &eacute;t&eacute; vue/corrig&eacute;e/comment&eacute;e par un prof Vous avez r&eacute;ussi le quiz<br />\r\n<br />\r\nQuestion: {ques_name}<br />\r\nTest :{test}<br />\r\n<br />\r\nCliquez sur le lien ci-dessous pour acc&eacute;der &agrave; votre compte et voir votre feuille d&#39;examen corrig&eacute;e. - {url}<br />\r\n<br />\r\nRemarques {notes}<br />\r\nCordialement {administratorSurname}<br />\r\nFormateur {administratorTelephone}<br />\r\nCourrier &eacute;lectronique : {emailAdministrator}');
INSERT INTO email_template VALUES(10,'Rapport non Quiz','Quizfailure','emailtemplate.png','french','Cher apprenant,<br />\r\nVotre tentative d&eacute;taill&eacute;e ci-dessous a &eacute;t&eacute; vue/corrig&eacute;e/comment&eacute;e par un prof Quizfailure<br />\r\n<br />\r\nQuestion: {ques_name}<br />\r\nTest :{test}<br />\r\n<br />\r\nCliquez sur le lien ci-dessous pour acc&eacute;der &agrave; votre compte et voir votre feuille d&#39;examen corrig&eacute;e. - {url}<br />\r\nRemarques {notes}<br />\r\n<br />\r\nCordialement {administratorSurname}<br />\r\nFormateur {administratorTelephone}<br />\r\nCourrier &eacute;lectronique : {emailAdministrator}');
INSERT INTO email_template VALUES(11,'Quiz Erfolgsbericht','Quizsuccess','emailtemplate.png','german','Sehr geehrte(r) Teilnehmer(in),<br />\r\n<br />\r\nDein nachfolgender Versuch wurde vom Lehrer angesehen/kommentiert/korrigiert.<br />\r\n<br />\r\nQuizsuccess Frage: {ques_name}<br />\r\nTest :{test}<br />\r\n<br />\r\nKlicke nachfolgenden Link, um zu Deinem Account zu gelangen und Dein kommentiertes<br />\r\n<br />\r\nExamensblatt anzusehen - {url}<br />\r\nNotes {notes}<br />\r\n<br />\r\nMit freundlichen Gr&uuml;&szlig;en {administratorSurname}<br />\r\nVerantwortlicher {administratorTelephone}<br />\r\nE-mail : {emailAdministrator}');
INSERT INTO email_template VALUES(12,'Quiz Fehler Bericht','Quizfailure','emailtemplate.png','german','Sehr geehrte(r) Teilnehmer(in),<br />\r\n<br />\r\nDein nachfolgender Versuch wurde vom Lehrer angesehen/kommentiert/korrigiert.<br />\r\n<br />\r\nQuizfailure Frage: {ques_name}<br />\r\nTest :{test}<br />\r\nKlicke nachfolgenden Link, um zu Deinem Account zu gelangen und Dein kommentiertes<br />\r\n<br />\r\nExamensblatt anzusehen - {url}<br />\r\nNotes {notes}<br />\r\n<br />\r\nMit freundlichen Gr&uuml;&szlig;en {administratorSurname}<br />\r\nVerantwortlicher {administratorTelephone}<br />\r\nE-mail : {emailAdministrator}');
INSERT INTO email_template VALUES(13,'New Assignment','Newassignment','emailtemplate.png','english','Dear {Name} ,<br />\r\n<br />\r\nCreated New Assignment : {courseName}<br />\r\n{assignmentName}<br />\r\n{assignmentDescription}<br />\r\n<br />\r\nDeadline : {assignmentDeadline}<br />\r\nUpload your paper on : {siteName}<br />\r\nYours,<br />\r\n<br />\r\n{authorName}<br />\r\n');
INSERT INTO email_template VALUES(14,'Submit Work','Submitwork','emailtemplate.png','english','Dear {authorName} ,<br />\r\n<br />\r\n{studentName} has published a paper named<br />\r\n{paperName}<br />\r\nfor the {assignmentName} - {assignmentDescription}in the course {courseName}<br />\r\n<br />\r\nDeadline was : {assignmentDeadline}<br />\r\nThe paper was submitted on : {assignmentSentDate}<br />\r\nYou can mark, comment and correct this paper on : {siteName}<br />\r\nYours,<br />\r\n<br />\r\n{administratorSurname}<br />\r\n');
INSERT INTO email_template VALUES(15,'Correct Work','Correctwork','emailtemplate.png','english','Dear {studentName} ,<br />\r\n<br />\r\nI have corrected your Paper<br />\r\n{paperName}<br />\r\nfor the {assignmentName} - {assignmentDescription}in the course{courseName}<br />\r\n<br />\r\nDeadline was : {assignmentDeadline}<br />\r\nThe paper was submitted on : {assignmentSentDate}<br />\r\nCheck your mark and /or corrections on : {siteName}<br />\r\nYours,&nbsp;<br />\r\n<br />\r\n{authorName}<br />\r\n');
INSERT INTO email_template VALUES(16,'Inscription par ch�que', 'EmailsInCaseOfChequePayment', 'emailtemplate.png', 'french', 'Cher (�re) {firstName} {lastName} ,<br/><br/>\r\n\r\nVous �tes inscrit(e) au programme "{Programme}" sur {siteName} {Institution}<br/>\r\n\r\nNOM D''UTILISATEUR : {username}\r\nMOT DE PASSE : {password}<br/><br/>\r\n\r\nComme vous avez pay� par ch�que, votre compte sera activ� d�s que votre paiement sera enregistr� par nos services. <br/>\r\n\r\n{siteName} vous offre une exp�rience e-learning authentique avec la possibilit� de progresser pas ? pas sous la supervision d''un tuteur. Pour en savoir plus : {url}\r\n\r\nMerci de faire confiance ? : {Institution}.\r\n\r\nCordialement,\r\n\r\n{siteName}\r\n{administratorSurname}');
INSERT INTO email_template VALUES(17,'User registration with cheque payment','EmailsInCaseOfChequePayment','emailtemplate.png','english','Dear {firstName} {lastName} ,<br />\r\n<br />\r\nYou are registered to the next programmes on {siteName}<br />\r\n<br />\r\n{Programme}<br />\r\n{Institution}<br />\r\n<br />\r\nLOGIN : {username}<br />\r\nPASSWORD : {password}<br />\r\n<br />\r\nAs you paid by cheque, your account will be activated once we validate your payment.<br />\r\n<br />\r\n{siteName} offers you a true e-learning experience with the posibilty to progress step by step in your learning process under the supervision of a tutor that is dedicated to your support.<br />\r\n<br />\r\nFor more details : {InstitutionUrl}<br />\r\nThank you for trusting {Institution}.<br />\r\nYours, {siteName}<br />\r\n<br />\r\n{administratorSurname}');
INSERT INTO email_template VALUES(18, 'Inscription une session', 'UserRegistrationToSession', 'emailtemplate.png', 'french', 'Cher(�re) {administratorname} ,<br/><br/>\r\n\r\nL''�tudiant {firstName} {lastName} ,<br/><br/>\r\n\r\na �t� inscrit au programme "{Programme}" sur{siteName} {Institution}<br/>\r\n\r\nNOM D''UTILISATEUR : {username}\r\n\r\nVous pouvez maintenant v�rifier si cet �tudiant a un tuteur dans chacun de ses cours en allant {sessionList}\r\n\r\n\r\nCordialement,\r\n\r\n{siteName}\r\n{administratorSurname}');
INSERT INTO email_template VALUES(19,'New Group','NewGroup','emailtemplate.png','english','Dear {adminName} ,<br />\r\n<br />\r\nNew Group created automatically to give space to new user<br />\r\n<br />\r\nGroup : {groupName}<br />\r\n<br />\r\nSeats : {maxStudent}<br />\r\n<br />\r\nIn course : {courseName}<br />\r\n<br />\r\nYours,<br />\r\n<br />\r\n{authorName}<br />\r\n<br />\r\n');
INSERT INTO email_template VALUES(20, 'Nouveau devoir', 'Newassignment', 'emailtemplate.png', 'french', 'Cher(�re) {Name} ,<br/><br/>\r\n\r\nUn nouveau devoir a �t� cr�� dans le cours :  {courseName} <br/>\r\n\r\n{assignmentName} <br/>\r\n\r\n{assignmentDescription} <br/><br/>\r\n\r\nEch�ance : {assignmentDeadline} <br/>\r\n\r\nRemettez votre travail sur : {siteName} <br/>\r\n\r\nCordialement,, <br/><br/>\r\n\r\n{authorName} <br/>\r\n');
INSERT INTO email_template VALUES(21, 'Travail publi�', 'Submitwork', 'emailtemplate.png', 'french', 'Cher(�re) {authorName} ,<br/><br/>\r\n\r\n{studentName} a publi� un travail intitul� <br/>\r\n\r\n{paperName} <br/>\r\n\r\npour le devoir {assignmentName} - {assignmentDescription} dans le cours  {courseName} <br/> <br/>\r\n\r\nL''�ch�ance �tait : {assignmentDeadline}\r\n<br/>\r\nLe travail a �t� remis le : {assignmentSentDate} <br/>\r\n\r\nVous pouvez noter, commenter et corriger ce travail sur : {siteName} <br/>\r\n\r\nCordialement, <br/><br/>\r\n\r\n{administratorSurname} <br/>\r\n');
INSERT INTO email_template VALUES(22, 'Travail corrig�', 'Correctwork', 'emailtemplate.png', 'french', 'Cher(�re) {studentName} ,<br/><br/>\r\n\r\nJ''ai corrig� votre travail :<br/>\r\n\r\n{paperName}  <br/>\r\n\r\npour le devoir {assignmentName} - {assignmentDescription} dans le cours {courseName} <br/><br/>\r\n\r\nL''�ch�ance �tait : {assignmentDeadline} <br/>\r\n\r\nLe travail a �t� remis le : {assignmentSentDate} <br/>\r\n\r\nConsultez vos points et/ou remarques et/ou correction sur : {siteName} <br/>\r\n\r\nCordialement,, <br/><br/>\r\n\r\n{authorName} <br/>\r\n');
INSERT INTO email_template VALUES(23, 'Nouveau groupe', 'NewGroup', 'emailtemplate.png', 'french', 'Cher(�re) {adminName} ,<br/><br/>\r\n\r\nUn nouvau groupe a �t� cr�� automatiuement pour accueillir de nouveaux �tudiants.<br/><br/>\r\n\r\nGroupe : {groupName} <br/><br/>\r\n\r\nPlaces :  {maxStudent} <br/><br/>\r\n\r\nDans le cours : {courseName} <br/><br/>\r\n\r\nCordialement, <br/><br/>\r\n\r\n{authorName} <br/><br/>\r\n');
INSERT INTO email_template VALUES(24, 'Inscription carte ou 3 fois', 'EmailsRegistrationInCaseCreditCardOrInstallment', 'emailtemplate.png', 'french', 'Cher(�re) {firstName} {lastName},\r\n\r\nVous �tes inscrit(e) au programme "{Programme}" sur le portail {siteName} \r\n\r\nNOM D''UTILISATEUR : {username} \r\nMOT DE PASSE : {password} \r\n\r\nEn cas de probl�me, veuillez nous contacter.\r\n\r\nCordialement,\r\n\r\nL''�quipe {Institution}\r\n29, quai Voltaire 75007 Paris\r\nT�l�phone : 01.40.15.70.00\r\n');
INSERT INTO email_template VALUES(25,'User Registration with credit card or 3 installment payment','EmailsRegistrationInCaseCreditCardOrInstallment','emailtemplate.png','english','Dear {firstName} {lastName},<br />\r\n<br />\r\nYou are registered to the next programmes on {siteName}<br />\r\n<br />\r\n{Programme}<br />\r\n{Institution} portal {InstitutionUrl}.<br />\r\n<br />\r\nUsername : {username}<br />\r\nPassword : {password}<br />\r\n<br />\r\n{siteName} offers you a true e-learning experience with the posibilty to progress step by step in your learning process under the supervision of a tutor that is dedicated to your support.<br />\r\n<br />\r\nFor more details : {detailsUrl}.<br />\r\nThank you for trusting {Institution}.<br />\r\nYours, {siteName}<br />\r\n<br />\r\n{administratorSurname}');
INSERT INTO email_template VALUES(26,'User Registration with credit card or 3 installment payment to new programmes','RegisterUsertoProgrammes','emailtemplate.png','english','Dear {firstName} {lastName},<br />\r\n<br />\r\nYou are registered to the next programmes on {siteName}<br />\r\n<br />\r\n{Programme}<br />\r\n{Institution} portal {InstitutionUrl}.<br />\r\n<br />\r\n{siteName} offers you a true e-learning experience with the posibilty to progress step by step in your learning process under the supervision of a tutor that is dedicated to your support.<br />\r\n<br />\r\nFor more details : {detailsUrl}.<br />\r\nThank you for trusting {Institution}.<br />\r\nYours, {siteName}<br />\r\n<br />\r\n{administratorSurname}');
INSERT INTO email_template VALUES(27,'User Registration with cheque payment to new programmes','RegisterUsertoProgrammesforChequePayment','emailtemplate.png','english','Dear {firstName} {lastName} ,<br />\r\n<br />\r\nYou are registered to the next programmes on {siteName}<br />\r\n<br />\r\n{Programme}<br />\r\n{Institution}<br />\r\n<br />\r\nAs you paid by cheque, your programmes will be activated once we validate your payment.<br />\r\n<br />\r\n{siteName} offers you a true e-learning experience with the posibilty to progress step by step in your learning process under the supervision of a tutor that is dedicated to your support.<br />\r\n<br />\r\nFor more details : {InstitutionUrl}<br />\r\nThank you for trusting {Institution}.<br />\r\nYours, {siteName}<br />\r\n<br />\r\n{administratorSurname}');
INSERT INTO email_template VALUES(28,'Message to administrator in user registration with cheque payment','EmailsInCaseOfChequePaymentToAdmin','emailtemplate.png','english','Dear {administratorSurname},<br />\r\n<br />\r\nThe next user is waiting to be activated once we validate your payment:<br />\r\n<br />\r\nName :&nbsp;{firstName} {lastName} ,<br />\r\n<br />\r\nLOGIN : {username}<br />\r\nPASSWORD : {password}<br />\r\n<br />\r\nThis user have been registered to the next programmes on {siteName}<br />\r\n<br />\r\n{Programme}<br />\r\n{Institution}<br />\r\n<br />\r\nFor more details : {InstitutionUrl}<br />\r\nThank you for trusting {Institution}.<br />\r\nYours, {siteName}<br />\r\n<br />\r\n{administratorSurname}');
INSERT INTO email_template VALUES(29,'Message to administrator in user registration with cheque payment to new programmes','RegisterUsertoProgrammesforChequePaymentToAdmin','emailtemplate.png','english','Dear {administratorSurname},<br />\r\n<br />\r\nThe next user is waiting to be&nbsp;registered to the next programmes on {siteName}&nbsp;once we validate the payment:<br />\r\n<br />\r\nName :&nbsp;{firstName} {lastName} ,<br />\r\n<br />\r\n{Programme}<br />\r\n{Institution}<br />\r\n<br />\r\nFor more details : {InstitutionUrl}<br />\r\nThank you for trusting {Institution}.<br />\r\nYours, {siteName}<br />\r\n<br />\r\n{administratorSurname}');

--
-- --------------------------------------------------------
--
-- Tables for reservation
--


--
-- Table structure for table reservation category
--

CREATE TABLE reservation_category (
   id  int unsigned NOT NULL auto_increment,
   parent_id  int NOT NULL default 0,
   name  varchar(128) NOT NULL default '',
  PRIMARY KEY  ( id )
);

-- --------------------------------------------------------

--
-- Table structure for table reservation category_rights
--

CREATE TABLE  reservation_category_rights  (
   category_id  int NOT NULL default 0,
   class_id  int NOT NULL default 0,
   m_items  tinyint NOT NULL default 0
);

-- --------------------------------------------------------

--
-- Table structure for table  item reservation
--

CREATE TABLE  reservation_item  (
   id  int unsigned NOT NULL auto_increment,
   category_id  int unsigned NOT NULL default 0,
   course_code  varchar(40) NOT NULL default '',
   name  varchar(128) NOT NULL default '',
   description  text NOT NULL,
   blackout  tinyint NOT NULL default 0,
   creator  int unsigned NOT NULL default 0,
   always_available TINYINT NOT NULL default 0,
  PRIMARY KEY  ( id )
);

-- --------------------------------------------------------

--
-- Table structure for table reservation item_rights
--

CREATE TABLE  reservation_item_rights  (
   item_id  int unsigned NOT NULL default 0,
   class_id  int unsigned NOT NULL default 0,
   edit_right  tinyint unsigned NOT NULL default 0,
   delete_right  tinyint unsigned NOT NULL default 0,
   m_reservation  tinyint unsigned NOT NULL default 0,
   view_right  tinyint NOT NULL default 0,
  PRIMARY KEY  ( item_id , class_id )
);

-- --------------------------------------------------------

--
-- Table structure for main reservation table
--

CREATE TABLE  reservation_main  (
   id  int unsigned NOT NULL auto_increment,
   subid  int unsigned NOT NULL default 0,
   item_id  int unsigned NOT NULL default 0,
   auto_accept  tinyint unsigned NOT NULL default 0,
   max_users  int unsigned NOT NULL default 1,
   start_at  datetime NOT NULL default '0000-00-00 00:00:00',
   end_at  datetime NOT NULL default '0000-00-00 00:00:00',
   subscribe_from  datetime NOT NULL default '0000-00-00 00:00:00',
   subscribe_until  datetime NOT NULL default '0000-00-00 00:00:00',
   subscribers  int unsigned NOT NULL default 0,
   notes  text NOT NULL,
   timepicker  tinyint NOT NULL default 0,
   timepicker_min  int NOT NULL default 0,
   timepicker_max  int NOT NULL default 0,
  PRIMARY KEY  ( id )
);

-- --------------------------------------------------------

--
-- Table structure for reservation subscription table
--

CREATE TABLE  reservation_subscription  (
   dummy  int unsigned NOT NULL auto_increment,
   user_id  int unsigned NOT NULL default 0,
   reservation_id  int unsigned NOT NULL default 0,
   accepted  tinyint unsigned NOT NULL default 0,
   start_at  datetime NOT NULL default '0000-00-00 00:00:00',
   end_at  datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  ( dummy )
);

-- ---------------------------------------------------------

--
-- Table structure for table user_friend will be rename to user_rel_user
--
CREATE TABLE user_rel_user(
  id bigint unsigned not null auto_increment,
  user_id int unsigned not null,
  friend_user_id int unsigned not null,
  relation_type int not null default 0,
  last_edit DATETIME,
  PRIMARY KEY(id)
);

ALTER TABLE user_rel_user ADD INDEX idx_user_rel_user_user (user_id);
ALTER TABLE user_rel_user ADD INDEX idx_user_rel_user_friend_user(friend_user_id);
ALTER TABLE user_rel_user ADD INDEX idx_user_rel_user_user_friend_user(user_id,friend_user_id);

--
-- Table structure for table user_friend_relation_type
--
CREATE TABLE user_friend_relation_type(
  id int unsigned not null auto_increment,
  title char(20),
  PRIMARY KEY(id)
);


--
-- Table structure for MD5 API keys for users
--

CREATE TABLE user_api_key (
    id int unsigned NOT NULL auto_increment,
    user_id int unsigned NOT NULL,
    api_key char(32) NOT NULL,
    api_service char(10) NOT NULL default 'dokeos',
    PRIMARY KEY (id)
);
ALTER TABLE user_api_key ADD INDEX idx_user_api_keys_user (user_id);

--
-- Table structure for table message
--
CREATE TABLE message(
	id bigint unsigned not null auto_increment,
	user_sender_id int unsigned not null,
	user_receiver_id int unsigned not null,
	msg_status tinyint unsigned not null default 0, -- 0 read, 1 unread, 3 deleted, 5 pending invitation, 6 accepted invitation, 7 invitation denied, 10 chat invitation, 11 chat denied
	send_date datetime not null default '0000-00-00 00:00:00',
	title varchar(255) not null,
	content text not null,
	group_id int unsigned not null default 0,
	parent_id int unsigned not null default 0,
    update_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY(id)
);

ALTER TABLE message ADD INDEX idx_message_user_sender(user_sender_id);
ALTER TABLE message ADD INDEX idx_message_user_receiver(user_receiver_id);
ALTER TABLE message ADD INDEX idx_message_user_sender_user_receiver(user_sender_id,user_receiver_id);
ALTER TABLE message ADD INDEX idx_message_group(group_id);
ALTER TABLE message ADD INDEX idx_message_parent(parent_id);

INSERT INTO user_friend_relation_type (id,title)
VALUES
(1,'SocialUnknow'),
(2,'SocialParent'),
(3,'SocialFriend'),
(4,'SocialGoodFriend'),
(5,'SocialEnemy'),
(6,'SocialDeleted');

--
-- Table structure for table legal (Terms & Conditions)
--

CREATE TABLE  legal (
  legal_id int NOT NULL auto_increment,
  language_id int NOT NULL,
  date int NOT NULL default 0,
  content text,
  type int NOT NULL,
  changes text NOT NULL,
  version int,
  PRIMARY KEY (legal_id,language_id)
);

INSERT INTO user_field (field_type, field_variable, field_display_text, field_visible, field_changeable) values (1, 'legal_accept','Legal',0,0);

--
-- Table structure for certificate with gradebook
--

CREATE TABLE gradebook_certificate(
	id bigint unsigned not null auto_increment,
	cat_id int unsigned not null,
	user_id int unsigned not null,
	score_certificate float unsigned not null default 0,
	date_certificate datetime not null default '0000-00-00 00:00:00',
	path_certificate text null,
	PRIMARY KEY(id)
);
ALTER TABLE gradebook_certificate ADD INDEX idx_gradebook_certificate_category_id(cat_id);
ALTER TABLE gradebook_certificate ADD INDEX idx_gradebook_certificate_user_id(user_id);
ALTER TABLE gradebook_certificate ADD INDEX idx_gradebook_certificate_category_id_user_id(cat_id,user_id);
ALTER TABLE gradebook_category ADD COLUMN document_id int unsigned default NULL;



--
-- Tables structure for search tool
--

-- specific fields tables
CREATE TABLE specific_field (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	code char(1) NOT NULL,
	name VARCHAR(200) NOT NULL
);

CREATE TABLE specific_field_values (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	course_code VARCHAR(40) NOT NULL ,
	tool_id VARCHAR(100) NOT NULL ,
	ref_id INT NOT NULL ,
	field_id INT NOT NULL ,
	value VARCHAR(200) NOT NULL
);
ALTER TABLE specific_field ADD CONSTRAINT unique_specific_field__code UNIQUE (code);

-- search engine references to map dokeos resources

CREATE TABLE search_engine_ref (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	course_code VARCHAR( 40 ) NOT NULL,
	tool_id VARCHAR( 100 ) NOT NULL,
	ref_id_high_level INT NOT NULL,
	ref_id_second_level INT NULL,
	search_did INT NOT NULL
);


--
-- Table structure for table user tag
--


CREATE TABLE tag (
	id int NOT NULL auto_increment,
	tag varchar(255) NOT NULL,
	field_id int NOT NULL,
	count int NOT NULL,
	PRIMARY KEY  (id)
);


CREATE TABLE user_rel_tag (
	id int NOT NULL auto_increment,
	user_id int NOT NULL,
	tag_id int NOT NULL,
	PRIMARY KEY  (id)
);

--
-- Table structure for user platform groups
--

CREATE TABLE group_social (
  id int NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  picture_uri varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
  visibility int NOT NULL,
  updated_on varchar(255) NOT NULL,
  created_on varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE group_rel_tag (
  id int NOT NULL AUTO_INCREMENT,
  tag_id int NOT NULL,
  group_id int NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE group_rel_user (
  id int NOT NULL AUTO_INCREMENT,
  group_id int NOT NULL,
  user_id int NOT NULL,
  relation_type int NOT NULL,
  PRIMARY KEY (id)
);

--
-- Table structure for table message attachment
--

CREATE TABLE IF NOT EXISTS message_attachment (
  id int NOT NULL AUTO_INCREMENT,
  path varchar(255) NOT NULL,
  comment text,
  size int NOT NULL default 0,
  message_id int NOT NULL,
  filename varchar(255) NOT NULL,
  PRIMARY KEY  (id)
);


INSERT INTO user_field (field_type, field_variable, field_display_text, field_visible, field_changeable) values (10, 'tags','tags',0,0);
INSERT INTO user_field (field_type, field_variable, field_display_text, field_visible, field_changeable) values (9, 'rssfeeds','RSS',0,0);

--
-- Table structure for table single_sign_on_association
--
CREATE TABLE IF NOT EXISTS single_sign_on_association (
  id int NOT NULL AUTO_INCREMENT,
  token text NOT NULL,
  date_end datetime,
  user_id int NOT NULL,
  login_status int NOT NULL default 0,
  PRIMARY KEY  (id)
);

--
-- Table structure for table user_chat
--
CREATE TABLE user_chat (
   id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
   from_user VARCHAR(255) NOT NULL DEFAULT '',
   to_user VARCHAR(255) NOT NULL DEFAULT '',
   message TEXT NOT NULL,
   sent DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
   recd INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
);

CREATE TABLE search_engine_keywords (
  id int(11) NOT NULL AUTO_INCREMENT,
  idobj int(11) DEFAULT NULL,
  course_code varchar(45) DEFAULT NULL,
  tool_id varchar(100) DEFAULT NULL,
  value text,
  PRIMARY KEY (id)
);

INSERT INTO user_field (field_type, field_variable, field_display_text, field_default_value, field_visible, field_registration, field_changeable, field_filter) VALUES
(1, 'organization', 'Organization', '', 0, 1, 1, 1),
(1, 'tva_id', 'TVA', '', 0, 1, 1, 1),
(1, 'phone', 'Phone', '', 1, 0, 1, 1),
(1, 'street', 'Street', '', 1, 0, 1, 1),
(1, 'addressline2', 'Address line', '', 1, 0, 1, 1),
(1, 'zipcode', 'Zip code', '', 1, 0, 1, 1),
(1, 'city', 'City', '', 1, 0, 1, 1);

DROP TABLE IF EXISTS country;
CREATE TABLE country(
    id INT  NOT NULL AUTO_INCREMENT, 
    iso VARCHAR(4), 
    original_name VARCHAR(200), 
    langvar VARCHAR(200), 
    iso3 VARCHAR(4)  NOT NULL, 
    numcode VARCHAR(5), PRIMARY KEY (id)
);

INSERT INTO country(iso, original_name, langvar, iso3, numcode) VALUES
('AF','AFGHANISTAN','Afghanistan','AFG','004'),
('AL','ALBANIA','Albania','ALB','008'),
('DZ','ALGERIA','Algeria','DZA','012'),
('AS','AMERICAN SAMOA','AmericanSamoa','ASM','016'),
('AD','ANDORRA','Andorra','AND','020'),
('AO','ANGOLA','Angola','AGO','024'),
('AI','ANGUILLA','Anguilla','AIA','660'),
('AG','ANTIGUA AND BARBUDA','AntiguaAndBarbuda','ATG','028'),
('AR','ARGENTINA','Argentina','ARG','032'),
('AM','ARMENIA','Armenia','ARM','051'),
('AW','ARUBA','Aruba','ABW','533'),
('AU','AUSTRALIA','Australia','AUS','036'),
('AT','AUSTRIA','Austria','AUT','040'),
('AZ','AZERBAIJAN','Azerbaijan','AZE','031'),
('BS','BAHAMAS','Bahamas','BHS','044'),
('BH','BAHRAIN','Bahrain','BHR','048'),
('BD','BANGLADESH','Bangladesh','BGD','050'),
('BB','BARBADOS','Barbados','BRB','052'),
('BY','BELARUS','Belarus','BLR','112'),
('BE','BELGIUM','Belgium','BEL','056'),
('BZ','BELIZE','Belize','BLZ','084'),
('BJ','BENIN','Benin','BEN','204'),
('BM','BERMUDA','Bermuda','BMU','060'),
('BT','BHUTAN','Bhutan','BTN','064'),
('BO','BOLIVIA','Bolivia','BOL','068'),
('BA','BOSNIA AND HERZEGOVINA','BosniaAndHerzegovina','BIH','070'),
('BW','BOTSWANA','Botswana','BWA','072'),
('BR','BRAZIL','Brazil','BRA','076'),
('BN','BRUNEI DARUSSALAM','BruneiDarussalam','BRN','096'),
('BG','BULGARIA','Bulgaria','BGR','100'),
('BF','BURKINA FASO','BurkinaFaso','BFA','854'),
('BI','BURUNDI','Burundi','BDI','108'),
('KH','CAMBODIA','Cambodia','KHM','116'),
('CM','CAMEROON','Cameroon','CMR','120'),
('CA','CANADA','Canada','CAN','124'),
('CV','CAPE VERDE','CapeVerde','CPV','132'),
('KY','CAYMAN ISLANDS','CaymanIslands','CYM','136'),
('CF','CENTRAL AFRICAN REPUBLIC','CentralAfricanRepublic','CAF','140'),
('TD','CHAD','Chad','TCD','148'),
('CL','CHILE','Chile','CHL','152'),
('CN','CHINA','China','CHN','156'),
('CO','COLOMBIA','Colombia','COL','170'),
('KM','COMOROS','Comoros','COM','174'),
('CG','CONGO','Congo','COG','178'),
('CD','CONGO, THE DEMOCRATIC REPUBLIC OF THE','CongoDemo','COD','180'),
('CK','COOK ISLANDS','CookIslands','COK','184'),
('CR','COSTA RICA','CostaRica','CRI','188'),
('CI','COTE D\'IVOIRE','CoteIvoire','CIV','384'),
('HR','CROATIA','Croatia','HRV','191'),
('CU','CUBA','Cuba','CUB','192'),
('CY','CYPRUS','Cyprus','CYP','196'),
('CZ','CZECH REPUBLIC','CzechRepublic','CZE','203'),
('DK','DENMARK','Denmark','DNK','208'),
('DJ','DJIBOUTI','Djibouti','DJI','262'),
('DM','DOMINICA','Dominica','DMA','212'),
('DO','DOMINICAN REPUBLIC','DominicanRepublic','DOM','214'),
('EC','ECUADOR','Ecuador','ECU','218'),
('EG','EGYPT','Egypt','EGY','818'),
('SV','EL SALVADOR','ElSalvador','SLV','222'),
('GQ','EQUATORIAL GUINEA','EquatorialGuinea','GNQ','226'),
('ER','ERITREA','Eritrea','ERI','232'),
('EE','ESTONIA','Estonia','EST','233'),
('ET','ETHIOPIA','Ethiopia','ETH','231'),
('FK','FALKLAND ISLANDS (MALVINAS)','FalklandIslands','FLK','238'),
('FO','FAROE ISLANDS','FaroeIslands','FRO','234'),
('FJ','FIJI','Fiji','FJI','242'),
('FI','FINLAND','Finland','FIN','246'),
('FR','FRANCE','France','FRA','250'),
('GF','FRENCH GUIANA','FrenchGuiana','GUF','254'),
('PF','FRENCH POLYNESIA','FrenchPolynesia','PYF','258'),
('GA','GABON','Gabon','GAB','266'),
('GM','GAMBIA','Gambia','GMB','270'),
('GE','GEORGIA','Georgia','GEO','268'),
('DE','GERMANY','Germany','DEU','276'),
('GH','GHANA','Ghana','GHA','288'),
('GI','GIBRALTAR','Gibraltar','GIB','292'),
('GR','GREECE','Greece','GRC','300'),
('GL','GREENLAND','Greenland','GRL','304'),
('GD','GRENADA','Grenada','GRD','308'),
('GP','GUADELOUPE','Guadeloupe','GLP','312'),
('GU','GUAM','Guam','GUM','316'),
('GT','GUATEMALA','Guatemala','GTM','320'),
('GN','GUINEA','Guinea','GIN','324'),
('GW','GUINEA-BISSAU','GuineaBissau','GNB','624'),
('GY','GUYANA','Guyana','GUY','328'),
('HT','HAITI','Haiti','HTI','332'),
('VA','HOLY SEE (VATICAN CITY STATE)','HolySee','VAT','336'),
('HN','HONDURAS','Honduras','HND','340'),
('HK','HONG KONG','HongKong','HKG','344'),
('HU','HUNGARY','Hungary','HUN','348'),
('IS','ICELAND','Iceland','ISL','352'),
('IN','INDIA','India','IND','356'),
('ID','INDONESIA','Indonesia','IDN','360'),
('IR','IRAN, ISLAMIC REPUBLIC OF','Iran','IRN','364'),
('IQ','IRAQ','Iraq','IRQ','368'),
('IE','IRELAND','Ireland','IRL','372'),
('IL','ISRAEL','Israel','ISR','376'),
('IT','ITALY','Italy','ITA','380'),
('JM','JAMAICA','Jamaica','JAM','388'),
('JP','JAPAN','Japan','JPN','392'),
('JO','JORDAN','Jordan','JOR','400'),
('KZ','KAZAKHSTAN','Kazakhstan','KAZ','398'),
('KE','KENYA','Kenya','KEN','404'),
('KI','KIRIBATI','Kiribati','KIR','296'),
('KP','KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF','KoreaDemo','PRK','408'),
('KR','KOREA, REPUBLIC OF','Korea','KOR','410'),
('KW','KUWAIT','Kuwait','KWT','414'),
('KG','KYRGYZSTAN','Kyrgyzstan','KGZ','417'),
('LA','LAO PEOPLE\'S DEMOCRATIC REPUBLIC','Lao','LAO','418'),
('LV','LATVIA','Latvia','LVA','428'),
('LB','LEBANON','Lebanon','LBN','422'),
('LS','LESOTHO','Lesotho','LSO','426'),
('LR','LIBERIA','Liberia','LBR','430'),
('LY','LIBYAN ARAB JAMAHIRIYA','LibyanArabJamahiriya','LBY','434'),
('LI','LIECHTENSTEIN','Liechtenstein','LIE','438'),
('LT','LITHUANIA','Lithuania','LTU','440'),
('LU','LUXEMBOURG','Luxembourg','LUX','442'),
('MO','MACAO','Macao','MAC','446'),
('MK','MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','Macedonia','MKD','807'),
('MG','MADAGASCAR','Madagascar','MDG','450'),
('MW','MALAWI','Malawi','MWI','454'),
('MY','MALAYSIA','Malaysia','MYS','458'),
('MV','MALDIVES','Maldives','MDV','462'),
('ML','MALI','Mali','MLI','466'),
('MT','MALTA','Malta','MLT','470'),
('MH','MARSHALL ISLANDS','MarshallIslands','MHL','584'),
('MQ','MARTINIQUE','Martinique','MTQ','474'),
('MR','MAURITANIA','Mauritania','MRT','478'),
('MU','MAURITIUS','Mauritius','MUS','480'),
('MX','MEXICO','Mexico','MEX','484'),
('FM','MICRONESIA, FEDERATED STATES OF','Micronesia','FSM','583'),
('MD','MOLDOVA, REPUBLIC OF','Moldova','MDA','498'),
('MC','MONACO','Monaco','MCO','492'),
('MN','MONGOLIA','Mongolia','MNG','496'),
('MS','MONTSERRAT','Montserrat','MSR','500'),
('MA','MOROCCO','Morocco','MAR','504'),
('MZ','MOZAMBIQUE','Mozambique','MOZ','508'),
('MM','MYANMAR','Myanmar','MMR','104'),
('NA','NAMIBIA','Namibia','NAM','516'),
('NR','NAURU','Nauru','NRU','520'),
('NP','NEPAL','Nepal','NPL','524'),
('NL','NETHERLANDS','Netherlands','NLD','528'),
('AN','NETHERLANDS ANTILLES','NetherlandsAntilles','ANT','530'),
('NC','NEW CALEDONIA','NewCaledonia','NCL','540'),
('NZ','NEW ZEALAND','NewZealand','NZL','554'),
('NI','NICARAGUA','Nicaragua','NIC','558'),
('NE','NIGER','Niger','NER','562'),
('NG','NIGERIA','Nigeria','NGA','566'),
('NU','NIUE','Niue','NIU','570'),
('NF','NORFOLK ISLAND','NorfolkIsland','NFK','574'),
('MP','NORTHERN MARIANA ISLANDS','NorthernMarianaIslands','MNP','580'),
('NO','NORWAY','Norway','NOR','578'),
('OM','OMAN','Oman','OMN','512'),
('PK','PAKISTAN','Pakistan','PAK','586'),
('PW','PALAU','Palau','PLW','585'),
('PA','PANAMA','Panama','PAN','591'),
('PG','PAPUA NEW GUINEA','PapuaNewGuinea','PNG','598'),
('PY','PARAGUAY','Paraguay','PRY','600'),
('PE','PERU','Peru','PER','604'),
('PH','PHILIPPINES','Philippines','PHL','608'),
('PN','PITCAIRN','Pitcairn','PCN','612'),
('PL','POLAND','Poland','POL','616'),
('PT','PORTUGAL','Portugal','PRT','620'),
('PR','PUERTO RICO','PuertoRico','PRI','630'),
('QA','QATAR','Qatar','QAT','634'),
('RE','REUNION','Reunion','REU','638'),
('RO','ROMANIA','Romania','ROM','642'),
('RU','RUSSIAN FEDERATION','RussianFederation','RUS','643'),
('RW','RWANDA','Rwanda','RWA','646'),
('SH','SAINT HELENA','SaintHelena','SHN','654'),
('KN','SAINT KITTS AND NEVIS','SaintKittsAndNevis','KNA','659'),
('LC','SAINT LUCIA','SaintLucia','LCA','662'),
('PM','SAINT PIERRE AND MIQUELON','SaintPierreAndMiquelon','SPM','666'),
('VC','SAINT VINCENT AND THE GRENADINES','SaintVincentAndTheGrenadines','VCT','670'),
('WS','SAMOA','Samoa','WSM','882'),
('SM','SAN MARINO','SanMarino','SMR','674'),
('ST','SAO TOME AND PRINCIPE','SaoTomeAndPrincipe','STP','678'),
('SA','SAUDI ARABIA','SaudiArabia','SAU','682'),
('SN','SENEGAL','Senegal','SEN','686'),
('SC','SEYCHELLES','Seychelles','SYC','690'),
('SL','SIERRA LEONE','SierraLeone','SLE','694'),
('SG','SINGAPORE','Singapore','SGP','702'),
('SK','SLOVAKIA','Slovakia','SVK','703'),
('SI','SLOVENIA','Slovenia','SVN','705'),
('SB','SOLOMON ISLANDS','SolomonIslands','SLB','090'),
('SO','SOMALIA','Somalia','SOM','706'),
('ZA','SOUTH AFRICA','SouthAfrica','ZAF','710'),
('ES','SPAIN','Spain','ESP','724'),
('LK','SRI LANKA','SriLanka','LKA','144'),
('SD','SUDAN','Sudan','SDN','736'),
('SR','SURINAME','Suriname','SUR','740'),
('SJ','SVALBARD AND JAN MAYEN','SvalbardAndJanMayen','SJM','744'),
('SZ','SWAZILAND','Swaziland','SWZ','748'),
('SE','SWEDEN','Sweden','SWE','752'),
('CH','SWITZERLAND','Switzerland','CHE','756'),
('SY','SYRIAN ARAB REPUBLIC','SyrianArabRepublic','SYR','760'),
('TW','TAIWAN, PROVINCE OF CHINA','Taiwan','TWN','158'),
('TJ','TAJIKISTAN','Tajikistan','TJK','762'),
('TZ','TANZANIA, UNITED REPUBLIC OF','Tanzania','TZA','834'),
('TH','THAILAND','Thailand','THA','764'),
('TG','TOGO','Togo','TGO','768'),
('TK','TOKELAU','Tokelau','TKL','772'),
('TO','TONGA','Tonga','TON','776'),
('TT','TRINIDAD AND TOBAGO','TrinidadAndTobago','TTO','780'),
('TN','TUNISIA','Tunisia','TUN','788'),
('TR','TURKEY','Turkey','TUR','792'),
('TM','TURKMENISTAN','Turkmenistan','TKM','795'),
('TC','TURKS AND CAICOS ISLANDS','TurksAndCaicosIslands','TCA','796'),
('TV','TUVALU','Tuvalu','TUV','798'),
('UG','UGANDA','Uganda','UGA','800'),
('UA','UKRAINE','Ukraine','UKR','804'),
('AE','UNITED ARAB EMIRATES','UnitedArabEmirates','ARE','784'),
('GB','UNITED KINGDOM','UnitedKingdom','GBR','826'),
('US','UNITED STATES','UnitedStates','USA','840'),
('UY','URUGUAY','Uruguay','URY','858'),
('UZ','UZBEKISTAN','Uzbekistan','UZB','860'),
('VU','VANUATU','Vanuatu','VUT','548'),
('VE','VENEZUELA','Venezuela','VEN','862'),
('VN','VIET NAM','VietNam','VNM','704'),
('VG','VIRGIN ISLANDS, BRITISH','VirginIslandsBritish','VGB','092'),
('VI','VIRGIN ISLANDS, U.S.','VirginIslandsUs','VIR','850'),
('WF','WALLIS AND FUTUNA','WallisAndFutuna','WLF','876'),
('EH','WESTERN SAHARA','WesternSahara','ESH','732'),
('YE','YEMEN','Yemen','YEM','887'),
('ZM','ZAMBIA','Zambia','ZMB','894'),
('ZW','ZIMBABWE','Zimbabwe','ZWE','716');

DROP TABLE IF EXISTS payer_user;
CREATE TABLE payer_user (
  id int(11) NOT NULL AUTO_INCREMENT,
  firstname varchar(200) NOT NULL,
  lastname varchar(200) DEFAULT NULL,
  email varchar(200) DEFAULT NULL,
  street_number text,
  street text,
  zipcode varchar(20) DEFAULT NULL,
  city varchar(200) DEFAULT NULL,
  country varchar(200) DEFAULT NULL,
  student_id int(11) NOT NULL DEFAULT '0',
  company varchar(200) DEFAULT NULL,
  vat_number varchar(20) DEFAULT NULL,
  phone varchar(50) DEFAULT NULL,
  civility varchar(20) DEFAULT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS payment_atos;
CREATE TABLE payment_atos (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL DEFAULT '0',
  sess_id int(11) NOT NULL DEFAULT '0',
  pay_type int(11) NOT NULL DEFAULT '0',
  pay_data text,
  pay_time int(11) NOT NULL DEFAULT '0',
  status int(11) NOT NULL DEFAULT '0',
  curr_quota int(11) NOT NULL DEFAULT '0',
  transaction_id varchar(255),
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS payment_settings;
CREATE TABLE payment_settings (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255),
  value varchar(255),
  position int(11) NOT NULL,
  gateway_id int(11) NOT NULL COMMENT '0 none , 1 atos, 2 paypal',
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS payment_log;
CREATE TABLE payment_log (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL DEFAULT '0',
  sess_id int(11) NOT NULL DEFAULT '0',
  pay_type int(11) NOT NULL DEFAULT '0',
  pay_data text,
  pay_time int(11) NOT NULL DEFAULT '0',
  status int(11) NOT NULL DEFAULT '0',
  curr_quota int(11) NOT NULL DEFAULT '0',
  transaction_id VARCHAR( 255 ) NULL ,
  ecommerce_gateway INT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS certificate;
CREATE TABLE certificate (
  id INT  NOT NULL AUTO_INCREMENT,
  portal_name VARCHAR(200),
  portal_logo VARCHAR(200),
  company VARCHAR(200),
  company_logo VARCHAR(200),
  certificate_date DATE  NOT NULL DEFAULT '0000-00-00',
  message TEXT,
  company_seal VARCHAR(200),
  scope TEXT,
  display_as VARCHAR(20) NOT NULL DEFAULT 'html',
  template INT  NOT NULL DEFAULT 1,
  required_score FLOAT NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS certificate_template;
CREATE TABLE certificate_template (
  id INT  NOT NULL AUTO_INCREMENT,
  title VARCHAR(200),
  description TEXT,
  thumbnail VARCHAR(200),
  content LONGTEXT,
  position INT NOT NULL DEFAULT 0,
  creation_date DATETIME  NOT NULL DEFAULT '0000-00-00 00:00:00',
  language VARCHAR(200),
  PRIMARY KEY (id)
);

INSERT INTO certificate_template (id, title, description, thumbnail, content, position, creation_date, language) VALUES
(1,	'certificate01',	NULL,	'pg_0001.jpg',	'<div class=\"bg-certificate01\" style=\"background-image:url(/main/default_course_document/images/templates/certificates/certificate01.jpg);background-repeat:no-repeat;height:756px;width:1070px;z-index:-10;margin:0px;\">\r\n	&nbsp;</div>\r\n<div class=\"certificate-drag\" style=\"top: 224px; left: 480px;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><span style=\"color:#950101;\"><strong><em><span style=\"font-size: 28px;\">Presented to</span></em></strong></span></span></div>\r\n<div class=\"certificate-drag\" style=\"top: 279px; left: 281px; width: 595px; text-align: center;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><em><span style=\"font-size:28px;\">{StudentFullName}</span></em></span></div>\r\n<div class=\"certificate-drag\" style=\"top: 371px; left: 360px; width: 518px;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><span style=\"color:#950101;\"><em><strong><span style=\"font-size: 28px;\">For the successful completion of</span></strong></em></span></span></div>\r\n<br />\r\n<div class=\"certificate-drag\" style=\"top: 592px; left: 70px;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><em><span style=\"font-size: 28px;\">{Date}</span></em></span></div>\r\n<br />\r\n<div class=\"certificate-drag\" style=\"top: 640px; left: 339px; width: 390px; text-align: center;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><em><span style=\"font-size: 28px;\">Trainer</span></em></span></div>\r\n<div class=\"certificate-drag\" style=\"top: 68px; left: 183px; width: 770px; text-align: center;position:absolute;z-index: 100;\">\r\n	<span style=\"color:#950101;\"><span style=\"font-size: 62px;\"><em>Award for Excellence</em></span></span></div>\r\n<div class=\"certificate-drag\" style=\"top: 423px; left: 279px; width: 594px; text-align: center;position:absolute;z-index: 100;\">\r\n	<em><span style=\"font-size:28px;\">{ModuleName}</span></em></div>\r\n<div class=\"certificate-drag\" style=\"top: 595px; left: 339px; width: 389px; text-align: center;position:absolute;z-index: 100;\">\r\n	<em><span style=\"font-size:28px;\">{TrainerFullName}</span></em></div>\r\n',	0,	'2012-04-14 01:57:58',	'english'),
(2,	'certificate02',	NULL,	'pg_0002.jpg',	'<div class=\"bg-certificate02\" style=\"background-image:url(/main/default_course_document/images/templates/certificates/certificate02.jpg);background-repeat:no-repeat;height:756px;width:1070px;z-index:-10;margin:0px;\">\r\n	&nbsp;</div>\r\n<br />\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 145px; left: 196px; width: 754px; text-align: center;\">\r\n	<span style=\"color:#0f1910;\"><em><span style=\"font-size: 72px;\">Award for Excellence</span></em></span></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; z-index: 10; top: 294px; left: 260px;\">\r\n	<span style=\"color:#3d4d3f;\"><span style=\"font-size: 28px;\">Presented to</span></span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 293px; left: 438px; width: 426px; text-align: center;\">\r\n	<span style=\"font-size:28px;\">{StudentFullName}</span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 363px; left: 534px;\">\r\n	<em><span style=\"font-size:36px;\"><strong><span style=\"color: rgb(134, 139, 118);\">For</span></strong></span></em></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 423px; left: 263px; width: 611px; text-align: center;\">\r\n	<span style=\"font-size:28px;\">{ModuleName}</span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 552px; left: 158px; width: 231px; text-align: center;\">\r\n	<span style=\"font-size:28px;\">{TrainerFullName}</span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 591px; left: 164px; width: 221px; text-align: center;\">\r\n	<span style=\"font-size:28px;\">Trainer</span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 556px; left: 801px;\">\r\n	<span style=\"font-size:28px;\">{Date}</span></div>\r\n',	0,	'2012-04-15 22:23:03',	'english'),
(3,	'certificate03',	NULL,	'pg_0003.jpg',	'<div class=\"bg-certificate03\" style=\"background-image:url(/main/default_course_document/images/templates/certificates/certificate03.jpg);background-repeat:no-repeat;height:756px;width:1070px;z-index:-10;margin:0px;\">\r\n	&nbsp;</div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 63px; left: 102px; z-index: 10; width: 873px; height: 77px; text-align: center;\">\r\n	<span style=\"font-size:62px;\"><strong>Business Certificate</strong></span></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 187px; left: 196px; z-index: 10; width: 685px; text-align: center;\">\r\n	<em><span style=\"font-size:36px;\">This certifies that</span></em></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 241px; left: 195px; z-index: 10; width: 684px; height: 33px; text-align: center;\">\r\n	<strong><span style=\"font-size:36px;\">{StudentFullName}</span></strong></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 309px; left: 199px; z-index: 10; width: 710px; height: 44px; text-align: center;\">\r\n	<em><span style=\"font-size:36px;\">has sucessfully completed the following </span></em></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 370px; left: 226px; z-index: 10; width: 621px; text-align: center;\">\r\n	<strong><span style=\"font-size:36px;\">{ModuleName}</span></strong></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 599px; left: 151px; z-index: 10;\">\r\n	<span style=\"font-size:28px;\">{TrainerFullName}</span></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 639px; left: 154px; z-index: 10;\">\r\n	&nbsp;</div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 643px; left: 154px; z-index: 10;\">\r\n	<span style=\"font-size:28px;\">Trainer</span></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 605px; left: 843px; z-index: 10;\">\r\n	<span style=\"font-size:28px;\">{Date}</span></div>\r\n',	0,	'2012-04-15 22:38:40',	'english'),
(4,	'certificate01',	NULL,	'pg_0001.jpg',	'<div class=\"bg-certificate01\" style=\"background-image:url(/main/default_course_document/images/templates/certificates/certificate01.jpg);background-repeat:no-repeat;height:756px;width:1070px;z-index:-10;margin:0px;\">\r\n	&nbsp;</div>\r\n<div class=\"certificate-drag\" style=\"top: 224px; left: 480px;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><span style=\"color:#950101;\"><strong><em><span style=\"font-size: 28px;\">Pr&eacute;sent&eacute; &agrave;</span></em></strong></span></span></div>\r\n<div class=\"certificate-drag\" style=\"top: 279px; left: 281px; width: 595px; text-align: center;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><em><span style=\"font-size:28px;\">{StudentFullName}</span></em></span></div>\r\n<div class=\"certificate-drag\" style=\"top: 371px; left: 360px; width: 518px;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><span style=\"color:#950101;\"><em><strong><span style=\"font-size: 28px;\">Pour la r&eacute;ussite de</span></strong></em></span></span></div>\r\n<br />\r\n<div class=\"certificate-drag\" style=\"top: 592px; left: 70px;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><em><span style=\"font-size: 28px;\">{Date}</span></em></span></div>\r\n<br />\r\n<div class=\"certificate-drag\" style=\"top: 640px; left: 339px; width: 390px; text-align: center;position:absolute;z-index: 100;\">\r\n	<span style=\"font-family:arial,helvetica,sans-serif;\"><em><span style=\"font-size: 28px;\">Professeur</span></em></span></div>\r\n<div class=\"certificate-drag\" style=\"top: 68px; left: 183px; width: 770px; text-align: center;position:absolute;z-index: 100;\">\r\n	<span style=\"color:#950101;\"><span style=\"font-size: 62px;\"><em>Prix pour les execelencia</em></span></span></div>\r\n<div class=\"certificate-drag\" style=\"top: 423px; left: 279px; width: 594px; text-align: center;position:absolute;z-index: 100;\">\r\n	<em><span style=\"font-size:28px;\">{ModuleName}</span></em></div>\r\n<div class=\"certificate-drag\" style=\"top: 595px; left: 339px; width: 389px; text-align: center;position:absolute;z-index: 100;\">\r\n	<em><span style=\"font-size:28px;\">{TrainerFullName}</span></em></div>\r\n',	0,	'2012-04-15 23:05:58',	'french'),
(5,	'certificate02',	NULL,	'pg_0002.jpg',	'<div class=\"bg-certificate02\" style=\"background-image:url(/main/default_course_document/images/templates/certificates/certificate02.jpg);background-repeat:no-repeat;height:756px;width:1070px;z-index:-10;margin:0px;\">\r\n	&nbsp;</div>\r\n<br />\r\n<div class=\"certificate-drag\" style=\"position: absolute; z-index: 10; top: 145px; left: 142px; width: 847px; text-align: center;\">\r\n	<span style=\"color:#0f1910;\"><em><span style=\"font-size: 62px;\">Prix pour les execelencia</span></em></span></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; z-index: 10; top: 294px; left: 260px;\">\r\n	<span style=\"color:#3d4d3f;\"><span style=\"font-size: 28px;\">Pr&eacute;sent&eacute; &agrave;</span></span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 293px; left: 438px; width: 426px; text-align: center;\">\r\n	<span style=\"font-size:28px;\">{StudentFullName}</span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 363px; left: 534px;\">\r\n	<em><span style=\"font-size:36px;\"><strong><span style=\"color: rgb(134, 139, 118);\">Pour</span></strong></span></em></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 423px; left: 263px; width: 611px; text-align: center;\">\r\n	<span style=\"font-size:28px;\">{ModuleName}</span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 552px; left: 158px; width: 231px; text-align: center;\">\r\n	<span style=\"font-size:28px;\">{TrainerFullName}</span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 591px; left: 164px; width: 221px; text-align: center;\">\r\n	<span style=\"font-size:28px;\">Professeur</span></div>\r\n<div class=\"certificate-drag\" style=\"position:absolute;z-index: 10;top: 556px; left: 801px;\">\r\n	<span style=\"font-size:28px;\">{Date}</span></div>\r\n',	0,	'2012-04-15 23:11:32',	'french'),
(6,	'certificate03',	NULL,	'pg_0003.jpg',	'<div class=\"bg-certificate03\" style=\"background-image:url(/main/default_course_document/images/templates/certificates/certificate03.jpg);background-repeat:no-repeat;height:756px;width:1070px;z-index:-10;margin:0px;\">\r\n	&nbsp;</div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 63px; left: 102px; z-index: 10; width: 873px; height: 77px; text-align: center;\">\r\n	<span style=\"font-size:62px;\"><strong>Certificat d&#39;affaires</strong></span></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 187px; left: 196px; z-index: 10; width: 685px; text-align: center;\">\r\n	<em><span style=\"font-size:36px;\">Ce document certifie que</span></em></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 241px; left: 195px; z-index: 10; width: 684px; height: 33px; text-align: center;\">\r\n	<strong><span style=\"font-size:36px;\">{StudentFullName}</span></strong></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 309px; left: 199px; z-index: 10; width: 710px; height: 44px; text-align: center;\">\r\n	<em><span style=\"font-size:36px;\">avoir suivi avec succ&egrave;s ce qui suit </span></em></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 370px; left: 226px; z-index: 10; width: 621px; text-align: center;\">\r\n	<strong><span style=\"font-size:36px;\">{ModuleName}</span></strong></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 599px; left: 151px; z-index: 10;\">\r\n	<span style=\"font-size:28px;\">{TrainerFullName}</span></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 639px; left: 154px; z-index: 10;\">\r\n	&nbsp;</div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 643px; left: 154px; z-index: 10;\">\r\n	<span style=\"font-size:28px;\">Professeur</span></div>\r\n<div class=\"certificate-drag\" style=\"position: absolute; top: 605px; left: 843px; z-index: 10;\">\r\n	<span style=\"font-size:28px;\">{Date}</span></div>\r\n',	0,	'2012-04-15 23:16:23',	'french');