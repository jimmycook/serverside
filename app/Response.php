<?php

namespace App;

class Response
{



	protected $body;

	public function writeBody($body){
		$this->body = $body;
	}
}
