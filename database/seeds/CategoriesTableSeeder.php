<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->delete();

        \DB::table('categories')->insert(array(
            0 =>
            array(
                'id'          => 1,
                'parent_id'   => 0,
                'post_count'  => 0,
                'weight'      => 100,
                'name'        => 'Assuntos Diversos',
                'slug'        => 'diversos',
                'description' => 'Nós pretendemos ser a maior comunidade libertária do País. Tópicos sobre assuntos diversos deve ser publicado sobre esse tema.',
                'created_at'  => '2016-07-03 10:00:00',
                'updated_at'  => '2016-07-03 10:00:00',
                'deleted_at'  => null,
            ),
            1 =>
            array(
                'id'          => 3,
                'parent_id'   => 0,
                'post_count'  => 0,
                'weight'      => 97,
                'name'        => 'Anúncio',
                'slug'        => 'anuncios',
                'description' => 'Anuncios Anarquicos.',
                'created_at'  => '2016-07-03 10:00:00',
                'updated_at'  => '2016-07-03 10:00:00',
                'deleted_at'  => null,
            ),
            2 =>
            array(
                'id'          => 4,
                'parent_id'   => 0,
                'post_count'  => 0,
                'weight'      => 99,
                'name'        => 'Pergunta e resposta',
                'slug'        => 'perguntas',
                'description' => 'Perguntas de baixa qualidade, não cumprindo com a norma, será que visa desrespeitar o usuário serão bloqueados pelos admin.',
                'created_at'  => '2016-07-03 10:00:00',
                'updated_at'  => '2016-07-03 10:00:00',
                'deleted_at'  => null,
            ),
            3 =>
            array(
                'id'          => 5,
                'parent_id'   => 0,
                'post_count'  => 0,
                'weight'      => 98,
                'name'        => 'Compartilhar',
                'slug'        => 'compartilhamento',
                'description' => 'Compartilhe a criação, compartilhe conhecimento, compartilhe inspiração, compartilhe ideias e compartilhe coisas bonitas. Se o layout for claro e o conteúdo for excelente, refinaremos o tópico. A postagem será recomendada para a página inicial do site, a página inicial para dispositivos móveis, a essência do jornal semanal, <a href = "http://weibo.com/laravelnews "> Informações do Laravel Weibo </a>.',
                'created_at'  => '2016-07-03 10:00:00',
                'updated_at'  => '2016-07-03 10:00:00',
                'deleted_at'  => null,
            ),
            4 =>
            array(
                'id'          => 6,
                'parent_id'   => 0,
                'post_count'  => 0,
                'weight'      => 98,
                'name'        => 'Tutorial',
                'slug'        => 'tutorial',
                'description' => 'Por favor, mantenha uma cópia do artigo do tutorial nesta categoria. Por favor, reimprima o artigo com a declaração "Reimpresso".',
                'created_at'  => '2016-07-03 10:00:00',
                'updated_at'  => '2016-07-03 10:00:00',
                'deleted_at'  => null,
            ),
            5 =>
            array(
                'id'          => 8,
                'parent_id'   => 0,
                'post_count'  => 0,
                'weight'      => 98,
                'name'        => 'Blog',
                'slug'        => 'blog',
                'description' => 'Informações do blog criados pelo próprio usuário.',
                'created_at'  => '2016-07-03 10:00:00',
                'updated_at'  => '2016-07-03 10:00:00',
                'deleted_at'  => null,
            ),
            6 =>
            array(
                'id'          => 9,
                'parent_id'   => 0,
                'post_count'  => 0,
                'weight'      => 98,
                'name'        => 'Vida Ancap',
                'slug'        => 'life',
                'description' => 'Situações de Vida Ancap. Piadas internas',
                'created_at'  => '2016-07-03 10:00:00',
                'updated_at'  => '2016-07-03 10:00:00',
                'deleted_at'  => null,
            ),
            7 =>
            array(
                'id'          => 10,
                'parent_id'   => 0,
                'post_count'  => 0,
                'weight'      => 98,
                'name'        => 'Links',
                'slug'        => 'links',
                'description' => 'Compartilhando links',
                'created_at'  => '2016-07-03 10:00:00',
                'updated_at'  => '2016-07-03 10:00:00',
                'deleted_at'  => null,
            ),
        ));
    }
}
