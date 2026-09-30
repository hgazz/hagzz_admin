<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Sport;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $activities = [
            // --- صالات الجيم واللياقة البدنية ---
            [
                'ar' => 'كمال أجسام وبناء عضلات',
                'en' => 'Bodybuilding & Muscle Building',
            ],
            [
                'ar' => 'لياقة بدنية وتخسيس',
                'en' => 'Fitness & Weight Loss',
            ],
            [
                'ar' => 'كروس فيت وتمارين وظيفية',
                'en' => 'CrossFit & Functional Training',
            ],
            [
                'ar' => 'تدريب شخصي (Private Training)',
                'en' => 'Personal & Private Training',
            ],
            [
                'ar' => 'كارديو وحرق دهون',
                'en' => 'Cardio & Fat Burning',
            ],
            [
                'ar' => 'ملاكمة وفنون قتالية',
                'en' => 'Boxing & Martial Arts',
            ],
            [
                'ar' => 'كيك بوكسينغ ومواي تاي',
                'en' => 'Kickboxing & Muay Thai',
            ],
            [
                'ar' => 'يوغا وبيلاتس',
                'en' => 'Yoga & Pilates',
            ],
            [
                'ar' => 'زومبا وإيروبكس',
                'en' => 'Zumba & Aerobics',
            ],
            [
                'ar' => 'رفع أثقال وقوة بدنية',
                'en' => 'Powerlifting & Weightlifting',
            ],
            [
                'ar' => 'جمباز وكاليستثنكس',
                'en' => 'Calisthenics & Gymnastics',
            ],
            [
                'ar' => 'سباحة وأكوا جيم',
                'en' => 'Swimming & Aqua Gym',
            ],

            // --- المراكز الصحية والسبا والاستشفاء ---
            [
                'ar' => 'سبا وساونا وجاكوزي',
                'en' => 'Spa, Sauna & Jacuzzi',
            ],
            [
                'ar' => 'مساج وتدليك علاجي',
                'en' => 'Therapeutic & Recovery Massage',
            ],
            [
                'ar' => 'علاج طبيعي وتأهيل إصابات',
                'en' => 'Physiotherapy & Injury Rehab',
            ],
            [
                'ar' => 'حمام مغربي وتركي',
                'en' => 'Moroccan & Turkish Bath',
            ],
            [
                'ar' => 'حجامة وتدليك رياضي',
                'en' => 'Cupping & Sports Massage',
            ],
            [
                'ar' => 'استشفاء عضلي وحمام ثلج (Ice Bath)',
                'en' => 'Ice Bath & Sports Recovery',
            ],
            [
                'ar' => 'تغذية علاجية ونحت القوام',
                'en' => 'Clinical Nutrition & Body Contouring',
            ],
            [
                'ar' => 'استرخاء وتأمل واستجمام',
                'en' => 'Meditation & Relaxation',
            ],
        ];

        foreach ($activities as $item) {
            $exists = Sport::query()
                ->where('name->ar', $item['ar'])
                ->orWhere('name->en', $item['en'])
                ->exists();

            if (!$exists) {
                Sport::create([
                    'name' => [
                        'ar' => $item['ar'],
                        'en' => $item['en'],
                    ],
                    'status' => 'active',
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to delete seeded sports on rollback
    }
};
