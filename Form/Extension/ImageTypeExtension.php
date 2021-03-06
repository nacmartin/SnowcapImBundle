<?php

/*
 * This file is part of the Snowcap ImBundle package.
 *
 * (c) Snowcap <shoot@snowcap.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Snowcap\ImBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Snowcap\ImBundle\Manager;

/**
 * Form type to show a preview of the image
 */
class ImageTypeExtension extends AbstractTypeExtension
{
    /**
     * @var Manager
     */
    protected $imManager;

    /**
     * @param Manager $imManager
     */
    public function __construct($imManager)
    {
        $this->imManager = $imManager;
    }

    /**
     * @return string
     */
    public function getExtendedType()
    {
        return 'snowcap_core_image';
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'format' => null,
        );
    }

    /**
     * @param \Symfony\Component\Form\FormBuilder $builder
     * @param array                               $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setAttribute('format', $options['format']);
    }

    /**
     * @param \Symfony\Component\Form\FormView      $view
     * @param \Symfony\Component\Form\FormInterface $form
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        $format = $form->getAttribute('format');
        $imageSrc = $view->get('image_src');
        if ($imageSrc !== null && $format !== null) {
            $view->set('image_src', $this->imManager->getUrl($format, $imageSrc));
        }
    }
}
