<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

class Extension extends FieldTypeAbstract
{
    /**
     * Field type slug
     *
     * @var string
     */
    public $field_type_slug = 'extension';

    /**
     * DB col type
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
     * Initialized
     *
     * @var array
     */
    protected $initialized = array();

    /**
     * Form input
     *
     * @return array
     */
    public function formInput()
    {
        return form_dropdown($this->formSlug, $this->getOptions(), $this->value);
    }

    /**
     * Filter input
     *
     * @return array
     */
    public function filterInput()
    {
        $options = $this->getOptions();

        if ($placeholder = $this->getParameter('filter_placeholder')) {
            $options = array('-----' => $placeholder) + $options;
        }

        return form_dropdown($this->getFilterSlug('is'), $options, $this->getFilterValue('is'));
    }

    /**
     * Data output
     *
     * @return mixed
     */
    public function dataOutput()
    {
        $managerClass = $this->getManagerClass();

        if ($this->value and $extension = $managerClass::getExtension($this->value)) {
            return $extension;
        }

        return null;
    }

    /**
     * Get options
     *
     * @return array
     */
    protected function getOptions()
    {
        $managerClass = $this->getManagerClass();

        $extensions = $managerClass::getAllExtensions();

        $options = array();

        foreach ($extensions as $extension) {
            $options[$extension->slug] = $extension->name;
        }

        return $options;
    }

    /**
     * Get manager class
     *
     * @return object
     */
    protected function getManagerClass()
    {
        $managerClass = $this->getParameter('manager_class');
        $managerClass = new $managerClass;

        $managerClass::init($this->getParameter('module'), $this->getParameter('extension_type'), true);

        return $managerClass;
    }
}
