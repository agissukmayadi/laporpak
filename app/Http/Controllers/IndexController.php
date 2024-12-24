<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    public function index()
    {
        $about = About::first();
        $faqs = Faq::all();
        $contact = Contact::first();
        $categories = Category::all();
        $regions = User::where('role', 'Goverment')
            ->whereNotNull('region')
            ->distinct()
            ->pluck('region');
        return view('index', compact('about', 'faqs', 'contact', 'categories', 'regions'));
    }

    public function dashboard()
    {
        $data = [];
        if (Auth::user()->role == "Admin") {
            $reportsByMonth = DB::table('reports')
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
                ->whereNotIn('status', ['Pending', 'Rejected'])
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray();
            $reportData = [];
            for ($i = 1; $i <= 12; $i++) {
                $reportData[] = $reportsByMonth[$i] ?? 0;
            }

            $reportsByCategory = DB::table('reports')
                ->join('categories', 'reports.category_id', '=', 'categories.id')
                ->select('categories.name as category', DB::raw('COUNT(reports.id) as total'))
                ->whereNotIn('reports.status', ['Pending', 'Rejected'])
                ->whereYear('reports.created_at', Carbon::now()->year)
                ->groupBy('categories.name')
                ->pluck('total', 'category')
                ->toArray();

            $reportsByRegion = DB::table('reports')
                ->select('region', DB::raw('COUNT(id) as total'))
                ->groupBy('region')
                ->orderBy('total', 'desc')
                ->pluck('total', 'region')
                ->toArray();

            $governmentUsers = DB::table('users')
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(id) as total'))
                ->where('role', 'Goverment')
                ->whereYear('created_at', Carbon::now()->year) // Mengambil data untuk tahun ini
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            // Ambil data total user Citizen per bulan
            $citizenUsers = DB::table('users')
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(id) as total'))
                ->where('role', 'Citizen')
                ->whereYear('created_at', Carbon::now()->year) // Mengambil data untuk tahun ini
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            // Format data untuk memastikan semua bulan tersedia (jika tidak ada data di bulan tertentu, diisi 0)
            $governmentData = [];
            $citizenData = [];
            for ($i = 1; $i <= 12; $i++) {
                $governmentData[] = $governmentUsers[$i] ?? 0;
                $citizenData[] = $citizenUsers[$i] ?? 0;
            }

            $data['governmentData'] = $governmentData;
            $data['citizenData'] = $citizenData;
            $data['reportsByRegion'] = $reportsByRegion;
            $data['reportsByCategory'] = $reportsByCategory;
            $data['reportDataByMonth'] = $reportData;
            $data['reportPendingCount'] = Report::where('status', 'Pending')->count();
            $data['reportCompletedCount'] = Report::where('status', 'Completed')->count();
            $data['reportInProgressCount'] = Report::where('status', 'In Progress')->count();
            $data['reportVerifiedCount'] = Report::where('status', 'Accepted')->count();
        } elseif (Auth::user()->role == "Citizen") {
            $data['reportPendingCount'] = Report::where('status', 'Pending')->where('user_id', Auth::user()->id)->count();
            $data['reportCompletedCount'] = Report::where('status', 'Completed')->where('user_id', Auth::user()->id)->count();
            $data['reportInProgressCount'] = Report::where('status', 'In Progress')->where('user_id', Auth::user()->id)->count();
            $data['reportVerifiedCount'] = Report::where('status', 'Accepted')->where('user_id', Auth::user()->id)->count();
        } elseif (Auth::user()->role == "Goverment") {
            $reportsByMonth = DB::table('reports')
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
                ->where('region', Auth::user()->region)
                ->whereNotIn('status', ['Pending', 'Rejected'])
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray();
            $reportData = [];
            for ($i = 1; $i <= 12; $i++) {
                $reportData[] = $reportsByMonth[$i] ?? 0;
            }

            $reportsByCategory = DB::table('reports')
                ->join('categories', 'reports.category_id', '=', 'categories.id')
                ->select('categories.name as category', DB::raw('COUNT(reports.id) as total'))
                ->where('reports.region', Auth::user()->region)
                ->whereNotIn('reports.status', ['Pending', 'Rejected'])
                ->whereYear('reports.created_at', Carbon::now()->year)
                ->groupBy('categories.name')
                ->pluck('total', 'category')
                ->toArray();

            $data['reportsByCategory'] = $reportsByCategory;
            $data['reportDataByMonth'] = $reportData;
            $data['reportPendingCount'] = Report::where('status', 'Pending')->where('region', Auth::user()->region)->count();
            $data['reportCompletedCount'] = Report::where('status', 'Completed')->where('region', Auth::user()->region)->count();
            $data['reportInProgressCount'] = Report::where('status', 'In Progress')->where('region', Auth::user()->region)->count();
            $data['reportVerifiedCount'] = Report::where('status', 'Accepted')->where('region', Auth::user()->region)->count();
        }
        return view('dashboard', $data);
    }
}