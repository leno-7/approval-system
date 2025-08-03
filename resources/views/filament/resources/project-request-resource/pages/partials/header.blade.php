<div class="bg-white p-4 rounded shadow mb-6">
    <h2 class="text-lg font-bold mb-2">معلومات المشروع الأساسية:</h2>
    <div class="grid grid-cols-2 gap-4 text-right">
        <div><strong>رقم المشروع:</strong> {{ $record->project_number }}</div>
        <div><strong>تاريخ الطلب:</strong> {{ $record->request_date }}</div>
        <div><strong>اسم المشروع:</strong> {{ $record->project_name }}</div>
        <div><strong>نوع المشروع:</strong> {{ $record->project_type }}</div>
        <div><strong>مستوى المشروع:</strong> {{ $record->project_level }}</div>
        <div><strong>الجهة المالكة:</strong> {{ $record->owner_department }}</div>
    </div>
</div>
