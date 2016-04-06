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

/**
 * flash a url
 * @param  string $url [description]
 * @return void
 */
function flashURL($url)
{
	App\Services\Session::set('flash_url', $url);
}

/**
 * Redirect to a flashed url if it exists
 * @return boolean|void
 */
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

/**
 * Redirects
 * @param  string $to
 * @return void
 */
function redirect($to)
{
	header('Location: ' . $to);
}

/**
 * Turn a string into a slug
 * @param  string $text
 * @return string
 */
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

/**
 * A bunch of checks for the order process that are used on multiple routes
 * @param  array $listing
 * @param  array $user
 * @return void
 */
function orderChecks($listing, $user)
{
	if (!$listing)
	{
		throw new Phroute\Phroute\Exception\HttpRouteNotFoundException('404', 1);
	}

	if ($user['credit'] < $listing['price'])
	{
		flash("You don't have enough credit on your account to buy this item.");
		redirect("/listings/" . $listing['slug']);
		die();
	}

	if ($user['id'] == $listing['user_id'])
	{
		flash("You cannot purchase your own item.");
		redirect("/listings/" . $listing['slug']);
		die();
	}

	if(count($listing['order']) == 6 && $listing['order']['status'] != 'cancelled' )
	{
		flash("This item is not available to order at this time.");
		redirect("/listings/" . $listing['slug']);
		die();
	}
}
