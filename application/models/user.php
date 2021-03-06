<?php

class User extends Eloquent
{
	
	public function address()
	{
		return $this->has_one('Address');
	}

	public function orders()
	{
		return $this->has_many('Order');
	}
	
	public function role()
	{
		return $this->belongs_to('Role');
	}

	public function isAdmin()
	{
		if ($this->role_id == RoleEnum::ADMIN) {
			return true;
		}
		return false;
	}

}