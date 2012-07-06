<?php

namespace AreYou\StillThereBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class HeartbeatType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('message', 'text', [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Your message',
                    'class' => 'input-xlarge',
                ],
            ]);
    }

    public function getName()
    {
        return 'areyoustillthere_heartbeat';
    }
}

