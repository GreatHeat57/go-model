<?php

use Illuminate\Database\Seeder;

class ValidValueSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$id         = 1;
		$categories = [
			[ EN => "Baby Model", DE => "Baby Modell" ],
			[ EN => "Model Kids", DE => "Modell Kids" ],
			[ EN => "Models", DE => "Models" ],
			[ EN => "Fitness Model", DE => "Fitness Modell" ],
			[ EN => "Plus size Model", DE => "Plus size Modell" ],
			[ EN => "50 Plus Model", DE => "50 Plus Modell" ]
		];

		$country = [
			[ EN => "Germany", DE => "Deutschland" ],
			[ EN => "Liechtenstein", DE => "Liechtenstein" ],
			[ EN => "Austria", DE => "Österreich" ],
			[ EN => "Switzerland", DE => "Schweiz" ]
		];

		$height = [];
		for ( $val = 48; $val <= 215; ++ $val ) {
			$height[] = [ EN => $val . " CM", DE => $val . " CM" ];
		}

		$mass = [];
		for ( $val = 5; $val <= 115; ++ $val ) {
			$mass[] = [ EN => $val . " KG", DE => $val . " KG" ];
		}

		$dress_size = [];
		for ( $val = 32; $val <= 164; $val = $val + 2 ) {
			$dress_size[] = [ EN => $val . " EU", DE => $val . " EU" ];
		}

		$shoe_size = [];
		for ( $val = 15; $val <= 52; $val ++ ) {
			$shoe_size[] = [ EN => $val, DE => $val ];
		}

		$eye_color = [
			[ EN => "Blue", DE => "Blau" ],
			[ EN => "Blue-Green", DE => "Blau-Grün" ],
			[ EN => "Brown", DE => "Braun" ],
			[ EN => "Dark blue", DE => "Dunkelblau" ],
			[ EN => "Dark brown", DE => "Dunkelbraun" ],
			[ EN => "Grey", DE => "Grau" ],
			[ EN => "Green", DE => "Grün" ],
			[ EN => "Light blue", DE => "Hellblau" ],
			[ EN => "Light brown", DE => "Hellbraun" ],
			[ EN => "Black", DE => "Schwarz" ],
		];

		$hair_color = [
			[ EN => "blond", DE => "Blond" ],
			[ EN => "brown", DE => "Braun" ],
			[ EN => "dark-blond", DE => "Dunkelblond" ],
			[ EN => "dark-brown", DE => "Dunkelbraun" ],
			[ EN => "grey", DE => "Grau" ],
			[ EN => "salt-and-pepper", DE => "Grau meliert" ],
			[ EN => "light-blond", DE => "Hellblond" ],
			[ EN => "light-brown", DE => "Hellbraun" ],
			[ EN => "red", DE => "Rot" ],
			[ EN => "black", DE => "Schwarz" ],
			[ EN => "white", DE => "Weiß" ],
			[ EN => "others", DE => "andere" ],
		];

		$skin_color = [
			[ EN => "brown-skin", DE => "bräunliche Haut" ],
			[ EN => "dark-skin", DE => "Dunkelhäutig" ],
			[ EN => "light-skin", DE => "Hellhäutig" ]
		];

		// Insert categories and its translations
		foreach ( $categories as $property ) {
			DB::table( 'valid_values' )->insert( [
				'id'   => $id,
				'key'  => 'name',
				'type' => PROPERTY_TYPE_CATEGORY
			] );

			foreach ( $property as $local => $value ) {
				DB::table( 'valid_value_translations' )->insert( [
					'valid_value_id' => $id,
					'locale'         => $local,
					'value'          => $value
				] );
			}

			$id ++;
		};

		// Insert country and its translations
		foreach ( $country as $property ) {
			DB::table( 'valid_values' )->insert( [
				'id'   => $id,
				'key'  => 'name',
				'type' => PROPERTY_TYPE_COUNTRY
			] );

			foreach ( $property as $local => $value ) {
				DB::table( 'valid_value_translations' )->insert( [
					'valid_value_id' => $id,
					'locale'         => $local,
					'value'          => $value
				] );
			}

			$id ++;
		};

		// Insert height and its translations
		foreach ( $height as $property ) {
			DB::table( 'valid_values' )->insert( [
				'id'   => $id,
				'key'  => 'name',
				'type' => PROPERTY_TYPE_HEIGHT
			] );

			foreach ( $property as $local => $value ) {
				DB::table( 'valid_value_translations' )->insert( [
					'valid_value_id' => $id,
					'locale'         => $local,
					'value'          => $value
				] );
			}

			$id ++;
		};

		// Insert mass and its translations
		foreach ( $mass as $property ) {
			DB::table( 'valid_values' )->insert( [
				'id'   => $id,
				'key'  => 'name',
				'type' => PROPERTY_TYPE_MASS
			] );

			foreach ( $property as $local => $value ) {
				DB::table( 'valid_value_translations' )->insert( [
					'valid_value_id' => $id,
					'locale'         => $local,
					'value'          => $value
				] );
			}

			$id ++;
		};

		// Insert dress_size and its translations
		foreach ( $dress_size as $property ) {
			DB::table( 'valid_values' )->insert( [
				'id'   => $id,
				'key'  => 'name',
				'type' => PROPERTY_TYPE_DRESS_SIZE
			] );

			foreach ( $property as $local => $value ) {
				DB::table( 'valid_value_translations' )->insert( [
					'valid_value_id' => $id,
					'locale'         => $local,
					'value'          => $value
				] );
			}

			$id ++;
		};

		// Insert shoe_size and its translations
		foreach ( $shoe_size as $property ) {
			DB::table( 'valid_values' )->insert( [
				'id'   => $id,
				'key'  => 'name',
				'type' => PROPERTY_TYPE_SHOE_SIZE
			] );

			foreach ( $property as $local => $value ) {
				DB::table( 'valid_value_translations' )->insert( [
					'valid_value_id' => $id,
					'locale'         => $local,
					'value'          => $value
				] );
			}

			$id ++;
		};

		// Insert eye_color and its translations
		foreach ( $eye_color as $property ) {
			DB::table( 'valid_values' )->insert( [
				'id'   => $id,
				'key'  => 'name',
				'type' => PROPERTY_TYPE_EYE_COLOR
			] );

			foreach ( $property as $local => $value ) {
				DB::table( 'valid_value_translations' )->insert( [
					'valid_value_id' => $id,
					'locale'         => $local,
					'value'          => $value
				] );
			}

			$id ++;
		};

		// Insert hair_color and its translations
		foreach ( $hair_color as $property ) {
			DB::table( 'valid_values' )->insert( [
				'id'   => $id,
				'key'  => 'name',
				'type' => PROPERTY_TYPE_HAIR_COLOR
			] );

			foreach ( $property as $local => $value ) {
				DB::table( 'valid_value_translations' )->insert( [
					'valid_value_id' => $id,
					'locale'         => $local,
					'value'          => $value
				] );
			}

			$id ++;
		};

		// Insert skin_color and its translations
		foreach ( $skin_color as $property ) {
			DB::table( 'valid_values' )->insert( [
				'id'   => $id,
				'key'  => 'name',
				'type' => PROPERTY_TYPE_SKIN_COLOR
			] );

			foreach ( $property as $local => $value ) {
				DB::table( 'valid_value_translations' )->insert( [
					'valid_value_id' => $id,
					'locale'         => $local,
					'value'          => $value
				] );
			}

			$id ++;
		};
	}
}
