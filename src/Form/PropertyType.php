<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => $this->translator->trans('property.title')
            ])
            ->add('description')
            ->add('surface')
            ->add('rooms', null, [
              'label' => $this->translator->trans('property.rooms')
            ])
            ->add('bedrooms', null, [
              'label' => $this->translator->trans('property.bedrooms')
            ])
            ->add('floor', null, [
              'label' => $this->translator->trans('property.floor')
            ])
            ->add('price', null, [
              'label' => $this->translator->trans('property.price')
            ])
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoicesHeat(),
                'label' => $this->translator->trans('property.heat')
            ])
            ->add('city', null, [
                'label' => $this->translator->trans('property.city')
            ])
            ->add('address', null, [
              'label' => $this->translator->trans('property.address')  
            ])
            ->add('postal_code', null, [
              'label' => $this->translator->trans('property.postal_code')
            ])
            ->add('sold', null, [
              'label' => $this->translator->trans('property.sold')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'form'
        ]);
    }

    public function getChoicesHeat()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach ($choices as $k => $choice) {
            $output[$choice] = $k; 
        }

        return $output;
    }
}
