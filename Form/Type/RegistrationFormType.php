<?php

namespace UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as FOSRegistrationFormType;

class RegistrationFormType extends FOSRegistrationFormType
{
    public function __construct()
    {
        parent::__construct('\UserBundle\Entity\User');
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('email', 'email', array('required' => false))
                ->add('first_name', 'text', array(
                    'required' => false,
                ))
                ->add('last_name', 'text', array(
                    'required' => false,
                ))
                ->remove('username')
                ->add('phone_number', 'number', array(
                    'label' => 'form.phone',
                    'required' => false,
                    'translation_domain' => 'FOSUserBundle',
                ));
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}
