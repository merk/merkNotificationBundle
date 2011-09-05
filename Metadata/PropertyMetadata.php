<?php
namespace merk\NotificationBundle\Metadata;

use Metadata\PropertyMetadata as BasePropertyMetadata;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class PropertyMetadata extends BasePropertyMetadata
{
    public $author;
    public $object;
    public $target;
    public $trigger;
    public $verb;
    
}
