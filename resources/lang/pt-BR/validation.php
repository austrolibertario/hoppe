<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'A :attribute tem que ser válido.',
    'active_url'           => 'A :attribute tem que ser uma URL válida.',
    'after'                => 'A :attribute tem que ser uma data anterior a :date.',
    'alpha'                => 'A :attribute só pode conter letras.',
    'alpha_dash'           => 'A :attribute só pode conter letras, números e hifem.',
    'alpha_num'            => 'A :attribute só pode conter letras e números.',
    'array'                => 'A :attribute tem que ser um array.',
    'before'               => 'A :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'O :attribute tem que ser entre :min e :max.',
        'file'    => 'O :attribute tem que ser entre :min e :max kilobytes.',
        'string'  => 'O :attribute tem que ser entre :min e :max caracteres.',
        'array'   => 'O :attribute tem que ser entre :min e :max itens.',
    ],
    'boolean'              => 'o campo :attribute só pode ser verdadeiro ou falso.',
    'confirmed'            => 'A :attribute confirmação não é válida.',
    'date'                 => 'A :attribute não é uma data válida.',
    'date_format'          => 'A :attribute está fora do formato :format.',
    'different'            => 'A :attribute and :other must be different.',
    'digits'               => 'A :attribute must be :digits digits.',
    'digits_between'       => 'A :attribute tem que ser entre :min and :max digits.',
    'email'                => 'A :attribute tem que ser um endereço válido.',
    'filled'               => 'A :attribute é obrigatório.',
    'exists'               => 'O :attribute selecionado não é válido.',
    'image'                => 'A :attribute tem que ser uma imagem.',
    'in'                   => 'A :attribute selecionado é inválido.',
    'integer'              => 'A :attribute tem que ser um inteiro.',
    'ip'                   => 'A :attribute tem que ser um IP válido.',
    'max'                  => [
        'numeric' => 'O :attribute não pode ser maior que :max.',
        'file'    => 'O :attribute não pode ser maior que :max kilobytes.',
        'string'  => 'O :attribute não pode ser maior que :max characters.',
        'array'   => 'O :attribute não pode ter mais que :max itens.',
    ],
    'mimes'                => 'O :attribute tem que ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O :attribute precisa ser menor que :min.',
        'file'    => 'O :attribute precisa ser menor que :min kilobytes.',
        'string'  => 'O :attribute precisa ser menor que :min caracteres.',
        'array'   => 'O :attribute precisa ter menos que :min itens.',
    ],
    'not_in'               => 'O selected :attribute é inválido.',
    'numeric'              => 'O :attribute precisa ser númeral.',
    'regex'                => 'O :attribute possui o formato inválido.',
    'required'             => 'O :attribute é obrigatório.',
    'required_if'          => 'O :attribute é obrigatório quando :other é :value.',
    'required_with'        => 'O :attribute é obrigatório quando :values está presente.',
    'required_with_all'    => 'O :attribute é obrigatório quando todos :values estão presente.',
    'required_without'     => 'O :attribute é obrigatório quando :values não estão presentes.',
    'required_without_all' => 'O :attribute é obrigatório quando nenhum deles :values estão presentes.',
    'same'                 => 'O :attribute e :other não são iguais.',
    'size'                 => [
        'numeric' => 'O :attribute precisa ter :size.',
        'file'    => 'O :attribute precisa ter :size kilobytes.',
        'string'  => 'O :attribute precisa ter :size caracteres.',
        'array'   => 'O :attribute precisa conter :size itens.',
    ],
    'string'               => 'O :attribute tem que ser um texto.',
    'timezone'             => 'O :attribute tem que ser uma zona de horário.',
    'unique'               => 'O :attribute já existe.',
    'url'                  => 'O :attribute formato é inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
