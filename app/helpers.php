<?php

/**
 * Simple helper functions
 */

function dd($thing = '')
{
	print_r($thing);
	die();
}

function flashMessage($type = 'info')
{
	if($message = App\Services\Session::get('flash_message'))
	{
		echo '<div class="alert alert-dismissible alert-'. $type .'" role="alert">';

		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>';

		echo '<p>' . $message . '</p>';

		echo '</div>';

		App\Services\Session::destroy('flash_message');
	}
}

function flash($message)
{
	App\Services\Session::set('flash_message', $message);
}

function redirect($to)
{
	header('Location: ' . $to);
}
