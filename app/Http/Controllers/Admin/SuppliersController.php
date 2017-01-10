<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Http\Requests\SupplierForm;
use App\Sourcing\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuppliersController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function index()
    {
        $suppliers = Supplier::latest()->paginate(15);

        return view('admin.suppliers.index')->with(compact('suppliers'));
    }

    public function show(Supplier $supplier)
    {
        return view('admin.suppliers.show')->with(compact('supplier'));
    }

    public function store(SupplierForm $request)
    {
        $supplier = Supplier::create($request->acceptedFields());

        $this->flasher->success('Supplier Added', 'The supplier has been added to the system');

        return redirect('admin/suppliers/' . $supplier->id);
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit')->with(compact('supplier'));
    }

    public function update(SupplierForm $request, Supplier $supplier)
    {
        $supplier->update($request->acceptedFields());

        $this->flasher->success('Changes Saved', 'The supplier details have been updated');

        return redirect('admin/suppliers/' . $supplier->id);
    }

    public function delete(Supplier $supplier)
    {
        $supplier->delete();

        $this->flasher->success('Supplier Deleted', 'The supplier has been deleted from the system');

        return redirect('admin/suppliers');
    }
}
