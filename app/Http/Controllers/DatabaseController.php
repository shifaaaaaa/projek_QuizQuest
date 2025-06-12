<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{
    public function index()
    {
        try {
            // Get all tables
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            
            $tableData = [];
            
            foreach ($tables as $table) {
                $tableName = $table->name;
                
                // Get table structure
                $columns = DB::select("PRAGMA table_info({$tableName})");
                
                // Get row count
                $count = DB::table($tableName)->count();
                
                // Get sample data (first 5 rows)
                $sampleData = DB::table($tableName)->limit(5)->get();
                
                $tableData[] = [
                    'name' => $tableName,
                    'columns' => $columns,
                    'count' => $count,
                    'sample_data' => $sampleData
                ];
            }
            
            return view('database.viewer', compact('tableData'));
            
        } catch (\Exception $e) {
            return view('database.viewer', [
                'error' => $e->getMessage(),
                'tableData' => []
            ]);
        }
    }
    
    public function showTable($tableName)
    {
        try {
            // Get all data from table
            $data = DB::table($tableName)->paginate(20);
            
            // Get table structure
            $columns = DB::select("PRAGMA table_info({$tableName})");
            
            return view('database.table', compact('data', 'columns', 'tableName'));
            
        } catch (\Exception $e) {
            return redirect()->route('database.index')->with('error', $e->getMessage());
        }
    }
}
