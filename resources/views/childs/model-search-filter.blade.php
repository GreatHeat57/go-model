 <!-- filter start -->
<form role="form" action="{{ lurl('model-list') }}" method="GET">
    {!! csrf_field() !!}

<div class="row bg-white box-shadow filter-area py-30 px-38 mb-40 mx-0">

    <!-- Last Activity -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Last Activity') }}</span>
        <div class="divider"></div>
        @if (isset($dates) and !empty($dates))
        @foreach($dates as $key => $value)
        {{ Form::radio('lastActivity', $key, null, ['class' => 'radio_field', 'id' => 'model_'.$key]) }}
        {{ Form::label('model_'.$key,  $value, ['class' => 'radio-label']) }}
        @endforeach
        @endif
    </div>

    <!-- Eye color -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Eye color') }}</span>
        <div class="divider"></div>
        @if (isset($eyeColors) and !empty($eyeColors))
        @foreach($eyeColors as $key => $eyeColor)
        {{ Form::radio('eyeColor', $key, null, ['class' => 'radio_field', 'id' => 'eyeColor_'.$key]) }}
        {{ Form::label('eyeColor_'.$key,  $eyeColor, ['class' => 'radio-label']) }}
        @endforeach
        @endif
    </div>

    <!-- Gender -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Gender') }}</span>
        <div class="divider"></div>
        {{ Form::radio('gender_id', 0, null, ['class' => 'radio_field', 'id' => t('Male')]) }}
        {{ Form::label(t('Male'),  t('Male') , ['class' => 'radio-label']) }}

        {{ Form::radio('gender_id', 1, null, ['class' => 'radio_field', 'id' => t('Female')]) }}
        {{ Form::label(t('Female'),   t('Female') , ['class' => 'radio-label']) }}
    </div>

    <!-- Skin Color -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Skin color') }}</span>
        <div class="divider"></div>
        @if (isset($skinColors) and !empty($skinColors))
        @foreach($skinColors as $key => $skinColor)
        {{ Form::radio('skinColor', $key, null, ['class' => 'radio_field', 'id' => 'skinColor_'.$key]) }}
        {{ Form::label('skinColor_'.$key,  $skinColor, ['class' => 'radio-label']) }}
        @endforeach
        @endif
    </div>

    <!-- Hair Color -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Hair color') }}</span>
        <div class="divider"></div>
        @if (isset($hairColors) and !empty($hairColors))
        @foreach($hairColors as $key => $hairColor)
        {{ Form::radio('hairColor', $key, null, ['class' => 'radio_field', 'id' => 'hairColor_'.$key]) }}
        {{ Form::label('hairColor_'.$key,  $hairColor, ['class' => 'radio-label']) }}
        @endforeach
        @endif
    </div>

    <!-- Height -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Height') }}</span>
        <div class="divider"></div>
        <div class="d-flex col-md-12 col-xl-12">
            <select name="minHeight" id="minHeight" class="form-control" >
                <option value=""></option>
                @foreach($properties['height'] as $key => $height)
                <option value="{{ $key }}"> {{ $height }} </option>
                @endforeach
            </select>
            <span class="mx-20"> - </span>
            <select name="maxHeight" id="maxHeight" class="form-control" >
                <option value=""></option>
                @foreach($properties['height'] as $key => $height)
                <option value="{{ $key }}"> {{ $height }} </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Weight -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Weight') }}</span>
        <div class="divider"></div>
        <div class="d-flex col-md-12 col-xl-12">
            <select name="minWeight" id="minWeight" class="form-control" >
                <option value=""></option>
                @foreach($properties['weight'] as $key => $weight)
                <option value="{{ $key }}"> {{ $weight }} </option>
                @endforeach
            </select>
            <span class="mx-20"> - </span>
            <select name="maxWeight" id="maxWeight" class="form-control" >
                <option value=""></option>
                @foreach($properties['weight'] as $key => $weight)
                <option value="{{ $key }}"> {{ $weight }} </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Chest -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Chest') }}</span>
        <div class="divider"></div>
        <div class="d-flex col-md-12 col-xl-12">
            <select name="minChest" id="minChest" class="form-control" >
                <option value=""></option>
                @for($i = 50; $i < 151; $i++)
                <option value="{{ $i }}"> {{ $i }} </option>
                @endfor
            </select>
            <span class="mx-20"> - </span>
            <select name="maxChest" id="maxChest" class="form-control" >
                <option value=""></option>
                @for($i = 50; $i < 151; $i++)
                <option value="{{ $i }}"> {{ $i }} </option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Waist -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Waist') }}</span>
        <div class="divider"></div>
        <div class="d-flex col-md-12 col-xl-12">
            <select name="minWaist" id="minWaist" class="form-control" >
                <option value=""></option>
                @for($i = 50; $i < 151; $i++)
                <option value="{{ $i }}"> {{ $i }} </option>
                @endfor
            </select>
            <span class="mx-20"> - </span>
            <select name="maxWaist" id="maxWaist" class="form-control" >
                <option value=""></option>
                @for($i = 50; $i < 151; $i++)
                <option value="{{ $i }}"> {{ $i }} </option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Hips -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Hips') }}</span>
        <div class="divider"></div>
        <div class="d-flex col-md-12 col-xl-12">
            <select name="minHips" id="minHips" class="form-control" >
                <option value=""></option>
                @for($i = 60; $i < 151; $i++)
                <option value="{{ $i }}"> {{ $i }} </option>
                @endfor
            </select>
            <span class="mx-20"> - </span>
            <select name="maxHips" id="maxHips" class="form-control" >
                <option value=""></option>
                @for($i = 60; $i < 151; $i++)
                <option value="{{ $i }}"> {{ $i }} </option>
                @endfor
            </select>
        </div>
    </div>


    <!-- Dress size -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Dress size') }}</span>
        <div class="divider"></div>
        <div class="d-flex col-md-12 col-xl-12">
            <select name="minDressSize" id="minDressSize" class="form-control" >
                <option value=""></option>
                @foreach($properties['dress_size'] as $key => $dressSize)
                <option value="{{ $key }}"> {{ $dressSize }} </option>
                @endforeach
            </select>
            <span class="mx-20"> - </span>
            <select name="maxDressSize" id="maxDressSize" class="form-control" >
                <option value=""></option>
                @foreach($properties['dress_size'] as $key => $dressSize)
                <option value="{{ $key }}"> {{ $dressSize }} </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Shoe size -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Shoe size') }}</span>
        <div class="divider"></div>
        <div class="d-flex col-md-12 col-xl-12">
            <select name="minShoeSize" id="minShoeSize" class="form-control" >
                <option value=""></option>
                @foreach($properties['shoe_size'] as $key => $shoeSize)
                <option value="{{ $key }}"> {{ $shoeSize }} </option>
                @endforeach
            </select>
            <span class="mx-20"> - </span>
            <select name="maxShoeSize" id="maxShoeSize" class="form-control" >
                <option value=""></option>
                @foreach($properties['shoe_size'] as $key => $shoeSize)
                <option value="{{ $key }}"> {{ $shoeSize }} </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Age -->
    <div class="col-md-12 form-group custom-radio bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
        <span class="title">{{ t('Age') }}</span>
        <div class="divider"></div>
        <div class="d-flex col-md-12 col-xl-12">
            <select name="minAge" id="minAge" class="form-control" >
                <option value=""></option>
                @for($i = 1; $i < 101; $i++)
                <option value="{{ $i }}"> {{ $i }} </option>
                @endfor
            </select>
            <span class="mx-20"> - </span>
            <select name="maxAge" id="maxAge" class="form-control" >
                <option value=""></option>
                @for($i = 1; $i < 101; $i++)
                <option value="{{ $i }}"> {{ $i }} </option>
                @endfor
            </select>
        </div>
    </div>


    <div class="mb-30 text-center">
        <button type="submit" class="btn btn-white search">{{ t('Search') }}</button>
    </div>

</div>
</form>
<!-- filter end --> 