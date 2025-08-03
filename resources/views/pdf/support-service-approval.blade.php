<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اعتماد الخدمات المساندة</title>
    <style>
       @font-face {
    font-family: 'Amiri';
    src: url('{{ storage_path("fonts/Amiri-Regular.ttf") }}') format('truetype');
}


        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
            line-height: 1.8;
            margin: 40px;
        }

        h1, h2 {
            text-align: center;
        }

        .section {
            margin-bottom: 25px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 15px;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 200px;
        }

        .value {
            display: inline-block;
        }
    </style>
</head>
<body>

<h1>تفاصيل اعتماد الخدمات المساندة</h1>

{{-- بيانات المشروع --}}
@if($approval->projectRequest)
    <div class="section">
        <h2>بيانات المشروع</h2>
        <div><span class="label">رقم المشروع:</span> <span class="value">{{ $approval->projectRequest->project_number }}</span></div>
        <div><span class="label">اسم المشروع:</span> <span class="value">{{ $approval->projectRequest->project_name }}</span></div>
        <div><span class="label">الإدارة المالكة:</span> <span class="value">{{ $approval->projectRequest->owner_department }}</span></div>
        <div><span class="label">تاريخ الطلب:</span> <span class="value">{{ optional($approval->projectRequest->request_date)->format('Y-m-d') }}</span></div>
    </div>
@else
    <p style="color: red; font-weight: bold;">⚠️ لا توجد بيانات مشروع مرتبطة.</p>
@endif

{{-- بيانات الاعتماد --}}
<div class="section">
    <h2>بيانات الاعتماد</h2>
    <div><span class="label">اعتماد مساعد الرئيس التنفيذي:</span> <span class="value">{{ $approval->approved_by_support_exec ? 'معتمد' : 'غير معتمد' }}</span></div>
    <div><span class="label">تاريخ الاعتماد:</span>
<span class="value">
    {{ $approval->approved_by_support_exec_at ? \Carbon\Carbon::parse($approval->approved_by_support_exec_at)->format('Y-m-d') : '--' }}
</span></div>

    <div><span class="label">ملاحظات:</span> <span class="value">{{ $approval->support_exec_notes ?? '--' }}</span></div>
</div>


</body>
</html>