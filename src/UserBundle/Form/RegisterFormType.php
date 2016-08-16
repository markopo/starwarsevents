<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterFormType extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text', array('required' => true,
            'label' => 'Användarnamn',
            'attr' => array('class' => 'username')))
            ->add('email', 'text', array('required' => true,
            'label' => 'Epost address',
            'attr' => array('class' => 'email')))
            ->add('plainPassword', 'repeated', array('type' => 'password',
                'required' => true,
                'label' => 'Lösenord',
                'attr' => array('class' => 'password')));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
       $resolver->setDefaults(array('data_class' => 'UserBundle\Entity\User'));
    }

    public function getName() {
        return 'user_register';
    }

}