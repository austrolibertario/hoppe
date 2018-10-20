<?php
/**
 * The main site settings page
 */
return [
	'title' => 'Configurações do site',

	'edit_fields' => array(
		'site_name' => array(
			'title' => 'Nome do site',
			'type' => 'text',
			'limit' => 50,
		),
		'site_intro_footer' => array(
			'title' => 'Descrição do site de rodapé',
			'type' => 'textarea',
			'limit' => 250,
		),
		'site_intro_font_page' => array(
			'title' => 'Descrição do site inicial',
			'type' => 'textarea',
			'limit' => 250,
		),
		'seo_title' => array(
			'title' => 'SEO - Title',
			'type' => 'textarea',
			'limit' => 250,
		),
		'seo_description' => array(
			'title' => 'SEO - Description',
			'type' => 'textarea',
			'limit' => 250,
		),
		'seo_keyword' => array(
			'title' => 'SEO - Keywords',
			'type' => 'textarea',
			'limit' => 250,
		),
		'compose_topic_hint' => array(
			'title' => 'Guia do usuário da página de postagem',
			'type' => 'textarea',
			'limit' => 500,
		),
		'logo' => array(
			'title' => 'Site Logo',
			'type' => 'image',
			'naming' => 'random',
			'location' => public_path() . '/assets/images/',
			'size_limit' => 2,
		),
        'logo_width' => array(
			'title' => 'Estilo do logotipo do site',
			'type' => 'textarea',
			'limit' => 500,
		),
	),
	/**
	 * The validation rules for the form, based on the Laravel validation class
	 *
	 * @type array
	 */
	'rules' => array(
		'site_name' => 'required|max:50',
		'logo' => 'required',
	),
	/**
	 * This is run prior to saving the JSON form data
	 *
	 * @type function
	 * @param array		$data
	 *
	 * @return string (on error) / void (otherwise)
	 */
	'before_save' => function(&$data)
	{
		// $data['site_name'] = $data['site_name'] . ' - The Blurst Site Ever';
	},
	/**
	 * The permission option is an authentication check that lets you define a closure that should return true if the current user
	 * is allowed to view this settings page. Any "falsey" response will result in a 404.
	 *
	 * @type closure
	 */
	'permission'=> function()
	{
		return true;
		//return Auth::user()->hasRole('developer');
	},
	/**
	 * This is where you can define the settings page's custom actions
	 */
	'actions' => [
		//Ordering an item up
		'clear_cache' => [
			'title' => 'Atualizar cache do sistema',
			'messages' => [
				'active' => 'Clearing cache...',
				'success' => 'Cache Cleared',
				'error' => 'There was an error while clearing the page cache',
			],
			//the settings data is passed to the closure and saved if a truthy response is returned
			'action' => function(&$data)
			{
                \Artisan::call('cache:clear');
				return true;
			}
		],
	],
];
