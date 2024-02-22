<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function isAdmin(): bool
	{
		return $this->value === self::ADMIN->value;
	}

	public function isUser(): bool
	{
		return $this->value === self::USER->value;
	}
}