<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * Extension Field Type
 *
 * @author      Ryan Thompson - AI Web Systems, Inc.
 * @copyright   Copyright (c) 2008 - 2014, AI Web Systems, Inc.
 * @link        http://www.aiwebsystems.com/
 */
class Extension extends FieldTypeAbstract
{
    /**
     * Field type slug
     *
     * @var string
     */
    public $field_type_slug = 'extension';

    /**
     * Database column type
     *
     * @var bool
     */
    public $db_col_type = 'string';

    /**
     * Version
     *
     * @var string
     */
    public $version = '1.1';

    /**
     * Custom parameters
     *
     * @var array
     */
    public $custom_parameters = array(
        'manager',
    );

    /**
     * Author
     *
     * @var array
     */
    public $author = array(
        'name' => 'Ryan Thompson - AI Web Systems, Inc.',
        'url'  => 'http://www.aiwebsystems.com/'
    );

    /**
     * Manager
     *
     * @return string
     */
    public function paramManager($value = null)
    {
        return form_input('manager', $value);
    }

    /**
     * Form input
     *
     * @return array
     */
    public function formInput()
    {
        $manager = $this->getParameter('manager');

        $manager = new $manager;

        $manager::init('payments', 'gateway');
        $extensions = $manager::getAllExtensions();

        $options = array();

        foreach ($extensions as $extension) {
            $options[$extension->slug] = $extension->name;
        }

        return form_dropdown($this->formSlug, $options, $this->value);
    }
}
