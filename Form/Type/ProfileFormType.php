<?php

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->remove('username')
                ->remove('current_password')
                ->add('captcha', 'captcha', array(
                    'required' => false
                ))
                ->add('first_name', 'text', array(
                    'required' => false,
                ))
                ->add('last_name', 'text', array(
                    'required' => false,
                ))
                ->add('phone_number', 'number', array(
                    'label' => 'form.phone',
                    'required' => false,
                    'translation_domain' => 'FOSUserBundle',
                ))
            ;
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'app_user_profile';
    }
}
