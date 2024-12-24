<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Report;
use App\Models\ReportAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();

        $reports = Report::query()->with([
            'category' => function ($query) {
                $query->withTrashed();
            },
            'user' => function ($query) {
                $query->withTrashed();
            }
        ]);

        if ($user->role == 'Citizen') {
            $reports = $reports->where('user_id', $user->id);
        } elseif ($user->role == 'Goverment') {
            $reports = $reports->where('region', $user->region)
                ->whereIn('status', ['Accepted', 'In Progress', 'Completed']);
        }

        if ($request->has('status') && !empty($request->status)) {
            $reports = $reports->whereIn('status', $request->status);
        }

        if ($request->has('category') && !empty($request->category)) {
            $reports = $reports->whereHas('category', function ($query) use ($request) {
                $query->whereIn('id', $request->category);
            });
        }

        $reports = $reports->get();

        return view('reports.index', compact('reports'));

    }

    public function create()
    {
        $categories = Category::all();
        $regions = User::where('role', 'Goverment')
            ->whereNotNull('region')
            ->distinct()
            ->pluck('region');

        return view('reports.create', compact('categories', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'category_id' => ['required'],
            'region' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'description' => ['required'],
            'attachments.*' => [
                'file',
                'mimes:png,jpg,jpeg,pdf,doc,docx,xls,xlsx,mp4,3gp',
                'max:2048',
            ],
        ]);

        $report = Report::create([
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'region' => $request->region,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'Pending',
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $path = $attachment->store('reports', 'public');
                ReportAttachment::create([
                    'report_id' => $report->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('reports')->with('success', 'Report created successfully');
    }

    public function verification(Request $request, Report $report)
    {
        $report->update([
            'status' => $request->status,
        ]);

        if ($request->status == 'Rejected') {
            $report->update([
                'note_rejected' => $request->note_rejected
            ]);
        } elseif ($request->status == 'In Progress') {
            $report->update([
                'priority' => $request->priority
            ]);
        }
        return redirect()->route('reports')->with('success', 'Report updated successfully');
    }

    public function show(Request $request, Report $report)
    {
        $report = $report->load([
            'category' => function ($query) {
                $query->withTrashed();
            },
            'user' => function ($query) {
                $query->withTrashed();
            },
            'comments',
            'attachments'
        ]);

        return view('reports.show', compact('report'));
    }

    public function comment(Request $request, Report $report)
    {
        $request->validate([
            'comment' => ['required'],
        ]);

        $comment = $report->comments()->create([
            'user_id' => Auth::user()->id,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Comment created successfully');
    }
}