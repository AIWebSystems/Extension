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
        'manager_class',
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
        return form_input('manager_class', $value);
    }

    /**
     * Form input
     *
     * @return array
     */
    public function formInput()
    {
        $managerClass = $this->getParameter('manager_class');
        $managerClass = new $managerClass;

        $managerClass::init($this->getParameter('module'), $this->getParameter('extension_type'));

        $extensions = $managerClass::getAllExtensions();

        $options = array();

        foreach ($extensions as $extension) {
            $options[$extension->slug] = $extension->name;
        }

        return form_dropdown($this->formSlug, $options, $this->value);
    }

    /**
     * Filter input
     *
     * @return array
     */
    public function filterInput()
    {
        $managerClass = $this->getParameter('manager_class');
        $managerClass = new $managerClass;

        $managerClass::init($this->getParameter('module'), $this->getParameter('extension_type'));

        $extensions = $managerClass::getAllExtensions();

        $options = array(null => $this->getParameter('placeholder', $this->getField()->field_name));

        foreach ($extensions as $extension) {
            $options[$extension->slug] = $extension->name;
        }

        return form_dropdown($this->getFilterSlug('is'), $options, $this->getFilterValue('is'));
    }
}
