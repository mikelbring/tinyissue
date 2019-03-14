<?php

class Projects_Controller extends Base_Controller {

	public function get_index()
	{
		$status = Input::get('status', 1);
		$projects_active = Project\User::active_projects(true);
		$projects_inactive = Project\User::inactive_projects(true);

		return $this->layout->with('active', 'projects')->nest('content', 'projects.index', array(
			'projects' => $status == 1 ? $projects_active : $projects_inactive,
			'active' => $status == 1 ? 'active' : 'archived',
			'active_count' => (int) count($projects_active),
			'archived_count' => (int) count($projects_inactive)
		));
	}

	public function get_new()
	{
		Asset::script('project-new', '/app/assets/js/project-new.js', array('app'));

		return $this->layout->with('active', 'projects')->nest('content', 'projects.new');
	}

	public function get_reports() {
		return $this->layout->with('active', 'projects')->nest('content', 'projects.reports');
	}

	public function post_reports() {
		if ($_POST["Etape"] == 'Activation') {
			$fileConfig = fopen('vendor/Reports/config.php', "r");
			while ($UneLigne = fgets($fileConfig)) {
				$Ligne[] = $UneLigne;
			}
			$Ligne[1] = '$RepInstalled = '.$_POST["Installed"].';
';
			$fileConfig = fopen('vendor/Reports/config.php', 'w');
			fwrite($fileConfig, implode("", $Ligne));
			fclose($fileConfig);
		}
		if ($_POST["Etape"] == 'Definition') {
			//Fichier de configuration de Report_bugs
			$ConfigDatabase = Config::get('database.connections.mysql');
			$configCont  = "<?php \n";
			$configCont .= "\$db_host = '".$ConfigDatabase["host"]."';\n";
			$configCont .= "\$db_user = '".$ConfigDatabase["username"]."';\n";
			$configCont .= "\$db_pass = '".$ConfigDatabase["password"]."';\n"; 
			$configCont .= "\$db_name = '".$ConfigDatabase["database"]."';\n"; 
			$configCont .= "\$language = '".$_POST["language"]."';\n"; 
			$configCont .= "\$BugsDir = 'http://".$_SERVER["SERVER_ADDR"].substr($_SERVER["SCRIPT_FILENAME"], strlen($_SERVER["DOCUMENT_ROOT"]))."';\n"; 
			$configCont .= "\n"; 
			$configCont .= "\$conn = new mysqli(\$db_host, \$db_user, \$db_pass, \$db_name);\n";
			$configCont .= "\n"; 
			$configCont .= "if (\$conn->connect_error) { \n "; 
			$configCont .= "\tdie('Connection failed: ' . \$conn->connect_error);\n"; 
			$configCont .= "}\n\n"; 
			$configCont .= "?>";
	
			$fileConfig = fopen('vendor/Reports/BugsRepConfig.php', 'w');
			fwrite($fileConfig, $configCont);
			fclose($fileConfig);
			
			//Comparaison du serveur de destination et du serveur d'origine
			$comparable = "false";
			$ServOrig = "http://".$_SERVER["SERVER_ADDR"];
			$ServOrigLen = strlen($ServOrig);
			$ServOrigs = "https://".$_SERVER["SERVER_ADDR"];
			$ServOrigsLen = strlen($ServOrig);
			if ( substr($_POST["Path"], 0, $ServOrigLen ) == $ServOrig  ) { $comparable = "true";  $Chemin = substr($_POST["Path"], $ServOrigLen +1 ); } 
			if ( substr($_POST["Path"], 0, $ServOrigsLen) == $ServOrigs ) { $comparable = "true";  $Chemin = substr($_POST["Path"], $ServOrigsLen +1); }
			if (!file_exists($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.@$Chemin)) { $comparable = "false"; }
	
			//Copie du fichier BugsRepConfig.php
			if ($comparable == "true") {
				if (copy(substr($_SERVER["SCRIPT_FILENAME"], 0, -9).'app/vendor/Reports/BugsRepConfig.php', $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.$Chemin."BugsRepConfig.php" )) {
					//La copie du fichier a fonctionné
				} else {
					$comparable = "false";
				}
			}
	
	
		//Writing the Reports configuration usefull to Bugs into the config.app.php file (Bugs' config file)
		$configCont = "<?php
\$RepInstalled = ".$comparable.";
\$ReportsConfig = array('".$_POST["Path"]."','".$_POST["language"]."');
?>
";
			$fileConfig = fopen('vendor/Reports/config.php', 'w');
			fwrite($fileConfig, $configCont);
			fclose($fileConfig);
		}
	
		return Redirect::to('projects/reports');
	}

	public function post_new() {
		$create = Project::create_project(Input::all());

		if($create['success']) {
			return Redirect::to($create['project']->to());
		}

		return Redirect::to('projects/new')
			->with_errors($create['errors'])
			->with('notice-error', __('tinyissue.we_have_some_errors'));
	}

}