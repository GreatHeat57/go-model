<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => '1',
                'key' => 'app',
                'name' => 'Application',
                'value' => '{"purchase_code":"6fd15638-ee22-4e10-92b3-f77ef034af85","name":"go-models.com","slogan":"no","logo":null,"favicon":null,"email":"admin@itellico.com","phone_number":null,"default_date_format":"%d %B %Y","default_datetime_format":"%d %B %Y %H:%M","default_timezone":"Europe\\/Vienna"}',
                'description' => 'Application Setup',
                'field' => '[
{"name":"separator_1","type":"custom_html","value":"<h3>Brand Info</h3>"},
{"name":"purchase_code","label":"Purchase Code","type":"text","hint":"Get your Purchase Code <a href=\\"https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-\\" target=\\"_blank\\">here</a>."},
{"name":"name","label":"App Name","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"slogan","label":"App Slogan","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"logo","label":"App Logo","type":"image","upload":"true","disk":"uploads","default":"app/default/logo.png","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"favicon","label":"Favicon","type":"image","upload":"true","disk":"uploads","default":"app/default/ico/favicon.png","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"separator_clear_1","type":"custom_html","value":"<div style=\\"clear: both;\\"></div>"},
{"name":"email","label":"Email","type":"email","hint":"The email address that all emails from the contact form will go to.","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"phone_number","label":"Phone number","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2","type":"custom_html","value":"<h3>Date Format</h3>"},
{"name":"default_date_format","label":"Date Format","type":"text","hint":"The implementation makes a call to <a href=\\"http://php.net/strftime\\" target=\\"_blank\\">strftime</a> using the current instance timestamp.","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"default_datetime_format","label":"Date Time Format","type":"text","hint":"The implementation makes a call to <a href=\\"http://php.net/strftime\\" target=\\"_blank\\">strftime</a> using the current instance timestamp.","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"default_timezone","label":"Default Timezone","type":"select2","attribute":"time_zone_id","model":"\\\\App\\\\Models\\\\TimeZone","hint":"NOTE: This option is used in the Admin panel","wrapperAttributes":{"class":"form-group col-md-6"}}
]',
                'parent_id' => '0',
                'lft' => '2',
                'rgt' => '3',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => '2',
                'key' => 'style',
                'name' => 'Style',
                'value' => NULL,
                'description' => 'Style Customization',
                'field' => '[
{"name":"separator_1","type":"custom_html","value":"<h3>Front-End</h3>"},
{"name":"app_skin","label":"Front Skin","type":"select2_from_array","options":{"skin-default":"Default","skin-blue":"Blue","skin-yellow":"Yellow","skin-green":"Green","skin-red":"Red"}},

{"name":"separator_2","type":"custom_html","value":"<h4>Customize the Front Style</h4>"},
{"name":"separator_2_1","type":"custom_html","value":"<h5><strong>Global</strong></h5>"},
{"name":"body_background_color","label":"Body Background Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#FFFFFF"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"body_text_color","label":"Body Text Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#292B2C"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"body_background_image","label":"Body Background Image","type":"image","upload":"true","disk":"uploads","default":"","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"separator_clear_1","type":"custom_html","value":"<div style=\\"clear: both;\\"></div>"},
{"name":"body_background_image_fixed","label":"Body Background Image Fixed","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6","style":"margin-top: 20px;"}},
{"name":"page_width","label":"Page Width","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"separator_clear_2","type":"custom_html","value":"<div style=\\"clear: both;\\"></div>"},
{"name":"title_color","label":"Titles Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#292B2C"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"progress_background_color","label":"Progress Background Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":""},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"link_color","label":"Links Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#4682B4"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"link_color_hover","label":"Links Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#FF8C00"},"wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2_2","type":"custom_html","value":"<h5><strong>Header</strong></h5>"},
{"name":"header_sticky","label":"Header Sticky","type":"checkbox"},
{"name":"header_height","label":"Header Height","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"header_background_color","label":"Header Background Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#F8F8F8"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"header_bottom_border_width","label":"Header Bottom Border Width","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"header_bottom_border_color","label":"Header Bottom Border Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#E8E8E8"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"header_link_color","label":"Header Links Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#333"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"header_link_color_hover","label":"Header Links Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#000"},"wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2_3","type":"custom_html","value":"<h5><strong>Footer</strong></h5>"},
{"name":"footer_background_color","label":"Footer Background Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#F5F5F5"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"footer_text_color","label":"Footer Text Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#333"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"footer_title_color","label":"Footer Titles Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#000"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"separator_clear_2","type":"custom_html","value":"<div style=\\"clear: both;\\"></div>"},
{"name":"footer_link_color","label":"Footer Links Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#333"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"footer_link_color_hover","label":"Footer Links Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#333"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"payment_icon_top_border_width","label":"Payment Methods Icons Top Border Width","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"payment_icon_top_border_color","label":"Payment Methods Icons Top Border Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#DDD"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"payment_icon_bottom_border_width","label":"Payment Methods Icons Bottom Border Width","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"payment_icon_bottom_border_color","label":"Payment Methods Icons Bottom Border Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#DDD"},"wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2_4","type":"custom_html","value":"<h5><strong>Buttons \'Post a Job\' and \'Add your Resume\'</strong></h5>"},
{"name":"btn_post_bg_top_color","label":"Gradient Background Top Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#ffeb43"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"btn_post_bg_bottom_color","label":"Gradient Background Bottom Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#fcde11"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"btn_post_border_color","label":"Button Border Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#f6d80f"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"btn_post_text_color","label":"Button Text Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#292b2c"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"btn_post_bg_top_color_hover","label":"Gradient Background Top Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#fff860"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"btn_post_bg_bottom_color_hover","label":"Gradient Background Bottom Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#ffeb43"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"btn_post_border_color_hover","label":"Button Border Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#fcde11"},"wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"btn_post_text_color_hover","label":"Button Text Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#1b1d1e"},"wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_3","type":"custom_html","value":"<h4>Raw CSS (Optional)</h4>"},
{"name":"separator_3_1","type":"custom_html","value":"You can also add raw CSS to customize your website style by using the field below. <br>If you want to add a large CSS code, you have to use the /public/css/custom.css file."},
{"name":"custom_css","label":"Custom CSS","type":"textarea","attributes":{"rows":"5"},"hint":"Please <strong>do not</strong> include the &lt;style&gt; tags."},

{"name":"separator_4","type":"custom_html","value":"<h3>Admin panel</h3>"},
{"name":"admin_skin","label":"Admin Skin","type":"select2_from_array","options":{"skin-black":"Black","skin-blue":"Blue","skin-purple":"Purple","skin-red":"Red","skin-yellow":"Yellow","skin-green":"Green","skin-blue-light":"Blue light","skin-black-light":"Black light","skin-purple-light":"Purple light","skin-green-light":"Green light","skin-red-light":"Red light","skin-yellow-light":"Yellow light"}}
]',
                'parent_id' => '0',
                'lft' => '4',
                'rgt' => '5',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => '3',
                'key' => 'listing',
                'name' => 'Listing & Search',
                'value' => NULL,
                'description' => 'Listing & Search Options',
                'field' => '[
{"name":"separator_1","type":"custom_html","value":"<h3>Displaying</h3>"},
{"name":"items_per_page","label":"Items per page","type":"text","hint":"Number of items per page (> 4 and < 40)","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2","type":"custom_html","value":"<h3>Distance</h3>"},
{"name":"search_distance_max","label":"Max Search Distance","type":"select2_from_array","options":{"1000":"1000","900":"900","800":"800","700":"700","600":"600","500":"500","400":"400","300":"300","200":"200","100":"100","50":"50","0":"0"},"hint":"Max search radius distance (in km or miles)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"search_distance_default","label":"Default Search Distance","type":"select2_from_array","options":{"200":"200","100":"100","50":"50","25":"25","20":"20","10":"10","0":"0"},"hint":"Default search radius distance (in km or miles)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"search_distance_interval","label":"Distance Interval","type":"select2_from_array","options":{"250":"250","200":"200","100":"100","50":"50","25":"25","20":"20","10":"10","5":"5"},"hint":"The interval between filter distances (shown on the search results page)","wrapperAttributes":{"class":"form-group col-md-6"}}
]',
                'parent_id' => '0',
                'lft' => '6',
                'rgt' => '7',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => '4',
                'key' => 'single',
                'name' => 'Ads Single Page',
                'value' => NULL,
                'description' => 'Ads Single Page Options',
                'field' => '[
{"name":"separator_1","type":"custom_html","value":"<h3>Publication</h3>"},
{"name":"pictures_limit","label":"Pictures Limit","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"tags_limit","label":"Tags Limit","type":"text","hint":"NOTE: The \'tags\' field in the \'posts\' table is a varchar 255","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"guests_can_post_ads","label":"Allow Guests to post Ads","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"posts_review_activation","label":"Allow Ads to be reviewed by Admins","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"guests_can_apply_jobs","label":"Allow Guests to apply Jobs","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2","type":"custom_html","value":"<h3>Edition</h3>"},
{"name":"simditor_wysiwyg","label":"Allow the Simditor WYSIWYG Editor","type":"checkbox"},
{"name":"ckeditor_wysiwyg","label":"Allow the CKEditor WYSIWYG Editor","type":"checkbox","hint":"For commercial use: http://ckeditor.com/pricing. NOTE: You need to disable the \'Simditor WYSIWYG Editor\'"},

{"name":"separator_3","type":"custom_html","value":"<h3>External Services</h3>"},
{"name":"show_post_on_googlemap","label":"Show Ads on Google Maps (Single Page Only)","type":"checkbox","hint":"You have to enter your Google Maps API key at: <br>Setup -> General Settings -> Others.","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"activation_facebook_comments","label":"Allow Facebook Comments (Single Page Only)","type":"checkbox","hint":"You have to configure the Login with Facebook at: <br>Setup -> General Settings -> Social Login.","wrapperAttributes":{"class":"form-group col-md-6"}}
]',
                'parent_id' => '0',
                'lft' => '8',
                'rgt' => '9',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => '5',
                'key' => 'mail',
                'name' => 'Mail',
                'value' => '{"driver":"mailgun","host":"smtp.mailgun.org","port":"465","username":"v2_go-models.com@go-models.com","password":"dgHgB_hft52Gtddj&Tdz211","encryption":"starttls","mailgun_domain":"go-models.com","mailgun_secret":"key-05c522bdedb1f31da735530cf8a8577d","mandrill_secret":null,"ses_key":null,"ses_secret":null,"ses_region":null,"sparkpost_secret":null,"email_sender":"admin@itellico.com","email_verification":"0","admin_email_notification":"0","payment_email_notification":"0"}',
                'description' => 'Mail Sending Configuration',
                'field' => '[
{"name":"driver","label":"Mail Driver","type":"select2_from_array","options":{"smtp":"SMTP","mailgun":"Mailgun","mandrill":"Mandrill","ses":"Amazon SES","sparkpost":"Sparkpost","mail":"PHP Mail","sendmail":"Sendmail"}},

{"name":"separator_1","type":"custom_html","value":"<h3>SMTP Parameters</h3>"},
{"name":"separator_1_1","type":"custom_html","value":"Required for drivers: SMTP, Mailgun, Mandrill, Sparkpost"},
{"name":"host","label":"Mail Host","type":"text","hint":"SMTP Host","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"port","label":"Mail Port","type":"text","hint":"SMTP Port (e.g. 25, 587, ...)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"username","label":"Mail Username","type":"text","hint":"SMTP Username","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"password","label":"Mail Password","type":"text","hint":"SMTP Password","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"encryption","label":"Mail Encryption","type":"text","hint":"SMTP Encryption (e.g. tls, ssl, starttls)","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2","type":"custom_html","value":"<h3>Mailgun</h3>"},
{"name":"mailgun_domain","label":"Mailgun Domain","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"mailgun_secret","label":"Mailgun Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_3","type":"custom_html","value":"<h3>Mandrill</h3>"},
{"name":"mandrill_secret","label":"Mandrill Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_4","type":"custom_html","value":"<h3>Amazon SES</h3>"},
{"name":"ses_key","label":"SES Key","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"ses_secret","label":"SES Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"ses_region","label":"SES Region","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_5","type":"custom_html","value":"<h3>Sparkpost</h3>"},
{"name":"sparkpost_secret","label":"Sparkpost Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_6","type":"custom_html","value":"<hr>"},

{"name":"separator_7","type":"custom_html","value":"<h3>Other Configurations</h3>"},
{"name":"email_sender","label":"Transactional Email Sender","type":"email","hint":"Transactional Email Sender. Example: noreply@yoursite.com","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"email_verification","label":"Email Verification Required","type":"checkbox","hint":"By enabling this option you have to add this entry: <strong>DISABLE_EMAIL=false</strong> in the /.env file."},
{"name":"admin_email_notification","label":"Admin Email Notification","type":"checkbox","hint":"Send Email Notifications to the admins when ads was added or users was registered etc."},
{"name":"payment_email_notification","label":"Payment Email Notification","type":"checkbox","hint":"Send Email Notifications to user and admins when payments was sent."}
]',
                'parent_id' => '0',
                'lft' => '10',
                'rgt' => '11',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => '6',
                'key' => 'sms',
                'name' => 'SMS',
                'value' => NULL,
                'description' => 'SMS Sending Configuration',
                'field' => '[
{"name":"driver","label":"SMS Driver","type":"select2_from_array","options":{"nexmo":"Nexmo","twilio":"Twilio"}},

{"name":"separator_1","type":"custom_html","value":"<h3>Nexmo</h3>"},
{"name":"separator_1_1","type":"custom_html","value":"Get a Nexmo Account <a href=\\"https://www.nexmo.com/\\" target=\\"_blank\\">here</a>."},
{"name":"nexmo_key","label":"Nexmo Key","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"nexmo_secret","label":"Nexmo Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"nexmo_from","label":"Nexmo From","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2","type":"custom_html","value":"<h3>Twilio</h3>"},
{"name":"separator_2_1","type":"custom_html","value":"Get a Twilio Account <a href=\\"https://www.twilio.com/\\" target=\\"_blank\\">here</a>."},
{"name":"twilio_account_sid","label":"Twilio Account SID","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"twilio_auth_token","label":"Twilio Auth Token","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"twilio_from","label":"Twilio From","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_3","type":"custom_html","value":"<hr>"},

{"name":"separator_4","type":"custom_html","value":"<h3>Other Configurations</h3>"},
{"name":"phone_verification","label":"Enable Phone Verification","type":"checkbox","hint":"By enabling this option you have to add this entry: <strong>DISABLE_PHONE=false</strong> in the /.env file."},
{"name":"message_activation","label":"Enable SMS Message","type":"checkbox","hint":"Send a SMS in addition for each message between users. NOTE: You will have a lot to spend on the SMS sending credit."}
]',
                'parent_id' => '0',
                'lft' => '12',
                'rgt' => '13',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => '7',
                'key' => 'seo',
                'name' => 'SEO',
                'value' => NULL,
                'description' => 'SEO Tools',
                'field' => '[
{"name":"separator_1","type":"custom_html","value":"<h3>Verification Tools</h3>"},
{"name":"google_site_verification","label":"Google site verification content","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"alexa_verify_id","label":"Alexa site verification content","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"msvalidate","label":"Bing site verification content","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"twitter_username","label":"Twitter Username","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2","type":"custom_html","value":"<h3>Indexing (On Search Engines)</h3>"},
{"name":"no_index_categories","label":"No Index Categories Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"no_index_tags","label":"No Index Tags Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"no_index_cities","label":"No Index Cities Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"no_index_users","label":"No Index Users Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"no_index_companies","label":"No Index Companies Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"no_index_all","label":"No Index All Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_3","type":"custom_html","value":"<h3>Posts Permalink Settings</h3>"},
{"name":"posts_permalink","label":"Posts Permalink","type":"select2_from_array","options":{"{slug}-{id}":"{slug}-{id}","{slug}/{id}":"{slug}/{id}","{slug}_{id}":"{slug}_{id}","{id}-{slug}":"{id}-{slug}","{id}/{slug}":"{id}/{slug}","{id}_{slug}":"{id}_{slug}","{id}":"{id}"},"hint":"The word {id} will be replaced by the Post ID, and {slug} by the Post title\'s slug.<br>e.g. http://www.domain.com/{slug}/{id}","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"posts_permalink_ext","label":"Posts Permalink Extension","type":"select2_from_array","options":{"":"&nbsp;",".html":".html",".htm":".htm",".php":".php",".aspx":".aspx"},"hint":"You can add an extension for the Posts Permalink (Optional).<br>e.g. http://www.domain.com/{slug}/{id}.html","wrapperAttributes":{"class":"form-group col-md-6"}}
]',
                'parent_id' => '0',
                'lft' => '14',
                'rgt' => '15',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => '8',
                'key' => 'upload',
                'name' => 'Upload',
                'value' => NULL,
                'description' => 'Upload Settings',
                'field' => '[
{"name":"image_types","label":"Upload Image Types","type":"text","hint":"Upload image types (ex: jpg,jpeg,gif,png,...)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"file_types","label":"Upload File Types","type":"text","hint":"Upload file types (ex: pdf,doc,docx,odt,...)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"max_file_size","label":"Upload Max File Size","type":"text","hint":"Upload Max File Size (in KB)","wrapperAttributes":{"class":"form-group col-md-6"}}
]',
                'parent_id' => '0',
                'lft' => '16',
                'rgt' => '17',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => '9',
                'key' => 'geo_location',
                'name' => 'Geo Location',
                'value' => '{"geolocation_activation":"1","default_country_code":"AT","country_flag_activation":"1","local_currency_packages_activation":"0"}',
                'description' => 'Geo Location Configuration',
                'field' => '[
{"name":"geolocation_activation","label":"Enable Geolocation","type":"checkbox","hint":"Before enabling this option you need to download the Maxmind database by following the documentation <a href=\\"http://support.bedigit.com/help-center/articles/14/enable-the-geo-location\\" target=\\"_blank\\">here</a>.","wrapperAttributes":{"class":"form-group col-md-6","style":"margin-top: 20px;"}},
{"name":"default_country_code","label":"Default Country","type":"select2","attribute":"asciiname","model":"\\\\App\\\\Models\\\\Country","allows_null":"true","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"separator_clear_1","type":"custom_html","value":"<div style=\\"clear: both;\\"></div>"},
{"name":"country_flag_activation","label":"Show country flag on top","type":"checkbox","hint":"<br>","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"local_currency_packages_activation","label":"Allow users to pay the Packages in their country currency","type":"checkbox","hint":"You have to create a list of <a href=\\"#admin#/package\\" target=\\"_blank\\">Packages</a> per currency (using currencies of activated countries) to allow users to pay the Packages in their local currency.<br>NOTE: By unchecking this field all the lists of Packages (without currency matching) will be shown during the payment process.","wrapperAttributes":{"class":"form-group col-md-6"}}
]',
                'parent_id' => '0',
                'lft' => '18',
                'rgt' => '19',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => '10',
                'key' => 'security',
                'name' => 'Security',
                'value' => '{"login_open_in_modal":"1","login_max_attempts":"5","login_decay_minutes":"15","recaptcha_activation":"0","recaptcha_public_key":"6LfMbE0UAAAAAA5qBt8L16lxUPCoe_q6dLawAP1_","recaptcha_private_key":"6LfMbE0UAAAAAFoX3zegNx8kQbbz_pdMYlOFOc0b"}',
                'description' => 'Security Options',
                'field' => '[
{"name":"separator_1","type":"custom_html","value":"<h3>Login</h3>"},
{"name":"login_open_in_modal","label":"Open In Modal","type":"checkbox","hint":"Open the top login link into Modal"},
{"name":"login_max_attempts","label":"Max Attempts","type":"select2_from_array","options":{"30":"30","20":"20","10":"10","5":"5","4":"4","3":"3","2":"2","1":"1"},"hint":"The maximum number of attempts to allow","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"login_decay_minutes","label":"Decay Minutes","type":"select2_from_array","options":{"1440":"1440","720":"720","60":"60","30":"30","20":"20","15":"15","10":"10","5":"5","4":"4","3":"3","2":"2","1":"1"},"hint":"The number of minutes to throttle for","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2","type":"custom_html","value":"<h3>reCAPTCHA</h3>"},
{"name":"recaptcha_activation","label":"Enable reCAPTCHA","type":"checkbox","hint":"Get reCAPTCHA site keys <a href=\\"https://www.google.com/recaptcha/\\" target=\\"_blank\\">here</a>."},
{"name":"recaptcha_public_key","label":"reCAPTCHA Public Key","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"recaptcha_private_key","label":"reCAPTCHA Private Key","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}}
]',
                'parent_id' => '0',
                'lft' => '20',
                'rgt' => '21',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => '11',
                'key' => 'social_auth',
                'name' => 'Social Login',
                'value' => '{"social_login_activation":"1","facebook_client_id":"353376078495448","facebook_client_secret":"fc360c7ac356e3170b3f5f583d3efc8a","google_client_id":"565310722440-bm81tdkfg2eqtabqadaf1hvetmsnov2n.apps.googleusercontent.com","google_client_secret":"8j7PVWgA4x2u2CjfBhXar1lw"}',
                'description' => 'Social Network Login',
                'field' => '[
{"name":"social_login_activation","label":"Enable Social Login","type":"checkbox","hint":"Allow users to connect via social networks"},

{"name":"separator_1","type":"custom_html","value":"<h3>Facebook</h3>"},
{"name":"separator_1_1","type":"custom_html","value":"Create a Facebook App <a href=\\"https://developers.facebook.com/\\" target=\\"_blank\\">here</a>. The \\"OAuth redirect URI\\" is: (http:// or https://) yoursite.com<strong>/auth/facebook/callback</strong> or www.yoursite.com<strong>/auth/facebook/callback</strong>"},
{"name":"facebook_client_id","label":"Facebook Client ID","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"facebook_client_secret","label":"Facebook Client Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2","type":"custom_html","value":"<h3>Google+</h3>"},
{"name":"separator_2_1","type":"custom_html","value":"Create a Google+ App <a href=\\"https://console.developers.google.com/\\" target=\\"_blank\\">here</a>. The \\"Authorized Redirect URI\\" is: (http:// or https://) yoursite.com<strong>/auth/google/callback</strong> or www.yoursite.com<strong>/auth/google/callback</strong>"},
{"name":"google_client_id","label":"Google Client ID","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"google_client_secret","label":"Google Client Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}}
]',
                'parent_id' => '0',
                'lft' => '22',
                'rgt' => '23',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => '12',
                'key' => 'social_link',
                'name' => 'Social Network',
                'value' => NULL,
                'description' => 'Social Network Profiles',
                'field' => '[
{"name":"facebook_page_url","label":"Facebook Page URL","type":"text"},
{"name":"twitter_url","label":"Twitter URL","type":"text"},
{"name":"google_plus_url","label":"Google+ URL","type":"text"},
{"name":"linkedin_url","label":"LinkedIn URL","type":"text"},
{"name":"pinterest_url","label":"Pinterest URL","type":"text"}
]',
                'parent_id' => '0',
                'lft' => '24',
                'rgt' => '25',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => '13',
                'key' => 'other',
                'name' => 'Others',
                'value' => '{"show_tips_messages":"1","googlemaps_key":"AIzaSyCVulNjSIG40n-3SUsjKgqTlhcU7TxKAmU","decimals_superscript":"0","cookie_expiration":"86400","cache_expiration":"1440","minify_html_activation":"0","http_cache_activation":"0"}',
                'description' => 'Other Options',
                'field' => '[
{"name":"separator_1","type":"custom_html","value":"<h3>Tips Info</h3>"},
{"name":"show_tips_messages","label":"Show Tips Notification Messages","type":"checkbox","hint":"e.g. SITENAME is also available in your country: COUNTRY. Starting good deals here now!<br>Login for faster access to the best deals. Click here if you don\'t have an account."},

{"name":"separator_2","type":"custom_html","value":"<h3>Google Maps</h3>"},
{"name":"googlemaps_key","label":"Google Maps Key","type":"text"},

{"name":"separator_3","type":"custom_html","value":"<h3>Number Format</h3>"},
{"name":"decimals_superscript","label":"Decimals Superscript","type":"checkbox"},

{"name":"separator_4","type":"custom_html","value":"<h3>Optimization</h3>"},
{"name":"cookie_expiration","label":"Cookie Expiration Time","type":"text","hint":"Cookie Expiration Time (in secondes)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"cache_expiration","label":"Cache Expiration Time","type":"text","hint":"Cache Expiration Time (in minutes)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"minify_html_activation","label":"Enable HTML Minify","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"http_cache_activation","label":"Enable HTTP Cache","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}}
]',
                'parent_id' => '0',
                'lft' => '26',
                'rgt' => '27',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => '14',
                'key' => 'cron',
                'name' => 'Cron',
                'value' => NULL,
                'description' => 'Cron Job',
                'field' => '[
{"name":"separator_1","type":"custom_html","value":"<h3>Cron</h3>"},
{"name":"separator_1_1","type":"custom_html","value":"You need to add \'/usr/bin/php -q /path/to/your/website/artisan ads:clean\' in your Cron Job tab. Click <a href=\\"http://support.bedigit.com/help-center/articles/19/configuring-the-cron-job\\" target=\\"_blank\\">here</a> for more information."},
{"name":"unactivated_posts_expiration","label":"Unactivated Ads Expiration","type":"text", "hint":"In days (Delete the unactivated ads after this expiration)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"activated_posts_expiration","label":"Activated Ads Expiration","type":"text", "hint":"In days (Archive the activated ads after this expiration)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"archived_posts_expiration","label":"Archived Ads Expiration","type":"text", "hint":"In days (Delete the archived ads after this expiration)","wrapperAttributes":{"class":"form-group col-md-6"}},

{"name":"separator_2","type":"custom_html","value":"<h3>Test</h3>"},
{"name":"separator_2_1","type":"custom_html","value":"You can run manually the Cron Job command by clicking the button below. <br><strong>CAUTION:</strong><br>- All the expirated paid ads (also called: premium or featured ads) will become regular ads (also called: normal or free ads).<br>&nbsp;&nbsp;You have to setup the premium ads expiration duration from: Setup -> Packages.<br>- All expirated active regular ads will be archived. <br>- All expirated inactive regular ads will be deleted.<br>- All expirated archived regular ads will be deleted."},
{"name":"separator_2_2","type":"custom_html","value":"<a href=\\"#admin#/test_cron\\" class=\\"btn btn-primary\\"><i class=\\"fa fa-play-circle-o\\"></i> Run Manually</a>"}
]',
                'parent_id' => '0',
                'lft' => '28',
                'rgt' => '29',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => '15',
                'key' => 'footer',
                'name' => 'Footer',
                'value' => '{"show_payment_plugins_logos":"1","show_powered_by":"0","powered_by_info":null,"tracking_code":null}',
                'description' => 'Pages Footer',
                'field' => '[
{"name":"show_payment_plugins_logos","label":"Show Payment Plugins Logos","type":"checkbox"},
{"name":"show_powered_by","label":"Show Powered by Info","type":"checkbox"},
{"name":"powered_by_info","label":"Powered by","type":"text"},
{"name":"tracking_code","label":"Tracking Code","type":"textarea","attributes":{"rows":"15"},"hint":"Paste your Google Analytics (or other) tracking code here. This will be added into the footer."}
]',
                'parent_id' => '0',
                'lft' => '30',
                'rgt' => '31',
                'depth' => '1',
                'active' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}