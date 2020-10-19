<?php
	namespace App\Form\Type;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Bridge\Doctrine\Form\Type\EntityType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use App\Entity\Politicien;
	use App\Entity\Affaire;

	class AffaireType extends AbstractType {
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder->add('designation', TextType::class)
			->add('lesPoliticiens', EntityType::class, [
                'class' => Politicien::class,
                'multiple' => true,
                'expanded' => true,
            ]);
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array( 'data_class' => Affaire::class,));
		}
	}