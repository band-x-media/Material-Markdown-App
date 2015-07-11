<?php


namespace Freedom\App;

use \Freedom\Framework\System\Base as AppBase;

class MaterialMarkdown extends AppBase\App implements AppBase\AppMethods {


	public	$name = "Material Markdown",
			$assets = [],
			$active = [],				//	an array of active nav items
			$current,					//	the current page data
			$first,						//	the first nav item
			$section,					//	the current section data
			$nav;						//	the nav structure
	
	public	$_layout = false,
			$_path = false;


	public function __construct() {

		parent::__construct();

	}


	public function applicationVariables($domain) {

		return [
			[
				"label" => "Path to site",
				"name" => "path",
				"value" => $this->getApplicationVariableValue("path", $domain),
				"type" => "text",
				"help" => "the absolute path to the site files on the server"
			]
		];

	}


	public function getApplicationVariableValue($name, $domain = false) {

		if(!$domain) $domain = \Scope::$domain;

		return $domain->applicationVariables[$name];

	}


	public function getCurrentRequestOutput() {

		if(empty($this->path)) \Redirect::withoutMessage(\Scope::url("home"));

		$this->variables["path"] = $this->getApplicationVariableValue("path");

		$this->variables["siteTitle"] = \Scope::$domain->site_name;

		$this->getToolbar()->getNav()->getContent()->getLayout();

		if(empty(trim($this->variables['content'])) && !empty($this->current['children']))
			\Redirect::withoutMessage($this->current['children'][0]['href']);

		$this->active[2] = $this->_findActiveNavItemAtLevel($this->nav, 2);

		if(@$this->active[2]["data"]["meta"]->sidebar == true)
			$this->variables["sidebar"] = $this->_buildSidebar($this->active[2]);

		if(!file_exists($this->current["file"])) {

			if(!empty($this->current["children"])) {

				\Redirect::withoutMessage(Scope::url($this->current["children"][0]["href"]));

			} else {

				\EventTower::fire("app.render.getAlternativeContent", [
				    "app" => &$this,
				    "reason" => [
				        "status" => 404,
				        "message" => "Content not Found"
				    ]
				]);
			}

		} else {

			$this->page()->body["content"] = (string) $this;

		}

		return $this;

	}


	private function _findActiveNavItemAtLevel($navItems, $level) {

		foreach($navItems as $item) {

			if($item["active"]) {

				if($item["level"] === $level) {

					return $item;

				} elseif(!empty($item["children"])) {

					return $this->_findActiveNavItemAtLevel($item["children"], $level);

				}

			}

		}

		return false;

	}


	public function __toString() {

		foreach($this->variables as $variable)
			if($variable instanceof View && $variable->hasCSS())
				$this->assets["css"][$variable->getViewFilePath("css")] = $variable->getCSS();

		$page = $this->current;
		$section = $this->section;
		$first = $this->first;

		ob_start();
		extract($this->variables, EXTR_SKIP);
		include "/srv/applications/MaterialMarkdown/layouts/{$this->_layout}.php";

		return ob_get_clean();

	}


	public function getContent() {

		$content = false;

		if(@$this->path[0] === "search") {

			$content = $this->getSearchResultsContent();

		} elseif(file_exists($this->current["file"])) {

			$content = \View::fromFile($this->current["file"], $this->variables);
			$content->useDelimiter = true;

		}

		$content = \Michelf\MarkdownExtra::defaultTransform($content);
		$content = str_replace("<table>", "<table class=\"table\">", $content);
		$this->variables['content'] = $content;

		$this->_UI_HTMLPage->body["classes"][] = "no-transition";

		$this->_UI_HTMLPage->css["files"][] = "http://code.band-x.media/SASS-Material-Design-for-Bootstrap/assets/css/material-bootstrap.min.css";

		$this->_UI_HTMLPage->javascript["files"][] = "http://code.band-x.media/SASS-Material-Design-for-Bootstrap/assets/js/material-bootstrap.min.js";
		$this->_UI_HTMLPage->javascript["files"][] = "https://cdn.rawgit.com/Prinzhorn/skrollr/master/dist/skrollr.min.js";
		$this->_UI_HTMLPage->javascript["files"][] = "https://cdn.rawgit.com/liabru/jquery-match-height/master/jquery.matchHeight-min.js";

		return $this;

	}




