<?php

use Illuminate\Database\Seeder;

class MetaTagsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('meta_tags')->delete();
        
        \DB::table('meta_tags')->insert(array (
            0 => 
            array (
                'id' => '1',
                'translation_lang' => 'en',
                'translation_of' => '1',
                'page' => 'home',
                'title' => '{app_name} - Geolocalized Job Board Script',
                'description' => 'Welcome to {app_name} : 100% Job Board. Find a job near you. Simple, fast and efficient - {country}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'translation_lang' => 'en',
                'translation_of' => '2',
                'page' => 'register',
                'title' => 'Sign Up - {app_name}',
                'description' => 'Sign Up on {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            2 => 
            array (
                'id' => '3',
                'translation_lang' => 'en',
                'translation_of' => '3',
                'page' => 'login',
                'title' => 'Login - {app_name}',
                'description' => 'Log in to {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            3 => 
            array (
                'id' => '4',
                'translation_lang' => 'en',
                'translation_of' => '4',
                'page' => 'create',
                'title' => 'Post a Job',
                'description' => 'Post a Job - {country}.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            4 => 
            array (
                'id' => '5',
                'translation_lang' => 'en',
                'translation_of' => '5',
                'page' => 'countries',
                'title' => 'Jobs in the World',
                'description' => 'Welcome to {app_name} : 100% Job Board. Find a job near you. Simple, fast and efficient.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            5 => 
            array (
                'id' => '6',
                'translation_lang' => 'en',
                'translation_of' => '6',
                'page' => 'contact',
                'title' => 'Contact Us - {app_name}',
                'description' => 'Contact Us - {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            6 => 
            array (
                'id' => '7',
                'translation_lang' => 'en',
                'translation_of' => '7',
                'page' => 'sitemap',
                'title' => 'Sitemap {app_name} - {country}',
                'description' => 'Sitemap {app_name} - {country}. Job Bord.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            7 => 
            array (
                'id' => '8',
                'translation_lang' => 'fr',
                'translation_of' => '1',
                'page' => 'home',
                'title' => '{app_name} - Geolocalized Job Board Script',
                'description' => 'Bienvenue sur {app_name} : Site d\'emplois 100% gratuit. Trouvez un travail près de chez vous. Simple, rapide et efficace - {country}',
                'keywords' => '{app_name}, {country}, offres d\'emploi, emplois, annonces, script, app, premium jobs',
                'active' => '1',
            ),
            8 => 
            array (
                'id' => '9',
                'translation_lang' => 'es',
                'translation_of' => '1',
                'page' => 'home',
                'title' => '{app_name} - Geolocalized Job Board Script',
                'description' => 'Welcome to {app_name} : 100% Job Board. Find a job near you. Simple, fast and efficient - {country}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            9 => 
            array (
                'id' => '10',
                'translation_lang' => 'fr',
                'translation_of' => '2',
                'page' => 'register',
                'title' => 'S\'inscrire - {app_name}',
                'description' => 'S\'inscrire sur {app_name}',
                'keywords' => '{app_name}, {country}, offres d\'emploi, emplois, annonces, script, app, premium jobs',
                'active' => '1',
            ),
            10 => 
            array (
                'id' => '11',
                'translation_lang' => 'es',
                'translation_of' => '2',
                'page' => 'register',
                'title' => 'Sign Up - {app_name}',
                'description' => 'Sign Up on {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            11 => 
            array (
                'id' => '12',
                'translation_lang' => 'fr',
                'translation_of' => '3',
                'page' => 'login',
                'title' => 'S\'identifier - {app_name}',
                'description' => 'S\'identifier sur {app_name}',
                'keywords' => '{app_name}, {country}, offres d\'emploi, emplois, annonces, script, app, premium jobs',
                'active' => '1',
            ),
            12 => 
            array (
                'id' => '13',
                'translation_lang' => 'es',
                'translation_of' => '3',
                'page' => 'login',
                'title' => 'Login - {app_name}',
                'description' => 'Log in to {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            13 => 
            array (
                'id' => '14',
                'translation_lang' => 'fr',
                'translation_of' => '4',
                'page' => 'create',
                'title' => 'Publiez une offre d\'emploi',
                'description' => 'Publiez une offre d\'emploi - {country}.',
                'keywords' => '{app_name}, {country}, offres d\'emploi, emplois, annonces, script, app, premium jobs',
                'active' => '1',
            ),
            14 => 
            array (
                'id' => '15',
                'translation_lang' => 'es',
                'translation_of' => '4',
                'page' => 'create',
                'title' => 'Publicar un anuncio gratuito',
                'description' => 'Publicar un anuncio gratuito - {country}.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            15 => 
            array (
                'id' => '16',
                'translation_lang' => 'fr',
                'translation_of' => '5',
                'page' => 'countries',
                'title' => 'Emplois dans le monde',
                'description' => 'Bienvenue sur {app_name} : Site d\'emplois 100% gratuit. Trouvez un travail près de chez vous. Simple, rapide et efficace.',
                'keywords' => '{app_name}, {country}, offres d\'emploi, emplois, annonces, script, app, premium jobs',
                'active' => '1',
            ),
            16 => 
            array (
                'id' => '17',
                'translation_lang' => 'es',
                'translation_of' => '5',
                'page' => 'countries',
                'title' => 'Jobs in the World',
                'description' => 'Welcome to {app_name} : 100% Job Board. Find a job near you. Simple, fast and efficient.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            17 => 
            array (
                'id' => '18',
                'translation_lang' => 'fr',
                'translation_of' => '6',
                'page' => 'contact',
                'title' => 'Nous contacter - {app_name}',
                'description' => 'Nous contacter - {app_name}',
                'keywords' => '{app_name}, {country}, offres d\'emploi, emplois, annonces, script, app, premium jobs',
                'active' => '1',
            ),
            18 => 
            array (
                'id' => '19',
                'translation_lang' => 'es',
                'translation_of' => '6',
                'page' => 'contact',
                'title' => 'Contact Us - {app_name}',
                'description' => 'Contact Us - {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            19 => 
            array (
                'id' => '20',
                'translation_lang' => 'fr',
                'translation_of' => '7',
                'page' => 'sitemap',
                'title' => 'Plan du site {app_name} - {country}',
                'description' => 'Plan du site {app_name} - {country}. Site d\'emplois.',
                'keywords' => '{app_name}, {country}, offres d\'emploi, emplois, annonces, script, app, premium jobs',
                'active' => '1',
            ),
            20 => 
            array (
                'id' => '21',
                'translation_lang' => 'es',
                'translation_of' => '7',
                'page' => 'sitemap',
                'title' => 'Sitemap {app_name} - {country}',
                'description' => 'Sitemap {app_name} - {country}. Job Bord.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            21 => 
            array (
                'id' => '22',
                'translation_lang' => 'en',
                'translation_of' => '22',
                'page' => 'password',
                'title' => 'Lost your password? - {app_name}',
                'description' => 'Lost your password? - {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            22 => 
            array (
                'id' => '23',
                'translation_lang' => 'fr',
                'translation_of' => '22',
                'page' => 'password',
                'title' => 'Mot de passe oublié? - {app_name}',
                'description' => 'Mot de passe oublié? - {app_name}',
                'keywords' => '{app_name}, {country}, offres d\'emploi, emplois, annonces, script, app, premium jobs',
                'active' => '1',
            ),
            23 => 
            array (
                'id' => '24',
                'translation_lang' => 'es',
                'translation_of' => '22',
                'page' => 'password',
                'title' => '¿Perdiste tu contraseña? - {app_name}',
                'description' => '¿Perdiste tu contraseña? - {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            24 => 
            array (
                'id' => '25',
                'translation_lang' => 'ar',
                'translation_of' => '1',
                'page' => 'home',
                'title' => '{app_name} - Geolocalized Job Board Script',
                'description' => 'Welcome to {app_name} : 100% Job Board. Find a job near you. Simple, fast and efficient - {country}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            25 => 
            array (
                'id' => '26',
                'translation_lang' => 'ar',
                'translation_of' => '2',
                'page' => 'register',
                'title' => 'سجل - {app_name}',
                'description' => 'اشترك في {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            26 => 
            array (
                'id' => '27',
                'translation_lang' => 'ar',
                'translation_of' => '3',
                'page' => 'login',
                'title' => 'تسجيل الدخول - {app_name}',
                'description' => 'تسجيل الدخول إلى {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            27 => 
            array (
                'id' => '28',
                'translation_lang' => 'ar',
                'translation_of' => '4',
                'page' => 'create',
                'title' => 'انشر وظيفة',
                'description' => 'انشر وظيفة - {country}.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            28 => 
            array (
                'id' => '29',
                'translation_lang' => 'ar',
                'translation_of' => '5',
                'page' => 'countries',
                'title' => 'وظائف في العالم',
                'description' => 'Welcome to {app_name} : 100% Job Board. Find a job near you. Simple, fast and efficient.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            29 => 
            array (
                'id' => '30',
                'translation_lang' => 'ar',
                'translation_of' => '6',
                'page' => 'contact',
                'title' => 'اتصل بنا - {app_name}',
                'description' => 'اتصل بنا - {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            30 => 
            array (
                'id' => '31',
                'translation_lang' => 'ar',
                'translation_of' => '7',
                'page' => 'sitemap',
                'title' => 'خريطة الموقع {app_name} - {country}',
                'description' => 'خريطة الموقع {app_name} - {country}. مجلس العمل.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            31 => 
            array (
                'id' => '32',
                'translation_lang' => 'ar',
                'translation_of' => '22',
                'page' => 'password',
                'title' => 'فقدت كلمة المرور الخاصة بك؟ - {app_name}',
                'description' => 'فقدت كلمة المرور الخاصة بك؟ - {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            32 => 
            array (
                'id' => '33',
                'translation_lang' => 'de',
                'translation_of' => '1',
                'page' => 'home',
                'title' => '{app_name} - Geolocalized Job Board Script',
                'description' => 'Welcome to {app_name} : 100% Job Board. Find a job near you. Simple, fast and efficient - {country}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            33 => 
            array (
                'id' => '34',
                'translation_lang' => 'de',
                'translation_of' => '2',
                'page' => 'register',
                'title' => 'Sign Up - {app_name}',
                'description' => 'Sign Up on {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            34 => 
            array (
                'id' => '35',
                'translation_lang' => 'de',
                'translation_of' => '3',
                'page' => 'login',
                'title' => 'Login - {app_name}',
                'description' => 'Log in to {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            35 => 
            array (
                'id' => '36',
                'translation_lang' => 'de',
                'translation_of' => '4',
                'page' => 'create',
                'title' => 'Post a Job',
                'description' => 'Post a Job - {country}.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            36 => 
            array (
                'id' => '37',
                'translation_lang' => 'de',
                'translation_of' => '5',
                'page' => 'countries',
                'title' => 'Jobs in the World',
                'description' => 'Welcome to {app_name} : 100% Job Board. Find a job near you. Simple, fast and efficient.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            37 => 
            array (
                'id' => '38',
                'translation_lang' => 'de',
                'translation_of' => '6',
                'page' => 'contact',
                'title' => 'Contact Us - {app_name}',
                'description' => 'Contact Us - {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            38 => 
            array (
                'id' => '39',
                'translation_lang' => 'de',
                'translation_of' => '7',
                'page' => 'sitemap',
                'title' => 'Sitemap {app_name} - {country}',
                'description' => 'Sitemap {app_name} - {country}. Job Bord.',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
            39 => 
            array (
                'id' => '40',
                'translation_lang' => 'de',
                'translation_of' => '22',
                'page' => 'password',
                'title' => 'Lost your password? - {app_name}',
                'description' => 'Lost your password? - {app_name}',
                'keywords' => '{app_name}, {country}, jobs ads, jobs, ads, script, app, premium jobs',
                'active' => '1',
            ),
        ));
        
        
    }
}