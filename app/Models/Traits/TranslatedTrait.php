<?php
/**
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Models\Traits;

trait TranslatedTrait {
	/*
		    |--------------------------------------------------------------------------
		    | FUNCTIONS
		    |--------------------------------------------------------------------------
	*/
	public static function transById($id, $locale = '') {
		if (empty($locale) || $locale == '') {
			$locale = config('app.locale');
		}

		$entry = static::where('translation_of', $id)->where('translation_lang', $locale)->first();

		if (empty($entry)) {
			$entry = static::find($id);
		}

		return $entry;
	}

	/*
		    |--------------------------------------------------------------------------
		    | RELATIONS
		    |--------------------------------------------------------------------------
	*/
	public function translated() {
		return $this->hasMany(get_called_class(), 'translation_of');
	}

	/*
		    |--------------------------------------------------------------------------
		    | SCOPES
		    |--------------------------------------------------------------------------
	*/
	public function scopeTrans($builder) {
		return $builder->where('translation_lang', config('app.locale'));
	}

	public function scopeTransIn($builder, $languageCode) {
		return $builder->where('translation_lang', $languageCode);
	}

	/*
		    |--------------------------------------------------------------------------
		    | ACCESORS
		    |--------------------------------------------------------------------------
	*/
	public function getTranslationOfAttribute() {
		$translationOf = (isset($this->attributes['translation_of'])) ? $this->attributes['translation_of'] : null;
		$entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : $translationOf;

		if (!empty($translationOf)) {
			if ($this->attributes['translation_lang'] == config('appLang.abbr')) {
				return $entityId;
			} else {
				return $translationOf;
			}
		} else {
			return $entityId;
		}
	}

	public function getTidAttribute() {
		$translationOf = (isset($this->attributes['translation_of'])) ? $this->attributes['translation_of'] : 0;
		$entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : $translationOf;

		if (!empty($translationOf)) {
			if ($this->attributes['translation_lang'] == config('appLang.abbr')) {
				return $entityId;
			} else {
				return $translationOf;
			}
		} else {
			return $entityId;
		}
	}

	/*
		    |--------------------------------------------------------------------------
		    | MUTATORS
		    |--------------------------------------------------------------------------
	*/
	public function setTranslationOfAttribute($value) {
		$entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : null;

		if (empty($value)) {
			if ($this->attributes['translation_lang'] == config('appLang.abbr')) {
				$this->attributes['translation_of'] = $entityId;
			} else {
				$this->attributes['translation_of'] = $value;
			}
		} else {
			$this->attributes['translation_of'] = $value;
		}
	}
}