	public function getSearchResultsContent() {

		$results = $this->searchFor(@$_POST["query"], $this->variables["path"] . "/content");

		$resultContent = [];

		if(!empty($results))
			foreach($results as $result) {
				$matched = $this->_getNavItemForFile($this->nav, $result);
				if(!empty($matched)) {
					$resultContent[] = [
						"name" => $matched["name"],
						"href" => $matched["href"]
					];
				}
			}

		ob_start();
		include "/srv/applications/MaterialMarkdown/layouts/pages/search.php";
		return ob_get_clean();

	}




	public function getLayout() {

		$layout = "page";

		$this->_layout = $layout;

		return $this;

	}


	public function getToolbar() {

		ob_start();
		extract($this->variables, EXTR_SKIP);
		include "/srv/applications/MaterialMarkdown/layouts/parts/toolbar.php";
		$this->variables["toolbar"] = ob_get_clean();

		return $this;

	}


	public function getNav() {

		$this->nav = $this->_getAllNavItems($this->variables["path"] . "/content");
		$nav = $this->nav;
#pre($nav);
		ob_start();
		extract($this->variables, EXTR_SKIP);
		include "/srv/applications/MaterialMarkdown/layouts/parts/nav-drawer.php";
		$this->variables["nav"] = ob_get_clean();

		return $this;

	}


	private function _getAllNavItems($dir, $i = 0, $url = "") {

		$nav = [];

		$l = $i + 1;

		foreach(glob($dir . "/*") as $file) {

			if(is_dir($file)) {

				$item = [];
				$item["name"] = basename($file);
				$item["level"] = $l;
				$item["position"] = false;

				$nameParts = explode(". ", $item["name"], 2);
				if(count($nameParts) > 1 && is_numeric($nameParts[0])) {
					$item["name"] = trim($nameParts[1]);
					$item["position"] = (int) $nameParts[0] - 1;
				}

				$item["file"] = $file . "/index.md.php";
				$item["uri"] = \Inflector::slugify($item["name"]);

				$thisURL = $url . "/" . $item["uri"];
				$item["href"] = $thisURL;

				$current = "/" . implode("/", $this->path);

				$item["active"] = strpos($current, $item["href"]) === 0 ? true : false;

				if($item["active"] && $l == 1) {
					$item["data"] = $this->_getFileDate($item["file"]);
					$this->first = $item;
				}

				$item["current"] = $current === $item["href"] ? true : false;

				$item["children"] = $this->_getAllNavItems($file, $l, $thisURL);

				$item["data"] = $this->_getFileDate($item["file"]);

				$nav[] = $item;

				if($item["current"]) $this->current = $item;

				if($item["active"] && $l == 2) $this->section = $item;

			}

		}

		return $nav;

	}


	private function _getNavItemForFile($allNav, $file) {

		$result = false;

		foreach($allNav as $nav) {

			if($nav["file"] === $file)
				$result = $nav;

			if(!$result)
				$result = $this->_getNavItemForFile($nav["children"], $file);

			if($result) break;

		}

		return $result;

	}


	private function _buildSidebar() {

		ob_start();
		$items = $this->active[2];
#		pre($items);
		include "/srv/applications/MaterialMarkdown/layouts/parts/sidebar.php";
		return ob_get_clean();

	}


	private function searchFor($term, $directory) {

		$results = [];

		foreach(glob($directory . "/*") as $file) {

			if(is_dir($file)) {

				$results = array_merge($results, $this->searchFor($term, $file));

			} else {

				$content = file_get_contents($file);
				if(strpos($content, $term) !== false)
					$results[] = $file;

			}

		}

		return $results;

	}


	/**
	 *
	 *	Each directory should have an index.md.php file in with the contents. In the header, you should add meta data enclosed in "---"
	 *
	 */
	private function _getFileDate($file) {

		$output = [
			"meta" => new \StdClass(),
			"content" => false
		];

		if(!file_exists($file)) return $output;

		$fileContent = file_get_contents($file);

		preg_match("/[\-]{3}(.*?)[\-]{3}/s", $fileContent, $metaContent);

	//	no match, return empty
		if(empty($metaContent[1])) return $output;

	//	get content metadata
		foreach(explode("\n", $metaContent[1]) as $line) {
			$line = trim($line);
			$parts = explode(":", $line, 2);
			if(count($parts) > 1) {
				$title = trim($parts[0]);
				$value = trim($parts[1]);
				$output["meta"]->$title = $value;
			}
		}

	//	get content
		$output["content"] = trim(str_replace($metaContent[0], "", $fileContent));

		return $output;

	}


}
