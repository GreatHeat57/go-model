<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
        ]);
        $this->call(UserTypesTableSeeder::class);
        $this->call(AdvertisingTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(ContinentsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(ExperienceTypesTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(HomeSectionsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(LtmTranslationsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(MetaTagsTableSeeder::class);
        $this->call(PackagesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(PostTypesTableSeeder::class);
        $this->call(ReportTypesTableSeeder::class);
        $this->call(ResumesTableSeeder::class);
        $this->call(SalaryTypesTableSeeder::class);
        $this->call(SavedPostsTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(Subadmin1TableSeeder::class);
        $this->call(Subadmin2TableSeeder::class);
        $this->call(TimeZonesTableSeeder::class);
        $this->call(UserProfileTableSeeder::class);
        $this->call(ValidValuesTableSeeder::class);
        $this->call(ValidValueTranslationsTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        $this->call(ModelCategoriesTableSeeder::class);
    }
}