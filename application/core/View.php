<?php

namespace application\core;


class View 
{

	public $path;
	public $route;
	public $script;

	public function __construct($route) 
	{
		$this->route = $route;
		$this->path = $route['controller'].'/'.$route['action'];
	}

	public function render($title, $vars = [], $layout = 'default') 
	{
		if($title === NULL || $title === "" || $title === false) $title = TITLE;

		$path = PUBLIC_PATH . $this->path. '.php';
		if (file_exists($path)) {

			$custom_script = "pages/" . $this->route["controller"] . ".js";
			file_exists(RESOURCES_PATH . "js/" . $custom_script)
				? $custom_script = "<script src='" . JS_URL . $custom_script . "'></script>"
				: $custom_script = "";

			extract($vars);

			ob_start();
			require $path;
			$content = ob_get_clean();

			require PUBLIC_PATH . '/layouts/'.$layout.'.php';
		}
	}

	public static function errorCode($code) 
	{
		http_response_code($code);
		$path = PUBLIC_PATH . '/errors/'.$code.'.php';
		if (file_exists($path)) {
			$custom_script = "";

			require $path;
		}
		exit;
	}

    public function redirect($url)
    {
        header('location: '.$url);
        exit;
    }

    public function message($status, $message)
	{
		exit(json_encode(['status' => $status, 'message' => $message]));
	}

	public function location($url) 
	{
		exit(json_encode(['url' => $url]));
	}
}	