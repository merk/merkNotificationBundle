<?php

namespace merk\NotificationBundle\Annotation;

/**
 * @Annotation
 * @author Richard Shank <develop@zestic.com>
 */
final class Notify
{
    public $actor;
    public $object;
    public $target;
    public $trigger;
    public $verb;

    public function __construct(array $values)
    {
        if (!isset($values['object'])) {
            throw new \InvalidArgumentException('You must define a "object" attribute for each Notify annotation.');
        }
        if (!isset($values['trigger'])) {
            throw new \InvalidArgumentException('You must define a "trigger" attribute for each Notify annotation.');
        }
        if (!isset($values['verb'])) {
            throw new \InvalidArgumentException('You must define a "verb" attribute for each Notify annotation.');
        }

        $this->object = $values['object'];
        $this->trigger = $values['trigger'];
        $this->verb = $values['verb'];

        if (isset($values['actor'])) {
            $this->actor = $values['actor'];
        }

        if (isset($values['target'])) {
            $this->target = $values['target'];
        }
    }
}