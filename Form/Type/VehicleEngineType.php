<?php

namespace Craue\FormFlowDemoBundle\Form\Type;

use Craue\FormFlowDemoBundle\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2013-2018 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class VehicleEngineType extends AbstractType {

	/**
	 * @var TranslatorInterface
	 */
	protected $translator;

	public function setTranslator(TranslatorInterface $translator) {
		$this->translator = $translator;
	}

	/**
	 * {@inheritDoc}
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$useChoicesAsValues = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix'); // Symfony's Form component >=2.8
		$setChoicesAsValuesOption = $useChoicesAsValues && method_exists('Symfony\Component\Form\AbstractType', 'getName'); // Symfony's Form component >=2.8 && <3.0

		$defaultOptions = array(
			'placeholder' => '',
		);

		if ($setChoicesAsValuesOption) {
			$defaultOptions['choices_as_values'] = true;
		}

		$translator = $this->translator;
		$defaultOptions['choices'] = function(Options $options) use ($translator, $useChoicesAsValues) {
			$choices = array();

			foreach (Vehicle::getValidEngines() as $value) {
				$label = $translator->trans($value, array(), 'vehicleEngines');
				$choices[$useChoicesAsValues ? $label : $value] = $useChoicesAsValues ? $value : $label;
			}

			if ($useChoicesAsValues) {
				ksort($choices);
			} else {
				asort($choices);
			}

			return $choices;
		};

		$resolver->setDefaults($defaultOptions);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getParent() {
		$useFqcn = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix'); // Symfony's Form component >=2.8

		return $useFqcn ? 'Symfony\Component\Form\Extension\Core\Type\ChoiceType' : 'choice';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return $this->getBlockPrefix();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getBlockPrefix() {
		return 'form_type_vehicleEngine';
	}

}
