<?php
	class Controller_Account extends Asstroller{

		private $user_id;

		public function __construct(){
			parent::__construct();
			Loader::helper("user");

			Config::set("navigation", true);

			$this->user_id = Session::getvar("is_logged_in_id");
		}

		public function index(){
			$this->view();
		}

		public function view($user_id = NULL){
			// account summary

			if($user_id){
				$user_id = trim($user_id);
			} else {
				$user_id = $this->user_id;
			}

			$user_info = Helper_User::get_user_by_id($user_id);			

			$view_data["user_info"] = $user_info;

			Config::set("page_title", "Account Information");
			Config::set("active_link", "summary");

			Template::setvar("page", "account/view");
			Template::set("account/template", $view_data);

		}

		/**
		 * Change your account's password
		 */
		public function password(){

			$user_info = Helper_User::get_user_by_id($this->user_id);

			if($_POST){

				$formdata = form_post_data(array("old_password", "new_password", "repeat_new_password"));
				
				$old_password = trim($formdata["old_password"]);
				$new_password = trim($formdata["new_password"]);
				$repeat_new_password = trim($formdata["repeat_new_password"]);

				$error_flag = false;

				if(strlen($old_password) <= 0){
					$error_flag = true;
					Template::notify("error", "Please enter the old password");
				} else {

					if(strlen($new_password) > 0 && strlen($repeat_new_password) > 0){
						// if both fields are not empty

						if(strlen($new_password) < 6){
							// the password cannot be less than 6 characters
							$error_flag = true;
							Template::notify("error", "Too short password. Password must be at least 6 characters long.");
						} else {
							// now compare the two new passwords
							if(strcmp($new_password, $repeat_new_password) !== 0){
								// both passwords are not same
								$error_flag = true;
								Template::notify("error", "New Passwords do not match. Please try again.");
							}
						}
					} else {
						Template::notify("error", "Please enter the new password");
					}
				}

				if(!$error_flag){
					// means there are no any errors
					// get the current user account from the database
					// if the old password matches with the one that the user entered
					// change the password, else throw an error

					$old_password_hash = Config::hash($old_password);

					if(strcmp($old_password_hash, trim($user_info->password)) === 0){

							if($this->change_password($new_password, $user_info)){
								Template::notify("success", "Password changed successfully");
							}
							redirect(Config::url("account"));

					} else {
						Template::notify("error", "Wrong Old Password. Please try again");
					}
				}
			}

			Config::set("active_link", "password");
			Config::set("page_title", "Change Account Password");

			$view_data["user_info"] = $user_info;

			Template::setvar("page", "account/password");
			Template::set("account/template", $view_data);
		}

		/**
		 * Post change password controller
		 * @todo - need to move it off the controller
		 */
		private function change_password($new_password, $user_info){

			$where["id"] = $user_info->id;
			$password_update_data["password"] = Config::hash($new_password);
			
			if($this->db->update(DB::db_tbl_users, $password_update_data, $where)){

				$email_details["to"] = $user_info->email;
				$email_details["message"] = <<<EOT
				Dear {$user_info->username},
				Your account's password has been changed.

				If you did not change this password, please contact support.

				Keep Exploring.

				Thanks,
EOT;
				Loader::helper("general");
				Helper_General::send_email($email_details);

				return true;
			} else {
				Template::notify("error", "There was an error changing the password. Please try again later");
			}

			return false;
		}	

	}