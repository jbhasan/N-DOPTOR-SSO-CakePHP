<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\View\Helper\UrlHelper;

class NDoptorController extends EFileController
{

	public function showLoginForm()
	{
		$redirect_path = '/dashboard';
		if ($this->request->getQuery('redirect')) {
			$redirect_path = "/" . $this->request->getQuery('redirect');
		}
		$redirect_path = UrlHelper::build('/login_response', ['fullBase' => true]) . '?redirect=' . $redirect_path;
		$return_url = UrlHelper::build($redirect_path, ['fullBase' => true]);
		return $this->redirect(Configure::read('ndoptor.login_sso_url') . '?referer=' . base64_encode($return_url));
	}

	public function loginResponse() {
		$request_data = $this->request->getQuery();
		$session = $this->request->getSession();

		$data = json_decode(base64_decode($request_data['data']), true);
		if ($data['status'] == 'success' && !empty($data['user_info'])) {

			/// your authentication process here START
			$session->write('login', ['status' => 'logged_in', 'user' => $data['user_info']]);
			$session->write('current_user', $data['user_info']);
			$session->write('token', $request_data['data']);
			$designation = $data['user_info']['office_info'][0];
			$designation['user_id'] = $data['user_info']['user']['id'];
			$designation['officer_name'] = $data['user_info']['employee_info']['name_bng'];
			$designation['officer_email'] = $data['user_info']['employee_info']['personal_email'];
			$designation['front_domain'] = 'localhost';
			$session->write('current_designation', $designation);

			$this->is_authenticated = true;
			/// Token should be nothi-bs token
			$this->token = $request_data['data'];
			/// nothi-bs token END

			/// your authentication process here END

			if (isset($request_data['redirect'])) {
				return $this->redirect($request_data['redirect']);
			} else {
				return $this->redirect('/');
			}
		} else {
			return $this->redirect('/login');
		}

	}

	public function logout() {
		$this->request->getSession()->destroy();
		$return_url = UrlHelper::build('/login', ['fullBase' => true]);
		return $this->redirect(Configure::read('ndoptor.logout_sso_url') . '?referer=' . base64_encode($return_url));
	}


}