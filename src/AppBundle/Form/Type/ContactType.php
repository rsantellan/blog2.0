<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Description of ContactType
 *
 * @author Rodrigo Santellan
 */
class ContactType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'contact.form.name.placeholder',
                    'pattern'     => '.{2,}' //minlength
                ),
                'label' => 'contact.form.name'
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'contact.form.email.placeholder'
                ),
                'label' => 'contact.form.email'
            ))
            ->add('subject', 'text', array(
                'attr' => array(
                    'placeholder' => 'contact.form.subject.placeholder',
                    'pattern'     => '.{3,}' //minlength
                ),
                'label' => 'contact.form.subject'
            ))
            ->add('message', 'textarea', array(
                'attr' => array(
                    'cols' => 90,
                    'rows' => 10,
                    'placeholder' => 'contact.form.message.placeholder'
                ),
                'label' => 'contact.form.message'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $collectionConstraint = new Collection(array(
            'name' => array(
                new NotBlank(array('message' => 'Name should not be blank.')),
                new Length(array('min' => 2))
            ),
            'email' => array(
                new NotBlank(array('message' => 'Email should not be blank.')),
                new Email(array('message' => 'Invalid email address.'))
            ),
            'subject' => array(
                new NotBlank(array('message' => 'Subject should not be blank.')),
                new Length(array('min' => 3))
            ),
            'message' => array(
                new NotBlank(array('message' => 'Message should not be blank.')),
                new Length(array('min' => 5))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'sitiobundle_contacttype';
    }
    
}


