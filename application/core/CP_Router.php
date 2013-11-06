<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Custom router function v 0.1
 *
 * Add functionality : read into more than one sub-folder
 *
 */

Class CP_Router extends CI_Router
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *  Parse Routes
	 *
	 * This function matches any routes that may exist in
	 * the config/routes.php file against the URI to
	 * determine if the class/method need to be remapped.
	 *
	 * @access	private
	 * @return	void
	 */
	function _parse_routes()
	{	
		// Turn the segment array into a URI string
		$uri = implode('/', $this->uri->segments);

		log_message('debug', 'Client sent : ' . $uri);

		// Is there a literal match?  If so we're done
		if (isset($this->routes[$uri]))
		{
			log_message('debug', 'Route found : ' . $uri . '  --> ' . $this->routes[$uri]);
			log_message('debug', 'Redirecting to : ' . $uri . '  --> ' . $uri);
			return $this->_set_request(explode('/', $this->routes[$uri]));
		}

		// Loop through the route array looking for wild-cards
		foreach ($this->routes as $key => $val)
		{
			$original_key = $key;
			$original_val = $val;

			// Convert wild-cards to RegEx
			$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $uri))
			{
				// Do we have a back-reference?
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}

				log_message('debug', 'Route found : ' . $original_key . '  --> ' . $original_val);
				log_message('debug', 'Redirecting to : ' . $uri . '  --> ' . $val);
				return $this->_set_request(explode('/', $val));
			}
		}

		// If we got this far it means we didn't encounter a
		// matching route so we'll set the site default route
		$this->_set_request($this->uri->segments);
	}

	function _validate_request($segments)
	{
		if (file_exists(APPPATH.'controllers/'.$segments[0].EXT))
		{
			return $segments;
		}

		if (is_dir(APPPATH.'controllers/'.$segments[0]))
		{
			$this->set_directory($segments[0]);
			$segments = array_slice($segments, 1);

			/* ----------- ADDED CODE ------------ */

			while(count($segments) > 0 && is_dir(APPPATH.'controllers/'.$this->directory.$segments[0]))
			{
				// Set the directory and remove it from the segment array
    		$this->set_directory($this->directory . $segments[0]);
    		$segments = array_slice($segments, 1);
			}

			/* ----------- END ------------ */

			if (count($segments) > 0)
			{
				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].EXT))
				{
					show_404($this->fetch_directory().$segments[0]);
				}
			}
			else
			{
				$this->set_class($this->default_controller);
				$this->set_method('index');

				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.EXT))
				{
					$this->directory = '';
					return array();
				}
			}
			return $segments;
		}
		show_404($segments[0]);
	}
}
/* End of file CP_Router.php */
/* Location: ./application/core/CP_Router.php */