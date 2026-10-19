"""Add explicitly fictional operations to the internal review catalog, never live tables."""
import argparse, datetime as dt, json, pathlib
from zoneinfo import ZoneInfo
root=pathlib.Path(__file__).resolve().parents[1]
parser=argparse.ArgumentParser()
parser.add_argument('--start-date',default='2026-10-24',help='Earliest local session date (YYYY-MM-DD)')
args=parser.parse_args(); earliest=dt.date.fromisoformat(args.start_date)
path=root/'resources/catalog/egypt-qatar-proposals.json';data=json.loads(path.read_text())
names=['أحمد سامي','كريم عادل','يوسف هاني','عمر شريف','زياد حسن','محمود طارق','علي خالد','مصطفى ياسر','آدم أمين','حسام وليد','سيف عمرو','فارس جمال','ندى أشرف','سلمى ماهر','مريم عادل','خالد ناصر','سامي فهد','حمد راشد','ناصر جاسم','فيصل علي','ماجد سالم','نورة حمد','دانة خالد','ريم يوسف','عبدالله ماجد','علي فهد','مريم ناصر','خالد حمد','سارة راشد','عمر سالم']
cities=['القاهرة الجديدة','القاهرة الجديدة','القاهرة الجديدة','القاهرة الجديدة','القاهرة الجديدة','القاهرة الجديدة','السادس من أكتوبر','الشيخ زايد','القاهرة الجديدة','المعادي','الدقي','الإسكندرية','الإسكندرية','زهراء المعادي','الإسكندرية']+['الدوحة','الدوحة','الدوحة','الدوحة','الوكرة','الدوحة','الدوحة','الدوحة','الدوحة','الدوحة','الدوحة','الدوحة','الدوحة','الدوحة','الدوحة']
facilities={'football':'ملعب كرة قدم','swimming':'مسبح تدريب','basketball':'ملعب كرة سلة','tennis':'ملعب تنس','squash':'ملعب اسكواش','judo':'صالة جودو','karate':'صالة كاراتيه','boxing':'صالة ملاكمة','parkour':'منطقة باركور','gymnastics':'صالة جمباز','kayak':'نقطة تدريب تجديف','skating':'ساحة تزلج','ballet':'استوديو باليه','volleyball':'ملعب كرة طائرة','taekwondo':'صالة تايكوندو','padel':'ملعب بادل','jiujitsu':'صالة جيو جيتسو','kickboxing':'صالة كيك بوكسينج','equestrian':'ساحة تدريب فروسية','fencing':'صالة مبارزة','badminton':'ملعب تنس ريشة','cricket':'ملعب كريكيت','rugby':'ملعب رجبي'}
weekday_ar=['الاثنين','الثلاثاء','الأربعاء','الخميس','الجمعة','السبت','الأحد']
patterns=[([5],'16:00'),([0,2],'17:30'),([1,3],'18:45')]
for i,a in enumerate(data['academies']):
    timezone='Africa/Cairo' if a['country']=='eg' else 'Asia/Qatar'
    coach={'key':a['key']+'-demo-coach','name_ar':names[i]+' (تجريبي)','status':'fictional_unverified','notice_ar':'اسم افتراضي للتجربة، لا يمثل موظفًا حقيقيًا لدى الجهة.','sport':a['selected_sport'],'image_url':None}
    location={'key':a['key']+'-demo-location','name_ar':f'{facilities[a["selected_sport"]]} تجريبي — {cities[i]}','city_ar':cities[i],'status':'demo_unverified','notice_ar':'موقع مقترح للتجربة فقط، لا يمثل عنوان فرع مؤكد.','latitude':None,'longitude':None,'street_address':None,'timezone':timezone}
    a['demo_coach']=coach;a['demo_location']=location
    for n,t in enumerate(a['trainings']):
        weekdays,start=patterns[n];day=earliest;sessions=[];zone=ZoneInfo(timezone)
        while len(sessions)<t['proposed_sessions']:
            if day.weekday() in weekdays:
                begin=dt.datetime.combine(day,dt.time.fromisoformat(start),zone)
                end=begin+dt.timedelta(minutes=60)
                sessions.append({'key':t['key']+f'-s{len(sessions)+1:02d}','start_at':begin.isoformat(),'end_at':end.isoformat(),'status':'demo_unverified'})
            day+=dt.timedelta(days=1)
        t.update({'coach':coach['name_ar'],'coach_key':coach['key'],'location_key':location['key'],'start_date':sessions[0]['start_at'][:10],'end_date':sessions[-1]['start_at'][:10],
            'weekdays':[dt.date(2026,10,19+d).strftime('%A') for d in weekdays],'weekdays_iso':[d+1 for d in weekdays],
            'weekdays_ar':' و'.join(weekday_ar[d] for d in weekdays),'start_time':start,'end_time':(dt.datetime.combine(earliest,dt.time.fromisoformat(start))+dt.timedelta(hours=1)).strftime('%H:%M'),
            'timezone':timezone,'proposed_duration_minutes':60,'operational_details_status':'demo_unverified','proposed_sessions_calendar':sessions,'is_bookable':False})
        t['description_ar']=f'برنامج مقترح من حجّز بعنوان «{t["name_ar"]}». السعر والمدرب والموقع والمواعيد بيانات تجريبية من إعداد حجّز بطلب صاحب المشروع، وليست بيانات تشغيل معتمدة من الجهة. لا يتيح حجزًا أو تحصيلًا.'
data['version']=2;data['demo_operations_prepared_at']='2026-10-20';data['owner_requested_demo_operations']=True
data['summary'].update({'fictional_coaches':30,'demo_locations':30,'demo_sessions':sum(len(t['proposed_sessions_calendar']) for a in data['academies'] for t in a['trainings'])})
data['notice_ar']='محتوى داخلي للمراجعة: الأسماء والرياضات الأصلية من ملف الليدز. البرامج والأسعار والمدربون والمواقع والمواعيد بيانات مقترحة/تجريبية أعدها حجّز بطلب صاحب المشروع، وليست عروضًا أو بيانات تشغيل معتمدة. لا حجوزات أو مدفوعات.'
path.write_text(json.dumps(data,ensure_ascii=False,indent=2)+'\n')
print('Prepared',data['summary']['demo_sessions'],'demo sessions with local time zones and real DST offsets; no database writes.')
