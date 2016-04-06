<?php

namespace App\Services;

use App\Services\Request;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;


class Paginator
{
    protected $page;

    protected $length;

    protected $array;

    /**
     * Set up the paginator
     * @param array $array
     * @param integer $length
     */
    public function __construct($array = [], $length = 16)
    {
        $this->init();
        $this->length = $length;
        $this->array = array_chunk($array, $length);
    }

    public function init()
    {
        $request = new Request;
        $this->page = $request->get('page');
        if ($this->page < 1)
        {
            $this->page = 1;
        }
        $this->page --;
    }

    public function getPageArray()
    {
        if ($this->page > $this->getNumPages() - 1)
        {
            throw new HttpRouteNotFoundException('404', 1);
        }
        return $this->array[$this->page];
    }

    public function getNumPages()
    {
        return count($this->array);
    }

    public function getPage()
    {
        return $this->page + 1;
    }

}
