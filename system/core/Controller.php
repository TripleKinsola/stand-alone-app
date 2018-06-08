<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {
	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/////////////////////////////
	/// Pre-Defined Properties and Methods///
	/////////////////////////////
	public $view_folder = "";
	public $person = array();
	public $data = array();
	public $sec_title = "Welcome";
	public $title = APP_NAME;
	public $view = "index";
	public $place = "";

	public $error = array();

	public $encryption;
	public $token = "";
	public $de_tok = "";
	public $user_in = false;

	public function render_template(){
		$this->load->view('templates/head');
		$this->load->view($this->view_folder.'/'.$this->view);
		$this->load->view('templates/foot');
	}
	public function render_dash_template(){
		$this->load->view('templates/dash_head');
		$this->load->view($this->view_folder.'/'.$this->view);
		$this->load->view('templates/dash_foot');
	}

	//////////////////////////////
	public $master_settings = array();

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////  Super Controller settings and pre-defines   ////////////////////////////////////
//		$this->master_settings = $this->master->select_by_id("settings", 7, "table_key");
//		$this->master_settings['si'] == 1 ? show_404() : "";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		if($this->session->userdata('logged_in')){
			$this->user_in = true;
			$this->person = $this->master->select_by_id("users", $this->session->userdata('roof'));
		}

		$this->encryption = new Encryption();
		//////////////////////////////////////////////////////////////
		/*
		Token Security Measures; To prevent crawlers and false form submitting
		*/
		///////////////////////////////////////////////////////////////
		$this->token = encrypt(TOKEN);
		$this->de_tok = decrypt($this->token);
		if(isset($_POST['make'])){
			if(!isset($_POST['token'])){
				show_error($message="Something certainly went wrong.", $status_code="500", $heading = 'An Error Was Encountered.');
			}else{
				$d_tok = decrypt($_POST['token']);
				if($d_tok != $this->de_tok){
					show_error($message="Something certainly went wrong.", $status_code="500", $heading = 'An Error Was Encountered.');
				}
			}
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
	protected function user_shud_be_logged_in($redirect_if_not_in = ""){
		if(!$this->user_in){
			flash_hash("Please login first.");
			!empty($redirect_if_not_in) ? redirect(BASEURL."identify?redirect=".$redirect_if_not_in) : redirect(BASEURL."identify");
		}
	}
	protected function user_shud_be_logged_in_and_be_sudo(){
		if($this->user_in){
			if($this->person['level'] != SUDO){
				flash_hash("Please login first.");
				!empty($redirect_if_not_in) ? redirect(BASEURL."identify?redirect=".$redirect_if_not_in) : redirect(BASEURL."login");
			}
		}else{
			flash_hash("Please login first.");
			!empty($redirect_if_not_in) ? redirect(BASEURL."identify?redirect=".$redirect_if_not_in) : redirect(BASEURL."login");
		}
	}
	protected function site_state(){
		//Site state: ON or Offline?
		switch($this->master_settings){
			case !$this->master_settings['site_state']:
				show_error("Currently offline.", 500, "We are currently working on a little upgrade...");
				break;

			default:
				//
				break;
		}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

	}
	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */

	public static function &get_instance()
	{
		return self::$instance;
	}
}
