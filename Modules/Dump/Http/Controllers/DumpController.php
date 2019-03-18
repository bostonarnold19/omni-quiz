<?php

namespace Modules\Dump\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Dump\Interfaces\DumpRepositoryInterface;

class DumpController extends Controller
{
    protected $dump_repository;

    public function __construct(DumpRepositoryInterface $dump_repository)
    {
        $this->dump_repository = $dump_repository;
    }

    public function index()
    {
        // $dumps = $this->dump_repository->all();
        // return view('dump::index', compact('dumps'));
    }
    public function create()
    {
        // return view('dump::create');
    }

    public function store(Request $request)
    {
        // $data = $request->all();
        // try {
        //     DB::beginTransaction();
        //     $this->dump_repository->save($data);
        //     DB::commit();
        //     $status = 'success';
        //     $message = 'Dump has been created.';
        // } catch (\Exception $e) {
        //     $status = 'error';
        //     $message = 'Internal Server Error. Try again later.';
        //     DB::rollBack();
        // }
        // return redirect()->route('dump.index')->with($status, $message);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // $dump = $this->dump_repository->find($id);
        // return view('dump::edit', compact('dump'));
    }

    public function update(Request $request, $id)
    {
        // $data = $request->all();
        // try {
        //     DB::beginTransaction();
        //     $user = $this->dump_repository->update($id, $data);
        //     DB::commit();
        //     $status = 'success';
        //     $message = 'Dump has been updated.';
        // } catch (\Exception $e) {
        //     $status = 'error';
        //     $message = 'Internal Server Error. Try again later.';
        //     DB::rollBack();
        // }
        // return redirect()->route('dump.index')->with($status, $message);
    }

    public function destroy($id)
    {
        // try {
        //     DB::beginTransaction();
        //     $this->dump_repository->delete($id);
        //     $status = 'success';
        //     $message = 'Dump has been deleted.';
        //     DB::commit();
        // } catch (\Exception $e) {
        //     $status = 'error';
        //     $message = 'Internal Server Error. Try again later.';
        //     DB::rollBack();
        // }
        // return redirect()->route('dump.index')->with($status, $message);
    }
}
