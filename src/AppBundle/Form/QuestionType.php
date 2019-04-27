<?php
namespace AppBundle\Form;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class QuestionType extends AbstractType
{

     public function buildForm(FormBuilderInterface $builder, array $options)
     {

         $builder
         ->add('name', TextType::class, array(
            'label' => 'Nume intrebare',
         ));

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event)  {
                $form = $event->getForm();

                $formOptions = array(
                        'class' => 'AppBundle\Entity\Survey',
                        'choice_label' => 'name',
                        'label' => 'Survey',
                        'query_builder' => function (EntityRepository $er) {
                                return $query = $er->createQueryBuilder('e')
                                    // ->join('e.subscription_service', 'sub')
                                    // ->where('sub.location = :id')
                                    // ->setParameter('id', $user->getLocation()->getId())
                                            ;
                        },
                        'placeholder' => 'Alege survey',
                );
                $form->add('survey', EntityType::class, $formOptions);
            }
        );
        
       
     }

     public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Question::class,
        ));
    }

     public function getName()
     {
        return 'question';
     }
}
?>