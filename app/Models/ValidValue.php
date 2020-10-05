<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class ValidValue extends Model {
	use Translatable;

	public $translatedAttributes = [ 'value' ];
	protected $fillable = [ 'key', 'type' ];

	public function getTransValue( string $lang ) {
		if ( $this->hasTranslation( $lang ) ) {
			return $this->translate( $lang )->value;
		}

		return null;
	}

	public static function getAllTransValues() {
		$properties = [
			EN => [
				PROPERTY_TYPE_CATEGORY   => [],
				PROPERTY_TYPE_COUNTRY    => [],
				PROPERTY_TYPE_HEIGHT     => [],
				PROPERTY_TYPE_MASS       => [],
				PROPERTY_TYPE_DRESS_SIZE => [],
				PROPERTY_TYPE_SHOE_SIZE  => [],
				PROPERTY_TYPE_EYE_COLOR  => [],
				PROPERTY_TYPE_HAIR_COLOR => [],
				PROPERTY_TYPE_SKIN_COLOR => []
			],
			DE => [
				PROPERTY_TYPE_CATEGORY   => [],
				PROPERTY_TYPE_COUNTRY    => [],
				PROPERTY_TYPE_HEIGHT     => [],
				PROPERTY_TYPE_MASS       => [],
				PROPERTY_TYPE_DRESS_SIZE => [],
				PROPERTY_TYPE_SHOE_SIZE  => [],
				PROPERTY_TYPE_EYE_COLOR  => [],
				PROPERTY_TYPE_HAIR_COLOR => [],
				PROPERTY_TYPE_SKIN_COLOR => []
			]
		];
		$validValues = ValidValue::all();
		foreach ( $validValues as $validValue ) {
			$properties[EN][$validValue->type][$validValue->id] = $validValue->getTransValue(EN);
			$properties[DE][$validValue->type][$validValue->id] = $validValue->getTransValue(DE);
		}

		return $properties;
	}
}
