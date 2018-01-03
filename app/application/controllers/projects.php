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
		$contenu = '<ul>';
		$contenu .= '<li>Modification du fichier de config de Bugs</li>';
		//Writing the Reports configuration usefull to Bugs into the config.app.php file (Bugs' config file)
		$configCont = "'".$_POST["Path"]."','".$_POST["SubDir"]."/','".$_POST["language"]."'";
		$fileConfig = fopen('vendor/Reports/config.php', 'w');
		fwrite($fileConfig, $configCont);
		fclose($fileConfig);
				

		$contenu .= '<li>Copie des fichiers de config de Reports</li>';
		//Copying the Reports files into the appropriate path of Reports' sub-directories
		$BugsDir = substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER["DOCUMENT_ROOT"]."/"));
		$NbRep = substr_count($BugsDir, "/");
		$racine = "../../../../";
		echo '<br /><br />';
		for($x=0; $x<$NbRep; $x++) { $racine .= "../"; }
		chdir("vendor/Reports/Bugs_Reporting");
		$NewDir = $racine.$_POST["Path"]."/".$_POST["SubDir"];
		if (!file_exists($NewDir)) { mkdir ($NewDir); }
		$No = array(".", "..");
		$Rep1 = scandir(".");
		foreach ($Rep1 as $file1) {
			if (!in_array($file1, $No)) {
				if (is_dir($file1)) {
					if (!file_exists($NewDir."/".$file1)) { mkdir($NewDir."/".$file1); }
					$Rep2 = scandir("./".$file1);
					foreach ($Rep2 as $file2) {
						if (!in_array($file2, $No)) {
							if (is_dir("./".$file1."/".$file2)) {
								if (!file_exists($NewDir."/".$file1."/".$file2)) { mkdir($NewDir."/".$file1."/".$file2); }
								$Rep3 = scandir("./".$file1."/".$file2);
								foreach($Rep3 as $file3) {
									if (!in_array($file3, $No)) {
										if (is_dir("./".$file1."/".$file2."/".$file3)) {
											if (!file_exists($NewDir."/".$file1."/".$file2."/".$file3)) { mkdir($NewDir."/".$file1."/".$file2."/".$file3); }
											$Rep4 = scandir("./".$file1."/".$file2."/".$file3);
											foreach($Rep4 as $file4) {
												if (!in_array($file3, $No)) {
													if (!is_dir("./".$file1."/".$file2."/".$file3."/".$file4)) { copy("./".$file1."/".$file2."/".$file3."/".$file4, $NewDir."/".$file1."/".$file2."/".$file3."/".$file4); }
												}
											}
										} else { copy("./".$file1."/".$file2."/".$file3, $NewDir."/".$file1."/".$file2."/".$file3); }
									}
								}
							} else { copy("./".$file1."/".$file2, $NewDir."/".$file1."/".$file2); }
						}
					}
				} else { copy("./".$file1, $NewDir."/".$file1); }
			}
		}
		
		$contenu .= '<li>Modification du fichier de config de Reports</li>';
		$ConfigDatabase = Config::get('database.connections.mysql');
		$LineBug = file($NewDir.'/BugsRepConfig.php');
		$LineBug[2] = "\$db_user = '".$ConfigDatabase["username"]."'\n;";
		$LineBug[3] = "\$db_pass = '".$ConfigDatabase["password"]."'\n;"; 
		$LineBug[4] = "\$db_name = '".$ConfigDatabase["database"]."'\n;"; 
		$LineBug[5] = "\$language = '".$_POST["language"]."';\n"; 
		$NewConfigFile = fopen($NewDir.'/BugsRepConfig.php', 'w');
		fwrite($NewConfigFile, implode("",$LineBug));
		fclose($NewConfigFile);

		$contenu .= '</ul>';
		$contenu .= '<script>alert("Installation complete");document.location.href="reports";</script>';
		return $contenu;
	}

	public function post_new()
	{
		$create = Project::create_project(Input::all());

		if($create['success']) {
			return Redirect::to($create['project']->to());
		}

		return Redirect::to('projects/new')
			->with_errors($create['errors'])
			->with('notice-error', __('tinyissue.we_have_some_errors'));
	}

}