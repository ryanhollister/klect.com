<?php
require_once APPPATH.'controllers/site'.EXT;

class Login extends Site
{
	
	function index($data = array())
	{
		$this->load->model('domain_model');
		$data['main_content'] = 'index';
		$data['page_title'] = 'KLECT - Where collectors inventory, value and trade stamps, coins, and so much more!';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'main';
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['js_includes'][] = 'login';
		$data['js_includes'][] = 'signup';
		$data['available_collections'] = $this->domain_model->getAllCollections();
		$data['content_left']['Events and Updates'] = $this->load->view('static/recent_news', $data, true);

		$data['content_right']['WELCOME TO KLECT'] = $this->load->view('static/index', $data, true);
		$data['logged_in'] = $this->phpsession->get('is_logged_in'); 
		$this->load->view('includes/klect_template', $data);		
	}
	
	/**
	 * Called when a user is trying to have their password reset and sent to their email address.
	 * 
	 */
	function forgot_password()
	{
		$this->load->model('person_model');
		$this->person_model->forgot_password();
	}
	
	/**
	 * Called to validate the credentials passed by a user on the login page.
	 */
	function validate_credentials()
	{		
		$this->load->model('person_model');
		$this->load->library('hash');
		$personVO = $this->person_model->validate();
		
		if($personVO) // if the user's credentials validated...
		{
			$this->person_model->trackLogin($personVO->getPerson_id());
			$this->load->model('domain_model');
			$currDomain = $this->domain_model->getDomainFromId($personVO->getDef_domain());
			$data = array(
				'is_logged_in' => true,
				'personVO'	=> $personVO,
				'current_domain' => $currDomain
			);
			$this->phpsession->save($data);
			redirect('members_area/dashboard');
		}
		else // incorrect username or password
		{
			$data['invalid'] = "Invalid Credentials, try again.";
			$this->index($data);
		}
	}	
	
	/**
	 * Called from the main page. This method validates the input and will attempt to create a user if the email and username arent already
	 * registered.
	 */
	function create_member()
	{
		$this->load->library('form_validation');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('fname', 'Name', 'trim|required');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('uname', 'Username', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
		
		
		if($this->form_validation->run() == FALSE)
		{
			echo false;
		}
		
		else
		{			
			$this->load->model('person_model');
			$personVO = $this->person_model->create_member();
			if (is_a($personVO, 'PersonVO'))
			{
				$this->load->model('domain_model');
				$this->domain_model->add_collection((int)$this->input->post('collection_id'), $personVO->getPerson_id());
				echo ($personVO == true);
			}
			else
			{
				echo $personVO;
			}
		}
	}
	
	/**
	 * Called from the dashboard. A user is able to edit their profile. This method returns the current profile details to pre-populate
	 * the form.
	 */
	function get_profile()
	{
		is_logged_in();
		$this->load->model('person_model');
		echo $this->person_model->get_profile();
	}
	
	/**
	 * This controller will kickoff the updating of a user's profile from the dashboard.
	 */
	function edit_profile()
	{
		is_logged_in();
		$this->load->model('person_model');
		$this->person_model->edit_profile();
	}
	
	/**
	 * terminates session. Kicked off from the Logout at the top of every members area page.
	 */
	function logout()
	{
		$this->phpsession->clear();
		redirect();
	}

}