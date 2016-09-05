<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterFormType extends AbstractType {

    private $required;

    public function __construct($required = true){
        $this->required = $required;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text', array('required' => $this->required,
            'label' => 'Användarnamn',
            'attr' => array('class' => 'username')))
            ->add('email', 'text', array('required' => $this->required,
            'label' => 'Epost address',
            'attr' => array('class' => 'email')))
            ->add('plainPassword', 'repeated', array('type' => 'password',
                'required' => $this->required,
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

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view['email']->vars['help'] = 'Hint: It will have an @ symbol!';
    }
}