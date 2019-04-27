<?php
namespace AppBundle\Form;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AnswerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('question')->add('score');
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event)  {
                $form = $event->getForm();

                $formOptions = array(
                        'class' => 'AppBundle\Entity\Question',
                        'choice_label' => 'name',
                        'label' => 'Intrebare',
                        'query_builder' => function (EntityRepository $er) {
                                return $query = $er->createQueryBuilder('e')
                                    // ->join('e.subscription_service', 'sub')
                                    // ->where('sub.location = :id')
                                    // ->setParameter('id', $user->getLocation()->getId())
                                            ;
                        },
                        'placeholder' => 'Alege intrebare',
                );
                $form->add('question', EntityType::class, $formOptions);
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Answer::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_answer';
    }


}
