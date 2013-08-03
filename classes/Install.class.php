<?php
	class Install {
	    
        public $per = "\n";
	    
        public static function create() {
            return new self();
        }
        
		private function __construct() {
            $this->filename = $this->request->getRadioPath()."_config.php";
            $this->file = file($this->filename);

		public function getWgetCron() {

		public function getPhpCron() {
			$file_adres = str_replace("//","/",$file_adres);
			return $file_adres;

		public function ifHag5() {
			$password = $this->request->getPostVar('password');

			if (empty($user) or empty($password)) {

			$this->saveConfig('USER', $user);

            Header("Location: install.php?hag=6");

		public function ifHag4() {
			$play_list_file = $this->request->getPostVar('playlist');
			$cf_ezstream = $this->request->getPostVar('cf_ezstream');
			$cf_icecast = $this->request->getPostVar('cf_icecast');
			}
            
            if (!file_exists($cf_icecast)){
                return"<p>Файл конфигурации icecast не существует.</p>";
            }
            
            if (!file_exists($cf_ezstream)) {
                return "<p>Файл конфигурации ezstream не существует.</p>";
            }
            
			if (!file_exists($play_list_file)) {
			}

            $pos_vhoh = strrpos($play_list_file, "/");
            $folder_chmod = substr($play_list_file, 0, $pos_vhoh);
            Ssh::create()->sshExec("chmod 777 $folder_chmod && chmod 777 $play_list_file");
            
            $pos_vhoh = strrpos($cf_ezstream, "/");
            $folder_chmod = substr($cf_ezstream, 0, $pos_vhoh);
            Ssh::create()->sshExec("chmod 777 $folder_chmod && chmod 644 $cf_ezstream");
            
            $pos_vhoh = strrpos($cf_icecast, "/");
            $folder_chmod = substr($cf_icecast, 0, $pos_vhoh);
            Ssh::create()->sshExec("chmod 777 $folder_chmod && chmod 644 $cf_icecast");

            $this->saveConfig('PLAYLIST', $play_list_file);
            $this->saveConfig('CF_EZSTREAM', $cf_ezstream);
            $this->saveConfig('CF_ICECAST', $cf_icecast);

            $xml = simplexml_load_file($cf_icecast);
			$this->saveConfig('ICE_LOGIN', $xml->authentication->{'admin-user'});
			$this->saveConfig('ICE_PASS', $xml->authentication->{'admin-password'});

			Header("Location: install.php?hag=5");

		public function ifHag3() {
			$con = @ssh2_connect($this->request->getPostVar('ip'), 22);
			if(!@ssh2_auth_password($con, $this->request->getPostVar('ssh_user'), $this->request->getPostVar('ssh_pass'))) {
				return "<p>Неправильный логин или пароль.</p>";
    		}
    		$this->saveConfig('IP', $this->request->getPostVar('ip'));
    		$this->saveConfig('URL', $this->request->getPostVar('url'));
    		$this->saveConfig('PORT', $this->request->getPostVar('port'));
    		$this->saveConfig('SSH_USER', $this->request->getPostVar('ssh_user'));
    		$this->saveConfig('SSH_PASS', $this->request->getPostVar('ssh_pass'));
    		Header("Location: install.php?hag=4");

		public function ifHag2() {
				$this->request->getPostVar('db_host'),
				$this->request->getPostVar('db_login'),
				$this->request->getPostVar('db_password')
			);
			$link_db = @mysql_select_db($this->request->getPostVar('db_name'));

			if ($link and $link_db) {
				$this->saveConfig('DB_HOST', $this->request->getPostVar('db_host'));
				$this->saveConfig('DB_LOGIN', $this->request->getPostVar('db_login'));
				$this->saveConfig('DB_PASSWORD', $this->request->getPostVar('db_password'));
				$this->saveConfig('DB_NAME', $this->request->getPostVar('db_name'));
				Header("Location: install.php?hag=3");

		public function createTable($db_name) {
				or die("Install query failed : " . mysql_error());
			mysql_query("ALTER DATABASE `".$db_name."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `last_zakaz` (
			  `id` varchar(15) NOT NULL,
			  `idsong` varchar(15) NOT NULL,
			  `track` varchar(100) NOT NULL,
			  `time` varchar(25) NOT NULL,
			  `skolko` varchar(10) NOT NULL,
			  `ip` varchar(25) NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `login` (
			  `ip` varchar(25) NOT NULL,
			  `dj` varchar(50) NOT NULL,
			  `raz` tinyint(10) NOT NULL,
			  `time` varchar(25) NOT NULL,
			  `hash` varchar(25) NOT NULL,
			  `admin` int(1) NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `playlist` (
			  `id` int(11) NOT NULL auto_increment,
			  `name` text,
			  `playmode` tinyint(4) default NULL,
			  `enable` tinyint(4) default NULL,
			  `event1` text,
			  `event2` text,
			  `now` tinyint(4) default NULL,
			  `show` tinyint(4) default NULL,
			  `sort` int(11) default NULL,
			  `last_time` bigint(20) default NULL,
			  `allow_zakaz` int(11) default '1',
			  `auto` int(11) default '0',
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `poisk` (
				`title` varchar(50) NOT NULL,
				`artist` varchar(50) NOT NULL,
				`id` int(10) NOT NULL,
				`idsong` int(11) NOT NULL,
				`filename` text NOT NULL,
				`duration` int(11) NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `songlist` (
			  `idsong` int(11) NOT NULL auto_increment,
			  `zakazano` int(10) NOT NULL,
			  `id` int(11) default NULL,
			  `filename` text,
			  `artist` text,
			  `title` text,
			  `album` text,
			  `genre` text,
			  `albumyear` int(11) default NULL,
			  `duration` int(11) default NULL,
			  `played` int(1) default '0',
			  `sort` int(11) default NULL,
              PRIMARY KEY  (`idsong`),
              FULLTEXT KEY `artist` (`artist`,`title`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `statistic` (
			  `type` varchar(50) NOT NULL,
			  `country` varchar(20) NOT NULL,
			  `country_name` varchar(25) NOT NULL,
			  `ip` varchar(50) NOT NULL,
			  `client` varchar(150) NOT NULL,
			  `listeners` varchar(15) NOT NULL,
			  `time` int(20) NOT NULL,
			  `date` varchar(10) NOT NULL,
			  KEY `stream` (`listeners`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

			mysql_query("CREATE TABLE IF NOT EXISTS `tracklist` (
			  `title` text,
			  `id` int(20) NOT NULL auto_increment,
			  `idsong` int(11) NOT NULL,
			  `filename` varchar(200) NOT NULL,
			  `time` varchar(25) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `user_ip` (
			  `id` int(20) NOT NULL auto_increment,
			  `ip` varchar(100) NOT NULL,
			  `time` varchar(100) NOT NULL,
			  `nomer` int(2) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `zakaz` (
			  `id` int(11) NOT NULL auto_increment,
			  `idsong` int(10) NOT NULL,
			  `filename` text,
			  `artist` text,
			  `title` text,
			  `album` text,
			  `duration` int(11) default NULL,
			  `admin` int(1) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `settings` (
			  `name` varchar(25) NOT NULL,
			  `value` text NOT NULL,
			  PRIMARY KEY  (`name`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;")
			 or die("Install query failed : " . mysql_error());

			mysql_query("CREATE TABLE IF NOT EXISTS `dj` (
			  `id` tinyint(50) NOT NULL auto_increment,
			  `description` varchar(100) NOT NULL,
			  `dj` varchar(50) NOT NULL,
			  `password` varchar(50) NOT NULL,
			  `admin` int(1) NOT NULL,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `dj` (`dj`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;")
			 or die("Install query failed : " . mysql_error());
			 			 
             $this->saveSetting('main_text', 'Здесь вы можете хранить общие записи..');
             $this->saveSetting('online', '0');

		public function getPerms($file) {

		public function ifPerms($file) {
        	if (is_writable($file)) {
        		return true;
        	} else {
        		return false;
        	}
		}

		public function getBaseDir() {
			$base_dir = ini_get("open_basedir");
   			if ($base_dir == "" or $base_dir == "/") {
   			    $base_dir = (empty($base_dir)) ? 'no_value' : $base_dir;
   				return '<span class="green"><b>'.$base_dir.'</b></span>';
   			} else {
   				return '<span class="red"><b>'.$base_dir.'</b></span>';
   			}
		}

		public function getSsh2() {
        
        public function getXML() {
            if (function_exists("simplexml_load_file")) {
                return '<span class="green"><b>установлена</b></span>';
            } else {
                return '<span class="red"><b>не установлена</b></span>';
            }
        }

		public function getCurl() {
			if (function_exists("curl_init")) {
				return '<span class="green"><b>установлена</b></span>';
			} else {
				return '<span class="red"><b>не установлена</b></span>';
			}
		}

		public function getIconv() {
			if (function_exists("iconv")) {
				return '<span class="green"><b>установлена</b></span>';
			} else {
				return '<span class="red"><b>не установлена</b></span>';
			}
		}

		public function getGd() {
			if (function_exists("imageCreate")) {
				return '<span class="green"><b>установлена</b></span>';
			} else {
				return '<span class="red"><b>не установлена</b></span>';
			}
		}

		public function isGreen($string) {

		public function addStatistic() {
			$add_site = "http://radiocms.ru/stations.php?i_url=".URL."&i_ip=".IP;
			$this->request->get($add_site);
		}

		public function ifHag1() {
            	$this->isGreen(
            		$this->getPerms($this->request->getMusicPath())
            	)	 and
            	$this->isGreen(
            		$this->getPerms($this->request->getRadioPath()."_config.php")
            	)	 and
            	$this->isGreen(
            		$this->getPerms($this->request->getRadioPath()."_system.php")
            	)	 and
            	$this->isGreen(
            		$this->getBaseDir()
            	)	 and
            	$this->isGreen(
            		$this->getSsh2()
            	)	 and
            	$this->isGreen(
            		$this->getCurl()
            	)	 and
            	$this->isGreen(
            		$this->getIconv()
            	)   and
                $this->isGreen(
                    $this->getGd()
                )    and
                $this->isGreen(
                    $this->getXML()
                )
            ) {
		
        public function saveConfig($const, $value) {     
            $value = htmlspecialchars($value, ENT_QUOTES, "utf-8");
            for ($i=0; $i<count($this->file); $i++) {
                if (strpos($this->file[$i], "define('$const'")) {
                    $this->file[$i] = "\t"."define('$const', '$value');".$this->per;
                    $h = fopen($this->filename, 'w+');
                    fwrite($h, implode($this->file, ""));
                    fclose($h);
                }
            }
        }
        
        public function saveSetting($name, $value) {
            $query = "SELECT * FROM  `settings` WHERE `name`='$name' LIMIT 1";
            $line = $this->getLine($query);
            if (!empty($line)) {
                $query = "UPDATE `settings` SET `value` = '".addslashes($value)."' WHERE `name`= '$name';";
                 $this->queryNull($query);
            } else {
                $query = "INSERT INTO `settings` ( `name` , `value` ) VALUES ('$name', '".addslashes($value)."');";
                $this->queryNull($query);;
            }
        }
        
        public function getLine($query) {
            $result = mysql_query($query) or die($this->debug());
            return mysql_fetch_array($result, MYSQL_ASSOC);
        }
        
        public function queryNull($query) {
            mysql_query($query) or die($this->debug());
        }
?>