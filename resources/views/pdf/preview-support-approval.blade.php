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
            font-family: 'Amiri', 'DejaVu Sans', sans-serif;
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
            width: 250px;
        }

        .value {
            display: inline-block;
        }
    </style>
</head>
<body>

    <h1>نموذج اعتماد الخدمات المساندة</h1>

    {{-- بيانات المشروع --}}
    @if($project)
    <div class="section">
            <h2>بيانات المشروع</h2>
            <div><span class="label">رقم المشروع:</span> <span class="value">{{ $project->project_number }}</span></div>
            <div><span class="label">اسم المشروع:</span> <span class="value">{{ $project->project_name }}</span></div>
            <div><span class="label">الإدارة المالكة:</span> <span class="value">{{ $project->owner_department }}</span></div>
            <div><span class="label">نوع المشروع:</span> <span class="value">{{ $project->project_type }}</span></div>
            <div><span class="label">تاريخ الطلب:</span> <span class="value">{{ optional($project->request_date)->format('Y-m-d') ?? '--' }}</span></div>
            <div><span class="label">القيمة التقديرية:</span> <span class="value">{{ $project->estimated_value }}</span></div>
            <div><span class="label">كتابة القيمة التقديرية:</span> <span class="value">{{ $project->estimated_value_text }}</span></div>
            <div><span class="label">المدة:</span> 
                <span class="value">
                    {{ $project->duration_year }} سنة،
                    {{ $project->duration_month }} شهر،
                    {{ $project->duration_day }} يوم
                </span>
            </div>
            <div><span class="label">وصف المشروع:</span> <span class="value">{{ $project->project_description }}</span></div>
            <div><span class="label">نطاق المشروع:</span> <span class="value">{{ $project->project_scope }}</span></div>
            <div><span class="label">الأهداف الاستراتيجية:</span> 
                <span class="value">
                    {{ is_array($project->project_objectives) ? implode('، ', $project->project_objectives) : $project->project_objectives }}
                </span>
            </div>
        </div>
    @endif

    {{-- جميع الاعتمادات --}}
    <div class="section">
        <h2>الاعتمادات</h2>

        @php
            function viewApproval($label, $approved, $date, $notes) {
                echo "<div><span class='label'>{$label}:</span> <span class='value'>" . ($approved ? 'معتمد' : 'غير معتمد') . "</span></div>";
                echo "<div><span class='label'>تاريخ الاعتماد:</span> <span class='value'>" . ($date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : '--') . "</span></div>";
                echo "<div><span class='label'>ملاحظات:</span> <span class='value'>" . ($notes ?? '--') . "</span></div><br>";
            }
        @endphp

        {{-- اعتماد المسؤول الأول --}}
        @php viewApproval(
            'اعتماد المسؤول الأول',
            $project->approved_by_first_owner ?? false,
            $project->approved_by_first_owner_at ?? null,
            $project->first_owner_notes ?? null
        ) @endphp

        {{-- اعتماد الموظف المختص المالي --}}
        @php viewApproval(
            'اعتماد الموظف المختص المالي',
            $project->financialAffair->approved_by_specialist ?? false,
            $project->financialAffair->approved_by_specialist_at ?? null,
            $project->financialAffair->specialist_notes ?? null
        ) @endphp

        {{-- اعتماد مدير المالية --}}
        @php viewApproval(
            'اعتماد مدير المالية',
            $project->financialAffair->approved_by_finance_director ?? false,
            $project->financialAffair->approved_by_finance_director_at ?? null,
            $project->financialAffair->finance_director_notes ?? null
        ) @endphp

        {{-- اعتماد موظف العقود --}}
        @php viewApproval(
            'اعتماد موظف العقود',
            $project->contract->approved_by_procurement_specialist ?? false,
            $project->contract->approved_by_procurement_specialist_at ?? null,
            $project->contract->procurement_specialist_notes ?? null
        ) @endphp

        {{-- اعتماد مدير العقود --}}
        @php viewApproval(
            'اعتماد مدير العقود',
            $project->contract->approved_by_procurement_manager ?? false,
            $project->contract->approved_by_procurement_manager_at ?? null,
            $project->contract->procurement_manager_notes ?? null
        ) @endphp

        {{-- اعتماد مكتب المشاريع --}}
        @php viewApproval(
            'اعتماد مكتب المشاريع',
            $project->completion->approved_by_pmo ?? false,
            $project->completion->approved_by_pmo_at ?? null,
            $project->completion->pmo_director_notes ?? null
        ) @endphp

        {{-- اعتماد مدير التخطيط والحوكمة --}}
        @php viewApproval(
            'اعتماد مدير التخطيط والحوكمة',
            $project->planningGovernanceApproval->approved_by_planning_director ?? false,
            $project->planningGovernanceApproval->approved_by_planning_director_at ?? null,
            $project->planningGovernanceApproval->planning_director_notes ?? null
        ) @endphp

        {{-- اعتماد مساعد الرئيس التنفيذي --}}
        @php viewApproval(
            'اعتماد مساعد الرئيس التنفيذي',
            $project->planningGovernanceApproval->approved_by_ceo_assistant ?? false,
            $project->planningGovernanceApproval->approved_by_ceo_assistant_at ?? null,
            $project->planningGovernanceApproval->ceo_assistant_notes ?? null
        ) @endphp

        {{-- اعتماد مساعد الرئيس التنفيذي للخدمات المساندة --}}
        @php viewApproval(
            'اعتماد مساعد الرئيس التنفيذي للخدمات المساندة',
            $approval->approved_by_support_exec ?? false,
            $approval->approved_by_support_exec_at ?? null,
            $approval->support_exec_notes ?? null
        ) @endphp

    </div>
    <div class="print-button">
        <button onclick="window.print()">🖨️ طباعة أو حفظ كـ PDF</button>
    </div>

</body>
</html>
