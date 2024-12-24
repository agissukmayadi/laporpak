<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Laporan API LaporPak", version="1.0.0")
 */
class APIController extends Controller
{
    /**
     * @OA\Get(
     *     path="/reports",
     *     tags={"Reports"},
     *     summary="Get Reports",
     *     description="Mengambil daftar laporan dengan opsi filter",
     *     @OA\Parameter(name="start_date", in="query", required=false, description="Tanggal mulai filter laporan (format: YYYY-MM-DD)", @OA\Schema(type="string")),
     *     @OA\Parameter(name="end_date", in="query", required=false, description="Tanggal akhir filter laporan (format: YYYY-MM-DD)", @OA\Schema(type="string")),
     *     @OA\Parameter(name="category", in="query", required=false, description="ID kategori untuk filter laporan", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="region", in="query", required=false, description="Nama region untuk filter laporan", @OA\Schema(type="string")),
     *     @OA\Parameter(name="priority", in="query", required=false, description="Prioritas laporan (Rendah, Menengah, Tinggi)", @OA\Schema(type="string")),
     *     @OA\Parameter(name="status", in="query", required=false, description="Status laporan (Pending, Accepted, In Progress, Completed, Rejected)", @OA\Schema(type="string")),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Berhasil mengambil laporan",
     *             "data": {
     *                 {"id": 1, "user_id": 2, "category_id": 1, "code": "RPT-001", "title": "Laporan A", "description": "Deskripsi laporan A", "region": "Jakarta", "priority": "Tinggi", "status": "Completed", "created_at": "2024-11-01T07:38:06.000000Z"},
     *                 {"id": 2, "user_id": 3, "category_id": 2, "code": "RPT-002", "title": "Laporan B", "description": "Deskripsi laporan B", "region": "Bandung", "priority": "Menengah", "status": "In Progress", "created_at": "2024-11-02T07:38:06.000000Z"}
     *             }
     *         })
     *     ),
     * )
     */
    public function reports(Request $request)
    {
        $query = Report::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }

        // Filter berdasarkan category
        if ($request->has('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter berdasarkan region
        if ($request->has('region')) {
            $query->where('region', $request->input('region'));
        }

        // Filter berdasarkan priority
        if ($request->has('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        // Filter berdasarkan status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $reports = $query->get();
        return response()->json(['status' => 'success', 'data' => $reports]);
    }

    /**
     * @OA\Get(
     *     path="/regions",
     *     tags={"Regions"},
     *     summary="Get Regions",
     *     description="Mengambil daftar region yang terdaftar berdasarkan user dengan role Government",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Berhasil mengambil daftar region",
     *             "data": {
     *                 {"region": "Jakarta"},
     *                 {"region": "Bandung"},
     *             }
     *         })
     *     ),
     * )
     */
    public function regions()
    {
        $regions = User::where('role', 'Goverment')->select('region')->distinct()->get();
        return response()->json(['status' => 'success', 'data' => $regions]);
    }

    /**
     * @OA\Get(
     *     path="/categories",
     *     tags={"Categories"},
     *     summary="Get Categories",
     *     description="Mengambil semua kategori",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Berhasil mengambil kategori",
     *             "data": {
     *                 {"id": 1, "name": "Kategori A"},
     *                 {"id": 2, "name": "Kategori B"},
     *             }
     *         })
     *     ),
     * )
     */
    public function categories()
    {
        $categories = Category::all();
        return response()->json(['status' => 'success', 'data' => $categories]);
    }
}
