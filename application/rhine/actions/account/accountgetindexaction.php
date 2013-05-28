<?php namespace Rhine\Actions\Account;

use Laravel\View;
use Laravel\Auth;
use Laravel\Redirect;

class AccountGetIndexAction
{

	/**
	 * @return View
	 */
	public function execute()
	{
		$user = Auth::user();
		if ($user == null) {
			throw new \LogicException('User not authenticated!');
		}

		return View::make('account.index')
		->with(compact('user'));
	}

}