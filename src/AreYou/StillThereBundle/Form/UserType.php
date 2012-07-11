<?php

namespace AreYou\StillThereBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('email', 'email', [
                'label' => 'Email',
            ])
            ->add('noHeartbeatTimeLimit', 'integer', [
                'attr' => [
                    'min' => 0,
                ],
            ])
            ->add('beaconActivated', 'checkbox', [
                'required' => false,
                'label'    => 'Activate my beacon',
            ]);
    }

    public function getName()
    {
        return 'areyoustillthere_heartbeat';
    }
}

