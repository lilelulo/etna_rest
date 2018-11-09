<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken as BasePreAuthenticatedToken;

class PreAuthenticatedToken extends BasePreAuthenticatedToken
{
	public function getResourceOwnerName()
	{
		return 'PreAuthenticatedToken';
	}
}
