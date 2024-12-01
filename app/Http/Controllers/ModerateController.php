<?php


namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;

class ModerateController extends Controller
{
    public function index()
    {
        // Fetch material reports
        $materialReports = DB::table('material_reports')
            ->join('materials', 'material_reports.material_id', '=', 'materials.id')
            ->join('users', 'material_reports.user_id', '=', 'users.id') // User who reported
            ->select(
                'material_reports.id as report_id',
                'materials.title as content', // Material title (this will be shown to the admin)
                'users.name as reported_by',
                'material_reports.reason',
                'material_reports.created_at',
                DB::raw('"Material" as type'),
                'materials.id as reported_id' // The ID of the reported material for viewing
            )
            ->get();

        // Fetch reply reports
        $replyReports = DB::table('report_replies')
            ->join('replies', 'report_replies.reply_id', '=', 'replies.id')
            ->join('users', 'report_replies.user_id', '=', 'users.id') // User who reported
            ->select(
                'report_replies.id as report_id',
                'replies.content as content', // Reply content (this will be shown to the admin)
                'users.name as reported_by',
                'report_replies.reason',
                'report_replies.created_at',
                DB::raw('"Reply" as type'),
                'replies.id as reported_id' // The ID of the reported reply for viewing
            )
            ->get();

        // Fetch question reports
        $questionReports = DB::table('report_questions')
            ->join('questions', 'report_questions.question_id', '=', 'questions.id')
            ->join('users', 'report_questions.user_id', '=', 'users.id') // User who reported
            ->select(
                'report_questions.id as report_id',
                'questions.content as content', // Question content (this will be shown to the admin)
                'users.name as reported_by',
                'report_questions.reason',
                'report_questions.created_at',
                DB::raw('"Question" as type'),
                'questions.id as reported_id' // The ID of the reported question for viewing
            )
            ->get();

        // Combine all reports
        $reports = $materialReports->merge($replyReports)->merge($questionReports);

        return view('moderate.index', compact('reports'));
    }

    public function allow($type, $id)
    {
        switch ($type) {
            case 'Material':
                DB::table('material_reports')->where('id', $id)->delete();
                break;
            case 'Reply':
                DB::table('report_replies')->where('id', $id)->delete();
                break;
            case 'Question':
                DB::table('report_questions')->where('id', $id)->delete();
                break;
        }

        return redirect()->route('moderate.index')->with('success', 'Report discarded.');
    }

    public function delete($type, $id)
    {
        switch ($type) {
            case 'Material':
                DB::table('materials')->where('id', function ($query) use ($id) {
                    $query->select('material_id')->from('material_reports')->where('id', $id);
                })->delete();
                DB::table('material_reports')->where('id', $id)->delete();
                break;
            case 'Reply':
                DB::table('replies')->where('id', function ($query) use ($id) {
                    $query->select('reply_id')->from('report_replies')->where('id', $id);
                })->delete();
                DB::table('report_replies')->where('id', $id)->delete();
                break;
            case 'Question':
                DB::table('questions')->where('id', function ($query) use ($id) {
                    $query->select('question_id')->from('report_questions')->where('id', $id);
                })->delete();
                DB::table('report_questions')->where('id', $id)->delete();
                break;
        }

        return redirect()->route('moderate.index')->with('success', 'Content deleted.');
    }

    public function view($type, $id)
    {
        switch ($type) {
            case 'Material':
                // Redirect to the existing material show page
                return redirect()->route('materials.show', ['material' => $id]);

            case 'Reply':
                // You need to know the department from the reply or question context, adjust this accordingly
                $reply = Reply::find($id); // Assuming it's a reply
                $departmentId = $reply->question->department_id; // Get the department from the related question
                return redirect()->route('chats.department', ['department' => $departmentId]);

            case 'Question':
                // Fetch the department for the question and redirect
                $question = Question::find($id);
                $departmentId = $question->department_id; // Get the department from the question
                return redirect()->route('chats.department', ['department' => $departmentId]);

            default:
                abort(404, 'Invalid type');
        }
    }

}
