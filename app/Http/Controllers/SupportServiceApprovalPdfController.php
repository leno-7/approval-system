<?php
namespace App\Http\Controllers;

use App\Models\SupportServiceApproval;

class SupportServiceApprovalPdfController extends Controller
{
    
    public function download(SupportServiceApproval $approval)
    {
        // PDF generation removed - DomPDF dependency deleted
        return response()->json(['message' => 'PDF generation not available'], 404);
    } 

    public function preview(SupportServiceApproval $approval)
{
    $approval->load('projectRequest');
    $project = $approval->projectRequest;

    return view('pdf.preview-support-approval', compact('approval', 'project'));
}

}

