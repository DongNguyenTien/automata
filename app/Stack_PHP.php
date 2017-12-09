<?php
/**
 * Created by PhpStorm.
 * User: ngothihai
 * Date: 12/8/17
 * Time: 12:41
 */

namespace App;



use Illuminate\Contracts\Queue\QueueableCollection;
use Illuminate\Contracts\Support\Arrayable;

class Stack_PHP extends \SplDoublyLinkedList implements \Iterator, Arrayable, \Countable
{

}