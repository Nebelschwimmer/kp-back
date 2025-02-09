<?php

namespace App\Exception\NotFound;

class GenreNotFoundException extends \RuntimeException
{
	public function __construct()
	{
		parent::__construct('Genre not found');
	}
}