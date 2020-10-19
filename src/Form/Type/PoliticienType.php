<?php
	namespace App\Form\Type;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\IntegerType;
	use Symfony\Bridge\Doctrine\Form\Type\EntityType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	use App\Entity\Politicien;
	use App\Entity\Parti;
	use App\Entity\Mairie;
	use App\Repository\PartiRepository;
	use App\Repository\MairieRepository;

	class PoliticienType extends AbstractType {
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder->add('nom', TextType::class)
			->add('sexe', TextType::class)
			->add('age', IntegerType::class)
			->add('parti', EntityType::class,
			 array('class' => Parti::class,
			 	'query_builder' => function (PartiRepository $repo) {
			 		return $repo->createQueryBuilder('p')
			 			->orderBy('p.nom'); }
 			))
 			->add('mairie', EntityType::class,
			 array('class' => Mairie::class,
			 	'query_builder' => function (MairieRepository $repo) {
			 		return $repo->createQueryBuilder('m')
			 			->orderBy('m.ville'); }
 			));
		}

		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults(array( 'data_class' => Politicien::class,));
		}
	}