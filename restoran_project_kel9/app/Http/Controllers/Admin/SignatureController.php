<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Product;
use App\Models\Signature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSignatureRequest;
use App\Http\Requests\UpdateSignatureRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroySignatureRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SignatureController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('Signature_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $signatures = Signature::with(['media'])->get();

        return view('admin.signatures.index', compact('signatures'));
    }

    public function create()
    {
        abort_if(Gate::denies('signature_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.signatures.create', compact('products'));
    }

    public function store(StoreSignatureRequest $request)
    {
        $product = Product::find($request->product_id);

        if ($product) {
            $signature = new Signature();
            $signature->product_id = $product->id;
            $signature->menu_name = $product->name; // Mengambil nama dari tabel products
            $signature->description = $request->description;
            $signature->save();

            if ($request->input('image', false)) {
                $signature->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }

            if ($media = $request->input('ck-media', false)) {
                Media::whereIn('id', $media)->update(['model_id' => $signature->id]);
            }
        }

        return redirect()->route('admin.signatures.index');
    }

    public function edit(Signature $signature)
    {
        abort_if(Gate::denies('signature_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.signatures.edit', compact('signature', 'products'));
    }

    public function update(UpdateSignatureRequest $request, Signature $signature)
    {
        $product = Product::find($request->product_id);

        if ($product) {
            $signature->product_id = $product->id;
            $signature->menu_name = $product->name; // Mengambil nama dari tabel products
            $signature->description = $request->description;
            $signature->save();

            if ($request->input('image', false)) {
                if (! $signature->image || $request->input('image') !== $signature->image->file_name) {
                    if ($signature->image) {
                        $signature->image->delete();
                    }
                    $signature->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
                }
            } elseif ($signature->image) {
                $signature->image->delete();
            }
        }

        return redirect()->route('admin.signatures.index');
    }

    public function show(Signature $signature)
    {
        abort_if(Gate::denies('signature_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.signatures.show', compact('signature'));
    }

    public function destroy(Signature $signature)
    {
        abort_if(Gate::denies('signature_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $signature->delete();

        return back();
    }

    public function massDestroy(MassDestroySignatureRequest $request)
    {
        $signatures = Signature::find(request('ids'));

        foreach ($signatures as $signature) {
            $signature->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('signature_create') && Gate::denies('signature_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Signature();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
