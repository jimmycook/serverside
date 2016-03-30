<?php

/**
 * Simple helper functions
 */

function dd($thing = '')
{
	print_r($thing);
	die();
}

function check()
{
	return App\Services\Auth::check();
}

function user()
{

	return \App\Services\Auth::user();
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

function flashURL($url)
{
	App\Services\Session::set('flash_url', $url);
}

function goToFlashUrl()
{
	if ($url = App\Services\Session::get('flash_url'))
	{
		App\Services\Session::destroy('flash_url');
		header('Location: ' . $url);
		die();
	}
	else
	{
		return false;
	}
}

function redirect($to)
{
	header('Location: ' . $to);
}

function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}
