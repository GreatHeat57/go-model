<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		// 'App\Model' => 'App\Policies\ModelPolicy',
	];
	
	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();
		
        // gate authentication check
        $this->gateAuth();

        // gate check jobs
        $this->gateJobs();

        //gate check messages
        $this->gateMessages();

        // gate check models
        $this->gateModel();

        // gate check partner
        $this->gatePartner();

        $this->gateUsers();
		
	}

    public function gateAuth(){

        Gate::define('free_country_user', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['free']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('premium_country_free_user', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('premium_country_paid_user', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium', 'premium_send']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('update_profile', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

    }

    public function gateJobs(){

        Gate::define('list_jobs', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('info_jobs', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('view_jobs', function ($user) {
            if($user->user_type_id == config('constant.model_type_id')){
                if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                    && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send', 'free']) 
                ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });

        Gate::define('add_jobs', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('apply_jobs', function ($user) {
            if($user->user_type_id == config('constant.model_type_id')){
                if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                    && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send']) 
                ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });

        // gate used to restrict the user to view applied jobs list
        Gate::define('applied_jobs', function ($user) {
            if($user->user_type_id == config('constant.model_type_id')){
                if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                    && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
                ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });

        // gate used to restrict the user invitation accept/decline event
        Gate::define('invited_jobs', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium', 'premium_send']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        // gate used to restrict the user to view my posted jobs list
        Gate::define('my_jobs', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium','free']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        // gate used to restrict the user to create new post jobs
        Gate::define('create_jobs', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('view_favourites_jobs_page', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('view_my_applications_page', function ($user) {

            if($user->user_type_id == config('constant.model_type_id')){
                if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                    && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
                ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        });

    }

    public function gateMessages(){

        Gate::define('list_messages', function ($user) {
            if($user->user_type_id == config('constant.model_type_id')){
                if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium','free']) 
                    && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
                ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });

        Gate::define('list_invitations', function ($user) {
            if($user->user_type_id == config('constant.model_type_id')){
                if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                    && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
                ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });

        Gate::define('send_invitations', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('view_messages', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('view_conversations', function ($user) {
            if($user->user_type_id == config('constant.model_type_id')){
                if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium','free']) 
                    && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
                ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });

        Gate::define('view_message_page', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('view_invitation_page', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('show_premium_button', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
            ){
                return true;
            }else{
                return false;
            }
        });
    }

    public function gateModel(){

        Gate::define('list_models', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium','free']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('view_models', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium','free']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
            ){
                return true;
            }else{
                return false;
            }
        });
    }

    public function gatePartner(){

        Gate::define('list_partner', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('view_partner', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
            ){
                return true;
            }else{
                return false;
            }
        });

        Gate::define('view_partner_page', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
            ){
                return true;
            }else{
                return false;
            }
        });


        Gate::define('view_fav_partner_page', function ($user) {
            if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium']) 
                && isset($user->user_register_type) && in_array($user->user_register_type, ['free']) 
            ){
                return true;
            }else{
                return false;
            }
        });
    }

    public function gateUsers(){

        Gate::define('view_profile', function ($user) {

            if($user->user_type_id == config('constant.model_type_id')){
                if( isset($user->country->country_type) && in_array($user->country->country_type, ['premium','free']) 
                    && isset($user->user_register_type) && in_array($user->user_register_type, ['premium','premium_send','free']) 
                ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });
    }


}
