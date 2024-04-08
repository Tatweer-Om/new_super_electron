<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nationalities', function (Blueprint $table) {
            $table->id(); 
            $table->string('nationality_code')->nullable();
            $table->string('nationality_name')->nullable(); // Assuming you want to relate this nationality to a user
            $table->timestamps();
        });

          // Insert nationalities into the database
          $nationalities = [
            ['nationality_code' => 'AF', 'nationality_name' => 'Afghan - أفغاني'],
            ['nationality_code' => 'AL', 'nationality_name' => 'Albanian - ألباني'],
            ['nationality_code' => 'DZ', 'nationality_name' => 'Algerian - جزائري'],
            ['nationality_code' => 'US', 'nationality_name' => 'American - أمريكي'],
            ['nationality_code' => 'AD', 'nationality_name' => 'Andorran - أندوري'],
            ['nationality_code' => 'AO', 'nationality_name' => 'Angolan - أنغولي'],
            ['nationality_code' => 'AG', 'nationality_name' => 'Antiguans - انتيغوا'],
            ['nationality_code' => 'AR', 'nationality_name' => 'Argentinean - أرجنتيني'],
            ['nationality_code' => 'AM', 'nationality_name' => 'Armenian - أرميني'],
            ['nationality_code' => 'AU', 'nationality_name' => 'Australian - أسترالي'],
            ['nationality_code' => 'AT', 'nationality_name' => 'Austrian - نمساوي'],
            ['nationality_code' => 'AZ', 'nationality_name' => 'Azerbaijani - أذربيجاني'],
            ['nationality_code' => 'BS', 'nationality_name' => 'Bahamian - باهامى'],
            ['nationality_code' => 'BH', 'nationality_name' => 'Bahraini - بحريني'],
            ['nationality_code' => 'BD', 'nationality_name' => 'Bangladeshi - بنجلاديشي'],
            ['nationality_code' => 'BB', 'nationality_name' => 'Barbadian - باربادوسي'],
            ['nationality_code' => 'AG', 'nationality_name' => 'Barbudans - بربودا'],
            ['nationality_code' => 'BW', 'nationality_name' => 'Batswana - بوتسواني'],
            ['nationality_code' => 'BY', 'nationality_name' => 'Belarusian - بيلاروسي'],
            ['nationality_code' => 'BE', 'nationality_name' => 'Belgian - بلجيكي'],
            ['nationality_code' => 'BZ', 'nationality_name' => 'Belizean - بليزي'],
            ['nationality_code' => 'BJ', 'nationality_name' => 'Beninese - بنيني'],
            ['nationality_code' => 'BT', 'nationality_name' => 'Bhutanese - بوتاني'],
            ['nationality_code' => 'BO', 'nationality_name' => 'Bolivian - بوليفي'],
            ['nationality_code' => 'BA', 'nationality_name' => 'Bosnian - بوسني'],
            ['nationality_code' => 'BR', 'nationality_name' => 'Brazilian - برازيلي'],
            ['nationality_code' => 'GB', 'nationality_name' => 'British - بريطاني'],
            ['nationality_code' => 'BN', 'nationality_name' => 'Bruneian - بروناى'],
            ['nationality_code' => 'BG', 'nationality_name' => 'Bulgarian - بلغاري'],
            ['nationality_code' => 'BF', 'nationality_name' => 'Burkinabe - بوركيني'],
            ['nationality_code' => 'MM', 'nationality_name' => 'Burmese - بورمي'],
            ['nationality_code' => 'BI', 'nationality_name' => 'Burundian - بوروندي'],
            ['nationality_code' => 'KH', 'nationality_name' => 'Cambodian - كمبودي'],
            ['nationality_code' => 'CM', 'nationality_name' => 'Cameroonian - كاميروني'],
            ['nationality_code' => 'CA', 'nationality_name' => 'Canadian - كندي'],
            ['nationality_code' => 'CV', 'nationality_name' => 'Cape Verdean - االرأس الأخضر'],
            ['nationality_code' => 'CF', 'nationality_name' => 'Central African - وسط أفريقيا'],
            ['nationality_code' => 'TD', 'nationality_name' => 'Chadian - تشادي'],
            ['nationality_code' => 'CL', 'nationality_name' => 'Chilean - شيلي'],
            ['nationality_code' => 'CN', 'nationality_name' => 'Chinese - صينى'],
            ['nationality_code' => 'CO', 'nationality_name' => 'Colombian - كولومبي'],
            ['nationality_code' => 'KM', 'nationality_name' => 'Comoran - جزر القمر'],
            ['nationality_code' => 'CG', 'nationality_name' => 'Congolese - كونغولي'],
            ['nationality_code' => 'CR', 'nationality_name' => 'Costa Rican - كوستاريكي'],
            ['nationality_code' => 'HR', 'nationality_name' => 'Croatian - كرواتية'],
            ['nationality_code' => 'CU', 'nationality_name' => 'Cuban - كوبي'],
            ['nationality_code' => 'CY', 'nationality_name' => 'Cypriot - قبرصي'],
            ['nationality_code' => 'CZ', 'nationality_name' => 'Czech - تشيكي'],
            ['nationality_code' => 'DK', 'nationality_name' => 'Danish - دانماركي'],
            ['nationality_code' => 'DJ', 'nationality_name' => 'Djibouti - جيبوتي'],
            ['nationality_code' => 'DO', 'nationality_name' => 'Dominican - دومينيكاني'],
            ['nationality_code' => 'NL', 'nationality_name' => 'Dutch - هولندي'],
            ['nationality_code' => 'TL', 'nationality_name' => 'East Timorese - تيموري شرقي'],
            ['nationality_code' => 'EC', 'nationality_name' => 'Ecuadorean - اكوادوري'],
            ['nationality_code' => 'EG', 'nationality_name' => 'Egyptian - مصري'],
            ['nationality_code' => 'AE', 'nationality_name' => 'Emirian - إماراتي'],
            ['nationality_code' => 'GQ', 'nationality_name' => 'Equatorial Guinean - غيني  استوائي'],
            ['nationality_code' => 'ER', 'nationality_name' => 'Eritrean - إريتري'],
            ['nationality_code' => 'EE', 'nationality_name' => 'Estonian - إستوني'],
            ['nationality_code' => 'ET', 'nationality_name' => 'Ethiopian - حبشي'],
            ['nationality_code' => 'FJ', 'nationality_name' => 'Fijian - فيجي'],
            ['nationality_code' => 'PH', 'nationality_name' => 'Filipino - فلبيني'],
            ['nationality_code' => 'FI', 'nationality_name' => 'Finnish - فنلندي'],
            ['nationality_code' => 'FR', 'nationality_name' => 'French - فرنسي'],
            ['nationality_code' => 'GA', 'nationality_name' => 'Gabonese - جابوني'],
            ['nationality_code' => 'GM', 'nationality_name' => 'Gambian - غامبيي'],
            ['nationality_code' => 'GE', 'nationality_name' => 'Georgian - جورجي'],
            ['nationality_code' => 'DE', 'nationality_name' => 'German - ألماني'],
            ['nationality_code' => 'GH', 'nationality_name' => 'Ghanaian - غاني'],
            ['nationality_code' => 'GR', 'nationality_name' => 'Greek - إغريقي'],
            ['nationality_code' => 'GD', 'nationality_name' => 'Grenadian - جرينادي'],
            ['nationality_code' => 'GT', 'nationality_name' => 'Guatemalan - غواتيمالي'],
            ['nationality_code' => 'GW', 'nationality_name' => 'Guinea-Bissauan - غيني بيساوي'],
            ['nationality_code' => 'GN', 'nationality_name' => 'Guinean - غيني'],
            ['nationality_code' => 'GY', 'nationality_name' => 'Guyanese - جوياني'],
            ['nationality_code' => 'HT', 'nationality_name' => 'Haitian - هايتي'],
            ['nationality_code' => 'HN', 'nationality_name' => 'Honduran - هندوراسي'],
            ['nationality_code' => 'HU', 'nationality_name' => 'Hungarian - هنغاري'],
            ['nationality_code' => 'IS', 'nationality_name' => 'Icelander - إيسلندي'],
            ['nationality_code' => 'IN', 'nationality_name' => 'Indian - هندي'],
            ['nationality_code' => 'ID', 'nationality_name' => 'Indonesian - إندونيسي'],
            ['nationality_code' => 'IR', 'nationality_name' => 'Iranian - إيراني'],
            ['nationality_code' => 'IQ', 'nationality_name' => 'Iraqi - عراقي'],
            ['nationality_code' => 'IE', 'nationality_name' => 'Irish - إيرلندي'],
            ['nationality_code' => 'IT', 'nationality_name' => 'Italian - إيطالي'],
            ['nationality_code' => 'CI', 'nationality_name' => 'Ivorian - إفواري'],
            ['nationality_code' => 'JM', 'nationality_name' => 'Jamaican - جامايكي'],
            ['nationality_code' => 'JP', 'nationality_name' => 'Japanese - ياباني'],
            ['nationality_code' => 'JO', 'nationality_name' => 'Jordanian - أردني'],
            ['nationality_code' => 'KZ', 'nationality_name' => 'Kazakhstani - كازاخستاني'],
            ['nationality_code' => 'KE', 'nationality_name' => 'Kenyan - كيني'],
            ['nationality_code' => 'KN', 'nationality_name' => 'Kittian and Nevisian - كيتياني ونيفيسياني'],
            ['nationality_code' => 'KW', 'nationality_name' => 'Kuwaiti - كويتي'],
            ['nationality_code' => 'KG', 'nationality_name' => 'Kyrgyz - قيرغيزستان'],
            ['nationality_code' => 'LA', 'nationality_name' => 'Laotian - لاوسي'],
            ['nationality_code' => 'LV', 'nationality_name' => 'Latvian - لاتفي'],
            ['nationality_code' => 'LB', 'nationality_name' => 'Lebanese - لبناني'],
            ['nationality_code' => 'LR', 'nationality_name' => 'Liberian - ليبيري'],
            ['nationality_code' => 'LY', 'nationality_name' => 'Libyan - ليبي'],
            ['nationality_code' => 'LI', 'nationality_name' => 'Liechtensteiner - ليختنشتايني'],
            ['nationality_code' => 'LT', 'nationality_name' => 'Lithuanian - لتواني'],
            ['nationality_code' => 'LU', 'nationality_name' => 'Luxembourger - لكسمبرغي'],
            ['nationality_code' => 'MK', 'nationality_name' => 'Macedonian - مقدوني'],
            ['nationality_code' => 'MG', 'nationality_name' => 'Malagasy - مدغشقري'],
            ['nationality_code' => 'MW', 'nationality_name' => 'Malawian - مالاوى'],
            ['nationality_code' => 'MY', 'nationality_name' => 'Malaysian - ماليزي'],
            ['nationality_code' => 'MV', 'nationality_name' => 'Maldivan - مالديفي'],
            ['nationality_code' => 'ML', 'nationality_name' => 'Malian - مالي'],
            ['nationality_code' => 'MT', 'nationality_name' => 'Maltese - مالطي'],
            ['nationality_code' => 'MH', 'nationality_name' => 'Marshallese - مارشالي'],
            ['nationality_code' => 'MR', 'nationality_name' => 'Mauritanian - موريتاني'],
            ['nationality_code' => 'MU', 'nationality_name' => 'Mauritian - موريشيوسي'],
            ['nationality_code' => 'MX', 'nationality_name' => 'Mexican - مكسيكي'],
            ['nationality_code' => 'FM', 'nationality_name' => 'Micronesian - ميكرونيزي'],
            ['nationality_code' => 'MD', 'nationality_name' => 'Moldovan - مولدوفي'],
            ['nationality_code' => 'MC', 'nationality_name' => 'Monacan - موناكو'],
            ['nationality_code' => 'MN', 'nationality_name' => 'Mongolian - منغولي'],
            ['nationality_code' => 'MA', 'nationality_name' => 'Moroccan - مغربي'],
            ['nationality_code' => 'LS', 'nationality_name' => 'Mosotho - ليسوتو'],
            ['nationality_code' => 'BW', 'nationality_name' => 'Motswana - لتسواني'],
            ['nationality_code' => 'MZ', 'nationality_name' => 'Mozambican - موزمبيقي'],
            ['nationality_code' => 'NA', 'nationality_name' => 'Namibian - ناميبي'],
            ['nationality_code' => 'NR', 'nationality_name' => 'Nauruan - ناورو'],
            ['nationality_code' => 'NP', 'nationality_name' => 'Nepalese - نيبالي'],
            ['nationality_code' => 'NZ', 'nationality_name' => 'New Zealander - نيوزيلندي'],
            ['nationality_code' => 'VU', 'nationality_name' => 'Ni-Vanuatu - ني فانواتي'],
            ['nationality_code' => 'NI', 'nationality_name' => 'Nicaraguan - نيكاراغوا'],
            ['nationality_code' => 'NE', 'nationality_name' => 'Nigerien - نيجري'],
            ['nationality_code' => 'KP', 'nationality_name' => 'North Korean - كوري شمالي'],
            ['nationality_code' => 'GB', 'nationality_name' => 'Northern Irish - إيرلندي شمالي'],
            ['nationality_code' => 'NO', 'nationality_name' => 'Norwegian - نرويجي'],
            ['nationality_code' => 'OM', 'nationality_name' => 'Omani - عماني'],
            ['nationality_code' => 'PK', 'nationality_name' => 'Pakistani - باكستاني'],
            ['nationality_code' => 'PW', 'nationality_name' => 'Palauan - بالاوي'],
            ['nationality_code' => 'PS', 'nationality_name' => 'Palestinian - فلسطيني'],
            ['nationality_code' => 'PA', 'nationality_name' => 'Panamanian - بنمي'],
            ['nationality_code' => 'PG', 'nationality_name' => 'Papua New Guinean - بابوا غينيا الجديدة'],
            ['nationality_code' => 'PY', 'nationality_name' => 'Paraguayan - باراغواياني'],
            ['nationality_code' => 'PE', 'nationality_name' => 'Peruvian - بيروفي'],
            ['nationality_code' => 'PL', 'nationality_name' => 'Polish - بولندي'],
            ['nationality_code' => 'PT', 'nationality_name' => 'Portuguese - برتغالي'],
            ['nationality_code' => 'QA', 'nationality_name' => 'Qatari - قطري'],
            ['nationality_code' => 'RO', 'nationality_name' => 'Romanian - روماني'],
            ['nationality_code' => 'RU', 'nationality_name' => 'Russian - روسي'],
            ['nationality_code' => 'RW', 'nationality_name' => 'Rwandan - رواندي'],
            ['nationality_code' => 'LC', 'nationality_name' => 'Saint Lucian - لوسياني'],
            ['nationality_code' => 'SV', 'nationality_name' => 'Salvadoran - سلفادوري'],
            ['nationality_code' => 'WS', 'nationality_name' => 'Samoan - ساموايان'],
            ['nationality_code' => 'SM', 'nationality_name' => 'San Marinese - سان مارينيز'],
            ['nationality_code' => 'ST', 'nationality_name' => 'Sao Tomean - ساو توميان'],
            ['nationality_code' => 'SA', 'nationality_name' => 'Saudi - سعودي'],
            ['nationality_code' => 'GB', 'nationality_name' => 'Scottish - سكتلندي'],
            ['nationality_code' => 'SN', 'nationality_name' => 'Senegalese - سنغالي'],
            ['nationality_code' => 'RS', 'nationality_name' => 'Serbian - صربي'],
            ['nationality_code' => 'SC', 'nationality_name' => 'Seychellois - سيشلي'],
            ['nationality_code' => 'SL', 'nationality_name' => 'Sierra Leonean - سيرا ليوني'],
            ['nationality_code' => 'SG', 'nationality_name' => 'Singaporean - سنغافوري'],
            ['nationality_code' => 'SK', 'nationality_name' => 'Slovakian - سلوفاكي'],
            ['nationality_code' => 'SI', 'nationality_name' => 'Slovenian - سلوفيني'],
            ['nationality_code' => 'SB', 'nationality_name' => 'Solomon Islander - جزر سليمان'],
            ['nationality_code' => 'SO', 'nationality_name' => 'Somali - صومالي'],
            ['nationality_code' => 'ZA', 'nationality_name' => 'South African - جنوب افريقيي'],
            ['nationality_code' => 'KR', 'nationality_name' => 'South Korean - كوري جنوبي'],
            ['nationality_code' => 'ES', 'nationality_name' => 'Spanish - إسباني'],
            ['nationality_code' => 'LK', 'nationality_name' => 'Sri Lankan - سري لانكي'],
            ['nationality_code' => 'SD', 'nationality_name' => 'Sudanese - سوداني'],
            ['nationality_code' => 'SR', 'nationality_name' => 'Surinamer - سورينامي'],
            ['nationality_code' => 'SZ', 'nationality_name' => 'Swazi - سوازي'],
            ['nationality_code' => 'SE', 'nationality_name' => 'Swedish - سويدي'],
            ['nationality_code' => 'CH', 'nationality_name' => 'Swiss - سويسري'],
            ['nationality_code' => 'SY', 'nationality_name' => 'Syrian - سوري'],
            ['nationality_code' => 'TW', 'nationality_name' => 'Taiwanese - تايواني'],
            ['nationality_code' => 'TJ', 'nationality_name' => 'Tajik - طاجيكستاني'],
            ['nationality_code' => 'TZ', 'nationality_name' => 'Tanzanian - تنزاني'],
            ['nationality_code' => 'TH', 'nationality_name' => 'Thai - تايلندي'],
            ['nationality_code' => 'TG', 'nationality_name' => 'Togolese - توغوي'],
            ['nationality_code' => 'TO', 'nationality_name' => 'Tongan - تونغاني'],
            ['nationality_code' => 'TT', 'nationality_name' => 'Trinidadian or Tobagonian - ترينيدادي او توباغو'],
            ['nationality_code' => 'TN', 'nationality_name' => 'Tunisian - تونسي'],
            ['nationality_code' => 'TR', 'nationality_name' => 'Turkish - تركي'],
            ['nationality_code' => 'TM', 'nationality_name' => 'Turkmen - تركمانستاني'],
            ['nationality_code' => 'TV', 'nationality_name' => 'Tuvaluan - توفالو'],
            ['nationality_code' => 'UG', 'nationality_name' => 'Ugandan - أوغندي'],
            ['nationality_code' => 'UA', 'nationality_name' => 'Ukrainian - أوكراني'],
            ['nationality_code' => 'UY', 'nationality_name' => 'Uruguayan - أوروجواياني'],
            ['nationality_code' => 'UZ', 'nationality_name' => 'Uzbekistani - أوزبكستاني'],
            ['nationality_code' => 'VA', 'nationality_name' => 'Vatican - فاتيكان'],
            ['nationality_code' => 'VE', 'nationality_name' => 'Venezuelan - فنزويلي'],
            ['nationality_code' => 'VN', 'nationality_name' => 'Vietnamese - فيتنامي'],
            ['nationality_code' => 'YE', 'nationality_name' => 'Yemenite - يمني'],
            ['nationality_code' => 'ZM', 'nationality_name' => 'Zambian - زامبي'],
            ['nationality_code' => 'ZW', 'nationality_name' => 'Zimbabwean - زيمبابوي']
        ];

        // Insert nationalities into the database
        foreach ($nationalities as $nationality) {
            DB::table('nationalities')->insert($nationality);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nationalities');
    }
};